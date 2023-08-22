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
class ValidasiController extends Controller
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
            
            $sTable ="SELECT aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai,aa.status, ac.msdesc proddesc, ab.msdesc cab FROM tr_sppa aa left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'  left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' WHERE aa.asuransi IN (select cabang FROM ms_admin  WHERE ms_admin.level='insurance')";
            $sTable .= " AND CONCAT(aa.regid, aa.nama, aa.tgllahir, aa.up, aa.nopeserta) LIKE '$cari' AND aa.status = 10 ORDER BY aa.regid LIMIT 100";
            // $sTable .= " AND aa.regid LIKE '$cari' OR aa.nama LIKE '$cari' OR aa.noktp LIKE '$cari' OR aa.tgllahir LIKE '$cari' OR aa.up LIKE '$cari' OR aa.nopeserta LIKE '$cari' OR aa.up LIKE '$cari' OR aa.premi LIKE '$cari' OR aa.mulai LIKE '$cari' OR ac.msdesc LIKE '$cari' OR ab.msdesc LIKE '$cari' ORDER BY aa.regid ASC LIKE '$cari' LIMIT 10";

            // $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            // dd(DB::select("SELECT aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai,aa.status, ac.msdesc proddesc, ab.msdesc cab FROM tr_sppa aa left join ms_master ab on aa.cabang=ab.msid and ab.mstype='cab'  left join ms_master ac on ac.msid=aa.produk and ac.mstype='produk' WHERE aa.status = 10 AND aa.asuransi IN (select cabang FROM ms_admin  WHERE ms_admin.level='insurance' )"));
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'validasi/validasi/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Validasi</a>&nbsp;';
                    $button .= '<a href="'.'validasi/reject/'. Crypt::encryptString($data->regid).'"  class="btn btn-danger text-white btn-sm" style="display:inline !important;">Reject</a>&nbsp;';
                    $button .= '<a href="'.'validasi/rollback/'. Crypt::encryptString($data->regid).'"  class="btn btn-success  text-white btn-sm" style="display:inline !important;">Rollback</a>&nbsp;';
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

        // $custCol = "";
        //     $custJoin = "";
        //     if ($vlevel == "insurance") {
        //         $custCol = ",'-',(IF(ae.borderono IS NOT NULL, 'YES', 'NO'))";
        //         $custJoin = " LEFT JOIN tr_bordero_dtl ae ON ae.regid = aa.regid ";
        //     }
        //     $sTable = "SELECT regid, nama, cabang, tgllahir, tglbatal, mulai, up, premi, status, aksi, reg_encode FROM (SELECT aa.regid, aa.nama, ad.msdesc 'cabang', aa.tgllahir, ab.tglbatal,aa.mulai, aa.up, aa.premi, ac.msdesc 'status', Concat(aa.regid, '-', aa.status, '-', aa.policyno $custCol) 'aksi',aa.regid reg_encode FROM   tr_sppa aa INNER JOIN tr_sppa_cancel ab ON aa.regid = ab.regid LEFT JOIN ms_master ac ON ac.msid = aa.status AND ac.mstype = 'STREQ' LEFT JOIN ms_master ad ON ad.msid = aa.cabang AND ad.mstype = 'CAB' $custJoin";
        //     if ($vlevel == "checker" or $vlevel == "schecker") {
        //         $sTable .= " WHERE aa.status IN ('7','73','8','83','84','85') AND aa.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%' ELSE cabang END cabang FROM ms_admin WHERE username = '$userid') ";
        //     } else if ($vlevel == "broker") {
        //         $sTable .= "WHERE aa.status IN ('7','8','71','81','83') ";
        //     } else if ($vlevel == "insurance") {
        //         $sTable .= "WHERE (aa.status IN ('72','82') OR (aa.status = '84' AND ae.borderono IS NOT NULL)) AND aa.asuransi IN (SELECT cabang FROM ms_admin WHERE level='insurance' AND username='$userid' ) ";
        //     }

        // $sTable .= " ) t_baru  LIMIT 10";
        // $validasi = DB::select($sTable);
        // dd($validasi); 
        // dd(Session::get('login')[0]);
        
        $data = [
            'judul' => 'validasi',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.validasi.index_desktop', compact('data'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.validasi.index', compact('data','validasi'));
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
                    $button = '<a href="'.'../inquiryclaim/view/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;<a href="'.'../validasi/detail_cancel/'. Crypt::encryptString($data->regid).'"  class="btn btn-danger btn-sm text-white" style="display:inline !important;">'.$status.'</a>';
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
        $data = [
            'judul' => 'validasi',
        ];
        $agent = new \Jenssegers\Agent\Agent;
        // if($agent->isDesktop()){
        //     return view('modul.validasi.index_desktop', compact('data','inquiry'));
        // }else{
        return view('modul.validasi.inquiry_cancel', compact('data'));
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
    public function update(Request $request)
    {
        // $sup = str_replace('.', '', $request->up);
        $sregid = Crypt::decryptString($request->regid);
        $snopeserta = $request->nopeserta;
        $scomment = $request->comment;
        $sstatus = $request->status;
        $sid = Crypt::decryptString($request->id);
        $sdate = date('Y-m-d H:i:s');
        $userid = Session::get('login')[0]->username;
        $vlevel = Session::get('login')[0]->level;
        
        
        $sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno  from  tbl_lastno_form a  LEFT JOIN tbl_lastno_trans  b ON a.trxid=b.trxid WHERE a.trxid= 'polno'  ";
        $nourut = DB::select($sqll);
        DB::select("update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'polno'");
        $policyno=$nourut[0]->seqno;
        
        DB::select("UPDATE tr_sppa SET nopeserta='$snopeserta',policyno='$policyno', status='5', validby='$userid',validdt='$sdate' WHERE regid='$sregid'");
        
        DB::select("insert into tr_billing (billno,billdt,duedt,policyno,reffno,grossamt,nettamt,admamt,discamt,totalamt,remark,billtype) select concat(aa.prevno,DATE_FORMAT(now(),aa.formdt),aa.billno) sbillno,  now(),date_add(now(),interval 15 day),bb.policyno,regid endorsno,gpremi,gpremi,0,0,gpremi,'Premi New business',1  from (select a.prevno, concat(right(concat(a.formseqno,b.lastno),formseqlen)) billno ,formdt  from tbl_lastno_form a inner join tbl_lastno_trans b on a.trxid=b.trxid  where a.trxid='billpre') aa ,  (select regid,policyno,sum(tpremi) gpremi from tr_sppa  where regid='$sregid' group by policyno,regid) bb ");
        DB::select("update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'billpre'");
        DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) select regid,'5','$userid','$sdate','$scomment' from tr_sppa where regid='$sregid'");
        
        if ($sstatus=='10'){
            
            
            DB::select("UPDATE tr_sppa SET nopeserta='$snopeserta',status='5', validby='$userid',validdt='$sdate' WHERE regid='$sregid' ");
            DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) select regid,'5','$userid','$sdate','$scomment' from tr_sppa where regid='$sregid'");
            
        }
        
        // dd($request);
        // dd(DB::select("SELECT * FROM tr_sppa WHERE regid = '$sregid'"));
        return redirect()->intended('validasi')->with('success', 'Data Berhasil divalidasi');
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
        return view('modul.validasi.detail_cancel', compact('data','alasan','jkel','kerja','cab','mitra','hubungan','id'));
    }
    public function cekvalidasi($id)
    { 
        $sid = Crypt::decryptString($id);
        $userid = Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        $data = DB::select("SELECT aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.tempat_lahir,aa.mulai,  aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno,aa.alamat,aa.nama_ahli_waris,aa.notelp_ahli_waris,aa.hubungan_ahli_waris FROM tr_sppa aa WHERE aa.regid='$sid'");
        // $data = DB::select($sqle);
        $sproduk = $data[0]->produk;
        $sup = $data[0]->up;
        $jkel = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel' order by ms.mstype");
        $produk = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk' order by ms.mstype");
        $cabang = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype");
        $mitra = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype");
        $pekerjaan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype");        
        $asuransi = DB::select("SELECT ms.msid comtabid,msdesc comtab_nm from ms_master ms left join tr_limit tl on ms.msid=tl.asuransi where ms.mstype='ASURANSI' and tl.produk='$sproduk' and '$sup' BETWEEN tl.minup and tl.maxup group by ms.msid,ms.msdesc ");        
		$hubungan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='hubungan'  order by ms.mstype");
        $file = DB::select(" SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc FROM tr_document a WHERE regid = '$sid'");
        $log = DB::select(" SELECT a.regid,a.status,a.comment,a.createdt,a.createby,b.msdesc stdesc FROM tr_sppa_log a INNER JOIN ms_master b ON a.status = b.msid AND b.mstype = 'streq' WHERE regid = '$sid' ORDER BY a.createdt DESC");
		$sid = $id;
        return view('modul.validasi.edit',compact('data','produk','cabang','pekerjaan','mitra','asuransi','hubungan','file','log','sid'));
    }
    public function view($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,  aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno FROM tr_sppa aa WHERE aa.regid='$sid'");
        
        // $data = DB::select("SELECT aa.*, ab.tglbatal, ab.masa, ab.sisa, ab.refund, ab.reason, ab.catreason, ac.msdesc resdesc FROM   tr_sppa aa INNER JOIN tr_sppa_cancel ab ON ab.regid = aa.regid LEFT JOIN ms_master ac ON ac.msid = ab.catreason AND ac.mstype = 'batal' WHERE  aa.regid = '$sid'");
        $alasan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype in ('batal','refund')  order by ms.mstype ");
        $jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
        $kerja = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        $cab = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
        $dokumen = DB::select("SELECT a.regid, a.tglupload, a.nama_file, a.tipe_file, a.ukuran_file, a.FILE, a.pages, a.seqno, a.jnsdoc FROM   tr_document a WHERE  regid = '$sid' ");
        // dd($dokumen);
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        return view('modul.validasi.detail', compact('data','alasan','jkel','kerja','cab','mitra','hubungan','dokumen','file','sid'));
    }
    public function reject($id){
        $sregid = Crypt::decryptString($id);
        $sdate = date('Y-m-d H:i:s');
        $userid = Session::get('login')[0]->username;
        $vlevel = Session::get('login')[0]->level;
        $scomment = "Aplikasi di cancel";
        // DB::select("UPDATE tr_sppa SET comment='$scomment', status='12', validby='$userid',validdt='$sdate' WHERE regid='$sregid'");
        dd(DB::select("SELECT * FROM tr_sppa WHERE regid='$sregid'"));
        DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) select regid,'12','$userid','$sdate',concat(comment,' ; aplikasi di cancel ') from tr_sppa where regid='$sregid' ");
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));
        
        // return redirect()->intended('validasi')->with('success', 'Data Berhasil disimpan');
    }
    public function rollback($id){
        $sregid = Crypt::decryptString($id);
        $sdate = date('Y-m-d H:i:s');
        $userid = Session::get('login')[0]->username;
        $vlevel = Session::get('login')[0]->level;
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));
        DB::select("UPDATE tr_sppa SET status='1' WHERE regid='$sregid' and status='4'");
        DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) select regid,'0','$userid','$sdate','Rollback' from tr_sppa WHERE regid='$sregid' ");
        DB::select("UPDATE tr_sppa SET status='0' WHERE regid='$sregid' and status='10'");
        DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) select regid,'0','$userid','$sdate','Rollback' from tr_sppa where regid='$sregid'  and status='10'");
        
        return redirect()->intended('validasi')->with('success', 'Data Berhasil disimpan');
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
        return view('modul.validasi.log', compact('data','data2'));
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
        $pdf = PDF::loadview('modul.validasi.cetak', compact('bill','transaction'));
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
