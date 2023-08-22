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
class ProsesController extends Controller
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
            if ($vlevel=="checker")
            {
            $sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai,ab.msdesc sts";
            $sqlr= $sqlr . " ,ab.msdesc sts from tr_sppa aa  ";
            $sqlr= $sqlr . " inner join  ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
            $sqlr= $sqlr . " where aa.status='2' order by aa.regid desc";
            }
            if ($vlevel=="schecker")
            {
            $sqlr="select aa.regid,aa.nama,aa.noktp,aa.tgllahir,aa.up,aa.nopeserta,aa.up,aa.premi,aa.mulai,ab.msdesc sts ";
            $sqlr= $sqlr . " ,ab.msdesc sts from tr_sppa aa  ";
            $sqlr= $sqlr . " inner join  ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' ";
            $sqlr= $sqlr . " where aa.status='3' order by aa.regid desc";
            }		
            $sqlr = $sqlr . " LIMIT 100";
            // $sTable .= " group by b.msdesc ,year(mulai) LIMIT 100";
            $data = DB::select($sqlr);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'proses/edit/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
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
            'judul' => 'Proses',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.proses.index_desktop', compact('data'));
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
        return view('modul.proses.edit', compact('data','produk','jkel','kerja','cab','mitra','hubungan','dokumen','file','sid','asuransi'));
    }
    public function update(Request $request){
        $id = Crypt::decrypt($request->msid);
        $scode=$request->code;
        $sdesk=$request->desk;
        $stype='cab';
        $userid=Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        $sup  = $request->up;
        $sjkel      = $request->jkel;
        $sproduk      = $request->produk;
        $smasa      = $request->masa;
        $stgllahir  = $request->tgllahir;
        $smulai  = $request->mulai;
        $spremi  = $request->premi;
        $susia=app('App\Http\Controllers\Modul\PengajuanController')->hitung_umur($stgllahir, $smulai);
        $sqlq = "select  rates,ratesother,tunggakan,bunga  ";
        $sqlq = $sqlq . " from  tr_rates  ";
        $sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' and '$susia' between umurb and umura and insperiodmm='$smasa'";
        $barisq = DB::select($sqlq);
        $srates = $barisq[0]->rates;
        $sratesoth = $barisq[0]->ratesother;
        $stunggakan = $barisq[0]->tunggakan;
        $sbunga= $barisq[0]->bunga;
        
        $spremi=($sup*$srates)/100;
        $sepremi=($sup*$sratesoth)/100;
        $stpremi=($spremi+$sepremi);

        $sakhir  = date('Y-m-d', strtotime('+' . $smasa . 'months', strtotime($smulai)));
        
        
        $sqlu="UPDATE tr_sppa SET masa='$smasa',mulai='$smulai',akhir='$sakhir',usia='$susia', ";
        $sqlu= $sqlu . " up='$sup',nopeserta='$snopeserta',premi='$spremi' where regid='$sregid'";
        DB::select("UPDATE ms_master SET msdesc='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
        // dd($id);
        return redirect()->intended('cabang')->with('success', 'Data Berhasil disimpan');
    }
    public function approve($id)
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        $sregid = Crypt::decryptString($id);
        $sts="";
        $sdate = date('Y-m-d H:i:s');
        if ($vlevel == "checker") {
            $sts='2';
        }
        if ($vlevel == "schecker") {
            $sts='3';
        }
        $sqlu="UPDATE tr_sppa SET status='$sts',editby='$vlevel' ";
        $sqlu=$sqlu . " WHERE regid='$sregid'  ";
        $query=DB::select($sqlu);
        
        $sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
        $sqll=$sqll . " values ('$sregid','$sts','$userid','$sdate') ";
        $query=DB::select($sqll);
        return redirect()->intended('proses')->with('success', 'Data Berhasil diapprove');
    }
    public function rollback($id)
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        $sregid = Crypt::decryptString($id);
        $sts="";
        $sdate = date('Y-m-d H:i:s');
        
        $sqlu="UPDATE tr_sppa SET status='0',editby='$vlevel' ";
        $sqlu=$sqlu . " WHERE regid='$sregid'  ";
        $query=DB::select($sqlu);
        
        $sqll="insert into tr_sppa_log (regid,status,createby,createdt,comment) ";
        $sqll=$sqll . " values ('$sregid','0','$userid','$sdate','rollback') ";
        $query=DB::select($sqll);
        return redirect()->intended('proses')->with('success', 'Data Berhasil dirollback');
    }
    public function delete($id)
    {
        DB::select("DELETE FROM cabang WHERE msid='$id'");
        // return view('master.product.add');
        return redirect()->intended('cabang')->with('success', 'Data Berhasil dihapus');
    }
}
