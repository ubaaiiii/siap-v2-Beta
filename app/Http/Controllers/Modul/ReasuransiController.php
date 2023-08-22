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
class ReasuransiController extends Controller
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
            
            // $reasuransi = (Session::get('login')[0]->reasuransi == NULL)?('NOM'):(Session::get('login')[0]->reasuransi);
            // if ($reasuransi !== 'NOM') {
            //     $sTable .= " AND aa.reasuransi = '$reasuransi' ";
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
                                        '<a href="'.'reasuransi/edit/'. Crypt::encrypt($p->regid).'" class="btn btn-default w-100 shadow small">Detail</a>'.
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
            
            
            $sTable = "select ab.nmasuransi,aa.asuransi,sum(sgp) sgp , sum(srp) srp ,sum(sor) sor from (SELECT a.asuransi,sum(a.gpremi) sgp,0 srp,sum(a.amtreas) sor from tr_sppa_reas a where a.rtype='OR' group by a.asuransi union all SELECT a.asuransi,0 sgp, sum(a.amtreas) srp , 0 sor from tr_sppa_reas a where a.rtype='treaty' group by a.asuransi) aa inner join ms_insurance ab on aa.asuransi=ab.asuransi group by aa.asuransi order by aa.asuransi ASC ";
            // $sTable .= " WHERE HAVING left(sg,4) LIKE '$cari' OR HAVING SUM(totpremi) LIKE '$cari' OR HAVING SUM(earn) LIKE '$cari' OR HAVING SUM(unearn) LIKE '$cari' GROUP BY left(sg,4) LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'reasuransi/detail/'. Crypt::encrypt($data->asuransi).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function getDetail(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            $sid = Crypt::decrypt($request->sid);
            // dd($sid);
            $sTable = "select aa.profileid,sum(sgp) sgp , sum(srp) srp ,sum(sor) sor from (SELECT a.asuransi,a.profileid,sum(a.gpremi) sgp,sum(a.amtreas) srp,sum(a.amtreas) sor from tr_sppa_reas a where a.rtype='OR' and a.asuransi='$id' group by a.profileid union all SELECT a.asuransi,a.profileid,sum(a.gpremi)sgp , sum(a.amtreas) srp , sum(a.amtreas) sor from tr_sppa_reas a where a.rtype='treaty' and a.asuransi='$sid' group by a.profileid) aa inner join ms_insurance ab on aa.asuransi=ab.asuransi group by aa.profileid order by aa.asuransi ASC  ";
            // $sTable .= " WHERE HAVING left(sg,4) LIKE '$cari' OR HAVING SUM(totpremi) LIKE '$cari' OR HAVING SUM(earn) LIKE '$cari' OR HAVING SUM(unearn) LIKE '$cari' GROUP BY left(sg,4) LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'../../reasuransi/transaksi/'. Crypt::encrypt($data->profileid).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
    }
    public function getTransaksi(Request $request)
    {
        if($request->ajax())
        {
            $vlevel = Session::get('login')[0]->level;
            $userid = Session::get('login')[0]->username;
            $cari = "%".$request->search."%";
            $sid = Crypt::decrypt($request->sid);
            // dd($sid);
            $sTable = "SELECT left(sg,10)tahun,SUM(totpremi) sj1,SUM(earn) sj2,SUM(unearn) sj3 FROM (SELECT left(mulai,10) sg,SUM(a.premi) totpremi, 0 earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,10) UNION ALL SELECT left(mulai,10) sg,0 totpremi, SUM(ROUND(TIMESTAMPDIFF(DAY, mulai,now() )/TIMESTAMPDIFF(DAY, mulai, akhir),5)*premi ) earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,10) UNION ALL SELECT left(mulai,10) sg,0  totpremi, 0 earn, sum(ROUND(TIMESTAMPDIFF(DAY, now(), akhir)/TIMESTAMPDIFF(DAY, mulai, akhir),5)*premi)  unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,10) ) p where left(sg,7)='$sid' GROUP BY left(sg,10)  ";
            // $sTable .= " WHERE HAVING left(sg,4) LIKE '$cari' OR HAVING SUM(totpremi) LIKE '$cari' OR HAVING SUM(earn) LIKE '$cari' OR HAVING SUM(unearn) LIKE '$cari' GROUP BY left(sg,4) LIMIT 10";
            $data = DB::select($sTable);
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a href="'.'reasuransi/detail/'. Crypt::encrypt($data->tahun).'"  class="btn btn-default btn-sm" style="display:inline !important;">View</a>&nbsp;';
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
        // AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND (DAY, NOW(),akhir )>=0 GROUP BY left(mulai,7) UNION ALL SELECT left(mulai,7) sg,0 totpremi, SUM(ROUND(TIMESTAMPDIFF(DAY, mulai,now())/TIMESTAMPDIFF(DAY, mulai, akhir),5)*premi ) earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,7) UNION ALL SELECT left(mulai,7) sg,0  totpremi, 0 earn, sum(ROUND(TIMESTAMPDIFF(DAY, now(), akhir)/TIMESTAMPDIFF(DAY, mulai, akhir),5)*premi)  unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,7) ) p GROUP BY left(sg,4) 
        $sTable = "SELECT ab.nmasuransi,aa.asuransi,sum(sgp) sgp , sum(srp) srp ,sum(sor) sor from (SELECT a.asuransi,sum(a.gpremi) sgp, 0 srp,sum(a.amtreas) sor from tr_sppa_reas a where a.rtype='OR' group by a.asuransi union all SELECT a.asuransi,0 sgp, sum(a.amtreas) srp , 0 sor from tr_sppa_reas a where a.rtype='treaty' group by a.asuransi) aa inner join ms_insurance ab on aa.asuransi=ab.asuransi group by aa.asuransi order by aa.asuransi ASC LIMIT 10";
        $reasuransi = DB::select($sTable);
        $produk = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='produk' and ms.msid<>'ALL' order by ms.msdesc  asc");
        $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        // dd($reasuransi); 
        // dd(Session::get('login')[0]);
        $data = [
            'judul' => 'Reasuransi',
        ];
        $agent = new \Jenssegers\Agent\Agent;
            return view('modul.reasuransi.index_desktop', compact('data','reasuransi','produk','mitra'));
        // if($agent->isDesktop()){
        // }else{
        //     return view('modul.reasuransi.index', compact('data','reasuransi','produk','mitra'));
        // }
    }
    public function store(Request $request)
    {
        $scode=$request->code;
        $sdesk=$request->desk;
        $stype='reasuransi';
        $userid=Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        DB::select("INSERT INTO ms_master (msid,msdesc,mstype,createby,createdt) VALUES ('$scode','$sdesk','$stype','$userid','$sdate')");
        return redirect()->intended('reasuransi')->with('success', 'Data Berhasil ditambahkan');
    }
    public function edit($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decrypt($id);
        $data = DB::select("SELECT * FROM ms_master where msid='$sid'");
        dd($data);
        return view('modul.reasuransi.edit', compact('data'));
    }
    public function detail($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decrypt($id);
        $data = DB::select("SELECT left(sg,7)tahun,SUM(totpremi) sj1,SUM(earn) sj2,SUM(unearn) sj3 FROM (SELECT left(mulai,7) sg,SUM(a.premi) totpremi, 0 earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi'  AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,7) UNION ALL SELECT left(mulai,7) sg,0 totpremi, SUM(ROUND((TIMESTAMPDIFF(DAY, mulai,now() )/TIMESTAMPDIFF(DAY, mulai, akhir)),5)*premi ) earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,7) UNION ALL SELECT left(mulai,7) sg,0  totpremi, 0 earn, sum(ROUND((TIMESTAMPDIFF(DAY, now(), akhir)/TIMESTAMPDIFF(DAY, mulai, akhir)),5)*premi)  unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,7) ) p where left(sg,4)='$sid' GROUP BY left(sg,7)");
        $data = [
            'judul' => 'reasuransi Detail',
        ];
        // dd($data);
        return view('modul.reasuransi.index_detail', compact('data','id'));
    }
    public function transaksi($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $sid = Crypt::decrypt($id);
        $data = DB::select("SELECT left(sg,10)tahun,SUM(totpremi) sj1,SUM(earn) sj2,SUM(unearn) sj3 FROM (SELECT left(mulai,10) sg,SUM(a.premi) totpremi, 0 earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,10) UNION ALL SELECT left(mulai,10) sg,0 totpremi, SUM(ROUND(TIMESTAMPDIFF(DAY, mulai,now() )/TIMESTAMPDIFF(DAY, mulai, akhir),5)*premi ) earn, 0 unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,10) UNION ALL SELECT left(mulai,10) sg,0  totpremi, 0 earn, sum(ROUND(TIMESTAMPDIFF(DAY, now(), akhir)/TIMESTAMPDIFF(DAY, mulai, akhir),5)*premi)  unearn FROM tr_sppa a INNER JOIN tr_sppa_paid b ON a.regid=b.regid  where b.paidtype='premi' AND TIMESTAMPDIFF(DAY, mulai,NOW() )>=0 AND TIMESTAMPDIFF(DAY, NOW(),akhir )>=0 GROUP BY left(mulai,10) ) p where left(sg,7)='$sid' GROUP BY left(sg,10)");
        $data = [
            'judul' => 'Detail Transaksi',
        ];
        // dd($data);
        return view('modul.reasuransi.index_transaksi', compact('data','id'));
    }
    public function update(Request $request){
        $id = Crypt::decrypt($request->msid);
        $scode=$request->code;
        $sdesk=$request->desk;
        $stype='reasuransi';
        $userid=Session::get('login')[0]->username;
        $sdate = date('Y-m-d H:i:s');
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));
        // DB::select("UPDATE tr_sppa SET status = '1',editby = '$userid',editdt = '$sdate' WHERE regid = '$sregid' AND premi <> 0 AND masa <> 0 AND usia <> 0");
        DB::select("UPDATE ms_master SET msdesc='$sdesk',editby='$userid',editdt='$sdate' WHERE msid='$id' and mstype='$stype' ");
        // dd($id);
        return redirect()->intended('reasuransi')->with('success', 'Data Berhasil disimpan');
    }
    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
