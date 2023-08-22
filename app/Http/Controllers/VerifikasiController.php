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
use PDF;
use Illuminate\Support\Facades\Crypt;

class VerifikasiController extends Controller
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
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if($user->level == 'broker'){
                // View::share( 'loggedInUser' ,  $user );
                return $next($request);
            }
            return redirect()->intended('index')->with('error', 'Maaf kamu tidak dapat mengakses ini');
            
        });
        // dd($request->session()->get('level'));
        // if(Auth::guard('admin')->user()->level !== 'broker'){
        //     return redirect()->intended('index')->with('error', 'Maaf kamu tidak dapat mengakses ini');
        // }
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
            $output = "";
            $vlevel = Auth::guard('admin')->user()->level;
            $userid = Auth::guard('admin')->user()->username;
            $cari = "%".$request->search."%";
            
            $sqlq = "SELECT SQL_CALC_FOUND_ROWS ma.msdesc asuransi,regid,nama,tgllahir,mulai,up,premi,pd.msdesc produk,masa,nopeserta,ab.msdesc status,aa.policyno,aa.status status_code FROM ";
            $sqlq .= "(select * from tr_sppa where status IN ( '5', '6', '20', '73', '83' ) ) aa ";
            $sqlq .= "INNER JOIN (select msid,msdesc,mstype from ms_master where mstype='STREQ') ab ON aa.status = ab.msid AND ab.mstype = 'STREQ' " ;
            $sqlq .= "INNER JOIN (select msid,msdesc,mstype from ms_master where mstype='ASURANSI') ma ON aa.asuransi = ma.msid AND ma.mstype = 'ASURANSI' ";
            $sqlq .= "INNER JOIN (select msid,msdesc,mstype from ms_master where mstype='produk') pd ON pd.msid = aa.produk AND pd.mstype = 'produk' ";
            $sqlq .= "WHERE  aa.status IN ( '5', '6', '20', '73', '83' ) ";
            if ($vlevel=="smkt" )
            {
                $sqlq .= " AND aa.createby IN (SELECT CASE WHEN a.parent=a.username THEN a.parent ELSE a.username END FROM   ms_admin a WHERE  (a.username = '$userid' OR a.parent = '$userid')) ";
            }
            
            if ($vlevel=="mkt" )
            {
                $sqlq .= " AND aa.createby = '$userid' ";
            }
            
            if ($vlevel=="checker" || $vlevel=="schecker" )
            {
                $sqlq .= " AND cabang LIKE (SELECT CASE WHEN cabang = 'ALL' THEN '%%' ELSE cabang END cabang FROM   ms_admin WHERE  username = '$userid' ) ";
            }
            
            // if ($vlevel=="broker" )
            // {
            
            // }
            
            // if ($vlevel=="insurance" )
            // {
            //     $sqlq .= " AND aa.asuransi IN (SELECT cabang FROM   ms_admin WHERE  level = 'insurance' AND    username = '$userid' ) ";
            // }
            
            $sqlq .= " AND asuransi LIKE '$cari' OR regid LIKE '$cari' OR nama LIKE '$cari' OR tgllahir LIKE '$cari' OR mulai LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR pd.msdesc LIKE '$cari' OR masa LIKE '$cari' OR nopeserta LIKE '$cari' OR ab.msdesc LIKE '$cari' OR aa.policyno LIKE '$cari' OR aa.status LIKE '$cari' ";
               
            // // if ($cari ) {
                // $sqlq .= ") OR ma.msdesc LIKE %.'$cari'.% OR regid LIKE %.'$cari'.% OR nama LIKE %.'$cari'.% OR tgllahir LIKE %.'$cari'.% OR mulai LIKE %.'$cari'.% OR up LIKE %.'$cari'.% OR premi LIKE %.'$cari'.% OR pd.msdesc LIKE %.'$cari'.% OR masa LIKE %.'$cari'.% OR nopeserta LIKE %.'$cari'.% OR ab.msdesc LIKE %.'$cari'.% OR aa.policyno LIKE %.'$cari'.% OR aa.status LIKE %.'$cari'.% ) ";
            // // }
            $sqlq .= " LIMIT 10";

            // if ($vlevel=="smkt" ) 211908010111
            // {
            //     $data = DB::select("CALL select_sertifikat_smkt('$userid')");
            // }elseif ($vlevel=="mkt" )
            // {
            //     $data = DB::select("CALL select_sertifikat_mkt('$userid')");
            // }elseif ($vlevel=="checker" || $vlevel=="schecker" )
            // {
            //     $data = DB::select("CALL select_sertifikat_checker('$userid','$cari')");
            // }elseif ($vlevel=="broker" )
            // {
                
            // }elseif ($vlevel=="insurance" )
            // {
            //    $data = DB::select("CALL select_sertifikat_insurance('$userid')");
            // }
            // if (!empty($request->get('search')['value'] && $request->get('search')['value'] !== "")) {
            //     echo "OK";
            // }
            $data = DB::select($sqlq); 
            // dd($data);
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
                                                '<p class="text-muted size-12">' .$p->status.'</p>'.
                                            '</div>'.
                                        '</div>'.
                                        '<a href="sertifikat/view/'.Crypt::encryptString($p->regid).'" class="btn btn-default w-100 shadow small">Detail</a>'.
                                    '</div>'.
                                '</div>'.
                            '</div> ';
                }
                return Response($output);
            }
        // return view('master.sertifikat.index');
    }
    public function getDesktop(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Auth::guard('admin')->user()->level;
            $userid = Auth::guard('admin')->user()->username;
            $cari = "%".$request->search."%";
            // $cari = "";
            
            $sqlq = "SELECT a.regid,a.nama,a.noktp,tgllahir,up,nopeserta,up,premi,mulai,ab.msdesc cab,ac.msdesc proddesc,a.createby FROM tr_sppa a";
            $sqlq .= " LEFT JOIN(SELECT regid FROM tr_sppa_log WHERE status = 13) b";
            $sqlq .= " ON a.regid = b.regid LEFT JOIN ms_master ab ON" ;
            $sqlq .= " a.cabang = ab.msid AND ab.mstype = 'cab' LEFT JOIN ms_master ac ON";
            $sqlq .= " ac.msid = a.produk AND ac.mstype = 'produk' WHERE";
            $sqlq .= " b.regid IS NULL AND a.status = '1'";
            
            // $sqlq .= " AND asuransi LIKE '$cari' OR regid LIKE '$cari' OR nama LIKE '$cari' OR tgllahir LIKE '$cari' OR mulai LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR pd.msdesc LIKE '$cari' OR masa LIKE '$cari' OR nopeserta LIKE '$cari' OR ab.msdesc LIKE '$cari' OR aa.policyno LIKE '$cari' OR aa.status LIKE '$cari' ";
            $sqlq .= " LIMIT 10";
               
            // // if ($cari ) {
                // $sqlq .= ") OR ma.msdesc LIKE %.'$cari'.% OR regid LIKE %.'$cari'.% OR nama LIKE %.'$cari'.% OR tgllahir LIKE %.'$cari'.% OR mulai LIKE %.'$cari'.% OR up LIKE %.'$cari'.% OR premi LIKE %.'$cari'.% OR pd.msdesc LIKE %.'$cari'.% OR masa LIKE %.'$cari'.% OR nopeserta LIKE %.'$cari'.% OR ab.msdesc LIKE %.'$cari'.% OR aa.policyno LIKE %.'$cari'.% OR aa.status LIKE %.'$cari'.% ) ";
            // // }
            $data = DB::select($sqlq);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'verifikasi/view/'. Crypt::encryptString($data->regid).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }

    public function index()
    {
        // $vlevel = Auth::guard('admin')->user()->level;
        // dd(Auth::guard('admin')->user());
        $vlevel = Auth::guard('admin')->user()->level;
        $userid = Auth::guard('admin')->user()->username;
        $data = "";
        
        $sqlq = "SELECT a.regid,a.nama,a.noktp,tgllahir,up,nopeserta,up,premi,mulai,ab.msdesc cab,ac.msdesc proddesc,a.createby FROM tr_sppa a";
        $sqlq .= " LEFT JOIN(  SELECT regid FROM tr_sppa_log WHERE status = 13) b";
        $sqlq .= " ON a.regid = b.regid LEFT JOIN ms_master ab ON" ;
        $sqlq .= " a.cabang = ab.msid AND ab.mstype = 'cab' LEFT JOIN ms_master ac ON";
        $sqlq .= " ac.msid = a.produk AND ac.mstype = 'produk' WHERE";
        $sqlq .= " b.regid IS NULL AND a.status = '1' ORDER BY b.regid LIMIT 10";
        $verifikasi = DB::select($sqlq); 
        // dd($verifikasi);
 
        $data = [
            'judul' => 'Verifikasi',
        ];
        $agent = new \Jenssegers\Agent\Agent;
        if($agent->isDesktop()){
            return view('modul.verifikasi.index_desktop', compact('data','verifikasi'));
        }else{
            return view('modul.verifikasi.index', compact('data','verifikasi'));
        }
    }
    public function view($id)
    { 
        $id = Crypt::decryptString($id);
        $sqle = " SELECT aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby,aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi,aa.bunga,aa.tunggakan,aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno,ab.msdesc tstatus,ac.paiddt FROM   tr_sppa aa LEFT JOIN ms_master ab ON aa.status = ab.msid AND ab.mstype = 'STREQ' LEFT JOIN tr_sppa_paid ac ON ac.regid = aa.regid WHERE aa.regid = '$id'";
        $produk = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk' order by ms.mstype");
        $cabang = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype");
        $pekerjaan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype");        
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$id' ");
        $data = DB::select($sqle);
        // dd($file);

        return view('master.sertifikat.view',compact('data','produk','cabang','pekerjaan','file'));
    }

    public function sertifikat($id) 
    {   
        $sregid = Crypt::decryptString($id);
        $sqlc="SELECT asuransi,nmasuransi,alamat,alamat1,alamat2,phone1, phone2,fax1,email,spath,pic,picjabat FROM ms_insurance  ";
        $sqlc= $sqlc . " where asuransi in (select asuransi from tr_sppa where regid='$sregid'  )";
        $ms_insurance =DB::select($sqlc);
        $sqlm="select aa.*,ab.msdesc jkeldesc,ac.msdesc kerja,aa.cabang,aa.mitra,aa.createby,aa.createdt,aa.produk, ";
        $sqlm=$sqlm ." ad.msdesc prodname,ae.msdesc scab,af.msdesc smitra ,ag.nama aoname ";
        $sqlm=$sqlm ." from tr_sppa aa inner join ms_master ab on aa.jkel=ab.msid and ab.mstype='JKEL' ";
        $sqlm=$sqlm ." left join  ms_master ac on aa.pekerjaan=ac.msid and ac.mstype='kerja'  ";
        $sqlm=$sqlm ." left join  ms_master ad on aa.produk=ad.msid and ad.mstype='PRODUK'";
        $sqlm=$sqlm ." left join  ms_master ae on aa.cabang=ae.msid and ae.mstype='cab'";
        $sqlm=$sqlm ." left join  ms_master af on aa.mitra=af.msid and af.mstype='mitra'";
        $sqlm=$sqlm ." left join  ms_admin ag on ag.username=aa.createby ";
        $sqlm=$sqlm ." where aa.regid='$sregid' ";
        $transaction = DB::select($sqlm);

        $sqlLog   = DB::select("SELECT max(createdt) 'tgl_approve' FROM tr_sppa_log WHERE regid='$sregid' AND status = 11");

 
        // dd($ms_insurance);
        $pdf = PDF::loadview('master.sertifikat.cert', compact('ms_insurance', 'sqlLog','transaction'));
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        return $pdf->stream('laporan-pegawai-pdf.pdf');
        // dd(Auth::guard('admin')->user()->id_member);
        // $brand = DB::select("SELECT * FROM md_brand");
        // $category = DB::select("SELxECT * FROM md_category");
        // $tokopedia = DB::select("SELECT * FROM md_category_tokopedia");
        // $shopee = DB::select("SELECT * FROM md_category_shopee");
        // return view('master.product.add', compact('brand','tokopedia','shopee','category'));
        return view('master.sertifikat.cert', compact('ms_insurance', 'sqlLog','transaction'));
    }

    public function invoice($id)
    {   
        $spolicyno = Crypt::decryptString($id);
        $bill = DB::select("select a.billno,date_format(a.billdt,'%d-%m-%Y') billdt from tr_billing a where a.policyno='$spolicyno'");
        // $transaction = DB::select("SELECT a.policyno,'Bank Bukopin' sclientname, nama clientname,'Asuranis Kredit' object,a.mulai effdt,a.akhir expdt,'Asuransi Kredit ' instype,grossamt,totalamt,mp.msdesc object, a.up, a.masa, a.regid FROM tr_sppa a INNER JOIN tr_billing b ON a.policyno = b.policyno INNER JOIN ms_master mp ON mp.msid = a.produk AND mp.mstype = 'produk' WHERE  a.policyno = '$spolicyno'");
        $transaction = DB::select("SELECT * FROM tr_sppa a INNER JOIN tr_billing b ON a.policyno = b.policyno INNER JOIN ms_master mp ON mp.msid = a.produk AND mp.mstype = 'produk' WHERE  a.policyno = '$spolicyno'");
        $sys = DB::select("select companyname,bank,acctno,acctname from ms_systab limit 1");
        // dd($transaction);
        $pdf = PDF::loadview('master.sertifikat.invoice', compact('bill','transaction'));
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        return $pdf->stream('laporan-pegawai-pdf.pdf');
        // dd(Auth::guard('admin')->user()->id_member);
        // $brand = DB::select("SELECT * FROM md_brand");
        // $category = DB::select("SELxECT * FROM md_category");
        // $tokopedia = DB::select("SELECT * FROM md_category_tokopedia");
        // $shopee = DB::select("SELECT * FROM md_category_shopee");
        // return view('master.product.add', compact('brand','tokopedia','shopee','category'));
        // return view('master.sertifikat.invoice', compact('bill','transaction'));
    }
    public function topup($id)
    { 
        $sid = Crypt::decryptString($id);
        $sqle = "select  aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai,aa.akhir,aa.masa,    ";
        $sqle = $sqle . " aa.up,  aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby,aa.validdt,aa.nopeserta,aa.usia,   ";
        $sqle = $sqle . " aa.premi,aa.epremi,aa.tpremi,aa.bunga,aa.tunggakan,aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno ,ab.paiddt ";
        $sqle = $sqle . " from tr_sppa aa left join tr_sppa_paid ab on aa.regid=ab.regid ";
        $sqle = $sqle . " where aa.regid='$sid'";

        $data = DB::select($sqle);
        // dd($data);
        $susia = $data[0]->tgllahir . ' / ' .  $data[0]->usia . ' tahun ';
        $smasaass = $data[0]->masa . ' Bulan / ' . $data[0]->mulai . ' s/d ' . $data[0]->akhir;
        $produk = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk' order by ms.mstype");
        $cabang = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype");
        $pekerjaan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype");
        $jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");

        return view('master.sertifikat.topup', compact('data','produk','cabang','pekerjaan','jkel','sid'));
    }
    public function storetopup(Request $request)
    { 
        $sup=str_replace('.', '', $request->up);
        $sproduk=$request->produk;      
        $sjkel=$request->jkel;      
        $smasa=$request->masa;      
        $stunggakan=$request->tunggakan;        
        $smulai=$request->mulai;        
        $stgllahir=$request->tgllahir;
        $sregid = $request->id;
        $sdate = date('Y-m-d H:i:s');
        $userid = Auth::guard('admin')->user()->username;
        $sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
        $sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
        $sqll = $sqll = $sqll . " where a.trxid= 'regid'";
        $data = DB::select($sqll);
        // dd($data);
        $nourut = $data[0]->seqno;
        $regid = $nourut;

        // $sqln  = "update tbl_lastno_trans  set lastno=lastno+1 where trxid= 'regid'";
        // DB::select($sqln);
        $sqlq = "select  rates,ratesother,tunggakan,bunga ,umurb,umura,round(datediff('$smulai','$stgllahir')/365) as usia ";
        $sqlq = $sqlq . " from  tr_rates  ";
        $sqlq = $sqlq . " where produk='$sproduk' and jkel='$sjkel' ";
        $sqlq = $sqlq . " and round(datediff('$smulai','$stgllahir')/365) between umurb and umura and insperiodmm='$smasa'";
        $sqlq = $sqlq . " and '$stunggakan' between gpb and gpa  and $sup between minup and maxup";
        $rates = DB::select($sqlq);
        // dd($rates);
        $srates = $rates[0]->rates;
        $sratesoth = $rates[0]->ratesother;
        $stunggakan1 = $rates[0]->tunggakan;
        $sbunga= $rates[0]->bunga;
        $sumurb= $rates[0]->umurb;
        $sumura= $rates[0]->umura;
        $susia= $rates[0]->usia;
        $spremi=($sup*$srates)/100;
        $spremi=($sup*$srates)/100;
        $sepremi=($sup*$sratesoth)/100;
        $stpremi=($spremi+$sepremi);
        $sakhir=date('Y-m-d', strtotime('+' . $smasa . 'months', strtotime($smulai)));
        $sqlt = "select  umurb,umura,maxup   ";
        $sqlt = $sqlt . " from  tr_term  where produk='$sproduk'  ";
        $term = DB::select($sqlt);
        $sbumurb = $term[0]->umurb;
        $sbumura = $term[0]->umura;
        $smaxup = $term[0]->maxup;
        $scomment = "";
        $spremi=0;
        $sepremi=0;
        $stpremi=0;
        $stunggakan=0;
        $sbunga=0;
        $susia=0;

        if ($susia<$sbumurb and $stpremi==0) 
        {
                $scomment=$scomment . " ".  'rate=0-->kriteria tidak ada dalam table tarif';
                $spremi=0;
                $sepremi=0;
                $stpremi=0;
        }
        if ($susia>$sbumura and $stpremi==0 ) 
        {
                $scomment=$scomment . " ".'rate=0-->kriteria tidak ada dalam table tarif ';
                $spremi=0;
                $sepremi=0;
                $stpremi=0;
        }   
        
        if ($sup>$smaxup ) 
        {
                $scomment=$scomment . " "."Pinjaman-->pinjaman melebih maksimum pinjaman sebesar "  ;
                $spremi=0;
                $sepremi=0;
                $stpremi=0;
        }   
        
        if (($susia+($smasa/12))>$sbumura ) 
        {
                $scomment=$scomment . " "."usia-->usia melebih maksimum usia pinjaman "  ;
                $spremi=0;
                $sepremi=0;
                $stpremi=0;
        }   
        if ($susia=='' )
        {
            $susia=0;
            $susia=app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $smulai);
        }
        if ($sbunga=='' )
        {
            $sbunga=0;
        }
        if ($stunggakan=='' )
        {
            $stunggakan=0;
        }
        $sqlt="insert into tr_sppa ( ";
        $sqlt= $sqlt . " regid,nama,noktp,jkel,pekerjaan,cabang,tgllahir,mulai,akhir,masa, ";   
        $sqlt= $sqlt . " up,status,createdt,createby,nopeserta,usia,";  
        $sqlt= $sqlt . " premi,epremi,tpremi,bunga,tunggakan,produk,mitra,comment,asuransi,policyno ) ";
        $sqlt= $sqlt . " select   '$regid',aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,'$smulai','$sakhir','$smasa', "; 
        $sqlt= $sqlt . " '$sup',    '0','$sdate','$userid','','$susia',";   
        $sqlt= $sqlt . " '$spremi','$sepremi','$stpremi','$sbunga','$stunggakan1','$sproduk',aa.mitra,'$scomment','',''  ";
        $sqlt= $sqlt . " from tr_sppa aa where aa.regid='$sregid' ";
        DB::select($sqlt);
        $sqll="insert into tr_sppa_log (regid,status,createby,createdt) ";
        $sqll=$sqll . " values ('$regid','0','$userid','$sdate') ";
        DB::select($sqll);  
        return redirect()->intended('sertifikat')->with('success', 'Data Berhasil ditambahkan');
        // dd($term);
    }
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'product_name'   => 'required',
        //     'product_code' => 'required',
        // ]);
        // return Validator::make($data, [
        //     'product_name' => ['required', 'string', 'max:255'],
        //     'product_code' => ['required', 'string', 'max:255'],
        // ]);
        $brand = DB::select("SELECT * FROM md_brand WHERE id_brand='$request->id_brand'");
        $kode = DB::select("SELECT max(id_sku_detail) as kodeTerbesar FROM md_product");
        $urutan = (int) substr($kode[0]->kodeTerbesar, -5);
        $urutan++;
        $depan = $brand[0]->brand_code. $request->varian_code;
        $sku_no = $depan . sprintf("%05s", $urutan);
        // dd($sku_no);

        $sku_name = $request->product_name.' - '.$request->varian_name;
        $sku_no_digit = strlen($sku_no);
        $sku_name_digit = strlen($sku_name);
        $sku_status = $request->sku_status;
        $product_name = $request->product_name;
        $varian_name = $request->varian_name;
        $varian_code = $request->varian_code;
        $id_brand = $request->id_brand;
        $id_category = $request->id_category;
        $id_category_tokopedia = $request->id_category_tokopedia;
        $id_category_shopee = $request->id_category_shopee;
        $length = $request->length;
        $width = $request->width;
        $height = $request->height;
        $volume_weight = ($length * $width * $height) /6;
        $actual_weight = $request->actual_weight;
        $retail_price = $request->retail_price;
        $username = Auth::guard('admin')->user()->username;
        // dd($product_code);
        DB::select("INSERT INTO md_product VALUES ('','$sku_no','$sku_name','$sku_status','$product_name','$varian_name','$varian_code','$id_brand','$sku_no_digit','$sku_name_digit','$id_category','$id_category_tokopedia','$id_category_shopee','$length','$width','$height','$volume_weight','$actual_weight','$retail_price','$username')");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Auth::guard('admin')->user()->id_member);
        $data = DB::select("SELECT * FROM md_product WHERE id_product='$id'");
        return view('master.product.edit', compact('data'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_name'   => 'required',
            'product_code' => 'required',
        ]);
        $product_name = $request->product_name;
        $product_code = $request->product_code;
        $username = Auth::guard('admin')->user()->username;
        // dd(Auth::guard('admin')->user()->id_member);
        $data = DB::select("UPDATE md_product SET product_name='$product_name', product_code='$product_code', created_by='$username' WHERE id_product='$request->id'");
        return redirect()->intended('product')->with('success', 'Data Berhasil diubah');
    }
    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
