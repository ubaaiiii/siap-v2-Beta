<?php
namespace App\Http\Controllers\Modul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Crypt;
use Session;
class KalkulatorController extends Controller
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
    public function index()
    {
        $data = [
            'judul' => 'Kalkulator',
        ];
        $produk = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk'  and msid<>'all' order by ms.msdesc  asc");
		$jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='jkel'  and msid<>'all' order by ms.msdesc  asc");
		$asuransi = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='asuransi'  and msid<>'all' order by ms.msdesc  asc");
        // dd($produk);
        return view('master.kalkulator.index', compact('data','produk','jkel','asuransi'));
    }
    public function hitung(Request $request)
    {
    	// buat no urut
    	$sqll = "SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno ";
		$sqll = $sqll . " from  tbl_lastno_form a  left join tbl_lastno_trans  b on a.trxid=b.trxid  ";
		$sqll = $sqll . " where a.trxid= 'calreg'";
		$urut = DB::select($sqll);
		$nourut = $urut[0]->seqno;
		DB::select("update tbl_lastno_trans set lastno=lastno+1 where trxid= 'calreg'");
		// dd($nourut);

		$sdate      = date('Y-m-d H:i:s');
    	$sup    = str_replace('.', '', $request->up);
    	$stgllahir  = $request->tgllahir;
		$smulai     = $request->mulai;
		$sasuransi     = $request->asuransi;
		$scalreg     = $nourut;
		$sproduk     = $request->produk;
		$sjkel     = $request->jkel;
		$smasa     = $request->masa;
		$stunggakan     = $request->gp;
		$sgp     = $request->gp;
		$userid = Session::get('login')[0]->username;
		$level = Session::get('login')[0]->level;
		$susia  	= app('App\Http\Controllers\Modul\PengajuanController')->hitung_umur($stgllahir,$smulai);
		$rates = DB::select("SELECT * FROM tr_rates WHERE asuransi = '$sasuransi' and produk = '$sproduk' AND jkel = '$sjkel' AND '$susia' BETWEEN umurb AND umura AND insperiodmm = '$smasa' AND '$stunggakan' BETWEEN gpb AND gpa AND $sup BETWEEN minup AND maxup");
        
        $srates      = "";
        $sratesoth   = "";
        $stunggakan1 = "";
        $sbunga      = "";
        $sumurb      = "";
        $sumura      = "";
        if ($rates) {
        	$srates      = $rates[0]->rates;
	        $sratesoth   = $rates[0]->ratesother;
	        $stunggakan1 = $rates[0]->tunggakan;
	        $sbunga      = $rates[0]->bunga;
	        $sumurb      = $rates[0]->umurb;
	        $sumura      = $rates[0]->umura;
        	
        }
       $spremi = 0;
       $sepremi = 0;
        // $susia      = $rates[0]->susia;
        // dd($srates);
       if ($srates == "") {
           $spremi      = $sup / 100;
       }else{
            $spremi      = ($sup * $srates) / 100;
       }
        if ($sratesoth == "") {
           $spremi      = $sup / 100;
       }else{
            $sepremi     = ($sup * $sratesoth) / 100;
       }
       $stpremi = ($spremi + $sepremi);
		$sakhir  = date('Y-m-d', strtotime('+' . $smasa . 'months', strtotime($smulai)));
		$sqlt    = "select  umurb,umura,maxup   ";
		$sqlt    = $sqlt . " from  tr_term  where produk='$sproduk'  ";
		 /* dd($sqlt); */
		$term = DB::select($sqlt);
		
		$sbumurb = $term[0]->umurb;
		$sbumura = $term[0]->umura;
		$smaxup  = $term[0]->maxup;
		$scomment = "";
		if ($susia < $sbumurb and $stpremi == 0) {
			$scomment = $scomment . " " .  'rate=0-->kriteria tidak ada dalam table tarif';
			$spremi   = 0;
			$sepremi  = 0;
			$stpremi  = 0;
		}
		if ($susia > $sbumura and $stpremi == 0) {
			$scomment = $scomment . " " . 'rate=0-->kriteria tidak ada dalam table tarif ';
			$spremi = 0;
			$sepremi = 0;
			$stpremi = 0;
		}
		if ($sup > $smaxup) {
			$scomment = $scomment . " " . "Pinjaman-->pinjaman melebih maksimum pinjaman sebesar ";
			$spremi = 0;
			$sepremi = 0;
			$stpremi = 0;
		}
		if (($susia + ($smasa / 12)) > $sbumura) {
			$scomment = $scomment . " " . "usia-->usia melebih maksimum usia pinjaman ";
			$spremi = 0;
			$sepremi = 0;
			$stpremi = 0;
		}
		if ($susia == '') {
			$susia = 0;
			$susia = app('App\Http\Controllers\Modul\PengajuanController')->hitung_umur($stgllahir,$smulai);
		}
		if ($sbunga == '') {
			$sbunga = 0;
		}
		if ($stunggakan == '') {
			$stunggakan = 0;
		}

		DB::select("INSERT INTO tr_calc (calreg, jkel, tgllahir, mulai, akhir, masa, up, createby, createdt, premi, epremi, tpremi, usia, produk, tunggakan, bunga,asuransi, comment) VALUES  ('$scalreg','$sjkel','$stgllahir','$smulai','$sakhir','$smasa','$sup','$userid','$sdate','$spremi','$sepremi','$stpremi','$susia','$sproduk','$sgp','$sbunga','$sasuransi','$scomment')");

		return redirect()->intended('kalkulator/detail/'.Crypt::encrypt($scalreg));
		
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
        $username = Session::get('login')[0]->username;
        // dd($product_code);
        DB::select("INSERT INTO md_product VALUES ('','$sku_no','$sku_name','$sku_status','$product_name','$varian_name','$varian_code','$id_brand','$sku_no_digit','$sku_name_digit','$id_category','$id_category_tokopedia','$id_category_shopee','$length','$width','$height','$volume_weight','$actual_weight','$retail_price','$username')");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil ditambahkan');
    }
    public function detail($id)
    {
    	$scalreg = Crypt::decrypt($id);
        $db = DB::select("SELECT aa.* from tr_calc aa where aa.calreg='$scalreg'");
		$produk = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk'  and msid<>'all' order by ms.msdesc  asc");
		$asuransi = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='asuransi'  and msid<>'all' order by ms.msdesc  asc");
		$jkel = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='jkel'  and msid<>'all' order by ms.msdesc  asc");
		$kalkulator = $db[0];
        return view('master.kalkulator.detail',compact('kalkulator','produk','asuransi','jkel'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_name'   => 'required',
            'product_code' => 'required',
        ]);
        $product_name = $request->product_name;
        $product_code = $request->product_code;
        $username = Session::get('login')[0]->username;
        // dd(Session::get('login')[0]->id_member);
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
