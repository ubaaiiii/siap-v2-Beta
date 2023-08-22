<?php

namespace App\Http\Controllers\Modul;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataController;
use App\Models\Inquiry;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
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
  private $data_dashboard;
  private $query;
  public function __construct()
  {
    $this->middleware('cek:admin');
    $this->query = new DataController;
    $this->data_dashboard = [
      'pending'   => (object) [
        'status' => [0],
        'judul'  => 'Data Pending',
      ],
      'realisasi' => (object) [
        'status' => [3],
        'judul'  => 'Data Realisasi',
      ],
      'approve'   => (object) [
        'status' => [1],
        'judul'  => 'Data Approve',
      ],
      'verifikasi' => (object) [
        'status' => [10],
        'judul'  => 'Data Check Photo Verif',
      ],
      'approved'  => (object) [
        'status' => [11],
        'judul'  => 'Data Check Photo Approve',
      ],
      'active'    => (object) [
        'status' => [2],
        'judul'  => 'Data Active',
      ],
      'validasi'  => (object) [
        'status' => [5],
        'judul'  => 'Data Validasi',
      ],
      'paid'      => (object) [
        'status' => [20],
        'judul'  => 'Data Paid',
      ],
    ];
  }
  public function index(Request $request, $regid = null)
  {
    if (empty($regid)) {
      $session = Session::get('login')[0];
      $data = [
        'judul'         => (isset($request->q) && array_key_exists($request->q, $this->data_dashboard)) ? $this->data_dashboard[$request->q]->judul : "Inquiry",
        'user'          => DB::table('ms_admin')->where('username', $session->username)->first()
      ];
      return view('master.inquiry.index', compact('data'));
    } elseif (!empty($regid)) {
      // dd(Session::get('login')[0]->id_member);
      $sid        = Crypt::decryptString($regid);
      $sqle       = " SELECT aa.regid, aa.nama, aa.noktp, aa.jkel, aa.pekerjaan, aa.cabang, aa.tgllahir, aa.mulai, aa.akhir, aa.masa, aa.up, aa.status, aa.createdt, aa.createby, aa.editdt, aa.editby, aa.validby, aa.validdt, aa.nopeserta, aa.usia,aa.premi, aa.epremi, aa.tpremi, aa.bunga, aa.tunggakan, aa.produk, aa.mitra, aa.comment, aa.asuransi, aa.policyno,aa.hubungan_ahli_waris,aa.nama_ahli_waris,aa.notelp_ahli_waris FROM tr_sppa aa WHERE aa.regid = '$sid'";
      $data       = DB::select($sqle);
      $sproduk    = $data[0]->produk;
      $sup        = $data[0]->up;
      $payload = [
        'session'   => Session::get('login')[0],
        'data'      => DB::select("SELECT sp.*,sl.tgl_approve FROM tr_sppa sp LEFT JOIN (SELECT regid, MAX(createdt) as tgl_approve FROM tr_sppa_log WHERE regid = '$sid') sl ON  sp.regid = sl.regid WHERE sp.regid = '$sid'"),
        'produk'    => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc"),
        'jkel'      => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc"),
        'kerja'     => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc"),
        'cabang'    => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc"),
        'mitra'     => DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc"),
        'pekerjaan' => DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype"),
        'hubungan'  => DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid"),
        'asuransi'  => DB::select("SELECT ms.msid comtabid,msdesc comtab_nm from ms_master ms left join tr_limit tl on ms.msid=tl.asuransi where ms.mstype='ASURANSI' and tl.produk='$sproduk' and '$sup' BETWEEN tl.minup and tl.maxup group by ms.msid,ms.msdesc "),
        'file'      => DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'"),
        'log'       => DB::select(" SELECT a.regid,a.status,a.comment,a.createdt,a.createby,b.msdesc stdesc FROM tr_sppa_log a INNER JOIN ms_master b ON a.status = b.msid AND b.mstype = 'streq' WHERE regid = '$sid' ORDER BY a.createdt DESC"),
        'judul'     => 'View Pengajuan',
      ];
      // $data       = DB::select("SELECT sp.*,sl.tgl_approve FROM tr_sppa sp LEFT JOIN (SELECT regid, MAX(createdt) as tgl_approve FROM tr_sppa_log WHERE regid = '$sid') sl ON  sp.regid = sl.regid WHERE sp.regid = '$sid'");
      // dd($data);
      // $produk     = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc");
      // $jkel       = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='JKEL'  order by ms.msdesc  asc");
      // $kerja      = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
      // $cabang     = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
      // $mitra      = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
      // $pekerjaan  = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype");
      // $hubungan   = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");
      // $asuransi   = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='asuransi' and ms.msid<>'ALL'order by ms.msid");
      // $dokumen    = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");
      // $file       = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid      ='$sid'");
      // $log        = DB::select(" SELECT a.regid,a.status,a.comment,a.createdt,a.createby,b.msdesc stdesc FROM tr_sppa_log a INNER JOIN ms_master b ON a.status = b.msid AND b.mstype = 'streq' WHERE regid = '$sid' ORDER BY a.createdt DESC");
      // dump($data);
      // return view('master.inquiry.detail', compact('data', 'produk', 'jkel', 'kerja', 'cab', 'mitra', 'hubungan', 'dokumen', 'file', 'sid', 'asuransi'));
      return view('master.inquiry.detail', $payload);
    }
  }
  public function getData(Request $request)
  {
    try {
      //code...
      $master = new Master;

      $session = Session::get('login')[0];
      // dd($session);
      $vlevel = $session->level;
      $userid = $session->username;

      // kalo dibuat join, lama banget loadingnya, jadi dibuat manggil array
      $tb_asuransi = DB::table('ms_insurance')->get();
      $asuransi = [];
      foreach ($tb_asuransi as $a) {
        $asuransi[strtoupper($a->asuransi)] = $a;
      }
      $streq  = $master->getDesc('STREQ');
      $produk = $master->getDesc('PRODUK');
      $cabang = $master->getDesc('CAB');
      // #############################################

      $table = Inquiry::query()
        ->leftJoin('ms_master as ms_status', function ($join) {
          $join->whereRaw('ms_status.msid = tr_sppa.status AND ms_status.mstype = "streq"');
        })
        ->leftJoin('ms_master as ms_produk', function ($join) {
          $join->whereRaw('ms_produk.msid = tr_sppa.produk AND ms_produk.mstype = "produk"');
        })
        ->leftJoin('ms_master as ms_cabang', function ($join) {
          $join->whereRaw('ms_cabang.msid = tr_sppa.cabang AND ms_cabang.mstype = "cab"');
        })
        ->leftJoin('ms_insurance', 'ms_insurance.asuransi', '=', 'tr_sppa.asuransi')
        ->whereNotNull('tr_sppa.up')
        ->whereNotNull('tr_sppa.premi');

      if ($vlevel == 'mkt' or $vlevel == 'smkt') {
        $table->whereRaw("tr_sppa.createby IN (  SELECT CASE
                                                            WHEN a.parent=a.username THEN a.parent
                                                            ELSE a.username
                                                        END
                                                    FROM   ms_admin a
                                                    WHERE  ( a.username='$userid' OR a.parent='$userid'))");
      } elseif ($vlevel == "schecker" or $vlevel == "checker") {
        if ($session->cabang !== "ALL") {
          $table->where('cabang', $session->cabang);
        }
      } else if ($vlevel == "broker") {
        // do nothing

      } else if ($vlevel == "insurance") {
        if ($session->cabang !== "ALL") {
          $table->where('asuransi', $session->cabang);
        }
      }

      $mitra = ($session->mitra == NULL) ? ('NOM') : ($session->mitra);
      if ($mitra !== 'ALL') {
        $table->where("tr_sppa.mitra", $session->mitra);
      }

      // $joins = [
      //     ['ms_master as ma', ["ma.mstype = 'ASURANSI'", "ma.msid = tr_sppa.asuransi"]],
      //     ['ms_master as mc', ["mc.mstype = 'CAB'", "mc.msid = tr_sppa.cabang"]],
      //     ['ms_master as ms', ["ms.mstype = 'STREQ'", "ms.msid = tr_sppa.status"]],
      //     ['ms_master as mp', ["mp.mstype = 'PRODUK'", "mp.msid = tr_sppa.produk"]],
      // ];

      // status berdasarkan tombol di dashboard
      if (!empty($request->q)) {
        if (array_key_exists($request->q, $this->data_dashboard)) {
          $table->where('status', $this->data_dashboard[$request->q]->status);
        } else {
          $request->request->add(['search' => $request->q]);
        }
      }
      // buat order field
      // $columns = [
      //     'regid',
      //     'nama',
      //     'asuransi',
      //     'produk',
      //     'policyno',
      //     'tgllahir',
      //     'mulai',
      //     'up',
      //     'premi',
      //     'cabang',
      //     'tr_sppa.createby',
      //     'status',
      //     'regid', // aksi
      // ];
      // buat select ke database
      $select = [
        // 'tr_sppa.*',
        'regid',
        'nama',
        // 'asuransi',
        'ms_insurance.nmasuransi as asuransi',
        // 'produk',
        'ms_produk.msdesc as produk',
        'policyno',
        'tgllahir',
        'mulai',
        'up',
        'tpremi',
        // cabang',
        'ms_cabang.msdesc as cabang',
        'tr_sppa.createby',
        'ms_status.msdesc as status',
        // 'regid AS reg_encode',
        DB::RAW("Concat(tr_sppa.regid,'-',tr_sppa.status,'-',(IF(tr_sppa.policyno IS NOT NULL,tr_sppa.policyno,''))) AS regid"),
        // 'policyno AS spolicyno'
      ];

      return DataTables::of($table->select($select))
        ->editColumn('up', function ($item) {
          return number_format((float) $item->up);
        })
        ->editColumn('tpremi', function ($item) {
          return number_format((float) $item->tpremi);
        })
        ->editColumn('tgllahir', function ($item) {
          return \Carbon\Carbon::parse($item->tgllahir)->isoFormat('DD-MM-YYYY');
        })
        ->editColumn('mulai', function ($item) {
          return \Carbon\Carbon::parse($item->mulai)->isoFormat('DD-MM-YYYY');
        })
        ->toJson();

      // $query  = $this->query->generateQuery($request, $table, $columns, $select);
      // // echo $query[3];
      // $data   = [];
      // foreach ($query[0] as $row) {
      //     // dd($row);
      //     $btn = "<a href='" . url('inquiry/' . Crypt::encryptString($row->regid)) . "' class='btn btn-44 btn-light shadow-sm mr-2'><i class='bi bi-search'></i></a>";
      //     switch ($row->status) {
      //         case '0':
      //             $btn .= "<a href='" . url('pengajuan/edit/' . Crypt::encryptString($row->regid)) . "' class='btn btn-44 btn-light text-warning shadow-sm mr-2'><i class='bi bi-pencil'></i></a>";
      //             $btn .= "<a href='" . url('pengajuan/hapus/' . Crypt::encryptString($row->regid)) . "' class='btn btn-44 btn-light text-danger shadow-sm mr-2'><i class='bi bi-trash'></i></a>";
      //             break;

      //         default:
      //             break;
      //     }

      //     $nestedData     = [];
      //     // $nestedData[]   = $row->aksi;
      //     // $nestedData[]   = '';
      //     // $nestedData[]   = $btn;
      //     $nestedData[]   = $row->regid;
      //     $nestedData[]   = $row->nama;
      //     $nestedData[]   = (array_key_exists($row->asuransi, $asuransi)) ? $asuransi[$row->asuransi]->nmasuransi : null;
      //     $nestedData[]   = (array_key_exists($row->produk, $produk)) ? $produk[$row->produk]->msdesc : null;
      //     $nestedData[]   = $row->policyno;
      //     $nestedData[]   = $row->tgllahir;
      //     $nestedData[]   = $row->mulai;
      //     $nestedData[]   = is_numeric($row->up) ? number_format($row->up, 2) : $row->up;
      //     $nestedData[]   = is_numeric($row->tpremi) ? number_format($row->tpremi, 2) : $row->tpremi;
      //     $nestedData[]   = (array_key_exists($row->cabang, $cabang)) ? $cabang[$row->cabang]->msdesc : null;
      //     $nestedData[]   = $row->createby;
      //     $nestedData[]   = (array_key_exists($row->status, $streq)) ? $streq[$row->status]->msdesc : null;
      //     $nestedData[]   = $btn;

      //     $data[] = $nestedData;
      // }

      // return response()->json([
      //     "draw"            => intval($request->draw),
      //     "recordsTotal"    => intval($query[1]),
      //     "recordsFiltered" => intval($query[2]),
      //     "data"            => $data,
      //     "sql"             => $query[3]
      // ], 200);
    } catch (\Exception $e) {
      echo $e;
    }
  }
  public function getDesktop(Request $request)
  {
    if ($request->ajax()) {
      $vlevel = Session::get('login')[0]->level;
      $userid = Session::get('login')[0]->username;
      $cari = "%" . $request->search . "%";
      // $cari = "";
      $aColumns = array('asuransi', 'cabang', 'produk', 'createby', 'regid', 'policyno', 'nama', 'tgllahir', 'mulai', 'up', 'premi', 'status', 'aksi');
      $sIndexColumn = "regid";


      $sTable = "SELECT SQL_CALC_FOUND_ROWS asuransi,cabang,produk,createby,regid,policyno,nama,tgllahir,mulai,up,premi,status,aksi FROM ( SELECT mc.msdesc cabang,
			ma.msdesc                  asuransi,
			mp.msdesc                  produk,
			aa.createby,
			regid,
			policyno,
			nama,
			tgllahir,
			mulai,
			up,
			premi,
			ms.msdesc                  status,
			regid     reg_encode,
			Concat(aa.regid, '-', aa.status, '-', (IF(aa.policyno IS NOT NULL, aa.policyno, ''))) aksi ,
			policyno spolicyno
			FROM   tr_sppa aa
			LEFT JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'ASURANSI') ma
					ON ma.msid = aa.asuransi
			INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'CAB') mc
					ON mc.msid = aa.cabang
			INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'STREQ') ms
					ON ms.msid = aa.status
			INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'PRODUK') mp
					ON mp.msid = aa.produk
			WHERE  aa.up != ''
			AND aa.premi != 0  ";
      if ($vlevel == 'mkt' or $vlevel == 'smkt') {
        $sTable .= "AND aa.createby IN ( SELECT CASE WHEN a.parent=a.username THEN a.parent ELSE a.username END FROM   ms_admin a WHERE  ( a.username='$userid' OR a.parent='$userid'))";
      } elseif ($vlevel == "schecker" or $vlevel == "checker") {
        $sTable .= "AND aa.cabang like (SELECT CASE WHEN cabang='ALL' THEN '%%' ELSE cabang END cabang FROM ms_admin WHERE username='$userid')";
      } else if ($vlevel == "broker") {
        $sTable .= " and length(aa.regid)>10 ";
      } else if ($vlevel == "insurance") {
        $sTable .= "AND aa.asuransi LIKE (SELECT cabang FROM ms_admin WHERE level='insurance' AND username='$userid' )";
      }
      $mitra = (Session::get('login')[0]->mitra == NULL) ? ('NOM') : (Session::get('login')[0]->mitra);
      if ($mitra !== 'NOM') {
        $sTable .= " AND aa.mitra = '$mitra' ";
      }
      $sTable = $sTable .  ") t_baru WHERE policyno LIKE '$cari' OR produk LIKE '$cari' OR cabang LIKE '$cari' OR asuransi LIKE '$cari' OR regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR status LIKE '$cari'  OR status  LIKE '$cari' LIMIT 100";
      $data = DB::select($sTable);
      // dd($data);
      return DataTables::of($data)
        ->addColumn('action', function ($data) {
          $button = '<a href="' . 'inquiry/view/' . Crypt::encryptString($data->regid) . '"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
          return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
  }
  public function data_cancel(Request $request)
  {
    if ($request->ajax()) {
      $vlevel = Session::get('login')[0]->level;
      $userid = Session::get('login')[0]->username;
      $cari = "%" . $request->search . "%";
      // $cari = "";
      $sTable = "SELECT regid,produk,nama,tgllahir,cabang,mulai,up,premi,status,aksi FROM (SELECT aa.regid, aa.nama, ac.msdesc 'cabang', ad.msdesc 'produk', aa.tgllahir, aa.mulai, aa.up, aa.premi, ab.msdesc 'status', concat(aa.regid,'-',aa.status) aksi FROM (select * from tr_sppa where status in ('5','6','20')";
      // $sTable = $sTable .  " WHERE policyno LIKE '$cari' OR produk LIKE '$cari' OR cabang LIKE '$cari' OR asuransi LIKE '$cari' OR regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR status LIKE '$cari'  OR status  LIKE '$cari' ";
      if ($vlevel == "schecker" or $vlevel == "checker") {
        $sTable .= " AND aa.cabang LIKE (SELECT CASE WHEN cabang='ALL' THEN '%%' ELSE cabang END cabang FROM ms_admin WHERE username='$userid') ";
      }
      $sTable .= " ) ) t_baru LIMIT 10";

      $data = DB::select($sTable);
      // dd($data);
      return DataTables::of($data)
        ->addColumn('action', function ($data) {
          $button = '<a href="' . 'inquiry/view/' . Crypt::encryptString($data->regid) . '"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
          return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
  }

  // public function index()
  // {

  //     $vlevel = Session::get('login')[0]->level;
  //     $userid = Session::get('login')[0]->username;

  //     $data = [
  //         'judul' => 'Inquiry',
  //     ];
  //     $agent = new \Jenssegers\Agent\Agent;
  //     if($agent->isDesktop()){
  //         return view('master.inquiry.index_dekstop', compact('data'));
  //     }else{
  //         $aColumns = array( 'asuransi','cabang','produk','createby','regid','policyno','nama','tgllahir','mulai','up','premi','status','aksi' );
  //         $sIndexColumn = "regid";
  //         $sTable = "SELECT SQL_CALC_FOUND_ROWS asuransi,cabang,produk,createby,regid,policyno,nama,tgllahir,mulai,up,premi,status,aksi FROM ( SELECT mc.msdesc cabang, ma.msdesc asuransi, mp.msdesc produk, aa.createby, regid, policyno, nama, tgllahir, mulai, up, premi, ms.msdesc status, Concat(aa.regid, '-', aa.status, '-', (IF(aa.policyno IS NOT NULL, aa.policyno, 'null'))) aksi FROM   tr_sppa aa LEFT JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'ASURANSI') ma ON ma.msid = aa.asuransi INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'CAB') mc ON mc.msid = aa.cabang INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'STREQ') ms ON ms.msid = aa.status INNER JOIN ( SELECT msid, msdesc FROM ms_master where mstype = 'PRODUK') mp ON mp.msid = aa.produk WHERE  aa.up != '' AND aa.premi != 0";
  //     // }
  //         $sTable = $sTable .  ") t_baru LIMIT 10";
  //         $inquiry = DB::select($sTable);
  //         return view('master.inquiry.index', compact('data','inquiry'));
  //     }

  // }
  public function cancel()
  {
    $vlevel = Session::get('login')[0]->level;
    $userid = Session::get('login')[0]->username;
    $data = [
      'judul' => 'Inquiry Cancel',
    ];
    $inquiry = "    ";
    $agent = new \Jenssegers\Agent\Agent;
    if ($agent->isDesktop()) {
      return view('master.inquiry.inquiry_cancel', compact('data', 'inquiry'));
    } else {
      return view('master.inquiry.index', compact('data', 'inquiry'));
    }
  }
  public function store(Request $request)
  {
    $brand = DB::select("SELECT * FROM md_brand WHERE id_brand='$request->id_brand'");
    $kode = DB::select("SELECT max(id_sku_detail) as kodeTerbesar FROM md_product");
    $urutan = (int) substr($kode[0]->kodeTerbesar, -5);
    $urutan++;
    $depan = $brand[0]->brand_code . $request->varian_code;
    $sku_no = $depan . sprintf("%05s", $urutan);
    // dd($sku_no);

    $sku_name = $request->product_name . ' - ' . $request->varian_name;
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
    $volume_weight = ($length * $width * $height) / 6;
    $actual_weight = $request->actual_weight;
    $retail_price = $request->retail_price;
    $username = Session::get('login')[0]->username;
    // dd($product_code);
    DB::select("INSERT INTO md_product VALUES ('','$sku_no','$sku_name','$sku_status','$product_name','$varian_name','$varian_code','$id_brand','$sku_no_digit','$sku_name_digit','$id_category','$id_category_tokopedia','$id_category_shopee','$length','$width','$height','$volume_weight','$actual_weight','$retail_price','$username')");
    // return view('master.product.add');
    return redirect()->intended('product')->with('success', 'Data Berhasil ditambahkan');
  }
  public function view($id)
  {
    // dd(Session::get('login')[0]->id_member);
    $sid = Crypt::decryptString($id);
    $data = DB::select("select aa.regid,aa.nama,aa.noktp,aa.jkel,aa.pekerjaan,aa.cabang,aa.tgllahir,aa.mulai, aa.akhir,aa.masa,aa.up,aa.status,aa.createdt,aa.createby,aa.editdt,aa.editby,aa.validby, aa.validdt,aa.nopeserta,aa.usia,aa.premi,aa.epremi,aa.tpremi, aa.bunga,aa.tunggakan, aa.produk,aa.mitra,aa.comment,aa.asuransi,aa.policyno,aa.asuransi,ab.msdesc tstatus,aa.hubungan_ahli_waris from tr_sppa aa  left join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' where aa.regid='$sid'");
    $produk = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk' order by ms.mstype");
    $cabang = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype");
    $pekerjaan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype");
    $asuransi = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='asuransi' and ms.msid<>'ALL' order by ms.mstype");
    $mitra = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='mitra' and ms.msid<>'ALL' order by ms.mstype");
    $jkel = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='jkel'  order by ms.mstype");
    $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$id' ");
    $dokumen = DB::select("SELECT regid, tglupload, nama_file, tipe_file, ukuran_file,file,pages,createby,createdt seqno,jnsdoc,catdoc FROM tr_document WHERE regid='$sid'");
    $log = DB::select("SELECT a.regid,a.status,a.comment,a.createdt,a.createby ,b.msdesc stdesc from tr_sppa_log a inner join ms_master b on a.status=b.msid and b.mstype='streq' where regid='$sid' order by a.createdt desc");
    // dd($dokumen);
    return view('master.inquiry.view', compact('data', 'produk', 'cabang', 'pekerjaan', 'asuransi', 'mitra', 'jkel', 'file', 'dokumen', 'log'));
  }
  public function detail_inquiry_claim($id)
  {
    // dd(Session::get('login')[0]->id_member);
    $sid = Crypt::decryptString($id);
    $data = DB::select("select aa.*,ab.msdesc tstatus  from tr_sppa aa  inner join ms_master ab on aa.status=ab.msid and ab.mstype='STREQ' where aa.regid='$sid'");
    $produk = DB::select("select ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='produk' order by ms.mstype");
    $cabang = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='cab'  order by ms.mstype");
    $pekerjaan = DB::select("select   ms.msid comtabid,msdesc comtab_nm from ms_master ms where ms.mstype='kerja'  order by ms.mstype");
    $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$id' ");
    $dokumen = DB::select("SELECT a.* from tr_document a  where regid='$sid'");
    // dd($dokumen);
    return view('master.inquiry.view_cancel', compact('data', 'produk', 'cabang', 'pekerjaan', 'file', 'dokumen'));
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
