<!doctype html>
<?php 
// function tglindo_balik($tgl){
//         $tanggal = substr($tgl,8,2);
//         $bulan =  substr($tgl,5,2);
//         $tahun = substr($tgl,0,4);
//         return $tanggal.'-'.$bulan.'-'.$tahun;       
// }
?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="../img/laporan.png">
	<link rel="stylesheet" type="text/css" href="../../css/laporan.css">
	<style>
		.logo {
			width: 300px;
			hight: 40px;
			margin: 10px 0px 10px 0px;
		}
		.kop {
			border-collpase: collapse;
		}
		.kop .header {
			width: 130px;
		}
		.kop .judul {
			text-align: right;
		}
		.kop table {
			text-align: left;
			border-collpase: collapse;
		}
		.kop table .cel1 {
			width: 200px;
		}
		.kop table .cel2 {
			width: 170px;
		}
		.kop table .cel3 {
			width: 170px;
		}
		.kop table td {
			font-size: 11px;
		}
		.garis {
			line-height: 1.5px;
		}
		.garis .line1 {
			border: 1px solid #000;
		}
		.garis .line2 {
			border: 0.5px solid #000;
		}
		.tbl_lap1 {
			margin: 20px 0px;
		}
		.tbl_lap1 .cel1 {
			width: 180px;
		}
		.tbl_lap1 .cel2 {
			width: 200px;
		}
		.tbl_lap1 .cel3 {
			width: 290px;
		}
		.judul {
			margin: 20px 0px;
			padding-right: 220px;
		}
		.tbl_lap2 {
			border-collapse: collapse;
			border: 1px solid #000;
		}
		.tbl_lap2 .cel1 {
			width: 20px;
		}
		.tbl_lap2 .cel2 {
			width: 200px;
		}
		.tbl_lap2 .cel3 {
			width: 400px;
		}
		.tbl_lap2 td {
			padding: 5px 2px;
		}
		.space {
			padding: 10px;
		}
		.tbl_lap3 .cel1 {
			width: 300px;
		}
		.tbl_lap3 .cel2 {
			width: 100px;
		}
		.tbl_lap3 .cel3 {
			width: 300px;
		}
		.table_new {
			border-collapse: collapse;
		}
		.table_new td {
			padding: 5px 10px 5px 10px;
			font-size: 9;
		}
		.table_new,
		.table_new th,
		.table_new td {
			border: 1px solid black;
		}
		td{
			font-size: 14px;
			padding: 0px 5px !important ;
			margin: 0;
		}
		.box1{
			width:40px;
			height:30px;
			background:green;
		}
		.rahasia{
			position: relative;
			float: right;
			width: 50px;
			height:20px;
			top: -50px;
			border: 1px solid black;
			padding: 5px;
			/*background-color: green;*/
			/*justify-content: center;*/
		}
		.border-box{
			width: 100%;
			height: auto;
			border: 1px solid black;
			padding-right: 10px;
			padding-left: 10px;
		}
		.float-right{
			width: 50%;
			float: right;
		}
		.float-left{
			width: 50%;
			float: left;
			padding-right: 4px;
			padding-left: 5px;
		}
		.garis{
			border-bottom: 1px solid black;
		}
		.garis-putus{
			border-bottom: 1px dashed black;
		}
		p{
			font-size: 13px;
			padding: 3px 5px !important ;
			margin: 0;
		}
		footer{
			font-size: 8px;
		}
		.clear{
			clear: both;
		}
	</style>
</head>
<body>
	<div class="page">
		
		<div class="kop">
			<table class="kop" width="100%"> 
				<tr>
					<td style="width: 10%">
						LOGO
						<!-- <img src="{{ url('assets/img/logo/pln-insurance.jpg') }}" class="logo" style="width: 10rem"> -->
					</td>
					<th style="width: 60%">
						SURAT KETERANGAN KESEHATAN TERTANGGUNG ASURANSI KREDIT MULTI GUNA
					</th>
					<td align="right" style="width: 30%">&nbsp;</td>
				</tr>
			</table>
		</div>
		
		<h5>I. INSTANSI PEMBERI KREDIT  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (SEBUTKAN)</h5>
		<table style="width: 100%">
			<tr>
				<td style="width: 50%">Bank Umum / BPR / Koperasi /………………………..</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
		</table>
		<h5>II. PERNYATAAN DEBITUR/TERTANGGUNG (SPD) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Harap dilampirkan fotocopy KTP)**</h5>
		<table style="width: 100%">
			<tr>
				<td colspan="3">Yang bertanda tangan dibawah ini,</td>
			</tr>
			<tr>
				<td style="width: 50%">Nama Lengkap (sesuai data pengajuan kredit)</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>		
				<td>Tempat & Tanggal Lahir</td>
				<td>:</td>
				<td>............</td>
			</tr>
			<tr>
				<td style="width: 50%">Alamat & No. Telepon</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">&nbsp;</td>
				<td style="width: 5%">&nbsp;</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Pekerjaan</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Saat ini dalam keadaan sehat</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Tinggi Badan & Berat Badan</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Memiliki Rekening Pinjaman Sebelumnya</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Yang diasuransikan </td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">Jika ya apakah sudah lunas : Sudah / Belum</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">Dengan ini mengajukan permohonan menjadi Peserta Asuransi Kredit Kumpulan untuk :</td>
			</tr>
			<tr>
				<td style="width: 50%">Uang Asuransi Awal (sesuai kredit yang diterima)</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>		
				<td>Tanggal Realisasi Kredit</td>
				<td>:</td>
				<td>............</td>
			</tr>
			<tr>
				<td style="width: 50%">Premi Sekaligust</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Mulai Asuransi (sesuai jangka waktu kredit) </td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Benefit**</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Nama yang menerima manfaat asuransi</td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
			<tr>
				<td style="width: 50%">Mulai Asuransi (sesuai jangka waktu kredit) </td>
				<td style="width: 5%">:</td>
				<td style="width: 45%">............</td>
			</tr>
		</table>
		<h5>III. KETERANGAN KESEHATAN TERTANGGUNG (SKKT) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (WAJIB DIISI)**</h5>
		<p>Mengajukan permintaan untuk mengasuransikan Peserta Asuransi Kredit yang nama-namanya tercantum dalam 
lampiran SURAT PERMINTAAN ini.</p>
		<table style="width: 100%">
			<tr>
				<td style="width: 70%">1. Apakah anda merokok ? </td>
				<td style="width: 15%">:</td>
				<td style="width: 15%">............</td>
			</tr>
			<tr>
				<td style="width: 70%">2. Apakah anda mengkonsumsi alcohol/minuman keras lainnya? </td>
				<td style="width: 15%">:</td>
				<td style="width: 15%">............</td>
			</tr>
			<tr>
				<td style="width: 70%">3. Apakah anda pernah ditolak/ditunda pengajuan dalam pengajuan asuransi jiwa? </td>
				<td style="width: 15%">:</td>
				<td style="width: 15%">............</td>
			</tr>
			<tr>
				<td style="width: 70%">
					4. Apakah anda sedang dalam perawatan/pengawasan dokter karena suatu penyakit? <br>
					&nbsp;&nbsp;&nbsp;&nbsp;Jika Ya, sebutkan penyakit yang diderita dan sejak kapan.</td>
				<td style="width: 15%">:</td>
				<td style="width: 15%">............</td>
			</tr>
			<tr>
				<td style="width: 70%">
					5. Apakah anda pernah dirawat di Rumah Sakit / dioprerasi dalam <br>
					&nbsp;&nbsp;&nbsp;&nbsp;dua tahun terakhir ini ? jika ya, kapan dan sebutkan penyakit yang diderita <br>
					&nbsp;&nbsp;&nbsp;&nbsp;atau operasi yang dilakukan .
				</td>
				<td style="width: 15%">:</td>
				<td style="width: 15%">............</td>
			</tr>
			<tr>
				<td colspan="3">6. Penyakit yang pernah diderita : <input type="checkbox" name=""> Tidak ada,saat ini kondisi saya dinyatakan SEHAT</td>
			</tr>
		</table>
		<table style="width: 100%">
			<tr>
				<td style="width: 15%;" align="right">Ada Yaitu,</td>
				<td style="width: 25%">
					<input type="checkbox" name="">TBC (th) ...... <br>
					<input type="checkbox" name="">Hati (th) ...... <br>
					<input type="checkbox" name="">Ayan (th) ...... <br>
					<input type="checkbox" name="">Paru (th) ...... 
				</td>
				<td style="width: 25%">
					<input type="checkbox" name="">Kanker (th) ...... <br>
					<input type="checkbox" name="">Ginjal (th) ...... <br>
					<input type="checkbox" name="">Jantung (th) ...... <br>
					<input type="checkbox" name="">Stroke (th) ...... 
				</td>
				<td style="width: 35%">
					<input type="checkbox" name="">Kencing manis. (th) ...... <br>
					<input type="checkbox" name="">Gangguan Jiwa. (th) ...... <br>
					<input type="checkbox" name="">Tekanan Darah Tinggi. (th) ...... <br>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center"><input type="checkbox" name=""> Lainnya sebutkan ....................................................., ...........................</td>
			</tr>
			<!-- <tr>
				<td style="width: 70%">2. Apakah anda mengkonsumsi alcohol/minuman keras lainnya? </td>
				<td style="width: 15%">:</td>
				<td style="width: 15%"><input type="checkbox" name=""> TBC (th) ............ <input type="checkbox" name="">Kanker (th) </td>
			</tr> -->
		</table>
		<p>Apabila dari hasil pemeriksaan kasehatan saya ditemukan kelainan akan tetapi masih dapat diterima dengan membayar Extra Premi, 
maka saya bersedia membayar Extra Premi tersebut.</p>
		<hr>
		<h5>IV. HANYA UNTUK PELAKSANAAN PEMERIKSAAN KESEHATAN/MEDICAL(Diisi oleh petugas)</h5>
		<table style="width: 100%">
			<tr>
				<td colspan="3">
					<p>Berdasarkan Usia dan Uang Asuransi Awal, maka calon debitur tersebut diatas diwajibkan melakukan pemeriksaan kesehatan :</p>
				</td>
			</tr>
			<tr>
				<td style="width: 40%">1. Jenis pemeriksaan kesehatan </td>
				<td style="width: 2%">:</td>
				<td style="width: 60%" align="left">....................................................................................</td>
			</tr>
			<tr>
				<td style="width: 40%">2. Nama Dokter/rumah sakit/Lab</td>
				<td style="width: 2%">:</td>
				<td style="width: 60%" align="left">.............................................................(Propider/Non Provider)*</td>
			</tr>
			<tr>
				<td style="width: 40%">3. Tanggal pemeriksaan </td>
				<td style="width: 2%">:</td>
				<td style="width: 60%" align="left">....................................................................................</td>
			</tr>
		</table>
		</div>
	</div>
	<br>
	<p>Saya menerangkan bahwa pernyatan-pernyataan tersebut diatas saya jawab dengan sebenarnya dan saya sadar bahwa jika ada
sesuatu hal yang saya ketahui tetapi tidak saya beritahukan atau saya dengan sengaja menjawab dengan tidak benar, maka Asuransi berhak membatalkan pertanggungan atau menolak membayar manfaat asuransi.
Selanjutnya saya memberikan izin dan atau kuasa kepada dokter, rumah sakit, klinik, puskesmas, perusahaan asuransi jiwa atau
pihak lain yang mempunyai catatan atau mengetahui keadaan kesehatan saya, untuk memberitahukan kepada Asuransi, segala kebenaran mengenai diri dan kesehatan saya yang diperlukan baik pada saat pengajuan
awal maupun saat pengajuan klaim dalam hubungan dengan perjanjian asuransi ini. Kuasa ini tidak menjadi berakhir karena sebab
apapun.===</p>
	
	<table style="width: 100%">
		<tr>
			<td style="width: 20%" align="left">
				<p>*) Lingkari yang dipilih</p>
				<p>**) Tandai yang benar</p>
			</td>
			<td style="width: 30%" align="center">
				Petugas Pemasaran
				<br><br><br><br><br>
				(...........................)
				<br>Nama Jelas
			</td>
			<td style="width: 40%" align="center">
				Kota,........., tanggal .............
				<br>Calon Tertanggung
				<br><br><br><br>
				(...........................)
				<br>Nama Jelas
			</td>
		</tr>
	</table>
	<br><br>
	<em>Diisi oleh Bagian Underwriting </em>
	<table style="width: 100%" border="1">
		<tr style="margin: 10px;">
			<td colspan="3" align="center"><b>CATATAN UNDERWRITING</b></td>
		</tr>
		<tr style="margin: 10px;">
			<td style="width: 30%">Data Lengkap : Ya / Tidak *)</td>
			<td style="width: 30%">
				Umur : tahun
				<div class="garis"></div>
				<br>
				Medis / Non Medis *)
				<br><br>
			</td>
			<td style="width: 30%">
				Total Mortalita : _________________ %
				<div class="garis"></div>
				Konsultasi Medis
				<br><br><br>
			</td>
		</tr>
		<tr style="margin: 10px;">
			<td><input type="checkbox" name=""> Ditunda</td>
			<td>Tanggal: </td>
			<td>Paraf: </td>
		</tr>
		<tr style="margin: 10px;">
			<td><input type="checkbox" name=""> Ditolak</td>
			<td>Tanggal: </td>
			<td>Paraf: </td>
		</tr>
		<tr style="margin: 10px;">
			<td><input type="checkbox" name=""> Diterima</td>
			<td>Tanggal: </td>
			<td>Paraf: </td>
		</tr>
		<tr style="margin: 10px;">
			<td colspan="3"><input type="checkbox" name=""> Standard <input type="checkbox" name=""> Substandard dengan Extra Mortality : ......... dan tarif premi tambahan : ........... Per mil</td>
		</tr>
		<tr style="margin: 10px;">
			<td colspan="3"><input type="checkbox" name=""> Fakultatif <input type="checkbox" name=""> Premi Pokok : Rp. ........... Extra premi : Rp. .......... Total premi : Rp. ............</td>
		</tr>
</td>
		</tr>
	</table>
</body>
</html>