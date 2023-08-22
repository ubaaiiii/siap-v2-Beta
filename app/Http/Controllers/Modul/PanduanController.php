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
use Session;
class PanduanController extends Controller
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
    public function getData(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            // Session::get('login')[0]->id_member;
            $data = DB::select("SELECT a.modul,a.level,a.file from tr_manual a left join ms_master b on b.msid=a.level and b.mstype='LEVEL' where level ='$vlevel' LIMIT 1000"); 
            // dd($data);
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a id="" href="'.$data->file.'" class="btn btn-default btn-sm" style="display:inline !important;">Download</a>&nbsp;';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('master.panduan.index');
    }


    public function index()
    {
        // dd(Session::get('login')[0]->id_member);
        // $data = DB::select("SELECT * FROM md_product LEFT JOIN md_brand ON md_product.id_brand=md_brand.id_brand LEFT JOIN md_category ON md_product.id_category=md_category.id_category LEFT JOIN md_category_tokopedia ON md_product.id_category_tokopedia=md_category_tokopedia.id_category_tokopedia LEFT JOIN md_category_shopee ON md_product.id_category_shopee=md_category_shopee.id_category_shopee");
        $data = [
            'judul' => 'Panduan',
        ];
        

        return view('master.panduan.index', compact('data'));
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
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
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
