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
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSend;
use Session;
class UserController extends Controller
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
            
            // $user = (Session::get('login')[0]->user == NULL)?('NOM'):(Session::get('login')[0]->user);
            // if ($user !== 'NOM') {
            //     $sTable .= " AND aa.user = '$user' ";
            // }
            
            // if ($_POST['sSearch'] == '') {
            //     $sTable .= " ORDER BY aa.createdt DESC";
            // }
            $sTable .= " ) t_baru WHERE regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR sts LIKE '$cari' OR comment LIKE '$cari' OR reg_encode LIKE '$cari' OR status  LIKE '$cari' LIMIT 100";

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
            $sTable = "SELECT a.*,b.msdesc cab, c.msdesc utype from ms_admin a  left join ms_master b on a.cabang=b.msid and b.mstype='cab' left join ms_master c on c.msid=a.level and c.mstype='utype'";
            $sTable .= " WHERE b.msdesc LIKE '$cari' OR c.msdesc LIKE '$cari' OR supervisor LIKE '$cari' OR nama LIKE '$cari' OR parent LIKE '$cari' OR mitra LIKE '$cari' order by a.id_admin desc LIMIT 100";
        	// $sTable .= " LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'user/edit/'. Crypt::encrypt($data->username).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
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
        // $sTable = "SELECT a.*,b.msdesc cab, c.msdesc utype from ms_admin a  left join ms_master b on a.cabang=b.msid and b.mstype='cab' left join ms_master c on c.msid=a.level and c.mstype='utype' order by a.id_admin desc";

        // $sTable .= " LIMIT 10";
        // $user = DB::select($sTable);
        // dd($user); 
        // dd(Session::get('login')[0]);
        // $data = DB::select("SELECT * FROM md_product LEFT JOIN md_brand ON md_product.id_brand=md_brand.id_brand LEFT JOIN md_category ON md_product.id_category=md_category.id_category LEFT JOIN md_category_tokopedia ON md_product.id_category_tokopedia=md_category_tokopedia.id_category_tokopedia LEFT JOIN md_category_shopee ON md_product.id_category_shopee=md_category_shopee.id_category_shopee");
    
    // dd($result);
        $data = [
            'judul' => 'User',
        ];
        $hakakses = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='utype'  order by ms.msdesc  asc ");
        $cabang = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='cab'  order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $supervisior = DB::select("select ms.username comtabid,ms.nama comtab_nm from ms_admin ms   order by ms.nama  asc ");
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.user.index_desktop', compact('data','hakakses','cabang','mitra','supervisior'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.user.index', compact('data','user','hakakses','cabang','mitra','supervisior'));
        // }
    }
    public function add()
    {
        $suname=$request->uname;
        $semail=$request->email;
        $snohp=$request->nohp;
        $snama=$request->nama;
        $smitra=$request->mitra;
        $sparent=$request->parent;
        $scabang=$request->cabang;
        $slevel=$request->level;
        $userid=$request->userid;
        $sdate = date('Y-m-d H:i:s');
        $sparent = "";

        $sqlq = " select id_admin from ms_admin order by id_admin desc limit 1 ";
        $hasilq = DB::select($sqlq);
        $surut = $hasilq->id_admin+1;
        $snama1=str_replace(' ', '',$snama).$surut;
        $suname=substr($snama1,0,6) . substr($surut,0,4) ;
        $supass=substr($snama1,4,2) . $surut . "@!";
        $upass = Hash::make($supass);

        if ($slevel=='smkt')
        {
            $sparent=$suname;
        }
        $sql="INSERT INTO ms_admin (username,id_peg,password,level,nama,email,nohp,mitra,photo, ";
        $sql= $sql . " cabang,parent,createby,createdt,supervisor) ";
        $sql= $sql . " VALUES ('$suname','$suname','$supass','$slevel','$snama','$semail','$snohp','$smitra','$sphoto', ";
        $sql= $sql . " '$scabang','$sparent','$userid','$sdate','$supass')";
        $produk = DB::select($sql);
        // dd($jkel);
        return view('modul.user.add', compact('produk','jkel','kerja','cab','user','hubungan'));
    }
    function reset($id)
	{
        $id = Crypt::decrypt($id);
	    $sqlu="update  ms_admin set password=Hash::make(CONCAT(SUBSTR(username,4,2),id_ADMIN,'@!')),supervisor=CONCAT(SUBSTR(username,4,2),id_ADMIN,'@!') ";
        $sqlu=$sqlu . " WHERE username='$id'";
        // $sqlu = unserialize($sqlu);
        $query=DB::select($sqlu);
        return redirect()->intended('user')->with('success', 'Data Berhasil direset');
	}
	function email($id)
	{
        // $id = Crypt::decrypt($id);
        $email = 'devmzfa@gmail.com';
        $data = [
            'title' => 'Selamat datang!',
            'url' => 'https://aantamim.id',
        ];
        Mail::to($email)->send(new MailSend($data));
        return 'Berhasil mengirim email!';
        // dd("ok");
        // $sqlu = unserialize($sqlu);
        // $query=DB::select($sqlu);
        return redirect()->intended('user')->with('success', 'Data Berhasil direset');
	}
    public function store(Request $request)
    {
        $suname=$request->uname;
        $semail=$request->email;
        $snohp=$request->nohp;
        $snama=$request->nama;
        $smitra=$request->mitra;
        $sparent=$request->parent;
        $scabang=$request->cabang;
        $slevel=$request->level;
        $userid=$request->userid;
        $sdate = date('Y-m-d H:i:s');
        // $sparent = "";

        $sqlq = " select id_admin from ms_admin order by id_admin desc limit 1 ";
        $hasilq = DB::select($sqlq);
        // dd($hasilq);
        $surut = $hasilq[0]->id_admin+1;
        $snama1=str_replace(' ', '',$snama).$surut;
        $suname=substr($snama1,0,6) . substr($surut,0,4) ;
        $supass=substr($snama1,4,2) . $surut . "@!";
        $upass = Hash::make($supass);
        
        if ($slevel=='smkt')
        {
            $sparent=$suname;
        }
        $sql="INSERT INTO ms_admin (username,id_peg,password,level,nama,email,nohp,mitra,photo, ";
        $sql= $sql . " cabang,parent,createby,createdt,supervisor) ";
        $sql= $sql . " VALUES ('$suname','$suname','$supass','$slevel','$snama','$semail','$snohp','$smitra','-', ";
        $sql= $sql . " '$scabang','$sparent','$userid','$sdate','$supass')";
        $produk = DB::select($sql);
        return redirect()->intended('user')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decrypt($id);
        $data = DB::select("SELECT * FROM ms_admin where username='$sid'");
        // dd($data);
        $hakakses = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='utype'  order by ms.msdesc  asc ");
        $cabang = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='cab'  order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $supervisior = DB::select("select ms.username comtabid,ms.nama comtab_nm from ms_admin ms   order by ms.nama  asc ");
        return view('modul.user.edit', compact('data','hakakses','cabang','mitra','supervisior'));
    }

    public function update(Request $request)
    {
        $suname=Crypt::decrypt($request->username);
        $semail=$request->email;
        $snohp=$request->nohp;
        $snama=$request->nama;
        $smitra=$request->mitra;
        $sparent=$request->parent;
        $scabang=$request->cabang;
        $slevel=$request->level;
        $userid=$request->userid;
        $sdate = date('Y-m-d H:i:s');
        // dd($suname);
        $sql="UPDATE ms_admin SET mitra='$smitra',level='$slevel' , ";
        $sql= $sql . " nama='$snama',email='$semail',nohp='$snohp', parent='$sparent',cabang='$scabang', ";
        $sql= $sql . " editby='$userid',editdt='$sdate' WHERE username='$suname' ";
        DB::select($sql);
        return redirect()->intended('user')->with('success', 'Data Berhasil diubah');
    }
    public function delete($id)
    {
        $id=Crypt::decrypt($id);
        DB::select("DELETE FROM ms_admin WHERE username='$id'");
        // return view('master.product.add');
        return redirect()->intended('user')->with('success', 'Data Berhasil dihapus');
    }
}
