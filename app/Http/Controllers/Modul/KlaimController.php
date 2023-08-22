<?php
namespace App\Http\Controllers\Modul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use DataTables;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Jenssegers\Agent\Agent;
use PDF;
use Session;
class KlaimController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function __construct()
    {
        $this->middleware('cek:admin');
        $this->middleware(function ($request, $next) {
            // $user = Auth::user();
            // if(Session::get('login')[0]->level == 'broker' || Session::get('login')[0]->level == 'insurance'){
                // View::share( 'loggedInUser' ,  $user );
                return $next($request);
            // }
            // return redirect()->intended('index')->with('error', 'Maaf kamu tidak dapat mengakses ini');
            
        });
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getInquiry(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            
            $custCol = "";
            $custJoin = "";
            if ($vlevel == "insurance") {
                $custCol = ",'-',(IF(ae.borderono IS NOT NULL, 'YES', 'NO'))";
                $custJoin = " LEFT JOIN tr_bordero_dtl ae ON ae.regid = aa.regid ";
            }
            $sTable = "SELECT SQL_CALC_FOUND_ROWS regid,produk,nama,tgllahir,cabang,mulai,up,premi,status,aksi FROM (SELECT aa.regid,aa.nama,
                ac.msdesc cabang, ad.msdesc produk,aa.tgllahir, aa.mulai, aa.up, aa.premi, ab.msdesc status, concat(aa.regid,'-',aa.status) aksi FROM (select * from tr_sppa where status in ('5','6','20' )) aa 
                INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='STREQ') ab ON aa.status = ab.msid 
                LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype = 'CAB') ac ON ac.msid = aa.cabang 
                INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='PRODUK') ad ON ad.msid = aa.produk 
                WHERE  aa.status IN ( '5', '6', '20' ) ";
                
            $sTable .= " ) t_baru WHERE regid LIKE '$cari' OR produk LIKE '$cari' OR nama LIKE '$cari' OR tgllahir LIKE '$cari' OR cabang LIKE '$cari' OR mulai LIKE '$cari' OR up LIKE '$cari' OR premi  LIKE '$cari' OR status  LIKE '$cari' OR aksi LIKE '$cari' LIMIT 100";

            // $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $status = "";
                    if ($data->status == "PAID") {
                        $status = "Refund";
                    }else{
                        $status = "Batal";
                    }
                    $button = '<a href="#"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;<a href="#"  class="btn btn-danger btn-sm text-white" style="display:inline !important;">Claim</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function getDesktop(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            
            $custCol = "";
            $custJoin = "";
            $custField = "";
            // if (in_array($vlevel, ['checker'])) {
			// 	// array_push($aColumns, 'sisawaktu');
			// 	$custField = "IF (tr.status IN ('93','94','95','96'),'<i class=\"green\">SELESAI</i>',
			// 	                    IF((wkc.msdesc + wkc.createby) - Datediff(tc.tgllapor,tc.tglkejadian) < 0, NULL,
			//                             If((wkc.msdesc + wkc.createby) - Datediff(tc.tgllapor,tc.tglkejadian) < 15 AND tr.status='90',
			//                                 Concat((wkc.msdesc + wkc.createby) - Datediff(tgllapor,tglkejadian),' hari <i class=\"merahin\"></i>'),
			//                                     Concat((wkc.msdesc + wkc.createby) - Datediff(tgllapor,tglkejadian),' hari')))) 'sisawaktu', ";
			// } elseif (in_array($vlevel, ['insurance', 'broker', 'schecker'])) {
			// 	// array_push($aColumns, 'jatuhtempo');
			// 	$custField = "concat(DATE_ADD(tc.tglkejadian, INTERVAL (wkc.msdesc + wkc.createby) DAY),
			// 	                    IF (DATE_ADD(tc.tglkejadian, INTERVAL (wkc.msdesc + wkc.createby) DAY) < NOW(),
			// 	                        '<span style=\"display:none;\">EXPIRED</span>',
			// 	                        '')) as 'jatuhtempo', ";
			// 	if (in_array($vlevel, ['broker'])) {
			// 		// $inserted = array('asuransi');
			// 		// array_splice($aColumns, 0, 0, $inserted);
			// 		$custField .= "tr.asuransi, ";
			// 	} 
			// }
            $sTable = "SELECT  tc.regclaim, 
            tr.regid, 
            tp.msdesc 'produk', 
            tr.nama, 
            tb.msdesc 'cabang', 
            tr.up, 
            tc.nilaios, 
            tr.premi, 
            tc.tglkejadian, 
            tc.tgllapor, 
            ts.msdesc 'status',
            tr.regid 'reg_encode', 
            concat(tc.regclaim,'-',
                   tr.regid,'-',
                   tr.status,'-',
                   tr.nama,'-',
                   IF(dok.hasil IS NULL,'Lengkap','Approve')) 'aksi'
                    FROM   tr_claim tc
                            INNER JOIN tr_sppa tr 
                                    ON tc.regid = tr.regid 
                        
                                                    INNER JOIN ms_master ts 
                                    ON ts.mstype='STREQ' AND ts.msid = tr.status 
                        
                                                    INNER JOIN ms_master tp
                                    ON tp.mstype='PRODUK' AND tp.msid = tr.produk
                        
                                                    INNER JOIN ms_master tb
                                    ON tb.mstype='CAB' AND tb.msid = tr.cabang
                            LEFT JOIN  (SELECT * FROM tr_document WHERE catdoc = 'clmreject') td
                                    ON td.regid = tr.regid
                            LEFT JOIN  (SELECT a.regid,
                                            GROUP_CONCAT(DISTINCT IF (b.editby = 'wajib' AND c.jnsdoc IS NULL,
                                            'Dokumen Belum Lengkap',
                                            NULL) SEPARATOR ', ')hasil
                                        FROM   tr_claim a
                                            INNER JOIN ms_master b
                                                    ON b.mstype = a.doctype
                                                        AND b.editby = 'wajib'
                                            LEFT JOIN tr_document c
                                                    ON c.regid = a.regid
                                                        AND c.jnsdoc = b.msid
                                        WHERE  b.createby IS NULL
                                            AND c.jnsdoc IS NULL
                                        GROUP BY regid) dok ON dok.regid = tr.regid
                            LEFT JOIN  (SELECT msid, msdesc, createby FROM ms_master WHERE mstype='WKTCLM') wkc
                                    ON wkc.msid = concat(tr.asuransi,tr.produk)
                        ";
            if ($vlevel == "schecker" or $vlevel == "checker") {
                $sTable .= "WHERE tr.cabang LIKE (SELECT 
                                                            if(cabang='ALL','%%',cabang)
                                                        FROM   ms_admin 
                                                        WHERE  username='$userid' ) ";
                if ($vlevel == 'schecker') {
                    // $sTable .= "AND tcd.uploaded >= tcm.jmldokumen ";
                    $sTable .= "AND ((tr.status = '90' AND dok.hasil IS NULL) OR (tr.status != '90')) ";
                }
            }
            
            if ($vlevel == "broker") {
                $sTable .= "WHERE tr.status='91'";
            }
            
            if ($vlevel == "insurance") {
                $sTable .= "WHERE (tr.status IN ('90', '92','93','96')
                                    OR (tr.status = '90' AND NOW() > DATE_ADD(tc.tglkejadian,INTERVAL (wkc.msdesc + wkc.createby) DAY)))
                                    AND tr.asuransi IN (SELECT cabang 
                                                        FROM   ms_admin 
                                                        WHERE  level='insurance' 
                                                            AND username='$userid' )";
            }
            // $sTable .= "  t_baru WHERE regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR produk ";
        	// $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // $data = DB::select("");
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = "";
                    if($vlevel == 'broker' && ($data->status == 90 || $data->status == 91) || ($vlevel == "checker" && $data->status == '90')){
                        $button .= '<a href="'.'klaim/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
                        $button .= '<a href="'.'klaim/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-danger btn-sm" style="display:inline !important;">Batal</a>&nbsp;';
                        $button .= '<a href="'.'klaim/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-success btn-sm" style="display:inline !important;">Approve</a>&nbsp;';
                        
                    }else{
                        $button .= '<a href="'.'klaim/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
                    }
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function getPro(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            
            $sTable = "SELECT regid,produk,nama,cabang,nopeserta,policyno,up,premi,status,aksi FROM (SELECT aa.regid, ac.msdesc 'produk', aa.nama, ad.msdesc 'cabang', aa.nopeserta, aa.policyno, aa.up, aa.premi, ab.msdesc 'status', aa.regid 'aksi' FROM (select * from tr_sppa where  status='20' ";
            $sTable .= " ) aa INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='STREQ') ab ON aa.status = ab.msid INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='PRODUK') ac ON aa.produk = ac.msid INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='CAB') ad ON aa.cabang = ad.msid WHERE  aa.status IN ( '20' )  ";
            $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'pengajuan/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function index(Request $request)
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        
        $data = [
            'judul' => 'Klaim',
        ];
        $agent = new \Jenssegers\Agent\Agent;
        return view('modul.klaim.index_desktop', compact('data'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.klaim.index', compact('data','klaim'));
        // }
    }
    public function pro()
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        $sTable = "SELECT regid,produk,nama,cabang,nopeserta,policyno,up,premi,status,aksi FROM (SELECT aa.regid, ac.msdesc 'produk', aa.nama, ad.msdesc 'cabang', aa.nopeserta, aa.policyno, aa.up, aa.premi, ab.msdesc 'status', aa.regid 'aksi' FROM (select * from tr_sppa where  status='20' ";
        $sTable .= " ) aa INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='STREQ') ab ON aa.status = ab.msid INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='PRODUK') ac ON aa.produk = ac.msid INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='CAB') ad ON aa.cabang = ad.msid WHERE  aa.status IN ( '20' )  ";
        $sTable .= " ) t_baru  LIMIT 10";
        $klaim = DB::select($sTable);
        $data = [
            'judul' => 'Klaim',
        ];
        $agent = new \Jenssegers\Agent\Agent;
        if($agent->isDesktop()){
            return view('modul.klaim.pro_desktop', compact('data','klaim'));
        }else{
            return view('modul.klaim.pro', compact('data','klaim'));
        }
    }
    function hitung_umur($tanggal_lahir, $tanggal_mulai, $result = null, $naik = true)
	{
	    $d1     = new DateTime($tanggal_lahir);
	    $d2     = new DateTime($tanggal_mulai);
	    $diff   = $d2->diff($d1);
	    $tahun  = $diff->y;
	    $bulan  = $diff->m;
	    $hari   = $diff->d;
	    if ($naik) {
	        if ($diff->m >= 6) {
	            $tahun++;
	            $bulan = 0;
	            $hari = 0;
	        }
	    }
	    
	    if ($result == null) {
	        return $tahun;
	    } else if ($result == "bulan") {
	        return $bulan;
	    } else if ($result == "hari") {
	        return $hari;
	    }
	    // return "Usia ".$diff->y." tahun, ".$diff->m." bulan, ".$diff->d." hari";
	}
    public function store(Request $request)
    {
        $sup = str_replace('.', '', $request->up);
        $sproduk = $request->produk;
        $sjkel = $request->jkel;
        $snama      = str_replace("'", "`", $request->nama);
        $susia = $request->usia;
        
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        return view('modul.klaim.edit', compact('data','tempat_kejadian','penyebab','hubungan','dokumen','file','sid'));
    }
    public function update(Request $request)
    {
        $sup = str_replace('.', '', $request->up);
        $sproduk = $request->produk;
        $sjkel = $request->jkel;
        $snama      = str_replace("'", "`", $request->nama);
        $susia = $request->usia;
        
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        return view('modul.klaim.edit', compact('data','tempat_kejadian','penyebab','hubungan','dokumen','file','sid'));
    }
    public function claim(Request $request)
    {
        $sup = str_replace('.', '', $request->up);
        $sproduk = $request->produk;
        $sjkel = $request->jkel;
        $snama      = str_replace("'", "`", $request->nama);
        $susia = $request->usia;
        
        $insClaim = "INSERT INTO tr_claim (regclaim, regid, tgllapor, tmpkejadian, tglkejadian, detail, statclaim, createdt, createby, penyebab, expireddt, nopk, nilaios,doctype)
        VALUES     ('$sregclaim',
                    '$sregid',
                    '$stgllapor',
                    '$stmpkejadian',
                    '$stglkejadian',
                    '$sdetail',
                    '$status',
                    '$sdate',
                    '$userid',
                    '$spenyebab',
                    '$tglexpired',
                    '$snopeserta',
                    '$snilaios',
                    '$sdoctype') ";
        
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        return view('modul.klaim.edit', compact('data','tempat_kejadian','penyebab','hubungan','dokumen','file','sid'));
    }
    public function inquiryklaim()
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        $data = [
            'judul' => 'Klaim',
        ];
        $agent = new \Jenssegers\Agent\Agent;
        // if($agent->isDesktop()){
        //     return view('modul.pembatalan.index_desktop', compact('data','inquiry'));
        // }else{
        return view('modul.klaim.inquiry_klaim', compact('data'));
        // }
    }
    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('modul.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
