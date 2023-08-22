<style>
       /*-------------------------------*/
       .lds-facebook {
              display: inline-block;
              position: absolute;
              z-index: 1;
              left: 50%;
              top: 50%;
              width: 80px;
              height: 80px;
       }
       .lds-facebook div {
              display: inline-block;
              position: absolute;
              left: 8px;
              width: 16px;
              background: #3691ED;
              animation: lds-facebook 0.5s cubic-bezier(0, 0.5, 0.5, 1) infinite;
       }
       .lds-facebook div:nth-child(1) {
              left: 8px;
              animation-delay: -0.24s;
       }
       .lds-facebook div:nth-child(2) {
              left: 32px;
              animation-delay: -0.12s;
       }
       .lds-facebook div:nth-child(3) {
              left: 56px;
              animation-delay: 0;
       }
       @keyframes lds-facebook {
              0% {
                     top: 8px;
                     height: 64px;
              }
              50%,
              100% {
                     top: 24px;
                     height: 32px;
              }
       }
</style>
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<h3 id='judul'>{{$stitle}}</h3>
<table style='border-left: 5px solid red;'>
  <tr><td>Periode</td><td>:</td><td>{{ $tgl1 .' s/d '. $tgl2 }}</td></tr>
  <tr><td>Asuransi</td><td>:</td><td>{{ $asuransi }}</td></tr>
  <tr><td>Produk</td><td>:</td><td>{{ $produk }}</td></tr>
  <tr><td>Cabang</td><td>:</td><td>{{ $cabang }}</td></tr>
</table>

<table class='display' id='table-export'>
    <thead>
      <tr style='white-space: nowrap;'>
        <th>Produk</th>
        <th>No Register</th>
        <th>No Pinjaman</th>
        <th>Nama</th>
        <th>No KTP</th>
        <th>Jkel</th>
        <th>Pekerjaan</th>
        <th>Cabang</th>
        <th>Tgl Lahir</th>
        <th>Mulai</th>
        <th>Akhir</th>
        <th>Masa</th>
        <th>Grace Period</th>
        <th>Up</th>
        <th>Premi</th>
        <th>Asuransi</th>
        <th>Status</th>
        <th>Nama AO</th>
        <th>Username AO</th>
        <th>Tgl Input</th>
      </tr>
    </thead>
    <tbody>
      @foreach($export as $item)
        <tr>
          <td>{{ $item->Produk }}</td>
          <td>{{ $item->No_Register }}</td>
          <td>{{ $item->No_Pinjaman }}</td>
          <td>{{ $item->Nama }}</td>
          <td>{{ $item->No_KTP }}</td>
          <td>{{ $item->Jkel }}</td>
          <td>{{ $item->Pekerjaan }}</td>
          <td>{{ $item->Cabang }}</td>
          <td>{{ $item->Tgl_Lahir }}</td>
          <td>{{ $item->Mulai }}</td>
          <td>{{ $item->Akhir }}</td>
          <td>{{ $item->Masa }}</td>
          <td>{{ $item->Graceperiod }}</td>
          <td>{{ $item->UP }}</td>
          <td>{{ $item->Premi }}</td>
          <td>{{ $item->Asuransi }}</td>
          <td>{{ $item->Status }}</td>
          <td>{{ $item->Nama_AO }}</td>
          <td>{{ $item->Username_AO }}</td>
          <td>{{ $item->Tgl_Input }}</td>
        </tr>
      @endforeach
    </tbody>


<script>
       $(document).ready(function() {
              document.title = '{{ $stitle}}';
              $('#judul').html('{{ $stitle}}');
              $('#table-export').DataTable({
                     dom: 'Bfrtip',
                     buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5'
                     ]
              });
       })
</script>