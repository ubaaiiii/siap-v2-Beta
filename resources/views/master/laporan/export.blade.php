@extends('layouts.app')

    @section('content')
<main class="h-100 has-header">

        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-light back-btn" >
                        <i class="bi bi-arrow-left"> </i>Cancel
                    </button>
                </div>
                <div class="col align-self-center text-center">
                    <h5>{{$stitle}}</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ url('notification') }}" target="_self" class="btn btn-light btn-44">
                        <i class="bi bi-bell"></i>
                        <span class="count-indicator"></span>
                    </a>
                </div>
            </div>
        </header>
        <!-- Header ends -->

        <!-- main page content -->
        <div class="main-container container">

            <!-- user information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-50 shadow rounded-10 text-white" style="background-color: #E73712;">
                                EKS
                            </figure>
                        </div>
                        <div class="col px-0 align-self-center">
                            <h3 class="mb-0 text-color-theme">{{$stitle}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted ">
                            <table style='border-left: 5px solid red;'>
                                   <tr><td> &nbsp; Periode</td><td>:</td><td>{{ $tgl1 .' s/d '. $tgl2 }}</td></tr>
                                   <tr><td> &nbsp; Asuransi</td><td>:</td><td>{{ $asuransi }}</td></tr>
                                   <tr><td> &nbsp; Produk</td><td>:</td><td>{{ $produk }}</td></tr>
                                   <tr><td> &nbsp; Cabang</td><td>:</td><td>{{ $cabang }}</td></tr>
                            </table>
                    </p>
                    <div class="table-responsive">
                     <table id="allData" class="table nowrap" style="width: 100%">
                     <thead>
                            <tr>
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
                     </div>
              </div>
            </div>
            <!-- profile information -->
            <!-- <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div> -->
            

 
        <!-- </div> -->
        <!-- main page content ends -->

    </main>
    @endsection
    @section('style')
    <!-- <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    @endsection
    
    @section('script')
    <script>
        $(function() {
            $('#allData').DataTable({
                     dom: 'Bfrtip',
                     buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5'
                     ]
            });
        });

       
    </script>
    
    <script>
       //     $(document).ready(function() {
       //            document.title = '{{ $stitle}}';
       //            $('#judul').html('{{ $stitle}}');
       //            $('#table-export').DataTable({
       //                   dom: 'Bfrtip',
       //                   buttons: [
       //                          'copyHtml5',
       //                          'excelHtml5',
       //                          'csvHtml5'
       //                      ]
       //               });
       //        })
       </script>
       @endsection





