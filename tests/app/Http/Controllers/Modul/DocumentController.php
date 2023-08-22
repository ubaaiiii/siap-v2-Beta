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

class DocumentController extends Controller
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


    public function approve($id){
        $sregid = Crypt::decryptString($id);
        $sdate = date('Y-m-d H:i:s');
        $userid = Session::get('login')[0]->username; 
        // dd(DB::select("SELECT * FROM tr_sppa_log WHERE regid = '$sregid'"));

        // DB::select("UPDATE tr_sppa SET status = '1',editby = '$userid',editdt = '$sdate' WHERE regid = '$sregid' AND premi <> 0 AND masa <> 0 AND usia <> 0");
        DB::select("UPDATE tr_sppa SET status = '1',editby = '$userid',editdt = '$sdate' WHERE regid = '$sregid'");

        DB::select("INSERT INTO tr_sppa_log (regid, status, createby, createdt, comment) VALUES('$sregid','1','$userid','$sdate','approve by ao spv')");

 
        return redirect()->intended('pengajuan')->with('success', 'Data Berhasil disimpan');
    }

    public function log($id)
    {
        $regid = Crypt::decryptString($id);
        $data = DB::select("SELECT a.*  FROM tr_sppa a WHERE regid='$regid'");
        // $type = 'LTPGJ';

        // if ($type == 'LTPGJ') {
        //     $status = "NOT IN ( '7','71','72','73','8','81','82','83','84','85','90','91','92','93','94','95','96' )";
        // } elseif ($type == 'LTBTL') {
        //     $status = "IN ( '7','71','72','73' )";
        // } elseif ($type == 'LTRFN') {
        //     $status = "IN ( '8','81','82','83','84','85' )";
        // } elseif ($type == 'LTCLM') {
        //     $status = "IN ( '90','91','92','93','94','95','96' )";
        // } else {
        //     $status = "LIKE '%%'";
        // }
        
        // $sqll=" SELECT a.regid,a.status,a.comment,a.createdt,a.createby,b.msdesc statpol FROM tr_sppa_log a INNER JOIN ms_master b ON a.status=b.msid AND b.mstype='STREQ' WHERE a.regid='$regid' AND status $status ORDER BY a.createdt DESC ";
        $data2 = DB::select(" SELECT a.regid,a.status,a.comment,a.createdt,a.createby,b.msdesc statpol FROM tr_sppa_log a INNER JOIN ms_master b ON a.status=b.msid AND b.mstype='STREQ' WHERE a.regid='$regid' ORDER BY a.createdt DESC ");
        // dd($data2);
        return view('master.pengajuan.log', compact('data','data2'));
    }

    public function report($id)
    {
        // dd(Session::get('login')[0]->id_member);
        $regid = Crypt::decryptString($id);

        return view('master.pengajuan.report', compact('regid'));


    }

    public function reportlpfk($id)
    {
        // dd(Session::get('login')[0]->id_member);
        // $regid = Crypt::decryptString($id);
        $regid = "";

            $pdf = PDF::loadview('master.pengajuan.lpfk', compact('regid'));
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            return $pdf->stream('laporan-pegawai-pdf.pdf');
        
        return view('master.pengajuan.lpfk', compact('regid'));


    }
    public function reportskkt($id)
    {
        // dd(Session::get('login')[0]->id_member);
        // $regid = Crypt::decryptString($id);
        $regid = "";

            $pdf = PDF::loadview('master.pengajuan.skkt', compact('regid'));
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            return $pdf->stream('laporan-pegawai-pdf.pdf');
        
        return view('master.pengajuan.skkt', compact('regid'));


    }

    public function reportspa($id)
    {
        // dd(Session::get('login')[0]->id_member);
        // $regid = Crypt::decryptString($id);
        $regid = "";

            $pdf = PDF::loadview('master.pengajuan.spa', compact('regid'));
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            return $pdf->stream('laporan-pegawai-pdf.pdf');
        
        return view('master.pengajuan.spa', compact('regid'));


    }

    public function reportspkk($id)
    {
        // dd(Session::get('login')[0]->id_member);
        // $regid = Crypt::decryptString($id);
        $regid = "";

            $pdf = PDF::loadview('master.pengajuan.spkk', compact('regid'));
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            return $pdf->stream('laporan-pegawai-pdf.pdf');
        
        return view('master.pengajuan.spkk', compact('regid'));


    }

    public function reportspm($id)
    {
        // dd(Session::get('login')[0]->id_member);
        // $regid = Crypt::decryptString($id);
        $regid = "";

            $pdf = PDF::loadview('master.pengajuan.spm', compact('regid'));
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            return $pdf->stream('laporan-pegawai-pdf.pdf');
        
        return view('master.pengajuan.spm', compact('regid'));


    }

    public function doc($id,$type)
    {
        // dd(Session::get('login')[0]->id_member);
        $regid = Crypt::decryptString($id);
        $data = DB::select("SELECT a.*  FROM tr_sppa a WHERE regid='$regid'");
        // dd($data);
        $jenis = $type;
        $vlevel = Session::get('login')[0]->level;
        $custWhere = "";

        if ($jenis == 'DTCLM') {
            $custWhere = " WHERE  mstype = (SELECT doctype FROM   tr_claim WHERE  regid = '$regid') ";
        }
        elseif ($jenis == 'DTBTL') {
            $custWhere = " WHERE  mstype = 'FRMBATAL' ";
        }
        elseif ($jenis == 'DTRFN') {
            $custWhere = " WHERE  mstype = 'FRMREFUND' ";
        }
        elseif ($jenis == 'DTPGJ') {
            $custWhere .= " WHERE mstype = concat('PGJ',(SELECT produk FROM tr_sppa WHERE regid = '$regid'))";
            $foto = DB::select("SELECT * FROM tr_document WHERE regid = '$regid' AND nama_file like '%FOT%'");
            // dd($foto);
            if ($foto) {
                $i = 0;
                foreach($foto as $row) {
                    $custWhere .= "UNION (SELECT
                                        'UPLOADED PHOTO ".$i."',
                                        '".$row->tipe_file."',
                                        '".$row->ukuran_file."',
                                        '".$row->tglupload."',
                                        concat('".$regid.$row->seqno."',
                                               '-',
                                               'UPLOADED PHOTO $i',
                                               '-',
                                               '".$row->ukuran_file."',
                                               '-',
                                               '".$row->tipe_file."',
                                               '-',
                                               'UPLOADED PHOTO $i',
                                               '-',
                                               '".$row->file."',
                                               '-',
                                               'null',
                                               '-',
                                               'null') 'aksi')
                                    ";
                    $i++;
                }
            }
            
            
        }
        else {
            $custWhere = " WHERE mstype IN (
                            ( SELECT doctype
                              FROM   tr_claim
                              WHERE  regid = '$regid'),
                            'FRMBATAL',
                            'FRMREFUND',
                            concat('PGJ',( SELECT produk
                                           FROM   tr_sppa
                                           WHERE  regid = '$regid'))) ";
            $foto = DB::select("SELECT * FROM tr_document WHERE regid = '$regid' AND nama_file like '%FOT%'");
            if ($foto) {
                $i = 0;
                foreach($foto as $row) {
                    $custWhere .= " UNION 
                                    SELECT 
                                        'UPLOADED PHOTO $i',
                                        '".$row->tipe_file."',
                                        '".$row->ukuran_file."',
                                        '".$row->tglupload."',
                                        concat('$regid".$row->seqno."',
                                               '-',
                                               'UPLOADED PHOTO $i',
                                               '-',
                                               '".$row->ukuran_file."',
                                               '-',
                                               '".$row->tipe_file."',
                                               '-',
                                               'UPLOADED PHOTO $i',
                                               '-',
                                               '".$row->file."',
                                               '-',
                                               'null,'
                                               '-',
                                               'null,') 'aksi'
                                    ";
                    $i++;
                }
            }
        }

        $dokumen = DB::select("SELECT SQL_CALC_FOUND_ROWS dokumen,tipe,ukuran,tglupload,aksi,nama_file FROM (
        SELECT a.msdesc 'dokumen', b.tipe_file 'tipe', b.nama_file 'nama_file',b.ukuran_file 'ukuran',b.tglupload,
        concat(
            IF (concat(b.regid,b.seqno) IS NOT NULL, concat(b.regid,b.seqno), 'null'),'-', a.msid,'-',
            IF (b.ukuran_file IS NOT NULL, b.ukuran_file, 'null'), '-', 
            IF (b.tipe_file IS NOT NULL, b.tipe_file, 'null'), '-', a.msdesc,'-',
            IF (b.file IS NOT NULL, b.file, 'null'),'-',
            IF (a.createby IS NOT NULL, a.createby, 'null'),'-',
            IF (a.editby IS NOT NULL, a.editby, 'null')) 'aksi' FROM ms_master a 
            LEFT JOIN (SELECT regid, seqno, file, jnsdoc, tipe_file, ukuran_file, tglupload,nama_file FROM tr_document where regid = '$regid') b 
            ON a.msid = b.jnsdoc $custWhere
        ) t_baru");

        // dd($dokumen);

        $cek1 = DB::select("SELECT * FROM (SELECT * FROM ms_master a LEFT JOIN (SELECT regid, seqno, file, jnsdoc, tipe_file, ukuran_file, tglupload,nama_file FROM tr_document where regid = '$regid') b ON a.msid = b.jnsdoc $custWhere) t_baru");
        $cek2 = DB::select("select * from tr_document where regid = '$regid' limit 10 ");
        // $cek2 = DB::select("DELETE FROM tr_document where regid = '$regid'");
        // $kerja = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='KERJA' order by ms.msdesc  asc");
        // $cab = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='CAB' and ms.msid<>'ALL' order by ms.msdesc  asc");
        // $mitra = DB::select("select ms.msid comtabid,ms.msdesc comtab_nm from ms_master ms   where ms.mstype='mitra'  order by ms.msdesc  asc");
        // $hubungan = DB::select("select ms.msid comtabid,left(msdesc,50) comtab_nm from ms_master ms where ms.mstype='hubungan' order by ms.msid");

        // $dokumen = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc from tr_document a  where regid='$sid'");

        // $file = DB::select("SELECT * FROM tr_document where regid = '$regid'");
        $file = DB::select("SELECT a.regid,a.tglupload,a.nama_file,a.tipe_file,a.ukuran_file,a.file,a.pages,a.seqno,a.jnsdoc,a.catdoc from tr_document a  where regid='$regid'");
        // dump($cek1,$file);
 
        return view('master.pengajuan.doc', compact('data','dokumen','vlevel','regid','cek1'));
    }

    public function upload(Request $request){
        // $this->validate($request, [
        // //     'product_name'   => 'required',
        // //     'product_code' => 'required',
        // // ]);

        $sdate = date('Y-m-d H:i:s');
        $userid = Session::get('login')[0]->username; 

        //     echo "OK";

        $regid = Crypt::decryptString($request->regid);
        DB::select("SELECT * FROM tr_document WHERE regid='$regid'");
        if ($request->file("upload") != null) 
        {
            $file = $request->file("upload");
            $imageName = time().$request->jnsdoc.$file->getClientOriginalName(); 
            $tgl = date("Y-m-d");
            $file_ext = $file->getClientOriginalExtension();
            $file_size = $file->getSize();
            $jnsdoc = $request->jnsdoc;
            $catdoc = $request->jnsdoc;
            $status = "berhasil";
            $pesan = "Data berhasil di simpan";
            
            if ($file->move('assets/upload/'.$regid, $imageName)) {
                $lokasi = "assets/upload/".$regid;
                $sqlq=" INSERT INTO tr_document (regid,tglupload,nama_file,tipe_file,ukuran_file,file,jnsdoc,catdoc) VALUES('$regid','$tgl','$imageName','$file_ext','$file_size','$lokasi','$jnsdoc','$catdoc')";
                $query = DB::select($sqlq);
                if ($catdoc == 'clm') {
                    $cekDoc = DB::select(" SELECT b.jmldokumen,c.uploaded FROM tr_claim a LEFT JOIN (SELECT mstype,Count(msid) 'jmldokumen' FROM   ms_master GROUP  BY mstype) b ON b.mstype = a.doctype LEFT JOIN (SELECT regid, Count(regid) 'uploaded' FROM   tr_document WHERE  catdoc = 'clm' GROUP  BY regid) c ON c.regid = a.regid WHERE  a.regid = '$regid' ");
                    $d  = DB::select($cekDoc);
                    if ($d[0]->uploaded >= $d[0]->jmldokumen) {
                        $updClm = "UPDATE tr_claim SET softcopydt = '$sdate' WHERE regid ='$regid' AND `softcopydt` = 0"; //cegah update, saat dokumen diupload ulang
                        if (DB::select($updClm)) { 
                            echo "berhasil"; 
                        } else {
                            $status = "error";
                            $pesan = "Data gagal di simpan";
                        }
                    } else {
                        echo "berhasil";
                    }
                } else {
                    echo "berhasil";
                }
            }else {
                $status = "error";
                $pesan = "Data gagal di simpan";
            }

        return redirect()->back()->with('success', 'Data Berhasil dihapus');
        // dd(DB::select("SELECT * FROM tr_document WHERE regid='$regid'")); 
        }
    }

    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'product_name'   => 'required',
        //     'product_code' => 'required',
        // ]);

        $sproduk = $request->produk;
        $sjkel = $request->jkel;
        $snama      = str_replace("'", "`", $request->nama);
        $susia = $request->usia;
        $snoktp = $request->noktp;
        $stmplahir = $request->tempat_lahir;
        $smasa = $request->masa;
        $salamat = $request->alamat;
        $spekerjaan = $request->pekerjaan;
        $scabang = $request->cabang;
        $snopeserta = $request->nopeserta;
        $scabang = $request->cabang;
        $stunggakan = $request->tunggakan;
        $stgllahir = $request->tgllahir;
        $smulai = $request->mulai;
        $smitra = $request->mitra;
        $sakhir     = date('Y-m-d', strtotime('+' . $smasa . 'months', strtotime($smulai))); 
        $hubunganahli  = $request->hubungan;
        $hubunganahli2 = $request->ket_hubungan;
        $nmahli = $request->nama_ahli_waris;
        $notelpahli = $request->notelp_ahli_waris;
        $scomment = $request->catatan;
        $status     = '0';
        $userid = Session::get('login')[0]->username;

        $sdate      = date('Y-m-d H:i:s');
        $sregid     = $request->regid;
        $sup        = str_replace(',', '', $request->up);

        $susia      = app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $smulai);
        $sbulan     = app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $smulai, "bulan");
        $shari      = app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $smulai, "hari");
    //  $total_usia = ($susia + ($smasa / 12));
        
        // belum naik / reset bulan hari
        $sakhir     = date('Y-m-d', strtotime('+' . $smasa . 'months', strtotime($smulai)));
        $busia      = app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $sakhir, null, false);
        $bbulan     = app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $sakhir, "bulan", false);
        $bhari      = app('App\Http\Controllers\Master\PengajuanController')->hitung_umur($stgllahir, $sakhir, "hari", false);

        $rates = DB::select("SELECT rates,ratesother,tunggakan,bunga,umurb,umura,$susia FROM tr_rates WHERE produk = '$sproduk' AND jkel = '$sjkel' AND $susia BETWEEN umurb AND umura AND insperiodmm = '$smasa' AND '$stunggakan' BETWEEN gpb AND gpa AND $sup BETWEEN minup AND maxup");

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


        $produk = DB::select("SELECT umurb, umura, maxup FROM tr_term WHERE produk='$sproduk'");
        
        $sbumurb    = $produk[0]->umurb;
        $sbumura    = $produk[0]->umura;
        $smaxup     = $produk[0]->maxup;

        $stpremi        = ($spremi + $sepremi);
        $hubungan = "";

        if ($susia < $sbumurb and $stpremi == 0) {
            $scomment   .= " Usia minimum(".$sbumurb." tahun) belum tercapai, harap cek kembali tanggal lahir dan tanggal mulai. ";
            $spremi     = 0;
            $sepremi    = 0;
            $stpremi    = 0;
        }

        if ($susia > $sbumura or ($susia >= $sbumura and ($sbulan > 0 or $shari > 0)) and $stpremi == 0) {
            $scomment   .= " Usia maksimum(".$sbumura." tahun) terlampaui, harap cek kembali tanggal lahir dan tanggal mulai. ";
            $spremi     = 0;
            $sepremi    = 0;
            $stpremi    = 0;
        }

        if ($sup > $smaxup) {
            $scomment   .= " Plafond melebih maksimum pinjaman(" . number_format($smaxup, 0, ".", ",")."). ";
            $spremi     = 0;
            $sepremi    = 0;
            $stpremi    = 0;
        }

        if ($busia > $sbumura or ($busia >= $sbumura and ($bbulan > 0 or $bhari > 0))) {
            $scomment   .= " Usia debitur ditambah masa pinjaman adalah ".$busia." tahun ".$bbulan." bulan ".$bhari." hari (melebihi maksimal usia pinjaman ".$sbumura." tahun 0 bulan 0 hari)";
            $spremi     = 0;
            $sepremi    = 0;
            $stpremi    = 0;
        }
        
        if ($susia == '') {
            $susia = $susia;
        }
        
        if ($sbunga == '') {
            $sbunga = 0;
        }
        
        if ($stunggakan == '') {
            $stunggakan = 0;
        }
        
        if ($hubunganahli == 'LAINNYA') {
            $hubungan = $hubunganahli2;
        } else {
            $result = DB::select("SELECT * FROM ms_master WHERE mstype='hubungan' AND msid='$hubunganahli'");
            foreach ($result as $r) {
                $hubungan = $r->msdesc;
            }
        }

        $hasil =DB::select("UPDATE tr_sppa SET nama= '$snama',cabang = '$scabang',mitra = '$smitra',usia = '$susia',tgllahir = '$stgllahir',up = '$sup', jkel = '$sjkel', pekerjaan = '$spekerjaan', tempat_lahir = '$stmplahir', alamat = '$salamat', noktp = '$snoktp', tpremi = '$spremi', premi = '$spremi', epremi = 0, status = 0, editby = '$userid', editdt = '$sdate', masa = '$smasa', akhir = '$sakhir', mulai = '$smulai', tunggakan = '$stunggakan', nama_ahli_waris = '$nmahli',notelp_ahli_waris = '$notelpahli',hubungan_ahli_waris = '$hubungan', COMMENT = '$scomment' WHERE regid = '$sregid'");
        // dd($hasil);

        return redirect()->intended('pengajuan')->with('success', 'Data Berhasil diubah');
    }

    public function delete($id)
    {
        DB::select("DELETE FROM md_product WHERE id_product='$id'");
        // return view('master.product.add');
        return redirect()->intended('product')->with('success', 'Data Berhasil dihapus');
    }
}
