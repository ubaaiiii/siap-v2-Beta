<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Functions
{
  function formatBytes($bytes, $precision = 2)
  {
    $base = log($bytes, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
  }

  function test()
  {

    // mkdir("../../../httpdocs/adm/laporan/claim/form");
    // $dirs = array_filter(glob('../*'), 'is_dir');
    // print_r($dirs);
    // $myfile = fopen("../httpdocs/adm/newfile.txt", "w") or die("Unable to open file!");
    // $txt    = "John Doe\n";
    // fwrite($myfile, $txt);
    // $txt    = "Jane Doe\n";
    // fwrite($myfile, $txt);
    // fclose($myfile);
    // die;
    // DB::enableQueryLog();
    // $data = DB::select("SELECT * FROM tr_sppa sp
    //                     INNER JOIN tr_sppa_paid pd ON pd.regid = sp.regid AND paidtype = 'PREMI' WHERE tpremi <> paidamt");
    // $sql = "SELECT ms_admin.*,
    //             cb.msdesc as nm_cabang,
    //             mtr.msdesc as nm_mitra,
    //             asr.nmasuransi as nm_asuransi
    //         FROM ms_admin
    //         LEFT JOIN ms_master as cb ON cb.msid = ms_admin.cabang AND cb.mstype = 'cab'
    //         LEFT JOIN ms_insurance as asr ON asr.asuransi = ms_admin.cabang
    //         LEFT JOIN ms_master as mtr ON mtr.msid = ms_admin.mitra AND mtr.mstype = 'mitra'";

    // $sql = "SELECT * FROM tr_sppa WHERE epremi <> 0 AND status IN (8, 81, 82)";
    // $sql = "SELECT * FROM tr_sppa_cancel WHERE regid = 212305115895";

    $sql = "SELECT * FROM ms_insurance";
    $data = DB::select($sql);
    // $data = DB::statement("SHOW TABLE STATUS where name like 'download'");
    return json_encode($data);
    // return DB::table('tr_sppa')->paginate(10);
    // die;
    // dd($data);
    try {

      // $data = DB::table('tr_sppa')->whereRaw("produk in ('?','?)'",["MP01"])->get();
      // DB::transaction(function () {

      // ------ Tambah kuota tiap bulan ------
      // DB::unprepared(DB::raw("INSERT INTO `ms_kuota` (`asuransi`, `kuota`, `startdt`, `enddt`) VALUES ('hsi', '250000000000', '2023-08-01', '2023-08-31') "));
      // DB::unprepared(DB::raw("INSERT INTO `ms_kuota` (`asuransi`, `kuota`, `startdt`, `enddt`) VALUES ('sit', '250000000000', '2023-08-01', '2023-08-31') "));
      // DB::unprepared(DB::raw("INSERT INTO `ms_kuota` (`asuransi`, `kuota`, `startdt`, `enddt`) VALUES ('abb', '250000000000', '2023-08-01', '2023-08-31') "));
      // ------------- End Kuota -------------

      // Tambah Asuransi
      // DB::unprepared(DB::raw("INSERT INTO `ms_master` (`msid`, `msdesc`, `mstype`, `createby`, `createdt`, `editby`, `editdt`) VALUES ('TSP', 'TASPEN LIFE', 'ASURANSI', NULL, NULL, NULL, NULL); "));

      // DB::unprepared(DB::raw("UPDATE tr_sppa set asuransi = 'TSP' WHERE regid=212307119691 "));
      // DB::unprepared(DB::raw("UPDATE tr_sppa SET tempat_lahir = \"TO'LAMBA SALUPUTTI\" WHERE regid = 212305116291"));
      // DB::unprepared(DB::raw("UPDATE `ms_admin` SET `password` = REPLACE(`password`, '-nonaktif', '')  WHERE `username` = 'CHKSPBOG27'"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa_paid pd
      //                         INNER JOIN tr_sppa sp ON pd.regid = sp.regid AND paidtype = 'PREMI'
      //                         SET paidamt = tpremi
      //                         WHERE tpremi <> paidamt"));
      // DB::unprepared(DB::raw("UPDATE tr_sppa_cancel SET refund=3435789 WHERE regid=212212106338"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa SET tmt_pensiun='2023-12-01' WHERE regid IN (212307119758)"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa SET status = 1 WHERE regid IN (212307119870)"));

      // DB::unprepared(DB::raw("UPDATE tr_billing SET totalamt=-10512500, grossamt=-9787500, discamt=-725000 WHERE billno='202308127784' "));
      // DB::unprepared(DB::raw("UPDATE tr_sppa_cancel SET refund=10512500 WHERE regid='212306117299' "));

      // DB::unprepared(DB::raw("UPDATE tr_sppa SET status = 90 WHERE regid='212111081384'"));
      // DB::unprepared(DB::raw("UPDATE tr_claim SET statclaim = 90 WHERE regid='212111081384'"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa SET status = 1 WHERE regid IN (212308120834)"));
      // DB::unprepared(DB::raw("DELETE FROM tr_sppa_log WHERE regid IN (212308120834) AND createdt IN ('2023-08-14 10:36:35', '2023-08-14 10:28:09')"));

      // DB::unprepared(DB::raw("ALTER TABLE tr_sppa CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8_general_ci;"));
      // DB::unprepared(DB::raw("SHOW TABLE STATUS where name like 'tr_sppa'"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa_log SET createdt='2023-07-18 17:42:01' WHERE regid='212212106342' AND status = 95 AND createdt='2023-07-31 14:31:26' "));

      // update rate
      // DB::unprepared(DB::raw("UPDATE tr_rates
      //                         SET `rates` = 0.45 * `insperiodyy`
      //                         WHERE produk = 'PR01'
      //                             AND umurb = 40
      //                             AND umura = 55;"));
      // DB::unprepared(DB::raw("UPDATE tr_rates
      //                         SET `rates` = 0.45 * `insperiodyy`
      //                         WHERE produk = 'PN01'
      //                             AND umurb = 21
      //                             AND umura = 55;"));
      // DB::unprepared(DB::raw("UPDATE tr_term SET maxup = 150000000 WHERE produk='PR02'"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa_log SET createby='BULAN33863' WHERE regid=212305115215 AND createdt='2023-07-11 08:52:26'"));

      // DB::unprepared(DB::raw("UPDATE tr_sppa SET status=96 WHERE regid IN (211908015159, 212305115215, 211908015161, 212003054645, 211908009616)"));
      // DB::unprepared(DB::raw("DELETE FROM tr_sppa_log WHERE regid in (211908009616) AND status IN (94) AND createdt='2023-07-27 16:56:58'"));

      // update tr_limit
      // DB::unprepared(DB::raw("UPDATE tr_limit SET flag=0 WHERE asuransi IN ('ETI', 'MPM', 'TKP')"));

      // update tr_rates
      // DB::unprepared(DB::raw("UPDATE tr_rates SET rates=0.45*insperiodyy, umura=55, editdt=NOW() WHERE produk='MP01' AND umurb=45 "));
      // DB::unprepared(DB::raw("UPDATE tr_rates SET rates=1.05*insperiodyy, umurb=61, umura=65, editdt=NOW() WHERE produk='MP01' AND umurb=56 "));
      // DB::unprepared(DB::raw("UPDATE tr_rates SET rates=0.85*insperiodyy, umurb=56, umura=60, editdt=NOW() WHERE produk='MP01' AND umurb=51 "));

      // });
      $result = "success";

      DB::commit();
    } catch (\Exception $e) {
      $data   = null;
      $result = $e;
      DB::rollback();
      //do something with $e->getMessage();
    }

    return response()->json(
      [
        'query'   => DB::getQueryLog(),
        // 'data'    => $data,
        'result'  => $result,
      ]
    );
  }

  function upload(Request $request)
  {
    $ds          = DIRECTORY_SEPARATOR;  //1

    $storeFolder = "../../../httpdocs/" . $request->url;   //2

    if (!empty($_FILES)) {

      $tempFile = $_FILES['file']['tmp_name'];          //3

      $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4

      $targetFile =  $targetPath . $_FILES['file']['name'];  //5

      move_uploaded_file($tempFile, $targetFile); //6

    }
  }
}
