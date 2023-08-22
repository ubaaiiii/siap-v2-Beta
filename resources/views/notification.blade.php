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
                    <h5>Notification</h5>
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
        <div class="main-container container pt-0">
            <!-- notification list -->
            <div class="row">
                <div class="col-12 px-0">
                    <div class="list-group list-group-flush bg-none">
                        <div class="list-group-item bg-light text-center py-2 text-mute">NOTIFICATION</div>
                        @foreach($notif as $item)
                        <?php   
                            $msg = explode('|',$item->pesan);
                        ?>
                        <a class="list-group-item bg-white">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-44 coverimg rounded-10">
                                        <img src="assets/img/user3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-1"><b>{{$msg[0]}}</b> {{$msg[1]}}</p>
                                    <p class="size-12 text-muted">{{$msg[2]}}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
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
    
       @endsection


