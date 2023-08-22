<html>
	<head>
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
			display: block;
			width: 10000px !important;
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
	<body>
		<div class="page">
			<!-- <div class="kops">
		</div>
		<div class="garis">
			<hr class="line1"/>
			<hr class="line2"/>
		</div> -->
			<div class="judul">
				<b></b><br>
				<b style="font-size:16px">PERSETUJUAN PENERIMAAN KEPESERTAAN ASURANSI KREDIT</b><br>
			</div>
			<p class="space"></p>
			<div>
				<p style="font-size:13px;">
				    <br>
				    <br>
				    Bersama ini kami sampaikan persetujuan penerimaan kepesertaan asuransi kredit dengan data sebagai berikut:<br>
				</p>
			</div>
			<br>
			<table class="table_new" style="width:100%">
			
				<!--<tr>-->
				<!--	<td style="width: 40%">Jenis Produk Asuransi </td><td  style="width: 50%"><?= $transaction[0]->prodname; ?></td>-->
				<!--</tr>-->
				<tr>
					<td style="width: 40%">No Register </td><td  style="width: 50%"><?= $transaction[0]->regid; ?></td>
				</tr>
				<!--<tr>-->
				<!--	<td style="width: 40%">No Pinjaman </td><td  style="width: 50%"><?= $transaction[0]->nopeserta; ?></td>-->
				<!--</tr>-->
				<tr>
					<td style="width: 40%">No KTP </td><td  style="width: 50%"><?= $transaction[0]->noktp; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Nama Peserta / Debitur </td><td  style="width: 50%"><?= $transaction[0]->nama; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Jenis Kelamin </td><td  style="width: 50%"><?= $transaction[0]->jkeldesc; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Tempat / Tanggal Lahir </td><td  style="width: 50%"><?= $transaction[0]->tempat_lahir." / ".$transaction[0]->tgllahir; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Alamat </td><td  style="width: 50%"><?= $transaction[0]->alamat; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Pekerjaan</td><td  style="width: 50%"><?= $transaction[0]->kerja; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Cabang</td><td  style="width: 50%"><?= $transaction[0]->scab; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Mulai Asuransi</td><td  style="width: 50%"><?= $transaction[0]->mulai; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Akhir Asuransi</td><td  style="width: 50%"><?= $transaction[0]->akhir; ?></td>
				</tr>
								<tr>
					<td style="width: 40%">Masa Asuransi (bulan)</td><td  style="width: 50%"><?= $transaction[0]->masa . ' Bulan / '. number_format((int) $transaction[0]->masa / 12, 2, ',', '') ." Tahun"; ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Uang Pertanggungan</td><td  style="width: 50%">Rp. <?= number_format($transaction[0]->up,0); ?></td>
				</tr>
				<tr>
					<td style="width: 40%">Premi</td><td  style="width: 50%">Rp. <?= number_format($transaction[0]->premi,0); ?></td>
				</tr>
			</table>
			<div class="info">
				<p class="space"></p>
				<!--<p align="justify">-->
				<!--    Kami harap data yang kami sampaikan dapat diterima dan digunakan dengan sebaik-baiknya.<br>-->
				<!--    Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.-->
				<!--</p>-->
				<p class="space"></p>
				<p class="space"></p>
				<p align="justify">
				    Hormat kami,<br><br>
				</p>
				<table>
				    <tr>
				        <td><b style="font-size:14px"><?= $transaction[0]->nmasuransi;?></b></td>
				    </tr>
				    <tr>
				        <td align="center"><img src="{{ url('assets/img/ttd.png') }}" style="width:80;height:80px;"></td>
				    </tr>
				    <tr>
				        <td align="center"><?= $transaction[0]->pic; ?></td>
				    </tr>
				    <tr>
				        <td><hr style="height:1px;color:black"></td>
				    </tr>
				    <tr>
				        <td align="center"><?= $transaction[0]->picjabat; ?></td>
				    </tr>
				</table>
			</div>
		</div><br><br><br>
		<page_footer>
			<div class="" style="font-size:10px">
				Dicetak secara otomatis dari <a href="https://siap-laku.com/bank">SIAP</a> pada <?= date("d-m-Y H:i:s"); ?>
			</div>
		</page_footer>
	</body>
</html>