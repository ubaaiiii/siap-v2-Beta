<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use DataTables;
use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Jenssegers\Agent\Agent;
use Session;

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
    public function index()
    {
        // dd(Session::get('login')[0]->level);
        $jkel = ['Laki-laki','Perempuan'];
        $userid = Session::get('login')[0]->username;
        // $dataLaki = DB::select("SELECT sum(jkel='L') as Laki FROM tr_sppa ");
        $data = collect(DB::select("SELECT sum(jkel='P') as Perempuan,sum(jkel='L') as Laki FROM tr_sppa WHERE createby='$userid'"));
        $jumlah_pengajuan[] = $data[0]->Laki;
        $jumlah_pengajuan[] = $data[0]->Perempuan;
        $dpending = DB::select("SELECT count(1)  as pending FROM tr_sppa WHERE createby='$userid' and status in (0,51,1) ");
        $dverif = DB::select("SELECT count(1)  as verif FROM tr_sppa WHERE createby='$userid' and status in (11,4)");
        $dvalid = DB::select("SELECT count(1)  as valid FROM tr_sppa WHERE createby='$userid' and status in  (5,6) ");
        $drealisasi = DB::select("SELECT count(1)  as realisasi FROM tr_sppa WHERE createby='$userid' and status in (3,20) ");

 
        // dd($dpending);
        $pending = $dpending[0]->pending;
		$verif = $dverif[0]->verif;
		$valid = $dvalid[0]->valid;
		$realisasi = $drealisasi[0]->realisasi;
        // dd($data);
        return view('index', compact('jkel','jumlah_pengajuan','pending','verif','valid','realisasi'));
    }
}
