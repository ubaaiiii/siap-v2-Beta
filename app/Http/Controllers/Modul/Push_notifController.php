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
class Push_notifController extends Controller
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
            if(Session::get('login')[0]->level == 'broker'){
                // View::share( 'loggedInUser' ,  $user );
                return $next($request);
            }
            return redirect()->intended('index')->with('error', 'Maaf kamu tidak dapat mengakses ini');
            
        });
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
            
            
            $sTable = "SELECT id,level,cabang,username,pesan,tgl_mulai,tgl_selesai,action FROM (SELECT p.id, p.level, c.msdesc cabang, p.username, p.pesan, p.tgl_mulai, p.tgl_selesai, p.id action FROM tbl_push_notif p JOIN ms_master c on p.cabang = c.msid and c.mstype='CAB'";
            $sTable .= " ) t_baru WHERE level LIKE '$cari' OR cabang LIKE '$cari' OR username LIKE '$cari' OR pesan LIKE '$cari' OR tgl_mulai LIKE '$cari' OR tgl_selesai LIKE '$cari' OR action LIKE '$cari' LIMIT 10";
            // $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'push_notif/edit/'. Crypt::encryptString($data->id).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
                    $hapus = "'yakin ingin dihapus?'";
                    $button .= '<a onclick="return confirm('.$hapus.')" href="'.'push_notif/delete/'. Crypt::encryptString($data->id).'"  class="btn btn-danger btn-sm text-white" style="display:inline !important;">Delete</a>&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function get_nama(Request $request)
    {
        if($request->ajax())
        {
            $level = Session::get('login')[0]->level;
            $cabang = Session::get('login')[0]->cabang;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            $array = "";
            
            $array = DB::select("SELECT id_admin,nama,level,username,cabang FROM ms_admin WHERE level='$level' OR cabang='$cabang' AND nama LIKE '$cari' LIMIT 20");
            
            // dd($request->jenis_transaksi);
            return response()->json($array);
        }
    }
    public function index(Request $request)
    {
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->username;
        // Session::get('login')[0]->id_member;
        // dd($request->server('HTTP_SEC_CH_UA_PLATFORM'));
        // $push_notif = DB::select($sTable);
        $tipeuser = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms where ms.mstype='level'  order by ms.msdesc  asc ");
        $cabang = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='cab'  order by ms.msdesc  asc");
        // $data_nama = response()->json($array);
        $data = [
            'judul' => 'Puth Notification',
        ];
        // dd($data_nama);
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.push_notif.index_desktop', compact('data','tipeuser','cabang'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.push_notif.index', compact('data'));
        // }
    }
    public function store(Request $request)
    {
        
        $userid = Session::get('login')[0]->username;
        $pesannya = $request->tipe.'|'.$request->judul.'|'.$request->isi;
        $sqll = DB::select("INSERT INTO `tbl_push_notif`(`level`, `cabang`, `username`, `pesan`, `tgl_mulai`, `tgl_selesai`,`createby`) VALUES ('$request->level', '$request->cabang', '$request->username', '$pesannya', '$request->tgl_mulai', '$request->tgl_selesai', '$request->userid')");
        $sdate = date('Y-m-d');
        
        $insLog = DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) VALUES ('$request->username','00','$sdate','$userid','Insert Push Notification')");
        // dd(DB::select("SELECT * FROM `tbl_push_notif`"));
        // DB::select("INSERT INTO tr_sppa (regid, nama, noktp, jkel, tempat_lahir, alamat, pekerjaan, cabang, tgllahir, mulai, akhir, masa, up, nopeserta, status, createby,createdt, premi, epremi,tpremi, usia, produk, tunggakan, bunga, mitra, nama_ahli_waris, notelp_ahli_waris, hubungan_ahli_waris, comment)VALUES('$regid','$snama','$snoktp','$sjkel','$stmplahir','$salamat','$spekerjaan','$scabang','$stgllahir','$smulai','$sakhir','$smasa','$sup','$snopeserta','$status','$userid','$sdate','$spremi','$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra','$nmahli','$notelpahli','$hubungan','$scomment')");
        return redirect()->intended('push_notif')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT id,level,cabang,username,pesan,tgl_mulai,tgl_selesai,action FROM (SELECT p.id, p.level, c.msdesc cabang, p.username, p.pesan, p.tgl_mulai, p.tgl_selesai, p.id action FROM tbl_push_notif p JOIN ms_master c on p.cabang = c.msid and c.mstype='CAB') t_baru WHERE id= '$sid'");
        $tipeuser = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms where ms.mstype='level'  order by ms.msdesc  asc ");
        // dd($tipeuser);
        $cabang = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='cab'  order by ms.msdesc  asc");
        return view('modul.push_notif.edit', compact('data','id','tipeuser','cabang'));
    }
   
    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'product_name'   => 'required',
        //     'product_code' => 'required',
        // ]);
        $id = Crypt::decryptString($request->id);
        $level = $request->level;
        $cabang = $request->cabang;
        $username = $request->username;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;
        $pesan = $request->tipe.'|'.$request->judul.'|'.$request->isi;
        $userid = Session::get('login')[0]->username;
        // $paidid = Crypt::decryptString($paidid);
        DB::select("UPDATE tbl_push_notif SET level='$level', cabang='$cabang', username='$username', pesan='$pesan', tgl_mulai='$tgl_mulai', tgl_selesai='$tgl_selesai',createby='$userid' WHERE id='$id'");
        // DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) VALUES ('$regid','$paidid','$userid',now(),'Edit Tanggal Bayar')");
        // dd($hasil);
        return redirect()->intended('push_notif')->with('success', 'Data Berhasil diubah');
    }
    public function delete($id)
    {
        // $regid = Crypt::decryptString($regid);
        $id = Crypt::decryptString($id);
        // $userid = Session::get('login')[0]->username;
        // $tr_sppa = DB::select("SELECT status FROM tr_sppa WHERE regid = '$regid'");
        // $statusBaru = "";
        // $string = "";
        // foreach($tr_sppa as $row){
        //     switch($row->status) {
        //         case '20':                  // Paid
        //             $statusBaru = '5';      // Validasi
        //             $string     = "Premi";
        //             break;
        //         case '84':                  // Refund Paid Broker
        //             $statusBaru = '83';     // Refund Validasi
        //             $string     = "Refund Paid Broker";
        //             break;
        //         case '85':                  // Refund Paid Asuransi
        //             $statusBaru = '84';     // Refund Paid Broker
        //             $string     = "Refund Paid Asuransi";
        //             break;
        //         case '95':                  // Claim Paid
        //             $statusBaru = '93';     // Claim Valid
        //             $string     = "Claim";
        //             break;
        //     }
        // }

        DB::select("DELETE FROM tbl_push_notif WHERE id='$id'");
        // DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) VALUES ('$regid','$statusBaru',now(),'$userid','Hapus push_notif $string')");
        // DB::select("UPDATE tr_sppa SET status='$statusBaru' WHERE regid='$regid'");

        // return view('master.product.add');
        return redirect()->intended('push_notif')->with('success', 'Data Berhasil dihapus');
    }
}
