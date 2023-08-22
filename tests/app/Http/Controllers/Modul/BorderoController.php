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

class BorderoController extends Controller
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
                                        '<a href="'.'bordero/edit/'. Crypt::encryptString($p->regid).'" class="btn btn-default w-100 shadow small">Detail</a>'.
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
        // return view('master.bordero.index');
    }

    public function getDesktop(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            
            

            $sTable = "SELECT a.borderono,a.reffdt,b.reffamt,a.status,a.period1,a.period2,a.branch asuransi,a.produk from tr_bordero a left join (SELECT c.borderono,SUM(c.premi) reffamt FROM tr_bordero_dtl c group by c.borderono ) b  on a.borderono=b.borderono ";
            $sTable .= " WHERE a.borderono LIKE '$cari' OR a.reffdt LIKE '$cari' OR b.reffamt LIKE '$cari' OR a.status LIKE '$cari' OR a.period1 LIKE '$cari' OR a.period2 LIKE '$cari' OR a.branch LIKE '$cari' OR a.produk  LIKE '$cari' LIMIT 100";

        	// $sTable .= "  order by a.borderono desc LIMIT 10";
            $data = DB::select($sTable);

            // dd($data);

            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'bordero/edit/'. Crypt::encryptString($data->borderono).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
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

        $sTable = "SELECT 'paidid','regid','nama','up','premi','paiddt','comment','aksi' FROM (SELECT ab.paidid,aa.regid,aa.nama,aa.up,
               aa.premi,ab.paiddt,ac.comment,concat(aa.regid,'-',ab.paidid,'-',ac.status) aksi FROM tr_sppa aa INNER JOIN tr_sppa_paid ab ON aa.regid = ab.regid INNER JOIN tr_sppa_log ac ON aa.regid = ac.regid AND ab.createdt = ac.createdt";


        $sTable .= " ) t_baru  LIMIT 10";
        $produk = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $status = DB::select("select msid scode ,msdesc sdesc FROM ms_master where mstype='BLIST' order by msdesc");

        $bordero = DB::select($sTable);

        // dd($bordero); 
        // dd(Session::get('login')[0]);
        // $data = DB::select("SELECT * FROM md_product LEFT JOIN md_brand ON md_product.id_brand=md_brand.id_brand LEFT JOIN md_category ON md_product.id_category=md_category.id_category LEFT JOIN md_category_tokopedia ON md_product.id_category_tokopedia=md_category_tokopedia.id_category_tokopedia LEFT JOIN md_category_shopee ON md_product.id_category_shopee=md_category_shopee.id_category_shopee");
    
    // dd($result);

        $data = [
            'judul' => 'bordero',
        ];

        $agent = new \Jenssegers\Agent\Agent;
        return view('modul.bordero.index_desktop', compact('data','bordero','produk','status'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.bordero.index', compact('data','bordero','produk','status'));
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

        return view('master.bordero.add', compact('produk','jkel','kerja','cab','mitra','hubungan'));
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
    	$period1=$request->period1;
		$period2=$request->period2;
		$sfilter3=$request->sfilter3;
		$sfilter4=$request->sfilter4;
		$sdate = date('Y-m-d H:i:s');
		$reffdt= date('Y-m-d');
		$exdate=date("YmdHis");
		$userid = Session::get('login')[0]->username; 
        // $lststatus = "";


         // $sqld= " SELECT a.regid,a.status,a.premi from tr_sppa a left join tr_sppa_paid c on a.regid=c.regid left join tr_bordero_dtl b on a.regid=b.regid WHERE (c.paiddt between '$period1' and '$period2' ) and a.produk='$sfilter3' ";
        // $sqld= DB::SELECT("SELECT a.regid,a.status,a.premi from tr_sppa a left join tr_sppa_paid c on a.regid=c.regid WHERE (c.paiddt between '$period1' and '$period2') ORDER BY a.regid");
        // dd($sqld);
        
        $regbor = DB::select("SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid where a.trxid= 'regbor'");

        $nourut = $regbor[0]->seqno;
        // dd($request);

        $sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regbor'";
		$hasiln = DB::select($sqln);
		$borderono=$nourut;

		$sql="INSERT INTO tr_bordero (borderono,reffdt,period1,period2,reffamt,createby,createdt) VALUES ('$borderono','$reffdt','$period1','$period2',0,'$userid','$sdate')";
		/* file_put_contents('eror.txt', $sql, FILE_APPEND | LOCK_EX); */
		$query = DB::select($sql);

		$sqld= " insert into tr_bordero_dtl (borderono,regid,createdt,createby,lststatus,premi)";
        $sqld= " select '$borderono',a.regid,'$sdate','$userid',a.status,a.premi from tr_sppa a ";
        $sqld= $sqld . " inner join tr_sppa_paid c on a.regid=c.regid ";
        $sqld= $sqld . " left join tr_bordero_dtl b on a.regid=b.regid ";
        $sqld= $sqld . "  where (c.paiddt between '$period1' and '$period2' ) ";
        $sqld= $sqld . "  and a.produk='$sfilter3' and b.regid is null ";
        $query=DB::select($sqld);


		
		/* file_put_contents('erordtl.txt', $sqld, FILE_APPEND | LOCK_EX);   */
		$query=DB::select($sqld);
		// dd(DB::select("SELECT * FROM tr_bordero_dtl WHERE borderono='$borderono' LIMIT 10"));

		$sqld= "update tr_bordero set reffamt=(select sum(a.premi) from tr_bordero_dtl a ";
		$sqld= $sqld . "inner join tr_sppa b on a.regid=b.regid ";
		$sqld= $sqld . "where a.borderono='$borderono') ";
		$sqld= $sqld . "where borderono='$borderono' ";
		$query=DB::select($sqld);

        return redirect()->intended('bordero')->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT sp.*,sl.tgl_approve FROM tr_sppa sp LEFT JOIN (SELECT regid, MAX(createdt) as tgl_approve FROM tr_sppa_log WHERE regid = '$sid') sl ON  sp.regid = sl.regid WHERE sp.regid = '$sid'");
        // dd($data);
        $produk = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
        $kerja = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        $cab = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");

        $dokumen = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");

        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");

        return view('master.bordero.edit', compact('data','produk','jkel','kerja','cab','mitra','hubungan','dokumen','file','sid'));
    }

    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'product_name'   => 'required',
        //     'product_code' => 'required',
        // ]);

        $sproduk = $request->produk;
        $sjkel = $request->jkel;
        $snama      = str_replace("'", "`", $request->nama);
        $susia = $request->usia;
        $snoktp = $request->noktp;
        $stmplahir = $request->tempat_lahir;
        $smasa = $request->masa;
        $salamat = $request->alamat;
        $spekerjaan = $request->pekerjaan;
        $scabang = $request->cabang;
        $snopeserta = $request->nopeserta;
       

        $hasil =DB::select("UPDATE tr_sppa SET nama= '$snama',cabang = '$scabang',mitra = '$smitra',usia = '$susia',tgllahir = '$stgllahir',up = '$sup', jkel = '$sjkel', pekerjaan = '$spekerjaan', tempat_lahir = '$stmplahir', alamat = '$salamat', noktp = '$snoktp', tpremi = '$spremi', premi = '$spremi', epremi = 0, status = 0, editby = '$userid', editdt = '$sdate', masa = '$smasa', akhir = '$sakhir', mulai = '$smulai', tunggakan = '$stunggakan', nama_ahli_waris = '$nmahli',notelp_ahli_waris = '$notelpahli',hubungan_ahli_waris = '$hubungan', COMMENT = '$scomment' WHERE regid = '$sregid'");
        // dd($hasil);

        return redirect()->intended('bordero')->with('success', 'Data Berhasil diubah');
    }

    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
