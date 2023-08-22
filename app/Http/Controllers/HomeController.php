<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
class HomeController extends Controller
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
    public function index(Request $request)
    {
        $session            = $request->session()->get('login')[0];
        $userid             = $session->username;
        $data               = collect(DB::select("SELECT sum(jkel='P') as Perempuan,sum(jkel='L') as Laki FROM tr_sppa WHERE createby='$userid'"));
        $jumlah_pengajuan[] = $data[0]->Laki;
        $jumlah_pengajuan[] = $data[0]->Perempuan;
        $response = [
            'session'           => $session,
            'jkel'              => ['Laki-laki','Perempuan'],
            'jumlah_pengajuan'  => $jumlah_pengajuan,
        ];
        // dd($session);
        // dd(session('level'));
        // $dataLaki = DB::select("SELECT sum(jkel='L') as Laki FROM tr_sppa ");
        // $dpending           = DB::select("SELECT count(1)  as pending FROM tr_sppa WHERE createby='$userid' and status in (0,51,1) ");
        // $dverif             = DB::select("SELECT count(1)  as verif FROM tr_sppa WHERE createby='$userid' and status in (11,4)");
        // $dvalid             = DB::select("SELECT count(1)  as valid FROM tr_sppa WHERE createby='$userid' and status in  (5,6) ");
        // $drealisasi         = DB::select("SELECT count(1)  as realisasi FROM tr_sppa WHERE createby='$userid' and status in (3,20) ");
        DB::enableQueryLog();
        $dashboard = DB::table('tr_sppa')
            ->selectRaw("
            SUM(CASE WHEN tr_sppa.status IN (0) THEN 1 ELSE 0 END) AS pending,          -- Pending
            SUM(CASE WHEN tr_sppa.status IN (3) THEN 1 ELSE 0 END) AS realisasi,        -- Realisasi
            SUM(CASE WHEN tr_sppa.status IN (1) THEN 1 ELSE 0 END) AS approve,          -- Approve
            SUM(CASE WHEN tr_sppa.status IN (10) THEN 1 ELSE 0 END) AS verif,           -- Check Foto Verif
            SUM(CASE WHEN tr_sppa.status IN (11) THEN 1 ELSE 0 END) AS approved,        -- Check Foto Approve
            SUM(CASE WHEN tr_sppa.status IN (2) THEN 1 ELSE 0 END) AS active,           -- Active
            SUM(CASE WHEN tr_sppa.status IN (5) THEN 1 ELSE 0 END) AS validasi,         -- Validasi
            SUM(CASE WHEN tr_sppa.status IN (0,3,1,10,11,2,5) THEN 1 ELSE 0 END) AS outstanding,       -- Outstanding
            SUM(CASE WHEN tr_sppa.status IN (20) THEN 1 ELSE 0 END) AS paid             -- Paid
            ");
        $kontak = false;
        switch($session->level) {
            case "mkt" :
                $kontak = true;
                $dashboard->where('createby', $session->username);
                break;
            case "smkt" :
                $kontak = true;
                $child = DB::table('ms_admin')->where('parent', $session->username)->get();
                $dashboard->where('createby', $session->username)
                    ->orWhere('createby', $child->username);
                break;
            case "checker":
            case "schecker" :
                $kontak = true;
                if ($session->cabang != "ALL") {
                    $dashboard->where('cabang', $session->cabang);
                }
                break;
            case "insurance" :
                $kontak = true;
                $dashboard->where('asuransi', $session->cabang);
                break;
            case "broker" :
                $bulannya = (empty($_GET['bulannya']) ? date('Y-m') : $_GET['bulannya']);
                $dashboard_broker = DB::table('ms_contact as cnt')
                    ->selectRaw("
                        adm.username,
                        adm.nama,
                        adm.id_admin,
                        SUM(CASE WHEN lg.status IN(10, 12, 13) THEN 1 ELSE 0 END) AS approval,
                        SUM(CASE WHEN lg.status IN(20) THEN 1 ELSE 0 END) AS paid,
                        SUM(CASE WHEN lg.status IN(7, 71, 72, 8, 81, 82) THEN 1 ELSE 0 END) AS cancelation,
                        SUM(CASE WHEN lg.status IN(90, 91, 92, 93, 94, 95) THEN 1 ELSE 0 END) AS claim,
                        count(lg.regid) AS keseluruhan
                        ")
                    ->leftJoin('ms_admin as adm', function($q) {
                        $q->on('id_contact', '=', 'id_admin')
                            ->where('adm.level', '=', 'broker');
                    })
                    ->leftJoin('tr_sppa_log as lg', function($q) use ($bulannya) {
                        $q->on('adm.username', '=', 'lg.createby')
                            ->whereRaw("LEFT(lg.createdt, 7) = '$bulannya'",)
                            ->whereIn('lg.status', [10, 12, 13, 20, 7, 71, 72, 8, 81, 82, 90, 91, 92, 93, 94, 95]);
                    })
                    ->where('dashboard', 1)
                    ->whereNotNull('username')
                    ->groupBy('id_admin');
                $response['dashboard_broker'] = $dashboard_broker->get();
                $response['total'] = 0;
                foreach($response['dashboard_broker'] as $dbro) {
                    $response['total'] += $dbro->keseluruhan;
                }
                // echo "total " . $total;
                // dd($response);
                // dd($dashboard_broker->get());
                break;
            default:
                break;
        }
        if ($kontak) {
            $response['kontak'] = DB::table('ms_contact as cnt')
                ->leftJoin('ms_admin as adm', 'cnt.id_contact','=', 'adm.id_admin')
                ->where('cnt.kontak',1)
                ->get();
        }
        $aRange = "";
        $bRange = "";
        $custGroup="";
        $custOrder="";
        $custSelect="";
        $sqlPengajuan = "SELECT ".$custSelect."
            COUNT(`regid`)                        pengajuan,
            SUM(IF(`policyno` IS NOT NULL, 1, 0)) sertifikat,
            SUM(IF(`status` = 12, 1, 0))          reject
            FROM    `tr_sppa` t
            WHERE `createdt` BETWEEN '".$aRange."' AND '".$bRange."'
            ".$custGroup.$custOrder." ";
        $pengajuan = DB::select($sqlPengajuan);
        
        $sqlPremi = "SELECT CONCAT (str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W'), ' s/d ', str_to_date(concat(yearweek(p.`paiddt`, 2),' Sunday'), '%X%V %W') + interval 6 day ) grup,  Sum(`premi`) premi, sum(`up`) up
        FROM        `tr_sppa` t
        INNER JOIN  `tr_sppa_paid` p ON p.`regid` = t.`regid`
        WHERE  `status` >= 5
        AND `status` NOT IN ( 10, 11, 12, 13 )
        AND p.`paiddt`";
        
        $premi = DB::select($sqlPremi);
        
        // dd($premi);
        
        $response['dashboard'] = $dashboard->first();
        // dd(DB::getQueryLog());
        // dd($dpending);
        // $pending    = $dpending[0]->pending;
		// $verif      = $dverif[0]->verif;
		// $valid      = $dvalid[0]->valid;
		// $realisasi  = $drealisasi[0]->realisasi;
        // dd($data);
        // return view('index', compact('jkel','jumlah_pengajuan','pending','verif','valid','realisasi'));
        return view('index', $response);
    }
    public function notification() {
        $vlevel = session('level');
        $userid = session('username');
        $notif = DB::select("SELECT * FROM tbl_push_notif WHERE IF(level='ALL', username='$userid', level='$vlevel' OR IF(username='ALL',level='$vlevel',username='$userid'))");
        // dump($notif);
        return view('notification', compact('notif'));
    }
    public function maintenance() {
        return view('maintenance');
    }
}
