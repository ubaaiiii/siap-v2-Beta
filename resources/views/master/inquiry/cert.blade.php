<!doctype html>
<?php 
function tglindo_balik($tgl){
        $tanggal = substr($tgl,8,2);
        $bulan =  substr($tgl,5,2);
        $tahun = substr($tgl,0,4);
        return $tanggal.'-'.$bulan.'-'.$tahun;       
}
?>
<html>
	<head>
		<link rel="shortcut icon" href="../img/laporan.png">
		<link rel="stylesheet" type="text/css" href="{{ url('assets/css/laporan.css')}}">
		<style>
		table{
			font-size: 11px;
		}
		.logo{
			width:180px;
			/*padding: 50px 50px 50px 50px;*/
			margin: 30px 50px 10px 10px;
		}
		.judul_kop{
			text-align:center;
			font-size: 18px;
			position: relative;
			padding: 0px;
			margin: 0px;
			/*display: block;
			width: 10000px !important;*/
		}
		.judul_kop_rl{
			width: 25% !important;
		}
		.kop{
			border-collpase:collapse;
		}
		.kop .header{
			width:130px;
		}
		.kop .judul{
			text-align:center;
		}
		.kop table{
			text-align:left;
			border-collpase:collapse;
		}
		.kop table .cel1{
			width:200px;
		}
		.kop table .cel2{
			width:170px;
		}
		.kop table .cel3{
			width:170px;
		}
		.kop table td{
			font-size:11px;
		}
		.garis{
			line-height:1.5px;
		}
		.garis .line1{
			border:1px solid #000;
		}
		.garis .line2{
			border:0.5px solid #000;
		}
		.tbl_lap1{
			margin:20px 0px;
		}
		.tbl_lap1 .cel1{
			width:180px;
		}
		.tbl_lap1 .cel2{
			width:200px;
		}
		.tbl_lap1 .cel3{
			width:290px;
		}
		.judul{
			text-align:center;
		}
		.tbl_lap2{
			border-collapse:collapse;
			border:1px solid #000;
		}
		.tbl_lap2 .cel1{
			width:20px;
		}
		.tbl_lap2 .cel2{
			width:200px;
		}
		.tbl_lap2 .cel3{
			width:400px;
		}
		.tbl_lap2 td{
			padding:5px 2px;
		}
		.space{
			padding:10px;
		}
		.tbl_lap3 .cel1{
			width:300px;
		}
		.tbl_lap3 .cel2{
			width:100px;
		}
		.tbl_lap3 .cel3{
			width:300px;
		}
		.table_new{
			border-collapse: collapse;
		}
		.table_new td{
			padding: 5px 5px 5px 5px;
		 }
		.table_new, .table_new th, .table_new td {
    		border: 1px solid black;
		}
		.table_new_nb{
			border-collapse: collapse;
		}
		.table_new_head{
			border-collapse: collapse;
		}
		.table_new_nb head{
			padding: 10px 5px 5px 0px;
		 }
		 .list_1 li{
			 list-style: lower-alpha;
		 }
		 .list_check {
			 list-style: square;
		 }
		 .catatan{
			 font-size: 11px;
			 width: 94%;
		 }
		 .info{
			 text-align: justify;
			 font-size: 11px;
		 }
		 .juduls{
			 font-size: 11px;
			 font-weight: bold;
		 }
		 .chlist{
			 font-size: 10px;
			 border-left: 1px solid #000;
			 border-right: 1px solid #000;
		 }
		</style>
	</head>
	<body style="margin: 5px;">
		<div class="page">
		<div>
			<table style="width: 100%;">
				<tr > 
					<td class="judul_kop_rl">
						<img src="{{ url('assets/img/logo.png') }}" class="logo" style="width:80;height:80px;">
					</td>
					<td class="judul_kop">
						<h2 align="center" style="position: relative;left: -5rem;"><?php if(isset($ms_insurance[0]->nmasuransi)) {$ms_insurance[0]->nmasuransi; } ?> </h2>
                        <h5 align="center" style="position: relative;left: -5rem;"><?php if(isset($ms_insurance[0]->alamat)) {echo $ms_insurance[0]->alamat; } ?></h5>
						<h5 align="center" style="position: relative;left: -5rem;"><?php if(isset($ms_insurance[0]->alamat1)) { echo $ms_insurance[0]->alamat1; } ?> /h5>
						<h5 align="center" style="position: relative;left: -5rem;"><?php if(isset($ms_insurance[0]->phone2)) { echo $ms_insurance[0]->phone2. " " . $ms_insurance[0]->phone2; } ?></h5>
						<h5 align="center" style="position: relative;left: -5rem;"><?php if(isset($ms_insurance[0]->alamat)) {$ms_insurance[0]->alamat; } ?> </h5>
					</td> 
				</tr>
			</table>
		</div>
		<div class="garis">
			<hr class="line1"/>
			<hr class="line2"/>
		</div> 
			<div class="judul">
				<b></b><br>
				<b>SERTIFIKAT ASURANSI KREDIT</b><br>
			</div>
			<div class="juduls">
				<p align="center">No. <?php echo $transaction[0]->policyno; ?> </p> <br>
			</div>
			<div class="info">
				<p align="justify">Bahwa tertanggung / pemegang polis telah mengajukan suatu permohonan tertulis dan melakukan pembayaran premi yang menjadi dasar 
				dan merupakan bagian yang tidak terpisahkan dari Polis Induk Asuransi Kredit Multiguna. Penanggung akan memberikan manfaat asuransi berupa pembayaran
				sesuai jenis pertanggungan bilamana peserta tersebut mengalami kerugian yang diderita yang diakibatkan atas resiko yang dijamin dalam polis ini sesuai 
				nama yang tercantum dalam lampiran sertifikat ini. </p>
			</div>
			<br>
			<div class="juduls">
				<p align="center">INFORMASI NASABAH</p> <br>
			</div>
			<table class="table_new" style="width: 100%">
				<tr>
					<td style="width: 40%">Produk </td><td  style="width: 60%"><?php echo $transaction[0]->prodname; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">No Register </td><td  style="width: 60%"><?php echo $transaction[0]->regid; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">No Peserta </td><td  style="width: 60%"><?php echo $transaction[0]->nopeserta; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama Peserta </td><td  style="width: 60%"><?php echo $transaction[0]->nama; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Tanggal Lahir </td><td  style="width: 60%"><?php echo tglindo_balik($transaction[0]->tgllahir); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Jenis Kelamin </td><td  style="width: 60%"><?php echo $transaction[0]->jkeldesc; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">No KTP </td><td  style="width: 60%"><?php echo $transaction[0]->noktp; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Pekerjaan</td><td  style="width: 60%"><?php echo $transaction[0]->kerja; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mulai Asuransi</td><td  style="width: 60%"><?php echo tglindo_balik($transaction[0]->mulai); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Akhir Asuransi</td><td  style="width: 60%"><?php echo tglindo_balik($transaction[0]->akhir); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Masa Asuransi</td><td  style="width: 60%"><?php echo $transaction[0]->masa. ' Bulan' ; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Grace Period (Produk MPP)  </td><td  style="width: 60%"><?php echo $transaction[0]->tunggakan; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Jenis Pertanggungan </td><td  style="width: 60%"><?php echo "MENURUN"; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Resiko Yang Dijamin</td><td  style="width: 60%"><?php echo "MENINGGAL DUNIA"; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Uang Pertanggungan</td><td  style="width: 60%"><?php echo number_format($transaction[0]->up,0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Premi</td><td  style="width: 60%"><?php echo number_format($transaction[0]->premi,0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Account Officer</td><td  style="width: 60%"><?php echo $transaction[0]->aoname; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mitra</td><td  style="width: 60%"><?php echo $transaction[0]->smitra; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Cabang</td><td  style="width: 60%"><?php echo $transaction[0]->scab; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Tanggal Input</td><td  style="width: 60%"><?php echo $transaction[0]->createdt; ?></td>
				</tr>
				
			</table>
			<div class="info">
				<p class="space"></p>
				<p align="justify">Dalam hal peserta/debitur mengalami kerugian yang diderita atas resiko yang dijamin dalam polis ini 
				maka pemegang polis/peserta/debitur/ahli waris harus menyampaikan pemberitahuan secara tertulis kepada penanggung 
				dalam waktu  120x24 jam (4 Bulan). 
				Dokumen pendukung klaim diterima dalam waktu 180x24 jam (6 Bulan) setelah peserta mengalami resiko yang dijamin 
				dalam polis asuransi kredit multiguna. 
				</p>
				<p class="space"></p>
				<p class="space"></p>
			</div>
			<table width="100%">
				<tr>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;"></td>
					<td style="width: 18%"></td>
					<td style="width: 30%; text-align: center;">Polis asuransi ini di terbitkan pada <br><?= date_format(date_create($sqlLog[0]->tgl_approve),"d F Y H:i:s"); ?> </td>
				</tr>

				<tr>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;"></td>
					<td style="width: 18%"></td>
					<td style="width: 30%%; text-align: center;" >
						<img src="{{ url('assets/img/ttd.png') }}" style="width:200px;">
					</td>
				</tr>

				<tr>
					<td style="width: 18%;"></td>
					<td style="width: 30%; text-align: center;"></td>
					<td style="width: 18%"></td>
					<td style="width: 30%; text-align: center;"><?php if(isset($ms_insurance[0]->pic)) { echo $ms_insurance[0]->pic; } ?><br> ________________<br> <?php if(isset($ms_insurance[0]->phone2)) {  $ms_insurance[0]->picjabat; } ?> </td>
				</tr>
		</table>
		</div>
		<page_footer>
			<div class="" style="font-size:10px">
				Dicetak secara otomatis pada system pada <?php echo date("d F Y H:i:s"); ?>
			</div>
		</page_footer>
	</body>
</html>