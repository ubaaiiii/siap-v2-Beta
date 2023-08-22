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
		td{
			font-size: 14px;
			padding: 0px 5px !important ;
			margin: 0;
		}
	</style>
</head>
<body>
	<div class="page">
		
		<div class="kop">
			<table class="kop" width="100%"> 
				<tr>
					<td style="width: 10%">
						<img src="{{ url('assets/img/logo/logoinv.jpg') }}" class="logo" style="width: 10rem">
					</td>
					<th style="width: 50%">
						<center> 
							<h3>PREMIUM NOTES</h3>
						</center>
					</th>
					<td align="right" style="width: 40%"><b><?= ' No Nota  :  ' . $bill[0]->billno; ?></b> <br> <b><?= ' Tgl/Date : ' . $bill[0]->billdt; ?> </b></td>
				</tr>
			</table>
		</div>
		<div class="garis">
			<hr class="line1" />
			<hr class="line2" />
		</div>
		<table>
			<tr>
				<td class="cel1">Kepada</td>
				<td class="cel3"> <?= $transaction[0]->sclientname; ?> </td>
			</tr>
			<tr>
				<td> To </td>
				<td><?= ' : $transaction[0]->address1 $transaction[0]->address2 $transaction[0]->address3'; ?></td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> No Register <br> Register No </td>
				<td><?= ' : ' .  $transaction[0]->regid; ?></td>
				
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> No Sertifikat <br> Certificate No </td>
				<td><?= ' : ' .  $transaction[0]->policyno .  $transaction[0]->reffno; ?></td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> Nama Tertanggung <br> Name of Insured </td>
				<td><?= ' : ' . $transaction[0]->clientname; ?></td>
				
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> Jenis Asuransi <br>Class of business </td>
				<td><?= ' : ' . $transaction[0]->instype; ?></td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> Jangka waktu </td>
				<td><?= ' : ' . $transaction[0]->masa . ' bulan / ' . $transaction[0]->mulai . ' sd ' . $transaction[0]->akhir; ?></td>
			</tr>
			<tr>
				<td> Period </td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> Objeck Asuransi <br> Interest Insured </td>
				<td><?= ' : ' . $transaction[0]->object; ?></td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> Uang Pertanggungan <br> Sum Insured </td>
				<td><?= ' : ' . number_format($transaction[0]->up, 0); ?></td>
			</tr>
		</table><br>
		<table class="table_new" style="width:95%">
			<tr>
				<td style="width:35%"> <b> Catatan/Notes</b></td>
				<td style="width:30%" colspan="2"><b>Perincian/Detail</b></td>
			</tr>
			<tr>
				<td rowspan="13">
					<i>Jumlah tersebut dalam Nota Debet ini hendaknya segera 					dibayar untuk penyelesaian transaksi. <br>
				Harap pembayaran dilakukan dengan cheque silang (crossed cheque) atas nama  <br>
				PT. BINA DANA SEJAHTERA atau dipindahbukukan pada rekening giro  <br> 					
				di salah satu Bank berikut ini :<br> 					
				Please pay the amount shown in this Debit Note immediately to finalize the transaction. <br> 					
				Payment should be made with a crossed cheque in the name <br> 					
				PT. BINA DANA SEJAHTERA or transferred to our current account  <br> 					
				with one of  the following bank : 
				<br> <br> <br>					- Bank Bukopin Cabang S. Parman Acc. No. 100.1409.430 - IDR<br> <br> <br> <br>	 </i>
				</td>
				<td>Premi : </td>
				<td rowspan="2"><?= number_format($transaction[0]->grossamt, 0); ?></td>
			</tr>
			<tr>
				<td>Premium</td>
			</tr>
			<tr>
				<td>Premi Tambahan : </td>
				<td rowspan="2"><?= number_format($transaction[0]->discamt, 0); ?></td>
			</tr>
			<tr>
				<td>Extra Premium</td>
			</tr>
			<tr>
				<td>Biaya Polis : </td>
				<td rowspan="2"><?= number_format($transaction[0]->discamt, 0); ?></td>
			</tr>
			<tr>
				<td>Policy Cost</td>
			</tr>
			<tr>
				<td>Biaya Meterai : </td>
				<td rowspan="2"><?= number_format($transaction[0]->discamt, 0); ?></td>
			</tr>
			<tr>
				<td>Duty Cost</td>
			</tr>
			<tr>
				<td>+/- : </td>
				<td rowspan="2"><?= number_format($transaction[0]->discamt, 0); ?></td>
			</tr>
			<tr>
				<td>+/- : </td>
			</tr>
			<tr>
				<td>Jumlah : </td>
				<td rowspan="2"><?= number_format($transaction[0]->totalamt, 0); ?></td>
			</tr>
			<tr>
				<td>Total</td>
			</tr>
			<tr>
				<td colspan="2">PT. BINA DANA SEJAHTERA </td>
			</tr>
		</table>
		<br>
		<table>
			<tr>
				<td>Nota Debet ini bukan merupakan tanda bukti pembayaran.</td>
			</tr>
			<tr>
				<td>This Debit Note is not a receipt.</td>
			</tr>
		</table>
	</div>
	<br><br><br>
	<footer>
		<em>Printed <?= date("d-m-Y H:i:s"); ?></em>
	</footer>
</body>
</html>