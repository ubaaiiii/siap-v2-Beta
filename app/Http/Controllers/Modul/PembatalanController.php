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
class PembatalanController extends Controller
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
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getData(Request $request)
    {
        // if($request->ajax())
        // {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            // Session::get('login')[0]->id_member;
            $output = "";
            $sTable = "SELECT SQL_CALC_FOUND_ROWS regid,nama,up,premi,sts,comment,reg_encode,status FROM (SELECT aa.regid,aa.nama,aa.up,aa.premi,aa.comment,ad.msdesc sts,aa.regid reg_encode,aa.status FROM tr_sppa aa LEFT JOIN ms_admin ac ON ac.username = aa.createby LEFT JOIN ms_master ad ON ad.msid = aa.status AND ad.mstype = 'STREQ'";
            // if ($vlevel == 'smkt') {
            //     $sTable .= "AND aa.createby IN ( SELECT CASE WHEN a.parent=a.username THEN a.parent ELSE a.username END FROM ms_admin a WHERE ( a.username='$userid' OR a.parent='$userid')) ";
                
            // } else {
            //     $sTable .= "AND aa.createby IN ('$userid') ";
                                                  
            // }
            
            // $mitra = (Session::get('login')[0]->mitra == NULL)?('NOM'):(Session::get('login')[0]->mitra);
            // if ($mitra !== 'NOM') {
            //     $sTable .= " AND aa.mitra = '$mitra' ";
            // }
            
            // if ($_POST['sSearch'] == '') {
            //     $sTable .= " ORDER BY aa.createdt DESC";
            // }
            $sTable .= " ) t_baru WHERE regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR sts LIKE '$cari' OR comment LIKE '$cari' OR reg_encode LIKE '$cari' OR status  LIKE '$cari' LIMIT 10";

            $data = DB::select($sTable); 
            if($data){
                foreach ($data as $key => $p) {
                                        
                    $output.='<div class="col-md-6 card shadow-sm mb-4">'.
                                '<div class="card-body">'.
                                    '<div class="row container">'.
                                        '<div class="col align-self-center">'.
                                            '<h5 class="mb-0 text-color-theme">'.$p->nama.'</h5>'.
                                        '</div>'.
                                    '</div>'.
                                '</div>'.
                                '<div class="card border-0">'.
                                    '<div class="card-body">'.
                                        '<div class="row container mb-2">'.
                                            '<div class="col align-self-center">'.
                                                '<p class="text-muted size-12 mb-0">UP : '.number_format(floatval($p->up)).'</p>'.
                                            '<p class="text-muted size-12">Primi : '.number_format(floatval($p->premi)).'</p>'.
                                            '</div>'.
                                            '<div class="col align-self-top text-end">'.
                                                '<p class="text-muted size-12 mb-0">Jakarta, 1 Januari</p>'.
                                                '<p class="text-muted size-12">' .$p->sts.'</p>'.
                                            '</div>'.
                                        '</div>'.
                                        '<a href="'.'pengajuan/edit/'. Crypt::encryptString($p->regid).'" class="btn btn-default w-100 shadow small">Detail</a>'.
                                    '</div>'.
                                '</div>'.
                            '</div> ';
                }

                return Response($output);
           }
            // dd($data);
            // return DataTables::of($data)
            //         ->addColumn('action', function($data){
            //             $button = '<a id=""  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
            //             $button .= '<a id=""  class="btn btn-default btn-sm" style="display:inline !important;">Salin</a>&nbsp;';
            //             $button .= '<a id=""  class="btn btn-default btn-sm" style="display:inline !important;">Log</a>&nbsp;';
            //             $button .= '<a id=""  class="btn btn-default btn-sm" style="display:inline !important;">Doc</a>&nbsp;';
            //             $button .= '<a id=""  class="btn btn-default btn-sm" style="display:inline !important;">Approve</a>';
            //             return $button;
            //         })
            //         ->rawColumns(['action'])
            //         ->make(true);
        // }
        // return view('master.pengajuan.index');
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
            if ($vlevel == "insurance") {
                $custCol = ",'-',(IF(ae.borderono IS NOT NULL, 'YES', 'NO'))";
                $custJoin = " LEFT JOIN tr_bordero_dtl ae ON ae.regid = aa.regid ";
            }
            $sTable = "SELECT regid, nama, cabang, tgllahir, tglbatal, mulai, up, premi, status, aksi, reg_encode FROM (SELECT aa.regid, aa.nama, ad.msdesc 'cabang', aa.tgllahir, ab.tglbatal,aa.mulai, aa.up, aa.premi, ac.msdesc 'status', Concat(aa.regid, '-', aa.status, '-', aa.policyno $custCol) 'aksi',aa.regid reg_encode FROM   tr_sppa aa INNER JOIN tr_sppa_cancel ab ON aa.regid = ab.regid LEFT JOIN ms_master ac ON ac.msid = aa.status AND ac.mstype = 'STREQ' LEFT JOIN ms_master ad ON ad.msid = aa.cabang AND ad.mstype = 'CAB' $custJoin";
            if ($vlevel == "checker" or $vlevel == "schecker") {
                $sTable .= " WHERE aa.status IN ('7','73','8','83','84','85') AND aa.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%' ELSE cabang END cabang FROM ms_admin WHERE username = '$userid') ";
            } else if ($vlevel == "broker") {
                $sTable .= "WHERE aa.status IN ('7','8','71','81','83') ";
            } else if ($vlevel == "insurance") {
                $sTable .= "WHERE (aa.status IN ('72','82') OR (aa.status = '84' AND ae.borderono IS NOT NULL)) AND aa.asuransi IN (SELECT cabang FROM ms_admin WHERE level='insurance' AND username='$userid' ) ";
            }
            $sTable .= " ) t_baru WHERE regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR cabang LIKE '$cari' OR tglbatal LIKE '$cari' OR reg_encode LIKE '$cari' OR status  LIKE '$cari'";

            // $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'pembatalan/view/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
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
        // Session::get('login')[0]->id_member;
        // dd($request->server('HTTP_SEC_CH_UA_PLATFORM'));

        $custCol = "";
            $custJoin = "";
            if ($vlevel == "insurance") {
                $custCol = ",'-',(IF(ae.borderono IS NOT NULL, 'YES', 'NO'))";
                $custJoin = " LEFT JOIN tr_bordero_dtl ae ON ae.regid = aa.regid ";
            }
            $sTable = "SELECT regid, nama, cabang, tgllahir, tglbatal, mulai, up, premi, status, aksi, reg_encode FROM (SELECT aa.regid, aa.nama, ad.msdesc 'cabang', aa.tgllahir, ab.tglbatal,aa.mulai, aa.up, aa.premi, ac.msdesc 'status', Concat(aa.regid, '-', aa.status, '-', aa.policyno $custCol) 'aksi',aa.regid reg_encode FROM   tr_sppa aa INNER JOIN tr_sppa_cancel ab ON aa.regid = ab.regid LEFT JOIN ms_master ac ON ac.msid = aa.status AND ac.mstype = 'STREQ' LEFT JOIN ms_master ad ON ad.msid = aa.cabang AND ad.mstype = 'CAB' $custJoin";
            if ($vlevel == "checker" or $vlevel == "schecker") {
                $sTable .= " WHERE aa.status IN ('7','73','8','83','84','85') AND aa.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%' ELSE cabang END cabang FROM ms_admin WHERE username = '$userid') ";
            } else if ($vlevel == "broker") {
                $sTable .= "WHERE aa.status IN ('7','8','71','81','83') ";
            } else if ($vlevel == "insurance") {
                $sTable .= "WHERE (aa.status IN ('72','82') OR (aa.status = '84' AND ae.borderono IS NOT NULL)) AND aa.asuransi IN (SELECT cabang FROM ms_admin WHERE level='insurance' AND username='$userid' ) ";
            }

        $sTable .= " ) t_baru  LIMIT 10";

        $pembatalan = DB::select($sTable);
        // dd($pembatalan); 
        // dd(Session::get('login')[0]);
        $data = [
            'judul' => 'Pembatalan',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.pembatalan.index_desktop', compact('data','pembatalan'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.pembatalan.index', compact('data','pembatalan'));
        // }
    }
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
                    $button = '<a href="'.'../inquiryclaim/view/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;<a href="'.'../pembatalan/detail_cancel/'. Crypt::encryptString($data->regid).'"  class="btn btn-danger btn-sm text-white" style="display:inline !important;">'.$status.'</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function inquirycancel()
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        
        // $sTable = "SELECT SQL_CALC_FOUND_ROWS regid,produk,nama,tgllahir,cabang,mulai,up,premi,status,aksi FROM (SELECT aa.regid,aa.nama,
        // ac.msdesc cabang, ad.msdesc produk,aa.tgllahir, aa.mulai, aa.up, aa.premi, ab.msdesc status, concat(aa.regid,'-',aa.status) aksi FROM (select * from tr_sppa where status in ('5','6','20' )) aa 
        // INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='STREQ') ab ON aa.status = ab.msid 
        // LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype = 'CAB') ac ON ac.msid = aa.cabang 
        // INNER JOIN (SELECT msid,msdesc FROM ms_master WHERE mstype='PRODUK') ad ON ad.msid = aa.produk 
        // WHERE  aa.status IN ( '5', '6', '20' ) )t_baru LIMIT 100 ";
        
        // if ($vlevel=="schecker" or $vlevel=="checker") {
        //     $sTable .= " AND aa.cabang LIKE (SELECT CASE WHEN cabang='ALL' THEN '%%'
        //                                                 ELSE cabang END cabang
        //                                     FROM ms_admin
        //                                     WHERE username='$userid')  t_baru LIMIT 10";
                                            
        // } else {
        //     $sTable .= " t_baru  LIMIT 10";
        // }
            
        // $inquiry = DB::select($sTable);
        // dd($inquiry); 
        $data = [
            'judul' => 'Pembatalan',
        ];
        $agent = new \Jenssegers\Agent\Agent;
        // if($agent->isDesktop()){
        //     return view('modul.pembatalan.index_desktop', compact('data','inquiry'));
        // }else{
        return view('modul.pembatalan.inquiry_cancel', compact('data'));
        // }
    }
    public function add()
    {
        // dd(Session::get('login')[0]->id_member);
        // $brand = DB::select("SELECT * FROM md_brand");
        // $category = DB::select("SELECT * FROM md_category");
        // $tokopedia = DB::select("SELECT * FROM md_category_tokopedia");
        // $shopee = DB::select("SELECT * FROM md_category_shopee");
        // return view('master.product.add', compact('brand','tokopedia','shopee','category'));
        $produk = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
        $kerja = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        $cab = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
        // dd($jkel);
        return view('master.pengajuan.add', compact('produk','jkel','kerja','cab','mitra','hubungan'));
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
        // $sup = str_replace('.', '', $request->up);
        $sregid = Crypt::decryptString($request->regid);
        $scanceldt = $request->tglbatal;
        $scatreason = $request->catreason;
        $sreason = $request->reason;
        $userid = Session::get('login')[0]->username;
        $sdate      = date('Y-m-d H:i:s');
        // $sjkel = $request->jkel;
        // $snama      = str_replace("'", "`", $request->nama);
        // $susia = $request->usia;
        // $snoktp = $request->noktp;
        // $stmplahir = $request->tmplahir;
        // $smasa = $request->masa;
        $querycek   = DB::select("SELECT YEAR(mulai) 'mulai' from tr_sppa where regid = '$sregid'");
        $persentase = "";
        if ($querycek[0]->mulai < '2021') {
            $persentase = 50;
        } else {
            $persentase = 35;
        }
        // dd(DB::select("DELETE FROM tr_sppa_cancel WHERE tr_sppa_cancel.regid = '$sregid'"));
        
        DB::select("INSERT  INTO tr_sppa_cancel (regid, tglbatal, refund, masa, sisa, createby, createdt, statcan, catreason, reason) SELECT a.regid, '$scanceldt',IF (b.regid IS NULL, 0, IF (Datediff('$scanceldt', b.paiddt) < 30, a.premi,(Floor(Datediff(akhir, '$scanceldt') / 30.4) / masa ) * (tpremi * $persentase / 100 ))),masa,Floor(Datediff(akhir, '$scanceldt') / 30.4),'$userid','$sdate','1','$scatreason','$sreason' FROM   tr_sppa a LEFT JOIN tr_sppa_paid b ON a.regid = b.regid AND b.paidtype = 'PREMI' WHERE  a.regid = '$sregid' AND b.regid IS NOT NULL");
        
        
        DB::select("UPDATE tr_sppa SET    status = '8' WHERE  regid = '$sregid'");
        DB::select("INSERT INTO tr_sppa_log (regid, status, createby, createdt) VALUES ('$sregid','8','$userid','$sdate')  ");
        // DB::select("INSERT INTO tr_sppa (regid, nama, noktp, jkel, tempat_lahir, alamat, pekerjaan, cabang, tgllahir, mulai, akhir, masa, up, nopeserta, status, createby,createdt, premi, epremi,tpremi, usia, produk, tunggakan, bunga, mitra, nama_ahli_waris, notelp_ahli_waris, hubungan_ahli_waris, comment)VALUES('$regid','$snama','$snoktp','$sjkel','$stmplahir','$salamat','$spekerjaan','$scabang','$stgllahir','$smulai','$sakhir','$smasa','$sup','$snopeserta','$status','$userid','$sdate','$spremi','$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra','$nmahli','$notelpahli','$hubungan','$scomment')");
        return redirect()->intended('pembatalan')->with('success', 'Data Berhasil ditambahkan');
    }
    public function detail_cancel($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT aa.*,ab.tglbatal,ab.reason,ab.catreason,ac.paiddt 'tglbayar' FROM   tr_sppa aa LEFT JOIN tr_sppa_cancel ab ON ab.regid = aa.regid LEFT JOIN (SELECT * FROM tr_sppa_paid WHERE paidtype='PREMI') ac ON ac.regid = aa.regid WHERE  aa.regid = '$sid'");
        // dd($data);
        $alasan = "";
        if ($data[0]->status == '20') {
            $alasan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='refund'  order by ms.mstype ");
        }else{
            $alasan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='batal'  order by ms.mstype ");
        }
        $jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
        $kerja = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        $cab = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
        // dd($data);
        return view('modul.pembatalan.detail_cancel', compact('data','alasan','jkel','kerja','cab','mitra','hubungan','id'));
    }
    public function view($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT aa.*, ab.tglbatal, ab.masa, ab.sisa, ab.refund, ab.reason, ab.catreason, ac.msdesc resdesc FROM   tr_sppa aa INNER JOIN tr_sppa_cancel ab ON ab.regid = aa.regid LEFT JOIN ms_master ac ON ac.msid = ab.catreason AND ac.mstype = 'batal' WHERE  aa.regid = '$sid'");
        $alasan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype in ('batal','refund')  order by ms.mstype ");
        $jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
        $kerja = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        $cab = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
        $dokumen = DB::select("SELECT a.regid, a.tglupload, a.nama_file, a.tipe_file, a.ukuran_file, a.FILE, a.pages, a.seqno, a.jnsdoc FROM   tr_document a WHERE  regid = '$sid' ");
        // dd($dokumen);
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        return view('modul.pembatalan.detail', compact('data','alasan','jkel','kerja','cab','mitra','hubungan','dokumen','file','sid'));
    }
    public function approve($id){
        $sregid = Crypt::decryptString($id);
        $sdate = date('Y-m-d H:i:s');
        $userid = Session::get('login')[0]->username;
        $vlevel = Session::get('login')[0]->level;
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));
        $dcek   = DB::select("SELECT status from tr_sppa where regid = '$sregid'");
        $dstatus    = $dcek[0]->status;
        $statBaru = "";
        if ($vlevel == 'insurance') {
            $statBatal  = ['72'];
            $statRefund = ['82'];
            if ($dstatus == '72') {
                $statBaru = '73';
            } elseif ($dstatus == '82') {
                $statBaru = '83';
            }
        } elseif ($vlevel == 'broker') {
            $statBatal  = ['7', '71'];
            $statRefund = ['8', '81'];
            if ($dstatus == '7' || $dstatus == '71') {
                $statBaru = '72';
            } elseif ($dstatus == '8' || $dstatus == '81') {
                $statBaru = '82';
                $insBil = " INSERT INTO tr_billing (billno, billdt, duedt, policyno, reffno, grossamt, nettamt, admamt, discamt, totalamt, remark, billtype) SELECT Concat(aa.prevno, Date_format(Now(), aa.formdt), aa.billno) sbillno, Now(), Date_add(Now(), interval 15 day),bb.policyno,regid endorsno, gpremi, gpremi, 0, 0, gpremi, Concat('Refund Premi ; tanggal batal ', bb.tglbatal), 1 FROM   (SELECT a.prevno, Concat(Right(Concat(a.formseqno, b.lastno), formseqlen)) billno, formdt FROM   tbl_lastno_form a inner join tbl_lastno_trans b ON a.trxid = b.trxid WHERE  a.trxid = 'billpre') aa, (SELECT a.regid, b.policyno, SUM(a.refund) *- 1 gpremi, a.tglbatal FROM   tr_sppa_cancel a inner join tr_sppa b ON a.regid = b.regid WHERE  a.regid = '$sregid' GROUP  BY b.policyno,a.regid) bb  ";
                $updLast = "UPDATE tbl_lastno_trans SET lastno = lastno + 1 WHERE  trxid = 'billpre'  ";
                
            }
        } elseif ($vlevel == 'schecker') {
            $statBatal  = ['7','71'];
            $statRefund = ['8','81'];
            if ($dstatus == '7' || $dstatus == '71') {
                $statBaru = '71';
            } elseif ($dstatus == '8' || $dstatus == '81') {
                $statBaru = '81';
            }
        }
        $updSPPA = "UPDATE tr_sppa SET    status = '$statBaru', editby = '$userid', editdt = '$sdate' WHERE  regid = '$sregid' AND status = '$dstatus'  ";
        $insLog = " INSERT INTO tr_sppa_log (regid, status, createby, createdt) VALUES ('$sregid','$statBaru','$userid','$sdate')  ";
 
        return redirect()->intended('pembatalan')->with('success', 'Data Berhasil disimpan');
    }
    public function log($id,$type)
    {
        $regid = Crypt::decryptString($id);
        $data = DB::select("SELECT a.*  FROM tr_sppa a where a.regid='$regid'");
        $status= "";
        if ($type == 'LTPGJ') {
            $status = "NOT IN ( '7','71','72','73','8','81','82','83','84','85','90','91','92','93','94','95','96' )";
        } elseif ($type == 'LTBTL') {
            $status = "IN ( '7','71','72','73' )";
        } elseif ($type == 'LTRFN') {
            $status = "IN ( '8','81','82','83','84','85' )";
        } elseif ($type == 'LTCLM') {
            $status = "IN ( '90','91','92','93','94','95','96' )";
        } else {
            $status = "LIKE '%%'";
        }
        
        $data2 = DB::select("SELECT a.regid,a.status,a.comment,a.createdt,a.createby,b.msdesc statpol FROM tr_sppa_log a INNER JOIN ms_master b ON a.status=b.msid AND        b.mstype='STREQ' WHERE a.regid='$regid' AND status $status ORDER BY a.createdt DESC  ");
        // dd($data2);
        return view('modul.pembatalan.log', compact('data','data2'));
    }
    public function cetak($id)
    {
        $spolicyno = Crypt::decryptString($id);
        $bill = DB::select("select a.billno,date_format(a.billdt,'%d-%m-%Y') billdt from tr_billing a where a.policyno='$spolicyno'");
        // $transaction = DB::select("SELECT a.policyno,'Bank Bukopin' sclientname, nama clientname,'Asuranis Kredit' object,a.mulai effdt,a.akhir expdt,'Asuransi Kredit ' instype,grossamt,totalamt,mp.msdesc object, a.up, a.masa, a.regid FROM tr_sppa a INNER JOIN tr_billing b ON a.policyno = b.policyno INNER JOIN ms_master mp ON mp.msid = a.produk AND mp.mstype = 'produk' WHERE  a.policyno = '$spolicyno'");
        $transaction = DB::select("select a.policyno,'Bank Bukopin' sclientname,nama clientname, 'Asuranis Kredit' object, a.mulai effdt,a.akhir expdt , 'Asuransi Kredit ' instype, grossamt ,totalamt ,c.msdesc  object,a.up,a.masa,a.regid ,b.remark  from tr_sppa a inner join tr_billing b on a.policyno=b.policyno inner join ms_master c on c.msid=a.produk and c.mstype='produk' where a.policyno='$spolicyno' and b.grossamt<0");
        $sys = DB::select("select companyname,bank,acctno,acctname from ms_systab limit 1");
// 
        // dd($transaction);
        $pdf = PDF::loadview('modul.pembatalan.cetak', compact('bill','transaction'));
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        return $pdf->stream('laporan.pdf');
    }
    
    
    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
