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
class CheckerController extends Controller
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
            if(Session::get('login')[0]->level == 'checker' || Session::get('login')[0]->level == 'schecker'){
                // View::share( 'loggedInUser' ,  $user );
                return $next($request);
            }
            return redirect()->intended('index')->with('error', 'Maaf kamu tidak dapat mengakses ini');
            
        });
    }

    public function getDesktop(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            $sqlr = "";
            if ($vlevel == "checker") {
                $sqlr = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
                $sqlr = $sqlr . " ,cb.msdesc cabang,pd.msdesc produk,aa.masa from tr_sppa aa  ";
                $sqlr = $sqlr . "  left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
                $sqlr = $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
                $sqlr = $sqlr . " where aa.status='11'  ";
                $sqlr = $sqlr . " and aa.cabang like  ( ";
                $sqlr = $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
                $sqlr = $sqlr . "from ms_admin where username='$userid' )";
            }
            
            if ($vlevel == "schecker") {
                $sqlr = "select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai ";
                $sqlr = $sqlr . " ,cb.msdesc cabang,pd.msdesc produk,aa.masa from tr_sppa aa  ";
                $sqlr = $sqlr . "  left join ms_master cb on cb.msid=aa.cabang and cb.mstype='cab' ";
                $sqlr = $sqlr . "  left join ms_master pd on pd.msid=aa.produk and pd.mstype='produk' ";
                $sqlr = $sqlr . " where aa.status='2'  ";
                $sqlr = $sqlr . " and aa.cabang like  ( ";
                $sqlr = $sqlr . " select case when cabang='ALL' THEN '%%' ELSE cabang END cabang  ";
                $sqlr = $sqlr . "from ms_admin where username='$userid' )";
            }
            $sqlr = "SELECT    '' cek,
                            aa.regid, 
                            aa.nama, 
                            aa.tgllahir, 
                            aa.up, 
                            aa.nopeserta, 
                            aa.premi, 
                            aa.mulai , 
                            cb.msdesc cabang, 
                            pd.msdesc produk, 
                            aa.masa,
                            concat(aa.regid,'-',IF(aa.nopeserta='', 'null', aa.nopeserta),'-',aa.nama) aksi
                FROM      tr_sppa aa 
                LEFT JOIN ms_master cb 
                ON        cb.msid=aa.cabang AND cb.mstype='cab' 
                LEFT JOIN ms_master pd 
                ON        pd.msid=aa.produk AND pd.mstype='produk' 
                WHERE     aa.status='20' 
                AND       aa.cabang LIKE ( SELECT 
                                                CASE 
                                                    WHEN cabang='ALL' THEN '%%' 
                                                    ELSE cabang 
                                                END  cabang 
                                                FROM ms_admin WHERE username='$userid')";
            $sqlr = $sqlr . " AND aa.regid LIKE '$cari' OR aa.nama LIKE '$cari' OR aa.noktp LIKE '$cari' OR aa.nopeserta LIKE '$cari' LIMIT 100";
            // $sTable .= " group by b.msdesc ,year(mulai) LIMIT 100";
            $data = DB::select($sqlr);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'checker/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
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
            'judul' => 'Checker',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.checker.index_desktop', compact('data'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.cabang.index', compact('data','cabang'));
        // }
    }
    public function store(Request $request)
    {
        $scode=$request->code;
        $sdesk=$request->desk;
        $stype='cab';
        $userid = Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        DB::select("INSERT INTO ms_master (msid,msdesc,mstype,createby,createdt) VALUES ('$scode','$sdesk','$stype','$userid','$sdate')");
        // dd(DB::select("SELECT * FROM ms_master WHERE msid='$scode'"));
        return redirect()->intended('cabang')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT * FROM tr_sppa WHERE regid='$sid'");
        $produk     = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $jkel       = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
        $kerja      = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        $cab        = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra      = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $hubungan   = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
        $asuransi   = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='asuransi' and ms.msid<>'ALL'order by ms.msid");
        $dokumen    = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
        // dd($data);
        return view('modul.checker.edit', compact('data','produk','jkel','kerja','cab','mitra','hubungan','dokumen','file','sid','asuransi'));
    }
    public function update(Request $request){
        $sregid = Crypt::decryptString($request->regid);
        $scode=$request->code;
        $sdesk=$request->desk;
        $stype='cab';
        $userid=Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        $sjkel      = $request->jkel;
		$stgllahir  = $request->tgllahir;
		$stunggakan = $request->tunggakan;
		$smasa      = $request->masa;
		$smulai      = $request->mulai;
		$mulai      = $request->mulai;
		$status     = $request->status;
		$sproduk     = $request->produk;
		// $susia     = $request->usia;
		$sup     = $request->up;
        $susia      = app('App\Http\Controllers\Modul\PengajuanController')->hitung_umur($stgllahir, $smulai);
        $rates = DB::select("SELECT rates,
                ratesother
                FROM   tr_rates
                WHERE  produk = '$sproduk'
                AND jkel = '$sjkel'
                AND '$susia' BETWEEN
                    umurb AND umura
                AND insperiodmm = '$smasa'
                AND '$stunggakan' BETWEEN gpb AND gpa
                AND $sup BETWEEN minup AND maxup ");
        // dd($rates);
        $sakhir  = date('Y-m-d', strtotime('+' . $smasa . 'months', strtotime($smulai)));
        DB::select("UPDATE tr_sppa
        SET    masa = '$smasa',
               mulai = '$smulai',
               akhir = '$sakhir',
               usia = '$susia',
               up = '$sup'
        WHERE  regid = '$sregid'");
        DB::select("INSERT INTO tr_sppa_log
        (regid, status, createby, createdt, comment)
            VALUES ('$sregid',
         '$status',
         '$userid',
         '$sdate',
         'Perubahan Tanggal Mulai Asuransi<br>
          Sebelumnya: ".date_format(date_create($mulai),"d-m-Y")."<br>
          Menjadi: ".date_format(date_create($smulai),"d-m-Y")."')");
        // dd($request);
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));
        // DB::select("UPDATE tr_sppa SET status = '1',editby = '$userid',editdt = '$sdate' WHERE regid = '$sregid' AND premi <> 0 AND masa <> 0 AND usia <> 0");
        // DB::select("UPDATE ms_master SET msdesc='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
        // dd($id);
        return redirect()->intended('checker')->with('success', 'Data Berhasil disimpan');
    }
    public function approve($id)
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        $sregid = Crypt::decryptString($id);
        $sdate = date('Y-m-d H:i:s');
        if ($vlevel == "checker") {
            $sqlu = "UPDATE tr_sppa SET status='2',editby='$userid' ";
            $sqlu = $sqlu . " WHERE regid='$sregid'  ";
            /* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
            DB::select($sqlu);
    
            $sqll = "insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
            $sqll = $sqll . " values ('$sregid','2','$userid','$sdate','approve checker') ";
            DB::select($sqll);
        }
        if ($vlevel == "schecker") {
            /*update status spv checker*/
            $sqlu = "UPDATE tr_sppa SET status='3',editby='$userid' ";
            $sqlu = $sqlu . " WHERE regid='$sregid'  ";
            /* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
            $query = DB::select($sqlu);
            /*isi log status untuk spv checker*/
            $sqll = "insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
            $sqll = $sqll . " values ('$sregid','3','$userid','$sdate','approve checker') ";
            $query = DB::select($sqll);
    
            $sqlu = "UPDATE tr_sppa SET status='4',editby='$userid' ";
            $sqlu = $sqlu . " WHERE regid='$sregid'  and status='3'  ";
            /* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
            $query = DB::select($sqlu);
    
            $sqll = "insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
            $sqll = $sqll . " values ('$sregid','4','system','$sdate','verification by system') ";
            $query = DB::select($sqll);
    
            $sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
            $sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
            $sqll = $sqll = $sqll . " where a.trxid= 'polno'";
            $hasill = DB::select($sqll);
            $nourut = $hasil[0]->seqno;
    
            $sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'polno'";
            $hasiln = DB::select($sqln);
            $policyno = $nourut;
    
            $sqlu = "UPDATE tr_sppa SET policyno='$policyno',status='5', validby='$userid',validdt='$sdate' WHERE regid='$sregid'";
            /* file_put_contents('eror.txt', $sqlu, FILE_APPEND | LOCK_EX);   */
            $query = DB::select($sqlu);
    
            $sqlb = " insert into tr_billing (billno,billdt,duedt,policyno,reffno,grossamt,nettamt,admamt,discamt,totalamt,remark,billtype) ";
            $sqlb = $sqlb . "select concat(aa.prevno,DATE_FORMAT(now(),aa.formdt),aa.billno) sbillno, ";
            $sqlb = $sqlb . " now(),date_add(now(),interval 15 day),bb.policyno,regid endorsno,gpremi,gpremi,0,0,gpremi,'Premi New business',1   ";
            $sqlb = $sqlb . "from (select a.prevno, concat(right(concat(a.formseqno,b.lastno),formseqlen)) billno ,formdt  ";
            $sqlb = $sqlb . " from tbl_lastno_form a inner join tbl_lastno_trans b on a.trxid=b.trxid  where a.trxid='billpre') aa ,  ";
            $sqlb = $sqlb . " (select regid,policyno,sum(tpremi) gpremi from tr_sppa  ";
            $sqlb = $sqlb . " where regid='$sregid' group by policyno,regid) bb ";
            $query = DB::select($sqlb);
    
            $sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'billpre'";
            $query = DB::select($sqln);
    
            $sqll = "insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
            $sqll = $sqll . " values ('$sregid','5','system','$sdate','valid by system') ";
            $query = DB::select($sqll);
        }
        return redirect()->intended('checker')->with('success', 'Data Berhasil diapprove');
    }
    public function delete($id)
    {
        DB::select("DELETE FROM cabang WHERE msid='$id'");
        // return view('master.product.add');
        return redirect()->intended('cabang')->with('success', 'Data Berhasil dihapus');
    }
}
