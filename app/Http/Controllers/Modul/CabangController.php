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
class CabangController extends Controller
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
            
            // $cabang = (Session::get('login')[0]->cabang == NULL)?('NOM'):(Session::get('login')[0]->cabang);
            // if ($cabang !== 'NOM') {
            //     $sTable .= " AND aa.cabang = '$cabang' ";
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
                                        '<a href="'.'cabang/edit/'. Crypt::encryptString($p->regid).'" class="btn btn-default w-100 shadow small">Detail</a>'.
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
            
            
            $sTable = "select b.msdesc,year(mulai) syear , count(1) sdat,sum(premi) samt1, sum(epremi) samt2,sum(tpremi) samt3,b.msid from tr_sppa a join ms_master b on a.cabang=b.msid and b.mstype='cab'  ";
            $sTable .= "  WHERE b.msdesc LIKE '$cari' OR year(mulai) LIKE '$cari' OR premi LIKE '$cari' OR epremi LIKE '$cari' OR tpremi LIKE '$cari' OR b.msid LIKE '$cari' ";
            $sTable .= " group by b.msdesc ,year(mulai) LIMIT 100";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'cabang/edit/'. Crypt::encryptString($data->msid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
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
        $sTable = "SELECT b.msdesc,year(mulai) syear , count(1) sdat,sum(premi) samt1, sum(epremi) samt2,sum(tpremi) samt3 from tr_sppa a inner join ms_master b on a.cabang=b.msid and b.mstype='cab' group by b.msdesc ,year(mulai) ";
        $cabang = DB::select($sTable);
        // dd($cabang); 
        // dd(Session::get('login')[0]);
        $data = [
            'judul' => 'Cabang',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.cabang.index_desktop', compact('data','cabang'));
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
        $data = DB::select("SELECT * FROM ms_master where msid='$sid'");
        // dd($data);
        return view('modul.cabang.edit', compact('data'));
    }
    public function update(Request $request){
        $id = Crypt::decrypt($request->msid);
        $scode=$request->code;
        $sdesk=$request->desk;
        $stype='cab';
        $userid=Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        // dd($request);
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));
        // DB::select("UPDATE tr_sppa SET status = '1',editby = '$userid',editdt = '$sdate' WHERE regid = '$sregid' AND premi <> 0 AND masa <> 0 AND usia <> 0");
        DB::select("UPDATE ms_master SET msdesc='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
        // dd($id);
        return redirect()->intended('cabang')->with('success', 'Data Berhasil disimpan');
    }
    public function delete($id)
    {
        DB::select("DELETE FROM cabang WHERE msid='$id'");
        // return view('master.product.add');
        return redirect()->intended('cabang')->with('success', 'Data Berhasil dihapus');
    }
}
