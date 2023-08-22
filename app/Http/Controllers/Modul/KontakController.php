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
class KontakController extends Controller
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
            
            // $kontak = (Session::get('login')[0]->kontak == NULL)?('NOM'):(Session::get('login')[0]->kontak);
            // if ($kontak !== 'NOM') {
            //     $sTable .= " AND aa.kontak = '$kontak' ";
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
            $sTable = "SELECT SQL_CALC_FOUND_ROWS id_contact,nama,nohp,dashboard,kontak,aksi FROM (SELECT a.id_contact,b.nama,b.nohp,a.dashboard,a.kontak,concat(a.id_contact,'-',b.nama) aksi FROM ms_contact a INNER JOIN ms_admin b on a.id_contact = b.id_admin) t_baru ";
        	$sTable .= " LIMIT 100";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'kontak/edit/'. Crypt::encrypt($data->id_contact).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
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
        // $sTable = "SELECT SQL_CALC_FOUND_ROWS id_contact,nama,nohp,dashboard,kontak,aksi FROM (SELECT a.id_contact,a.nama,b.nohp,a.dashboard,a.kontak,concat(a.id_contact,'-',a.nama) aksi FROM ms_contact a INNER JOIN ms_admin b on a.id_contact = b.id_admin) t_baru ";

        // $sTable .= " LIMIT 10";
        // $kontak = DB::select($sTable);
        // dd($kontak); 
        // dd(Session::get('login')[0]);
        // $data = DB::select("SELECT * FROM md_product LEFT JOIN md_brand ON md_product.id_brand=md_brand.id_brand LEFT JOIN md_category ON md_product.id_category=md_category.id_category LEFT JOIN md_category_tokopedia ON md_product.id_category_tokopedia=md_category_tokopedia.id_category_tokopedia LEFT JOIN md_category_shopee ON md_product.id_category_shopee=md_category_shopee.id_category_shopee");
    
    // dd(DB::select("SELECT * FROM ms_contact"));
        $data = [
            'judul' => 'Kontak',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.kontak.index_desktop', compact('data'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.kontak.index', compact('data','kontak'));
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
        $kontak = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='kontak'  order by ms.msdesc  asc");
        $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
        // dd($jkel);
        return view('master.pengajuan.add', compact('produk','jkel','kerja','cab','kontak','hubungan'));
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
        $snoktp = $request->noktp;
      

        return redirect()->intended('pengajuan')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decrypt($id);
        $data = DB::select("SELECT * FROM ms_contact INNER JOIN ms_admin ON ms_contact.id_contact = ms_admin.id_admin WHERE id_contact='$sid'");
        // dd($data);
        return view('modul.kontak.edit', compact('data'));
    }
    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'product_name'   => 'required',
        //     'product_code' => 'required',
        // ]);
    	$id_contact = Crypt::decrypt($request->id_contact);
        $nama = $request->nama;
        $nohp = $request->nohp;
        // DB::select("INSERT INTO ms_contact (id_contact)")
        
        DB::select("UPDATE ms_contact INNER JOIN ms_admin ON ms_contact.id_contact = ms_admin.id_admin SET ms_contact.nama = '$nama', ms_admin.nama = '$nama', ms_admin.nohp = '$nohp' WHERE ms_contact.id_contact = '$id_contact'");

        return redirect()->intended('kontak')->with('success', 'Data Berhasil diubah');
    }
    public function delete($id)
    {
    	$id_contact = Crypt::decrypt($id_contact);
        DB::select("DELETE FROM ms_contact WHERE id_product='$id_contact'");
        // return view('master.product.add');
        return redirect()->intended('kontak')->with('success', 'Data Berhasil dihapus');
    }
}
