<?php
namespace App\Http\Controllers\Modul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use Session;
class ProfileController extends Controller
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
        $session = Session::get('login')[0];
        $payload = [
            'session'    => $session,
            // dd(Session::get('login')[0]->id_member);
            // $data    = DB::select("SELECT * FROM md_product LEFT JOIN md_brand ON md_product.id_brand=md_brand.id_brand LEFT JOIN md_category ON md_product.id_category=md_category.id_category LEFT JOIN md_category_tokopedia ON md_product.id_category_tokopedia=md_category_tokopedia.id_category_tokopedia LEFT JOIN md_category_shopee ON md_product.id_category_shopee=md_category_shopee.id_category_shopee"),
            // $profile = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc"),
            // $jkel    = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc"),
            'data'       => DB::select("select * from ms_admin a where username='$session->username'")[0],
            'level'      => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='utype' and ms.msid<>'ALL' order by ms.msdesc  asc"),
            'cabang'     => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc"),
            'mitra'      => DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra'  order by ms.mstype"),
            'parent'     => DB::select("select   ms.username comtabid,nama comtab_nm from ms_admin ms order by ms.username"),
        ];
        // dd($payload['data']);

        // dd($data);
        // return view('master.akun.index', compact('data','profile','jkel','kerja','cab','mitra','hubungan'));
        return view('master.akun.index', $payload);
    }
    public function add()
    {
        // dd(Session::get('login')[0]->id_member);
        $brand = DB::select("SELECT * FROM md_brand");
        $category = DB::select("SELECT * FROM md_category");
        $tokopedia = DB::select("SELECT * FROM md_category_tokopedia");
        $shopee = DB::select("SELECT * FROM md_category_shopee");
        return view('master.product.add', compact('brand','tokopedia','shopee','category'));
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
    public function password()
    {
        $userid = Session::get('login')[0]->username;
        $data =DB::select("select a.* from ms_admin a where a.username='$userid'");
        return view('master.akun.password', compact('data'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [ 
            'nama'   => 'required',
            'email' => 'required',
            'nohp' => 'required',
        ]);
        // $product_name = $request->product_name;
        // $product_code = $request->product_code;
        $sdate = date('Y/m/d H:i:s');
        $userid = Session::get('login')[0]->username;
        $id_admin = Session::get('login')[0]->id_admin;
        // dd($request);
        // $id_admin = Crypt::decryptString($request->id_admin);
        $data = DB::select("UPDATE ms_admin SET nama='$request->nama',email='$request->email',nohp='$request->nohp',editby='$userid',editdt='$sdate' WHERE username='$userid'");
        return redirect()->intended('profile')->with('success', 'Data Berhasil diubah');
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'passwordLama'   => 'required',
            'passwordBaru' => 'required',
            'konfirmasiPassword' => 'required',
        ]);
        // $product_name = $request->product_name;
        // $product_code = $request->product_code;
        $sdate = date('Y/m/d H:i:s');
        $userid = Session::get('login')[0]->username;
        $id_admin = Session::get('login')[0]->id_admin;
        $password = Session::get('login')[0]->password;
        $passwordLama = Hash::make($request->passwordLama);
        $passwordBaru = Hash::make($request->passwordBaru);
        // $cek = DB::select("SELECT * FROM ms_admin WHERE password='$passwordLama'");
        // Hash::check($request->passwordLama, Session::get('login')[0]->password);  
        if (Hash::check($request->passwordLama, Session::get('login')[0]->password)) {
            $data = DB::select("UPDATE ms_admin SET password='$passwordBaru' WHERE username='$userid'");
            return redirect()->intended('profile')->with('success', 'Data Berhasil diubah');
        }else{
            return redirect()->intended('password')->with('error', 'Password Lama Salah');
        }
        // dd($request);
        // $id_admin = Crypt::decryptString($request->id_admin);
        
    }
    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
