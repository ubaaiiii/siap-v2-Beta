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
		p{
			font-size: 13px;
			padding: 3px 5px !important ;
			margin: 0;
		}
		footer{
			font-size: 8px;
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
						&nbsp;
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
		<center><h2 style="text-decoration: underline;">SURAT PENGANTAR MEDIS</h2></center>
		<p>Kepada Yth, </p>
		<p>.............................................</p>
		<p>.............................................</p>
		<p>Dengan hormat,</p>
		<p>Harap Saudara Melakukan Pemeriksaan Medical Check Up</p>
		<p><input type="checkbox"> LPK ( Laporan Pemeriksaan Kesehatan )</p>
		<p><input type="checkbox"> STD ( Thorax Photo )</p>
		<p><input type="checkbox"> EKG ( Electro Kardio Gram dan Interpretasi)</p>
		<p><input type="checkbox"> Analisa Urine Lengkap (Macroscopic dan Microscopic)</p>
		<p><input type="checkbox"> Analisa Darah Rutin</p>
		<p><input type="checkbox"> ADAL ( Analisa Darah Dan Kimia Darah Lengkap )</p>
		<table  style="width: 100%;margin-bottom: 0px;margin-top: 0px;padding: 0px;">
			<tr>
				<td><p style="font-weight: bold;font-style: italic;display: inline;">Darah Rutin : </p></td>
			</tr>
			<tr>
				<td><p>Haemoglobin, Leukosit, Haemotocrit, Eritrosit, MCV, MCHC, LED, Differential Count & Trombosit dan hitung jenis</p></td>
			</tr>
			<tr>
				<td><p style="font-weight: bold;font-style: italic;display: inline;">Pemeriksaan Fungsi Hati (Liver Function Test) :</p></td>
			</tr>
			<tr>
				<td><p>Protein Total, Albumin, Globulin, Phosphatase Alkali, Bilirubin Total, Billirubin Direct, Billirubin Inderect, SGOT, SGPT, Gamma GT.</p></td>
			</tr>
			<tr>
				<td><p><div style="font-weight: bold;font-style: italic;display: inline-block;">Pemeriksaan Fungsi Ginjal (Renal Function test) :</div> Ureum, Kreatinin, Asam Urat</p></td>
			</tr>
			<tr>
				<td><p><div style="font-weight: bold;font-style: italic;display: inline-block;">Karbohidrat (Glucose test) :</div> Gula Darah Sewaktu, Gula Darah Puasa, Gula Darah 2 Jam Puasa, HbA1c.</p></td>
			</tr>
			<tr>
				<td><p><div style="font-weight: bold;font-style: italic;display: inline-block;">Pemeriksaan Serologi (Imuno Serologist) : </div> HBsAG dan HBeAg jika HBsAG Positif</p></td>
			</tr>
			<tr>
				<td><p><div style="font-weight: bold;font-style: italic;display: inline-block;">Kadar Lemak Darah (Lipid Profile) : </div> Kolesterol Total, HDL, LDL, Trigliserida.</p></td>
		</table>
<!-- 
		<p style="font-weight: bold;font-style: italic;">Ahli Waris</p>
		<p>Demikia Surat ini</p>
		<br> -->
		<table style="width: 100%;margin-bottom: 0px;margin-top: 0px;padding: 0px;">
			
			<tr>
				<td><p><input type="checkbox"> Treadmill Test</p></td>
				<td><p><input type="checkbox"> HIV Test ( Human Immuno Deficiency Virus Test )</p></td>
			</tr>
			<tr>
				<td><p><input type="checkbox"> Surat Pernyataan Dokter (Bermaterai) </p></td>
				<td><p><input type="checkbox"> AFP ( Alfa Feto Protein )</p></td>
			</tr>
			<tr>
				<td><p><input type="checkbox"> CEA ( Carcino Embryonic Antigen) </p></td>
				<td><p><input type="checkbox"> SKS ( Surat Keterangan Sehat )</p></td>
			</tr>
		</table>
		<br>
		<p>Terhadap Bapak/Ibu/Sdr/Sdri ……………………………………………….</p>
		<p>dan mohon semua hasil pemeriksaan dikirimkan kepada kami.</p>
		<p>Atas bantuan dan kerjasamanya diucapkan terima kasih.</p>
		<br>
		<table style="width: 100%">
			<tr>
				<td style="width: 30%"><h6>&nbsp;</h6></td>
				<td style="width: 30%"><h6>&nbsp;</h6></td>
				<td style="width: 40%"><p>Hormat Kami,<br>
				</p></td>
			</tr>
			<tr>
				<td style="width: 30%"> &nbsp;</td>
				<td style="width: 30%"><h6>&nbsp;</h6></td>
				<td style="width: 40%">.....................</td>
			</tr>
		</table>
	</div>
	<footer>
		<center>
			<!-- <span>Kantor Pusat :<br> 
			Gedung Andika, Jl Raya Pasar Minggu No 5, Pancoran Jakarta Selatan 12780, Tel.: 021-799 5888 (Hunting), Fax : 021-791 84342 <br>
			www.plninsurance.co.id</span> -->
		</center>
	</footer>
</body>
</html>