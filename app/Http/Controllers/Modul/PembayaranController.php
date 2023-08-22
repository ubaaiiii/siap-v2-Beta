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
class PembayaranController extends Controller
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
            
            
            $sTable = "SELECT paidid,regid,nama,up,premi,paiddt,paidamt,comment,aksi FROM (SELECT ab.paidid,aa.regid,aa.nama,aa.up,aa.premi,ab.paiddt,ab.paidamt,ac.comment,concat(aa.regid,'-',ab.paidid,'-',ac.status) aksi FROM tr_sppa aa INNER JOIN tr_sppa_paid ab ON aa.regid = ab.regid INNER JOIN tr_sppa_log ac ON aa.regid = ac.regid AND ab.createdt = ac.createdt";
            $sTable .= " ) t_baru WHERE regid LIKE '$cari' OR nama LIKE '$cari' OR up LIKE '$cari' OR premi LIKE '$cari' OR paidid LIKE '$cari' OR paiddt LIKE '$cari' OR paidamt LIKE '$cari' OR comment LIKE '$cari' LIMIT 10";
            // $sTable .= " ) t_baru  LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'pembayaran/edit/'. Crypt::encryptString($data->paidid).'"  class="btn btn-default btn-sm" style="display:inline !important;">Edit</a>&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->editColumn('up', function ($data) {
                    return number_format($data->up, 0);
                })->editColumn('premi', function ($data) {
                    return number_format($data->premi, 0);
                })
                ->make(true);
            }
    }
    public function get_nama(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            $array = "";
            if ($request->jenis_transaksi == "premi") {
                $array = DB::select("SELECT ms.regid id,concat(ms.nama,' - ',ms.regid) text,status dStatus FROM tr_sppa ms WHERE ms.status='5' AND ms.regid LIKE '$cari' OR ms.nama LIKE '$cari' LIMIT 20");
            } else if ($request->jenis_transaksi == "klaim") {
                $array = DB::select("SELECT ms.regid id,concat(ms.nama,' - ',ms.regid) text,status dStatus FROM tr_sppa ms WHERE ms.status='93' AND ms.regid LIKE '$cari' OR ms.nama LIKE '$cari' LIMIT 20");
            } else if ($request->jenis_transaksi == "refund") {
                if ($request->jenis_kas == "masuk") {
                    $array = DB::select("SELECT ms.regid id,concat(ms.nama,' - ',ms.regid) text,status dStatus FROM tr_sppa ms WHERE ms.status='84' AND ms.regid LIKE '$cari' OR ms.nama LIKE '$cari' LIMIT 20");
                } else if ($request->jenis_kas == "keluar") {
                    $array = DB::select("SELECT ms.regid id,concat(ms.nama,' - ',ms.regid) text,status dStatus FROM tr_sppa ms WHERE ms.status='83' AND ms.regid LIKE '$cari' OR ms.nama LIKE '$cari' LIMIT 20");
                }
            }else{
                $array = DB::select("SELECT ms.regid id,concat(ms.nama,' - ',ms.regid) text,status dStatus FROM tr_sppa ms WHERE ms.status IN (5, 83, 84, 93) AND ms.regid LIKE '$cari' OR ms.nama LIKE '$cari' AND dStatus='$request->jenis_transaksi'");
            }
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
        $sTable = "SELECT 'paidid','regid','nama','up','premi','paiddt','comment','aksi' FROM (SELECT ab.paidid,aa.regid,aa.nama,aa.up,
               aa.premi,ab.paiddt,ac.comment,concat(aa.regid,'-',ab.paidid,'-',ac.status) aksi FROM tr_sppa aa INNER JOIN tr_sppa_paid ab ON aa.regid = ab.regid INNER JOIN tr_sppa_log ac ON aa.regid = ac.regid AND ab.createdt = ac.createdt";

        $sTable .= " ) t_baru  LIMIT 10";

        $pembayaran = DB::select($sTable);
        // $array = DB::select("SELECT ms.regid id,concat(ms.nama,' - ',ms.regid) text,status dStatus FROM tr_sppa ms WHERE ms.status IN (5, 83, 84, 93)");
        // $data_nama = response()->json($array);
        $data = [
            'judul' => 'pembayaran',
        ];
        // dd($data_nama);
        $agent = new \Jenssegers\Agent\Agent;
        return view('modul.pembayaran.index_desktop', compact('data','pembayaran'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.pembayaran.index', compact('data','pembayaran'));
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
        return view('master.pengajuan.add', compact('produk','jkel','kerja','cab','mitra','hubungan'));
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
        $sregid     = $request->regid;
        $stglbayar  = $request->tgl_bayar;   
        $jenisTrans = $request->jenis_transaksi;
        $userid     = Session::get('login')[0]->username;
        $comment    = "";
        $jenisKas   = $request->jenis_kas;
        $sdate      = date('Y-m-d H:i:s');
        // dd($request);
        
        $sqll = DB::select("SELECT concat(concat(prevno,DATE_FORMAT(now(),'%y%m')),right(concat(formseqno,b.lastno),formseqlen)) as seqno FROM tbl_lastno_form a LEFT JOIN tbl_lastno_trans b ON a.trxid=b.trxid WHERE a.trxid= 'paidid'");
        $nourut = $sqll[0]->seqno;
        $sqln = "UPDATE tbl_lastno_trans SET lastno=lastno+1 WHERE trxid= 'paidid'";
        $hasiln = DB::select($sqln);
        $paidid = $nourut;

        if ($jenisTrans=='premi') {
            if ($comment == '') {
                $comment = "Pembayaran Premi";
            } 
            $insPaid = DB::select("INSERT INTO tr_sppa_paid(paidid, regid, paiddt, paidamt, createdt, createby,paidtype) SELECT '$paidid',regid,'$stglbayar',premi,'$sdate','$userid','PREMI' FROM tr_sppa WHERE regid='$sregid' ");
            $insLog = DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) SELECT regid,'20','$sdate','$userid','$comment'FROM tr_sppa WHERE regid='$sregid' ");
            
            $updSPPA = DB::select("UPDATE tr_sppa SET status = '20' WHERE regid='$sregid'");
        }
        
        elseif ($jenisTrans=='refund') {
            
            $insPaid = DB::select("INSERT INTO tr_sppa_paid (paidid, regid, paiddt, paidamt, createdt, createby,paidtype) SELECT '$paidid', sp.regid,'$stglbayar',IF (bd.regid IS NOT NULL,IF (DATEDIFF(sc.tglbatal,'$stglbayar')>30,sc.refund,sp.premi),sp.premi),'$sdate','$userid','REFUND' FROM tr_sppa sp LEFT JOIN tr_bordero_dtl bd ON bd.regid = sp.regid LEFT JOIN tr_sppa_cancel sc ON sc.regid = sp.regid WHERE sp.regid='$sregid'");
            
            if ($jenisKas == 'masuk') {               // kas masuk dari asuransi
                if ($comment !== '') {
                    $comment = "Refund Kas Masuk, ket: ".$comment;
                } else {
                    $comment = "Refund Kas Masuk";
                }
                $insLog = DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) SELECT regid,'85','$sdate','$userid','$comment' FROM tr_sppa WHERE regid='$sregid' ");
                
                $updSPPA = DB::select("UPDATE tr_sppa SET status = '85' WHERE regid='$sregid'");
            }
            
            elseif ($jenisKas == 'keluar') {
                if ($comment !== '') {
                    $comment = "Refund Kas Keluar, ket: ".$comment;
                } else {
                    $comment = "Refund Kas Keluar";
                }
                $insLog = DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) SELECT regid,'84','$sdate','$userid','$comment' FROM tr_sppa WHERE regid='$sregid' ");
                
                $updSPPA = DB::select("UPDATE tr_sppa SET status = '84' WHERE regid='$sregid'");
            }
            
        }
        
        elseif ($jenisTrans=='klaim') {
            // dd($paidid);
            if ($comment == '') {
                $comment = "Pembayaran Claim";
            } 
            // $jmlbayarclaim = str_replace('.', '', $request->jmlbyr);
            $insPaid = DB::select("INSERT INTO tr_sppa_paid(paidid, regid, paiddt, paidamt, createdt, createby,paidtype) VALUES ('$paidid','$sregid','$stglbayar','$request->jumlah_bayar','$sdate','$userid','CLAIM')");
            // dd(DB::select("SELECT * FROM tr_sppa_paid WHERE regid='$sregid'"));
            $insLog = DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) SELECT regid,'95','$sdate','$userid','$comment' FROM tr_sppa WHERE regid='$sregid' ");
            
            $updSPPA = DB::select("UPDATE tr_sppa SET status = '95' WHERE regid='$sregid'");
            
            $updClaim = DB::select("UPDATE tr_claim SET statclaim = '95' WHERE regid='$sregid'");
        }

        // DB::select("INSERT INTO tr_sppa (regid, nama, noktp, jkel, tempat_lahir, alamat, pekerjaan, cabang, tgllahir, mulai, akhir, masa, up, nopeserta, status, createby,createdt, premi, epremi,tpremi, usia, produk, tunggakan, bunga, mitra, nama_ahli_waris, notelp_ahli_waris, hubungan_ahli_waris, comment)VALUES('$regid','$snama','$snoktp','$sjkel','$stmplahir','$salamat','$spekerjaan','$scabang','$stgllahir','$smulai','$sakhir','$smasa','$sup','$snopeserta','$status','$userid','$sdate','$spremi','$sepremi','$stpremi','$susia','$sproduk','$stunggakan','$sbunga','$smitra','$nmahli','$notelpahli','$hubungan','$scomment')");
        return redirect()->intended('pembayaran')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decryptString($id);
        $data = DB::select("SELECT sp.paidid,tr.regid,tr.nama,sp.paiddt,sp.paidamt FROM tr_sppa_paid sp LEFT JOIN tr_sppa tr ON tr.regid = sp.regid WHERE sp.paidid = '$sid'");
        // dd($data);
        return view('modul.pembayaran.edit', compact('data','id'));
    }
   
    public function update(Request $request)
    {
        $this->validate($request, [
            'jumlah_bayar'   => 'required',
            'tglpaid' => 'required',
        ]);
        $paidid = $request->paidid;
        $regid = $request->regid;
        $stglbayar = $request->tglpaid;
        $userid = Session::get('login')[0]->username;
        $paidid = Crypt::decryptString($paidid);
        DB::select("UPDATE tr_sppa_paid SET paiddt='$stglbayar',paidamt='$request->jumlah_bayar' WHERE paidid='$paidid'");
        DB::select("insert into tr_sppa_log (regid,status,createby,createdt,comment) VALUES ('$regid','$paidid','$userid',now(),'Edit Tanggal Bayar')");
        // dd($hasil);
        return redirect()->intended('pembayaran')->with('success', 'Data Berhasil diubah');
    }
    public function delete($id,$regid)
    {
        $regid = Crypt::decryptString($regid);
        $paidid = Crypt::decryptString($id);
        $userid = Session::get('login')[0]->username;
        $tr_sppa = DB::select("SELECT status FROM tr_sppa WHERE regid = '$regid'");
        $statusBaru = "";
        $string = "";
        foreach($tr_sppa as $row){
            switch($row->status) {
                case '20':                  // Paid
                    $statusBaru = '5';      // Validasi
                    $string     = "Premi";
                    break;
                case '84':                  // Refund Paid Broker
                    $statusBaru = '83';     // Refund Validasi
                    $string     = "Refund Paid Broker";
                    break;
                case '85':                  // Refund Paid Asuransi
                    $statusBaru = '84';     // Refund Paid Broker
                    $string     = "Refund Paid Asuransi";
                    break;
                case '95':                  // Claim Paid
                    $statusBaru = '93';     // Claim Valid
                    $string     = "Claim";
                    break;
            }
        }

        DB::select("DELETE FROM tr_sppa_paid WHERE paidid='$paidid'");
        DB::select("INSERT INTO tr_sppa_log (regid, status, createdt, createby, comment) VALUES ('$regid','$statusBaru',now(),'$userid','Hapus Pembayaran $string')");
        DB::select("UPDATE tr_sppa SET status='$statusBaru' WHERE regid='$regid'");

        // return view('master.product.add');
        return redirect()->intended('pembayaran')->with('success', 'Data Berhasil dihapus');
    }
}
