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
						NAMA PT
						<!-- <b><?= ' JL. Raya Pasar Minggu No.5 Jakarta Selatan 12780'  ?></b> <br>
						<b><?= ' Telp : (021) 799 58888, Fax : (021) 791 84342 '  ?> </b><br>
						<b><?= ' cs@plninsurance.co.id '  ?> </b><br>
						<b><?= ' www.plninsurance.co.id '  ?> </b> -->
					</td>
				</tr>
			</table>
		</div>
		<center><h2 style="text-decoration: underline;">Laporan Pemeriksaan Fisik Kesehatan</h2></center>
		
		<div class="rahasia">Rahasia</div>
		<div class="border-box">
			<p>Kepada Dokter yang memeriksa diminta mencocokan keadaan calonTertanggung dengan Kartu Identitasnya ( KTP, SIM) 
dan mengisi jawaban dengan jelas :</p>
			<h5>1. IDENTITAS</h5>
			<table style="width: 100%">
				<tr>
					<td style="width: 25%">
						<p>1. Nomor KTP/SIM </p>
						<p>2. Nama : </p>
						<p>3 Jenis Kelamin </p>
						<p>4 Tempat/Tgl Lahir </p>
					</td>
					<td style="width: 5%">
						<p>:</p>
						<p>:</p>
						<p>:</p>
						<p>:</p>
					</td>
					<td style="width: 35%">
						<p>......................................................................................</p>
						<p>......................................................................................</p>
						<p>......................................................................................</p>
						<p>......................................................................................</p>
					</td>
					<th style="width: 15%">
						<div class="border-box" style="width: 75%">Tanda Tangan </div>
						<div class="border-box" style="width: 75%"><br><br><br><br></div>
					</th>
				</tr>
			</table>
		</div>
		<div class="border-box">
			<h5>2. UKURAN BADAN</h5>
			<table style="width: 100%;">
				<tr style="width: 30%;">
					<td>a. Tinggi Badan dengan/tanpa sepatu</td>
					<td>: ...................... (cm)</td>
					<td>d. Lingkar Perut</td>
					<td>: ...................... (cm)</td>
					
				</tr>
				<tr style="width: 20%;">
					<td>b. Berat Badan dengan/tanpa sepatu</td>
					<td>: ...................... (kg)</td>
					<td>e. Lingkar dada ( tarik nafas )</td>
					<td>: ...................... (cm)</td>
				</tr>
				<tr style="width: 30%;">
					<td>c. Lingkar Leher</td>
					<td>: ...................... (cm)</td>
					<td>f. Keluar nafas</td>
					<td>: ...................... (cm)</td>
				</tr>
			</table>
		</div>
		<div class="border-box float-left">
			<h5>3. KEADAAN UMUM</h5>
			<p>a. Apakah saudara kenal dengan calon ?</p>
			<p>&nbsp;&nbsp; Jika Kenal, Pribadi atau pasien ?</p>
			<p>b. Apakah calon kelihatan kurang sehat atau lebih tua dari umur</p>
			<p>&nbsp;&nbsp; yang disebutkan ?</p>
			<p>c. Adakah tanda – tanda luar yang memberikan kesan bahwa</p>
			<p>&nbsp;&nbsp; calon menderita suatu penyakit atau ada ketergantungan  </p>
			<p>&nbsp;&nbsp; pada obat, minuman keras dan semacamnya ?</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box float-left">
			<h5>4. TELINGA, HIDUNG, TENGGOROKAN, MATA</h5>
 
			<p>a. Bagaimana keadaan : </p>
			<p>&nbsp;&nbsp; 1. Mata &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4. Lidah</p>
			<p>&nbsp;&nbsp; 2. Telinga &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5. Gigi</p>
			<p>&nbsp;&nbsp; 3. Hidung &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6. Tenggorokan</p>
			<p>&nbsp;</p>
			<p>b. Adakah kelainan-kelainan pada leher, misalnya </p>
			<p>&nbsp;&nbsp; gejala – gejala Basedow atau struma ? ?</p>
			<p>&nbsp;</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>1 ........................................</p>
			<p>2 ........................................</p>
			<p>3 ........................................</p>
			<p>4 ........................................</p>
			<p>5 ........................................</p>
			<p>6 ........................................</p>
			<p>..........................................</p>
			<p>..........................................</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box float-left">
			<h5>5. KERANGKA OTOT DAN URAT SYARAF</h5>
 
			<p>a. Bagaimana keadaan kerangka, otot dan gizinya ? </p>
			<p>&nbsp;</p>
			<p>b. Adakah persangkaan penyakit pada otak</p>
			<p>&nbsp;&nbsp; , spinal dan urat syaraf ?  </p>
			<p>c. Bagaimanakah reflek - reflek lutut, A-chili, perut </p>
			<p>&nbsp;&nbsp; ,cremaster Babinski ?</p>
			<p>d. Adakah tanda – tanda kelainan Neurologik misalnya </p>
			<p>&nbsp;&nbsp; tremor, paralyse, dll ?</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box float-left">
			<h5>6. RONGGA DADA DAN PARU-PARU</h5>
 
			<p>a. Adakah kelainan pada bentuk rongga dada ? </p>
			<p>&nbsp;</p>
			<p>b. Adakah pernapasan symetris dan teratur ? </p>
			<p>&nbsp;</p>
			<p>c. Adakah kelainan pada perkussi dan Auskultasi ? </p>
			<p>&nbsp;</p>
			<p>d. Adakah calon Astmatis ? </p>
			<p>&nbsp;</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box float-left">
			<h5>7. SIRKULASI DARAH</h5>
 
			<p>a. Tekanan darah : - Systolic </p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Diastolik</p>
			<p>&nbsp;&nbsp; Pengukuran diulangi sesudah 5 menit, jika tekanan </p>
			<p>&nbsp;&nbsp; Darah lebih dari 140/90 </p>
			<p>&nbsp;</p>
			<p>b. nadi </p>
			<p><div class="garis"></div></p>
			<p>&nbsp;</p>
			<p><div class="garis"></div></p>
			<p>&nbsp;&nbsp; istarahat</p>
			<p><div class="garis"></div></p>
			<p>&nbsp;&nbsp; Rata-rata per menit </p>
			<p><div class="garis"></div></p>
			<p>Extra Sytole</p>
			<p>&nbsp;</p>
			<p>c. Adakah tanda – tanda peripheral vascular disease ? </p>
			<p>&nbsp;</p>
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
 
			<p>&nbsp; </p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
			<p>&nbsp;&nbsp; </p>
			<p>&nbsp;&nbsp; </p>
			<p>&nbsp;</p>
			<p>&nbsp; </p>
			<p><div class="garis"></div></p>
			<p>&nbsp;</p>
			<p><div class="garis"></div></p>
			<p>TekukLutut 10 x &nbsp;&nbsp;&nbsp; 5 menitkemudian</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><div class="garis-putus"></div></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p><div class="garis-putus"></div></p>
			<p>&nbsp;</p>
		</div>
		<div class="clear"></div> 
		<br><br><br><br><br><br><br><br><br>
		<div class="border-box float-left">
			<h5>8. JANTUNG</h5>
 
			<p>a. Dimanakah ictus cordis dada diraba ? </p>
			<p>&nbsp;</p>
			<p>b. Tentukan batas – batas jantung ? </p>
			<p>&nbsp;</p>
			<p>c. Adakah tanda – tanda pembesaran jantung ?  </p>
			<p>&nbsp;</p>
			<p>d. Adakah tanda – tanda dari dekompensasikordis ? </p>
			<p>&nbsp;</p>
			<p>e. Adakah murmur atau bunyi – bunyi jantung yang </p>
			<p>&nbsp;&nbsp; tidak normal ? </p>
			<p>f. Kalau ada, isi pertanyaan no. 9 </p>
			<p>&nbsp;</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			<p>..........................................</p>
			<p>&nbsp;</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box">
			<h5>9. TEMPAT DIDENGARNYA</h5>
			<table style="width: 100%">
				<tr>
					<td style="width: 20%">Waktu</td>
					<td style="width: 20%">...................</td>
					<td style="width: 15%">Intensity</td>
					<td style="width: 20%">...................</td>
					<td style="width: 15%">Quality</td>
					<td style="width: 20%">...................</td>
				</tr>
				<tr>
					<td style="width: 20%">a. Systolik</td>
					<td style="width: 20%"><input type="text" style="height: 10px;width: 100%;" name=""></td>
					<td style="width: 15%">- Lemah</td>
					<td style="width: 20%"><input type="text" style="height: 10px;width: 100%;" name=""></td>
					<td style="width: 15%">- Grade 1-2</td>
					<td style="width: 20%"><input type="text" style="height: 10px;width: 100%;" name=""></td>
				</tr>
			</table>
			<p>Transmisike : .........................................</p>
			<p>Apakah Diagnosa saudara ? .........................................</p>
		</div>
		<div class="border-box float-left">
			<h5>10. PERUT DAN ALAT-ALAT RONGGA PERUT</h5>
			<p>a. Bagaimanakah keadaan dinding perut dan isi perut, </p>
			<p>&nbsp;&nbsp; missal sakit ditekan ?</p>
			<p>b. Apakah hepar dan lien sehat ?</p>
			<p>&nbsp;&nbsp; Apakah nyeri tekan/lepas/pembesaran ?</p>
			<p>c. Apakah ada bekas – bekas operasi ?</p>
			<p>d. Adakah hernia, jelaskan !</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box float-left">
			<h5>11. ALAT-ALAT KELAMIN (URGENTALIS)</h5>
			<p>a. Bagaimana keadaan ginjal ? </p>
			<p>b. Adakah tanda - tanda syphilis gonorhoe ? </p>
			<p>c. Adakah tanda - tanda stricture atau kencing batu ?</p>
			<p>d. Adakah pembesaran prostat kelenjar-kelenjar lain ?</p>
			<p>e. Hasil pemeriksaan kemih ( harus dikeluarkan pada</p>
			<p>&nbsp;&nbsp; waktu pemeriksaan )</p>
			<p>&nbsp;&nbsp; - Berat Jenis : ......................</p>
			<p>&nbsp;&nbsp; - Warna : ......................</p>
			<p>&nbsp;&nbsp; - Reaksi : ......................</p>
			<p>&nbsp;</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>&nbsp;&nbsp; - Zat Gula :</p>
			<p>........................................</p>
			<p>&nbsp;&nbsp; - Albumin/protein :</p>
			<p>........................................</p>
			<p>&nbsp;&nbsp; - Kristal :</p>
			<p>........................................</p>
			
		</div>
		<div class="clear"></div> 
		<br><br><br><br>
		<div class="border-box float-left">
			<h5>12. KHUSUS WANITA</h5>
			<p>a. Apakah calon pernah/sedang menderita kelainan- </p>
			<p>&nbsp;&nbsp; kelainan pada peranakan/payudara ?</p>
			<p>b. Adakah kelainan – kelainan dalam kehamilan</p>
			<p>&nbsp;&nbsp;  dan menstruasi ? </p>
			<p>c. Apakah calon saat ini hamil ?</p>
			<p>d. Kalau ya , bulan keberapa ?</p>
			<p>e. Kapan terakhir bersalin ?</p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box float-left">
			<h5>13. KESIMPULAN</h5>
			<p>a. Berdasarkan pemeriksaan saudara, apakah anda </p>
			<p>&nbsp;&nbsp; menganjurkan suatu pemeriksaan</p>
			<p>&nbsp;&nbsp; tambahan atau laporan tambahan ?</p>
			<p>b. Bagaimana pendapat Saudara tentang kemungkinan</p>
			<p>&nbsp;&nbsp;  hidup calon berdasarkan kesehatan  </p>
			<p>&nbsp;&nbsp;  sekarang? ( baik, sedang, buruk ) </p>
			
		</div>
		<div class="border-box float-left">
			<h5>&nbsp;</h5>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			<p>........................................</p>
			
		</div>
		<div class="clear"></div> 
		<div class="border-box">
			<table style="width: 100%">
				<tr>
					<td style="width: 60px;">PANDANGAN DOKTER PENASEHAT : </td>
					<td style="width: 40px;">....................................................... </td>
				</tr>
				<tr>
					<td style="width: 60px;">&nbsp; </td> 
					<td style="width: 40px;">....................................................... </td>
				</tr>
			</table>
			<table style="width: 100%">
				<tr>
					<td style="width: 50%;">&nbsp;</td>
					<td align="center" style="width: 50%;">TANDA TANGAN DOKTER PEMERIKSA</td>
				</tr>
				<tr>
					<td colspan="2">Dr. Penasehat</td>
				</tr>
				<tr>
					<td colspan="2">Nama : ..........................</td>
				</tr>
				<tr>
					<td colspan="2">Alamat : ..........................</td>
				</tr>
				<tr>
					<td colspan="2">NB : Hasil pemeriksaan ini dikirim kepada Dr. Penasehat dalam sampul tertutup</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>