<!doctype html>
<?php 
function tglindo_balik($tgl){
        $tanggal = substr($tgl,8,2);
        $bulan =  substr($tgl,5,2);
        $tahun = substr($tgl,0,4);
        return $tanggal.'-'.$bulan.'-'.$tahun;       
}
?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="../img/laporan.png">
	<link rel="stylesheet" type="text/css" href="../../css/laporan.css">
	<style>
		.logo {
			width: 300px;
			hight: 80px;
			margin: 10px 50px 10px 10px;
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
		p{
			font-size: 16px;
		}
		td{
			font-size: 16px;
			padding: 0px 5px !important ;
			margin: 0;
		}
		.box1{
			width:40px;
			height:30px;
			background:green;
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
					<th style="width: 50%">
						<center> 
							
						</center>
					</th>
					<td align="right" style="width: 40%">
						ALAMAT
						<!-- <b><?= ' JL. Raya Pasar Minggu No.5 Jakarta Selatan 12780'  ?></b> <br> 
						<b><?= ' Telp : (021) 799 58888, Fax : (021) 791 84342 '  ?> </b>
						<b><?= ' cs@plninsurance.co.id '  ?> </b>
						<b><?= ' www.plninsurance.co.id '  ?> </b> -->
					</td>
				</tr>
			</table>
		</div>
		<center><h2 style="text-decoration: underline;">SURAT PERNYATAAN & KRONOLOGIS KEMATIAN</h2></center>
		<br>
		<p>Kami yag bertanda tangan dibawah ini :</p>
		<br>
		<p style="font-weight: bold;font-style: italic;">Ahli Waris</p>
		<table width="100%">
			<tr>
				<td style="width: 50%">Nama</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">NIK</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Tempat dan Tanggal Lahir</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Alamat Tinggal</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Hubungan dengan Tertanggung</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">No. Telp/Hp</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
		</table>
		<br>
		<p style="font-weight: bold;font-style: italic;">RT/RW</p>
		<table width="100%">
			<tr>
				<td style="width: 50%">Nama</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Alamat Tinggal</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">No.Telp/Hp</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
		</table>
		<br>
		<p>Dengan ini menyatakan bahwa benar Tertanggung atas nama :</p>
		<table width="100%">
			<tr>
				<td style="width: 50%">Nama</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">NIK</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">No. Polis Asuransi</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
		</table>
		<br>
		<p>Telah meninggal Dunia pada :</p>
		<table width="100%">
			<tr>
				<td style="width: 50%">Hari/Tanggal</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Waktu</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Alamat Kejadian</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Penyebab Meninggal Dunia</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
			<tr>
				<td style="width: 50%">Kronologi Kejadian</td>
				<td style="width: 2%">:</td>
				<td style="width: 78%">...................................................................................................</td>
			</tr>
		</table>
		<br><br><br><br><br>
		<table style="width: 100%;">
			<tr>
				<td>A</td>
				<td style="width: 50%">Almarhum/ah meninggal dengan tida-tiba saja?.</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">...............</td>
			</tr>
			<tr>
				<td>B</td>
				<td style="width: 50%">Almarhum/ah meninggal dengan tida-tiba saja?.</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>C</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal Jatuh Pingsan ? (Tidak sadarkan diri)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>D</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita kaku ? Lumpuh atau Kejang – Kejang Keram ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>E</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita sakit Batuk Batuk atau Sesak Nafas ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>F</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita saat Muntah – Muntah ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>G</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita sakit Diare ? (Mencret)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>H</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita sakit Kaki Bengkak ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>I</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita sakit Perut atau Gembung Perut ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>J</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita sakit Pinggang ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>K</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal menderita penyakit :</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">1. TUMOR</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">2. STROKE</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">3. Kencing Manis (Diabetes) </td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">4. Jantung </td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">5. Ginjal</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">6. Hati (liver)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">7. Tekanan Darah Tinggi (Hipertensi)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">8. Tekanan Darah Rendah (Hipotensi)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">9. Kanker</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">10. TBC (Tuberculosis)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">11. Penyakit Kelamin (GO & Syphilis)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">12. Malaria </td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">13. Syaraf</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 50%">14. Ayan ( Epilepsi)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>L</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal karena keracunan ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>M</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal dunia dalam keadaan Hamil atau sedang melahirkan anak / sesudah melahirkan anak ? (Hanya Untuk Wanita)</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>N</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal disebabkan oleh salah satu kecelakaan ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>O</td>
				<td style="width: 50%">Apakah almarhum/ah meninggal pada waktu / setelah dioperasi ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			<tr>
				<td>P</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal dirawat di Rumah Sakit ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>Q</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal diobati Dokter, Tabib, Dukun, dan Sebagainya ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>R</td>
				<td style="width: 50%">Apakah almarhum/ah meninggal kareana Bunuh Diri ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>S</td>
				<td style="width: 50%">Apakah almarhum/ah sebelum meninggal mengkonsumsi obat - obatan dari dokter (obat 
hipertensi/diabetes/obat tidur/ dan lainnya ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
			<tr>
				<td>T</td>
				<td style="width: 50%">Adakah tanda – tanda lain yang dapat saudara/I terangkan yang tidak terdapat pada pertanyaan diatas ?</td>
				<td style="width: 15%"><input type="checkbox"> TIDAK</td>
				<td style="width: 15%"><input type="checkbox"> YA</td>
				<td style="width: 30%">Sejak ...............</td>
			</tr>
		</table>
		<br>
		<p>Demikian Surat Pernyataan ini Kami buat dengan sebenar – benarnya dan penuh tanggung 
jawab atas segala keterangan yang diberikan, jika di kemudian hari ditemukan adanya 
keterangan yang tidak benar, maka kami bersedia menerima sanksi sesuai Hukum yang 
berlaku. Surat Pernyataan ini dibuat tanpa ada paksaan dari pihak manapun agar dapat 
digunakan sebagaimana mestinya. </p>
		<br>
		<table style="width: 100%">
			<tr>
				<td colspan="3">.....................</td>
			</tr>
			<tr>
				<td><h6>Ahli Waris</h6></td>
				<td><h6>&nbsp;</h6></td>
				<td><h6>RT/RW</h6></td>
			</tr>
			<tr>
				<td> Materai <br> 10.000</td>
				<td><h6>&nbsp;</h6></td>
				<td><h6>RT/RW</h6></td>
			</tr>
		</table>
		<br><br><br>
		<p style="font-weight: bold;font-style: italic;">Note : Mohon melampirkan Copy KTP Ahli Waris</p>
	</div>
	<br><br><br>
	<footer>
		<!-- <em>Printed <?= date("d-m-Y H:i:s"); ?></em> -->
	</footer>
</body>
</html>