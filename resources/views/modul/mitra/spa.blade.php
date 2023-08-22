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
						<!-- <img src="{{ url('assets/img/logo/pln-insurance.jpg') }}" class="logo" style="width: 10rem"> -->
						LOGO
					</td>
					<th style="width: 30%">
						&nbsp;
					</th>
					<td align="right" style="width: 60%">
						ALAMAT
						<!-- <b><?= ' JL. Raya Pasar Minggu No.5 Jakarta Selatan 12780'  ?></b> <br>
						<b><?= ' Telp : (021) 799 58888, Fax : (021) 791 84342 '  ?> </b><br>
						<b><?= ' cs@plninsurance.co.id '  ?> </b><br>
						<b><?= ' www.plninsurance.co.id '  ?> </b> -->
					</td>
				</tr>
			</table>
		</div>
		<center>
			<h2 style="margin: 0px;">SURAT PERMINTAAN ASURANSI</h2>
			<p>( harap diisi dengan lengkap dan ditulis dengan huruf cetak )</p>
		</center>
		<div class="garis"></div><br><br>
		<p>I. Yang bertanda tangan dibawah ini : </p>
		<table style="width: 100%">
			<tr>
				<td style="width: 45%">1. Nama</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>		
				<td>2. Tempat dan Tanggal Lahir</td>
				<td>:</td>
				<td>............</td>
			</tr>
			<tr>
				<td style="width: 45%">3. Jabatan</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">4. KTP/SIM/Paspor</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td colspan="3">
					Dalam hal ini bertindak untuk dan atas nama :
				</td>
			</tr>
			<tr>
				<td style="width: 45%">1. Nama</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>		
				<td>2. Jenis Usaha</td>
				<td>:</td>
				<td>............</td>
			</tr>
			<tr>
				<td style="width: 45%">3. Alamat</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">4. No Telp/Fax</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
		</table>
		<p>Mengajukan permintaan untuk mengasuransikan Peserta Asuransi Kredit yang nama-namanya tercantum dalam 
lampiran SURAT PERMINTAAN ini.</p>
		<table style="width: 100%">
			<tr>
				<td style="width: 45%">II. Yang diasuransikan</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">III. Macam Asuransi</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">III. Macam Asuransi</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">Jumlah Premi </td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr><tr>
				<td style="width: 45%">Cara Pembayaran Asuransi</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr><tr>
				<td style="width: 45%">Sumber Dana Premi **)</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">Mulai berlakunya Asuransi</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">Masa Asuransi</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">Jumlah Peserta ***) </td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
			<tr>
				<td style="width: 45%">V. Tambahan</td>
				<td style="width: 5%">:</td>
				<td style="width: 50%">............</td>
			</tr>
		</table>
		<p>Pertanggungan Asuransi yang diadakan, berdasarkan dan sangat tergantung kepada keterangan-keterangan yang kami berikan
termasuk keterangan dalam Surat Permintaan Asuransi Kredit ini, karena itu kami menyadari sepenuhnya bahwaAsuransi  berhak membatalkan pertanggungan Asuransi serta tidak berkewajiban membayar Manfaat
Asuransi, apabila ternyata keterangan yang kami berikan tidak benar dan disengaja.</p>
		<table style="width: 100%">
			<tr>
				<td style="width: 30%"><h6>&nbsp;</h6></td>
				<td style="width: 30%"><h6>&nbsp;</h6></td>
				<td style="width: 40%"><p><div class="garis"></div><br>
				Yang mengajukan permintaan</p></td>
			</tr>
			<tr>
				<td style="width: 30%"> &nbsp;</td>
				<td style="width: 30%"><h6>&nbsp;</h6></td>
				<td style="width: 40%">.....................</td>
			</tr>
		</table>
		</div>
	</div>
	<p>*) Coret yang tidak perlu</p>
	<p>**) Harap diisi untuk pelaksanaan Prinsip Mengenal Nasabah sesuai peraturan Menteri Keuangan No. 74/PMK.012/2006</p>
	<p>***) Jumlah Peserta Minimal diawal penutupan adalah 10(sepuluh) Peserta</p>
</body>
</html>