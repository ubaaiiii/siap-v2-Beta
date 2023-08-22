<?php
namespace App\Http\Controllers\Modul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
class LaporanController extends Controller
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
        // dd(Session::get('login')[0]->id_member);
        // $data = DB::select("SELECT * FROM md_product LEFT JOIN md_brand ON md_product.id_brand=md_brand.id_brand LEFT JOIN md_category ON md_product.id_category=md_category.id_category LEFT JOIN md_category_tokopedia ON md_product.id_category_tokopedia=md_category_tokopedia.id_category_tokopedia LEFT JOIN md_category_shopee ON md_product.id_category_shopee=md_category_shopee.id_category_shopee");
        $vlevel = Session::get('login')[0]->level;
        $userid = Session::get('login')[0]->id_peg;
        $mitra = Session::get('login')[0]->mitra;
        $cabang = DB::select("select cabang from ms_admin where id_peg='$userid'");
        $ucab = $cabang[0]->cabang;

        $produk = DB::select("SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='produk' order by msdesc ");
        $sqlc = "SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='cab' ";
        if ($vlevel == "mkt" or $vlevel == "smkt") {
        $sqlc = $sqlc . " and msid='$ucab'  ";
        }
        $sqlc = $sqlc . "  order by msdesc  ";
        $sel_cabang = DB::select($sqlc);

        $sqlc = "SELECT msid scode ,msdesc sdesc FROM ms_master where mstype='asuransi' ";
       //  if ($vlevel == "insurance") {
       //  $sqlc = $sqlc . " and msid='$ucab'  ";
       //  }
        $sqlc = $sqlc . "  order by msdesc  ";
        $asuransi = DB::select($sqlc);
       //  dd($asuransi);

        $sqlp = "SELECT repid scode ,repname sdesc FROM ms_report where repid<>''  ";
        if ($vlevel == "mkt" or $vlevel == "smkt") {
        $sqlp = $sqlp . " and cat='siap'  ";
        }
        //if ($vlevel=="checker" or $vlevel=="checker" )
        if ($vlevel == "checker" or $vlevel == "schecker") {
        $sqlp = $sqlp . " and cat='siap'  ";
        }
        if ($vlevel == "insurance") {
        $sqlp = $sqlp . " and cat='siapin'  ";
        }
        if ($vlevel == "broker") {
        $sqlp = $sqlp . " and cat='siap'  ";
        }
        $sqlp = $sqlp . "  order by repid  ";
        $report = DB::select($sqlp);
        $data = [
            'judul' => 'Laporan',
        ];
        return view('master.laporan.index', compact('data','report','asuransi','sel_cabang','produk','ucab','vlevel','userid'));
    }

    public function cetak(Request $request)
    {
      $tgl1 = $request->tgl1;
      $tgl2 = $request->tgl2;
      $sfilter1 = $request->sfilter1;
      $sfilter2 = $request->sfilter2;
      $sfilter3 = $request->sfilter3;
      $slvl = $request->slvl;
      $suid = $request->suid;
      $scab = $request->scab;
      $sreport = $request->treport;
      $exdate     = date("YmdHis");
      $stitle ="";
      // $stfile = $request->tipeekstensi;
        if ($sreport == 'siap1') {
              $file_name  = "lappending" . $exdate;
              $stitle     = "Laporan Data Pending";
              $sql = "SELECT f.msdesc Produk,Concat('`', a.regid) 'No_Register',a.nopeserta 'No_Pinjaman',a.nama Nama,Concat('`', a.noktp) 'No_KTP',jkel Jkel,If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan, b.msdesc Cabang,tgllahir 'Tgl_Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama_AO',
                       i.username                                'Username_AO',
                       a.createdt                                'Tgl_Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '0', '1' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " AND a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " AND a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " AND a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap2' or $sreport == 'siapin07') {
              $stitle = "Laporan Data Cek Foto";
              $file_name = "lapcekfoto" . $exdate;
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama_AO',
                       i.username                                'Username_AO',
                       a.createdt                                'Tgl_Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '11' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap3') {
              $stitle = "Laporan Data Active";
              $file_name = "lapactive" . $exdate;
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama_AO',
                       i.username                                'Username_AO',
                       a.createdt                                'Tgl_Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '2' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang =  '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap4') {
              $stitle = "Laporan Data Realisasi ";
              $file_name = "lapreal" . $exdate;
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama_AO',
                       i.username                                'Username_AO',
                       a.createdt                                'Tgl_Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '3' )
                       AND LEFT(a.mulai, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang =  '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap5') {
              $stitle = "Laporan Data Verifikasi ";
              $file_name = "lapverif" . $exdate;
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       akhir                                     Akhir,
                       masa                                      Masa,
                       a.tunggakan                               Graceperiod,
                       a.up,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama_AO',
                       i.username                                'Username_AO',
                       a.createdt                                'Tgl_Input'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '4' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap6' or $sreport == 'siapck6'  or $sreport == 'siapin6' or $sreport == 'siapin01') {
              $stitle = "Laporan Data Validasi ";
              $file_name = "lapvalid" . $exdate;
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(h.msdesc IS NULL, pekerjaan, h.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       a.akhir                                   Akhir,
                       a.masa                                    Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       i.nama                                    'Nama_AO',
                       i.username                                'Username_AO',
                       a.createdt                                'Tgl_Input',
                       Concat('`', a.policyno)                   'No Sertifikat',
                       a.validdt                                 'Tgl Validasi'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                       LEFT JOIN ms_admin i
                              ON a.createby = i.username
                WHERE  a.status IN ( '5' )
                       AND LEFT(a.validdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang =  '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap7' or $sreport == 'siapck7' or $sreport == 'siapmk7' or $sreport == 'siapin05') {
              $file_name = "lapbatal" . $exdate;
              $stitle = "Laporan Data Pembatalan";
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(i.msdesc IS NULL, pekerjaan, i.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       a.akhir                                   Akhir,
                       a.masa                                    Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  Status,
                       j.nama                                    'Nama_AO',
                       j.username                                'Username_AO',
                       d.paiddt                                  'Tgl Bayar',
                       a.createdt                                'Tgl_Input',
                       a.validdt                                 'Tgl Validasi',
                       Concat('`', a.policyno)                   'No Sertifikat',
                       h.tglbatal                                'Tgl Batal'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'PREMI'
                       LEFT JOIN tr_sppa_cancel h
                              ON a.regid = h.regid
                       LEFT JOIN ms_master i
                              ON a.pekerjaan = i.msid
                                 AND i.mstype = 'KERJA'
                       LEFT JOIN ms_admin j
                              ON a.createby = j.username
                WHERE  a.status IN ( '7', '71', '72', '73' )
                       AND LEFT(h.tglbatal, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk='$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang='$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap8' or $sreport == 'siapck8' or $sreport == 'siapin04') {
              $file_name = "laprefund" . $exdate;
              $stitle = "Laporan Data Refund";
              $sql = "SELECT f.msdesc                                  Produk,
                       Concat('`', a.regid)                      'No_Register',
                       a.nopeserta                               'No_Pinjaman',
                       a.nama                                    Nama,
                       Concat('`', a.noktp)                      'No_KTP',
                       jkel                                      Jkel,
                       If(i.msdesc IS NULL, pekerjaan, i.msdesc) Pekerjaan,
                       b.msdesc                                  Cabang,
                       tgllahir                                  'Tgl_Lahir',
                       mulai                                     Mulai,
                       a.akhir                                   Akhir,
                       a.masa                                    Masa,
                       a.tunggakan                               Graceperiod,
                       up                                        UP,
                       tpremi                                    Premi,
                       g.msdesc                                  Asuransi,
                       c.msdesc                                  'Status',
                       j.nama                                    'Nama_AO',
                       j.username                                'Username_AO',
                       a.createdt                                'Tgl_Input',
                       a.validdt                                 'Tgl Validasi',
                       Concat('`', a.policyno)                   'No Sertifikat',
                       e.paiddt                                  'Tgl Bayar Premi',
                       e.paidamt                                 'Jml Bayar Premi',
                       h.tglbatal                                'Tgl Batal',
                       h.sisa                                    'Sisa',
                       d.paiddt                                  'Tgl Refund Dibayar',
                       IF(a.status < 83,null,h.refund)           'Jml Refund Dibayar'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'REFUND'
                       LEFT JOIN tr_sppa_paid e
                              ON e.regid = a.regid
                                 AND e.paidtype = 'premi'
                       LEFT JOIN tr_sppa_cancel h
                              ON a.regid = h.regid
                       LEFT JOIN ms_master i
                              ON a.pekerjaan = i.msid
                                 AND i.mstype = 'KERJA'
                       LEFT JOIN ms_admin j
                              ON a.createby = j.username
                WHERE  a.status IN ( '8', '81', '82', '83', '84', '85' )
                       AND LEFT(h.tglbatal, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk='$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang='$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap9' or $sreport == 'siapck9'  or $sreport == 'siapin9') {
              $file_name = "lapclaim" . $exdate;
              $stitle = "Laporan Data Claim";
              $sql = "SELECT
                    prd.msdesc                                      AS 'Produk',
                    Concat('`', cl.regid)                           AS 'No_Register',
                    Concat('`', sp.policyno)                        AS 'No Sertifikat',
                    nopeserta                                       AS 'No_Pinjaman',
                    sp.nama                                         AS 'Nama',
                    jkel                                            AS 'Jkel',
                    kj.msdesc                                       AS 'Pekerjaan',
                    cb.msdesc                                       AS 'Cabang',
                    tgllahir                                        AS 'Tgl_Lahir',
                    mulai                                           AS 'Mulai',
                    Concat('`', noktp)                              AS 'No_KTP',
                    akhir                                           AS 'Akhir',
                    masa                                            AS 'Masa',
                    tunggakan                                       AS 'Graceperiod',
                    up                                              AS 'UP',
                    tpremi                                          AS 'Premi',
                    ins.msdesc                                      AS 'Asuransi',
                    st.msdesc                                       AS 'Status',
                    ad.nama                                         AS 'Nama_AO',
                    ad.username                                     AS 'Username_AO',
                    DATE_FORMAT(sp.createdt,'%Y-%m-%d')             AS 'Tgl_Input',
                    pd.paiddt                                       AS 'Tgl Bayar Premi',
                    pd.paidamt                                      AS 'Jml Bayar Premi',
                    Concat('`', regclaim)                           AS 'No Claim',
                    tglkejadian                                     AS 'Tgl Kejadian',
                    tgllapor                                        AS 'Tgl Lapor Claim',
                    DATE_FORMAT(cl.createdt,'%Y-%m-%d')             AS 'Tgl_Input Claim',
                    nilaios                                         AS 'Nilai OS',
                    DATE_ADD(tglkejadian,INTERVAL (wkc.msdesc + wkc.createby) DAY) AS 'Tgl Jatuh Tempo',
                    DATE_FORMAT(sp.validdt,'%Y-%m-%d')              AS 'Tgl Validasi',
                    DATE_FORMAT(cl.validdt,'%Y-%m-%d')              AS 'Tgl Valid Claim',
                    DATE_FORMAT(lg.createdt,'%Y-%m-%d')             AS 'Tgl Reject Claim',
                    rj.msdesc                                       AS 'Alasan Reject',
                    cl.comment                                      AS 'Keterangan',
                    lgd.createdt                                    AS 'Tgl Terima Dokumen',
                    pdc.paiddt                                      AS 'Tgl Bayar Claim',
                    pdc.paidamt                                     AS 'Jml Bayar Claim',
                    IF (dok.hasil IS NULL,
                        'Lengkap',
                        'Belum Lengkap')                            AS 'Status Dokumen',
                    kurang.kelengkapan                              AS 'Kekurangan'
                FROM tr_claim cl
                INNER JOIN (select * from tr_sppa where  status IN ( '90', '91', '92', '93', '94', '95', '96' ) ) sp
                    ON cl.regid = sp.regid
                LEFT JOIN (select regid,paiddt,paidamt from tr_sppa_paid where paidtype='PREMI') pd
                    ON cl.regid = pd.regid
                LEFT JOIN (select regid,paiddt,paidamt from tr_sppa_paid where paidtype='CLAIM') pdc
                    ON cl.regid = pdc.regid
                LEFT JOIN (select regid,createdt from tr_sppa_log where status=94) lg
                    ON cl.regid = lg.regid
                LEFT JOIN (select regid,createdt from tr_sppa_log where status=96) lgd
                    ON cl.regid = lgd.regid
                LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype='PRODUK') prd
                    ON prd.msid = sp.produk
                LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype='KERJA') kj
                    ON kj.msid = sp.pekerjaan
                LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype='CAB') cb
                    ON cb.msid = sp.cabang
                LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype='ASURANSI') ins
                    ON ins.msid = sp.asuransi
                LEFT JOIN (SELECT msid, msdesc FROM ms_master WHERE mstype='STREQ') st
                    ON st.msid = sp.status
                LEFT JOIN (SELECT msid, msdesc, createby FROM ms_master WHERE mstype='WKTCLM') wkc
                    ON wkc.msid = concat(asuransi,produk)
                LEFT JOIN  (SELECT msid, msdesc FROM ms_master WHERE mstype = 'REJECTTYPE') rj
                    ON rj.msid = cl.detail
                LEFT JOIN ms_admin ad
                    ON ad.username = sp.createby
                LEFT JOIN ( SELECT
                                a.regid,
                                GROUP_CONCAT(DISTINCT IF (b.editby = 'wajib' AND c.jnsdoc IS NULL,
                                    'Dokumen Belum Lengkap',
                                    null) SEPARATOR ', ') hasil
                            FROM tr_claim a
                                INNER JOIN ms_master b
                                          ON b.mstype = a.doctype
                                             AND b.editby = 'wajib'
                                LEFT JOIN tr_document c
                                          ON c.regid = a.regid
                                             AND c.jnsdoc = b.msid
                            WHERE b.createby IS NULL
                                AND c.jnsdoc IS NULL
                            GROUP BY regid) dok
                ON dok.regid = cl.regid
                LEFT JOIN ( SELECT
                                a.regid,
                                GROUP_CONCAT(trim(msdesc) SEPARATOR ', ') kelengkapan
                            FROM tr_claim a
                            INNER JOIN ms_master b
                                ON a.doctype = b.mstype
                            LEFT JOIN tr_document c
                                ON c.regid = a.regid
                                AND c.jnsdoc = b.msid
                            WHERE b.editby = 'wajib' and c.jnsdoc is null
                            GROUP BY a.regid) kurang
                    ON kurang.regid = cl.regid
                WHERE LEFT(cl.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " AND  sp.produk='$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " AND  sp.cabang='$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " AND  sp.asuransi =  '$sfilter3'";
              }
              //        echo $sql;die;
       }
       if ($sreport == 'siap10' or $sreport == 'siapck10') {
              $file_name = "lapbayar" . $exdate;
              $stitle = "Laporan Data Produksi Dibayar";
              $sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No_Register',
                       a.nopeserta             'No_Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No_KTP',
                       jkel                    Jkel,
                       pekerjaan               Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl_Lahir',
                       mulai                   Mulai,
                       akhir                   Akhir,
                       masa                    Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       d.paiddt                'Tgl Bayar',
                       d.paidamt               'Jml Bayar',
                       a.createdt              'Tgl_Input',
                       Concat('`', a.policyno) 'No Sertifikat',
                       h.msdesc                Mitra
                FROM   tr_sppa a
                       INNER JOIN ms_master b
                               ON a.cabang = b.msid
                                  AND b.mstype = 'cab'
                       INNER JOIN ms_master c
                               ON a.status = c.msid
                                  AND c.mstype = 'streq'
                       INNER JOIN tr_sppa_paid d
                               ON d.regid = a.regid
                                  AND d.paidtype = 'PREMI'
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       INNER JOIN ms_master g
                               ON a.asuransi = g.msid
                                  AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.mitra = h.msid
                                 AND h.mstype = 'mitra'
                WHERE  a.status = '20'
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap11' or $sreport == 'siapck11' or $sreport == 'siapin11' or $sreport == 'siapin02') {
              $stitle = "Laporan Data Outstanding ";
              $file_name = "lapdataos" . $exdate;
              $sql = " SELECT f.msdesc             Produk,
                       Concat('`', a.regid) 'No_Register',
                       a.nopeserta          'No_Pinjaman',
                       a.nama               Nama,
                       Concat('`', a.noktp) 'No_KTP',
                       jkel                 Jkel,
                       d.msdesc             Pekerjaan,
                       b.msdesc             Cabang,
                       tgllahir             'Tgl_Lahir',
                       mulai                Mulai,
                       akhir                Akhir,
                       masa                 Masa,
                       a.tunggakan          Graceperiod,
                       up                   UP,
                       tpremi               Premi,
                       g.msdesc             Asuransi,
                       c.msdesc             Status,
                       e.nama               'Nama_AO',
                       e.username           'Username_AO',
                       a.createdt           'Tgl_Input',
                       a.policyno           'No Sertifikat'
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master d
                              ON a.pekerjaan = d.msid
                                 AND d.mstype = 'KERJA'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                WHERE  a.status IN ( 2, 3, 4, 5 )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }

       if ($sreport == 'siap12' or $sreport == 'siapck12' or $sreport == 'siapin12'  or $sreport == 'siapmk12') {
              $file_name = "lapbayar" . $exdate;
              $stitle = "Laporan Data Pembayaran";

              $sql = "SELECT f.msdesc                Produk,
              Concat('`', a.regid)    'No Register',
              a.nopeserta             'No Pinjaman',
              a.nama                  Nama,
              Concat('`', a.noktp)    'No KTP',
              jkel                    Jkel,
              i.msdesc                Pekerjaan,
              b.msdesc                Cabang,
              tgllahir                'Tgl Lahir',
              mulai                   Mulai,
              akhir                   Akhir,
              masa                    Masa,
              a.tunggakan             Graceperiod,
              up                      UP,
              premi                   Premi,
                             epremi				   'Extra Premi',
                             tpremi				   'Total Premi',
              g.msdesc                Asuransi,
              c.msdesc                Status,
              e.nama                  'Nama AO',
              e.username              'Username AO',
              d.paiddt                'Tgl Bayar',
              d.paidamt               'Jml Bayar Premi',
              a.createdt              'Tgl Input',
              Concat('`', a.policyno) 'No Sertifikat',
              h.msdesc                mitra
       FROM   (select * from tr_sppa_paid WHERE LEFT(paiddt, 10)
                                          BETWEEN '$tgl1' AND '$tgl2' AND paidtype = 'PREMI') d
                                          INNER JOIN  tr_sppa a
                      ON d.regid = a.regid
              INNER JOIN ms_master b
                      ON a.cabang = b.msid
                         AND b.mstype = 'cab'
              INNER JOIN ms_master c
                      ON a.status = c.msid
                         AND c.mstype = 'streq'

              LEFT JOIN ms_admin e
                     ON a.createby = e.username
              INNER JOIN ms_master f
                      ON a.produk = f.msid
                         AND f.mstype = 'produk'
              INNER JOIN ms_master g
                      ON a.asuransi = g.msid
                         AND g.mstype = 'asuransi'
              LEFT JOIN ms_master h
                     ON a.mitra = h.msid
                        AND h.mstype = 'mitra'
              LEFT JOIN ms_master i
                     ON a.pekerjaan = i.msid
                        AND i.mstype = 'KERJA'
              WHERE 1";
              // $export = DB::select($sql);
              // dd($export);
              // dd("sini");
              // $file_name = "lapbayar" . $exdate;
              // $stitle = "Laporan Data Pembayaran";
              // $sql = "SELECT f.msdesc          Produk,
              //          Concat('`', a.regid)    'No_Register',
              //          a.nopeserta             'No_Pinjaman',
              //          a.nama                  Nama,
              //          Concat('`', a.noktp)    'No_KTP',
              //          jkel                    Jkel,
              //          i.msdesc                Pekerjaan,
              //          b.msdesc                Cabang,
              //          tgllahir                'Tgl_Lahir',
              //          mulai                   Mulai,
              //          akhir                   Akhir,
              //          masa                    Masa,
              //          a.tunggakan             Graceperiod,
              //          up                      UP,
              //          tpremi                  Premi,
              //          g.msdesc                Asuransi,
              //          c.msdesc                Status,
              //          e.nama                  'Nama_AO',
              //          e.username              'Username_AO',
              //          d.paiddt                'Tgl Bayar',
              //          d.paidamt               'Jml Bayar Premi',
              //          a.createdt              'Tgl_Input',
              //          Concat('`', a.policyno) 'No Sertifikat',
              //          h.msdesc                mitra
              //   FROM   tr_sppa a
              //          INNER JOIN ms_master b
              //                  ON a.cabang = b.msid
              //                     AND b.mstype = 'cab'
              //          INNER JOIN ms_master c
              //                  ON a.status = c.msid
              //                     AND c.mstype = 'streq'
              //          INNER JOIN (select * from tr_sppa_paid WHERE LEFT(paiddt, 10) BETWEEN '$tgl1' AND '$tgl2' AND paidtype = 'PREMI') d
              //                  ON d.regid = a.regid
              //          LEFT JOIN ms_admin e
              //                 ON a.createby = e.username
              //          INNER JOIN ms_master f
              //                  ON a.produk = f.msid
              //                     AND f.mstype = 'produk'
              //          INNER JOIN ms_master g
              //                  ON a.asuransi = g.msid
              //                     AND g.mstype = 'asuransi'
              //          LEFT JOIN ms_master h
              //                 ON a.mitra = h.msid
              //                    AND h.mstype = 'mitra'
              //          LEFT JOIN ms_master i
              //                 ON a.pekerjaan = i.msid
              //                    AND i.mstype = 'KERJA'
              //   WHERE 1 ";
              if ($sfilter1 != 'ALL') {
                     $sql .= " AND  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " AND  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " AND  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap13' or $sreport == 'siapck13' or $sreport == 'siapin09') {
              $file_name = "lapallstatus" . $exdate;
              $stitle = "Laporan Data produksi All Status";
              $sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No_Register',
                       a.nopeserta             'No_Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No_KTP',
                       jkel                    Jkel,
                       h.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl_Lahir',
                       mulai                   Mulai,
                       akhir                   Akhir,
                       masa                    Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       e.nama                  'Nama_AO',
                       e.username              'Username_AO',
                       d.paiddt                'Tgl Bayar Premi',
                       d.paidamt               'Jml Bayar Premi',
                       a.createdt              'Tgl_Input',
                       Concat('`', a.policyno) 'No Sertifikat',
                       IF (status < 20 AND status <> 12,
                          IF (validdt IS NOT NULL,
                              IF (Datediff(Curdate(), validdt) > 90,
                              'Pengajuan Expired (sudah valid)',
                              Date_add(validdt, INTERVAL 90 day)),
                              IF (Datediff(Curdate(), a.createdt) > 90,
                              'Pengajuan Expired',
                              Date_add(a.createdt, INTERVAL 90 day))),
                          NULL) 'Tgl Pengajuan Expired'
                FROM   tr_sppa a
                       INNER JOIN ms_master b
                               ON a.cabang = b.msid
                                  AND b.mstype = 'cab'
                       INNER JOIN ms_master c
                               ON a.status = c.msid
                                  AND c.mstype = 'streq'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'PREMI'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       INNER JOIN ms_master f
                               ON a.produk = f.msid
                                  AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                WHERE  LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap14' or  $sreport == 'siapck14' or  $sreport == 'siapin14') {
              $file_name = "lapreject" . $exdate;
              $stitle = "Laporan Data Reject";
              $sql = "SELECT f.msdesc             Produk,
                       Concat('`', a.regid) 'No_Register',
                       a.nama               Nama,
                       Concat('`', a.noktp) 'No_KTP',
                       jkel                 Jkel,
                       d.msdesc             Pekerjaan,
                       b.msdesc             Cabang,
                       tgllahir             'Tgl_Lahir',
                       mulai                Mulai,
                       akhir                Akhir,
                       masa                 Masa,
                       a.tunggakan          Graceperiod,
                       up                   UP,
                       tpremi               Premi,
                       g.msdesc             Asuransi,
                       c.msdesc             Status,
                       e.nama               'Nama_AO',
                       e.username           'Username_AO',
                       a.createdt           'Tgl_Input',
                       a.nopeserta          'No_Pinjaman',
                       Replace(Replace(Replace(Concat(h.comment, ' ', a.comment), '\n', ''),
                               '\t', ''),
                       '\r', '')            Ket
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN ms_master d
                              ON a.pekerjaan = d.msid
                                 AND d.mstype = 'KERJA'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN tr_sppa_log h
                              ON a.regid = h.regid
                                 AND h.status = '12'
                WHERE  a.status IN ( '12' )
                       AND LEFT(a.createdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang = '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       if ($sreport == 'siap15' or $sreport == 'siapck15') {
              $stitle = "Laporan Data Peuntupan ";
              $file_name = "laptutup" . $exdate;
              $sql = "SELECT f.msdesc                Produk,
                       Concat('`', a.regid)    'No_Register',
                       a.nopeserta             'No_Pinjaman',
                       a.nama                  Nama,
                       Concat('`', a.noktp)    'No_KTP',
                       jkel                    Jkel,
                       h.msdesc                Pekerjaan,
                       b.msdesc                Cabang,
                       tgllahir                'Tgl_Lahir',
                       mulai                   Mulai,
                       a.akhir                 Akhir,
                       a.masa                  Masa,
                       a.tunggakan             Graceperiod,
                       up                      UP,
                       tpremi                  Premi,
                       g.msdesc                Asuransi,
                       c.msdesc                Status,
                       e.nama                  'Nama_AO',
                       e.username              'Username_AO',
                       a.createdt              'Tgl_Input',
                       Concat('`', a.policyno) 'No Sertifikat',
                       a.validdt               'Tgl Validasi',
                       d.paiddt                'Tgl Bayar',
                       d.paidamt               Jmlbayar
                FROM   tr_sppa a
                       LEFT JOIN ms_master b
                              ON a.cabang = b.msid
                                 AND b.mstype = 'cab'
                       LEFT JOIN ms_master c
                              ON a.status = c.msid
                                 AND c.mstype = 'streq'
                       LEFT JOIN tr_sppa_paid d
                              ON d.regid = a.regid
                                 AND d.paidtype = 'premi'
                       LEFT JOIN ms_admin e
                              ON a.createby = e.username
                       LEFT JOIN ms_master f
                              ON a.produk = f.msid
                                 AND f.mstype = 'produk'
                       LEFT JOIN ms_master g
                              ON a.asuransi = g.msid
                                 AND g.mstype = 'asuransi'
                       LEFT JOIN ms_master h
                              ON a.pekerjaan = h.msid
                                 AND h.mstype = 'KERJA'
                WHERE  a.status IN ( '5', '20' )
                       AND LEFT(a.validdt, 10) BETWEEN '$tgl1' AND '$tgl2'";
              if ($sfilter1 != 'ALL') {
                     $sql .= " and  a.produk = '$sfilter1' ";
              }
              if ($sfilter2 != 'ALL') {
                     $sql .= " and  a.cabang =  '$sfilter2'";
              }
              if ($sfilter3 != 'ALL') {
                     $sql .= " and  a.asuransi =  '$sfilter3'";
              }
       }
       //   echo $sql;
       //   echo $sreport;
       //   die;

       if ($slvl == "smkt") {
              $sql .= " and a.createby in ";
              $sql .= " (select  case when a.parent=a.username ";
              $sql .= " then a.parent else a.username end from ms_admin a ";
              $sql .= " where (a.username='$suid' or a.parent='$suid')) ";
       }
       if ($slvl == "mkt") {
              $sql .= " and a.createby in ";
              $sql .= " (select  case when a.parent=a.username ";
              $sql .= " then a.parent else a.username end from ms_admin a ";
              $sql .= " where (a.username='$suid' or a.parent='$suid')) ";
       }
       // // dd(Session::get('login')[0]);
       $mitra = (Session::get('login')[0]->mitra == NULL) ? ('NOM') : (Session::get('login')[0]->mitra);
       if ($mitra !== 'NOM') {
              $sql .= " AND h.msdesc = '$mitra' ";
       }
       // $sql .= " LIMIT 10 ";
       $export = DB::select($sql);
       // dd($export);
       $speriode   = "Periode ~ " . $tgl1 . ' s/d ' . $tgl2;
      $sqlc       = DB::select("SELECT msdesc scab FROM ms_master where mstype='cab' and  msid='$sfilter2' ");
       // dd($export);
      $cabang     = $sqlc[0]->scab;
      // $scabang    = "Cabang ~ " . $data['scab'];
      $sqlc       = DB::select("SELECT msdesc sprod  FROM ms_master where mstype='produk' and  msid='$sfilter1' ");
      $produk     = $sqlc[0]->sprod;
      // $sproduk    = "Produk ~" . $sqlc['sprod'];
      $sqlc       = DB::select("SELECT  msdesc sins FROM ms_master where mstype='asuransi'  and  msid='$sfilter3'  ");
      $asuransi   = $sqlc[0]->sins;
        // dd(Session::get('login')[0]->id_member);
        // $brand = DB::select("SELECT * FROM md_brand");
        // $category = DB::select("SELECT * FROM md_category");
        // $tokopedia = DB::select("SELECT * FROM md_category_tokopedia");
        // $shopee = DB::select("SELECT * FROM md_category_shopee");
        // return view('master.product.add', compact('brand','tokopedia','shopee','category'));
        return view('master.laporan.export', compact('export','cabang','produk','asuransi','tgl1','tgl2','stitle'));
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
