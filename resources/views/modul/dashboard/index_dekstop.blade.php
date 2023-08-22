@extends('layouts.app')

    @section('content')
    <main class="h-100">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <div class="logo-small">
                        <img src="{{ asset(config('app.logo', 'assets/img/logo.png')) }}" alt="">
                        <h5>{{ config('app.title', 'SIAPLAKU') }}</h5>
                    </div>
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
            <!-- wallet balance -->
            <div class="row mb-4">
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Approve</p>
                                    <p>{{ $query[0]->s1}}<span class="small"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Verifikasi</p>
                                    <p>{{ $query[0]->s2}}<span class="small"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Validasi</p>
                                    <p>{{ $query[0]->s3}}<span class="small"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Sertifikat</p>
                                    <p>{{ $query[0]->s4}}<span class="small"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Realisasi</p>
                                    <p>{{ $query[0]->s5}}<span class="small"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 col-md-2 col-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressone"></div>
                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                            <i class="bi bi-globe"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <p class="small mb-1 text-muted">Paid</p>
                                    <p>{{ $query[0]->s6}}<span class="small"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <!-- calendar -->
                            <div class="row">
                                <div class="col position-relative align-self-center">
                                    <input type="text" placeholder="Select date range" readonly="readonly"
                                        id="daterange" class="calendar-daterange" />
                                    <h6 class="mb-1">Grafik Premi Dan Claim</h6>
                                    <!-- <p class="small text-muted textdate">1/8/2024 - 7/8/2024</p> -->
                                </div>
                                <!-- <div class="col-auto align-self-center">
                                    <button class="btn btn-light btn-44 daterange-btn">
                                        <i class="bi bi-calendar-range size-22"></i>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body px-2">
                            <canvas id="myChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main page content ends -->

    </main>

    <!-- <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Record</h4>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4" >Name Area : </label>
                        <div class="col-md-12">
                        <input type="text" name="namearea" id="namearea" autocomplete="true" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Note Area : </label>
                        <div class="col-md-12">
                        <input type="text" name="notearea" id="notearea" autocomplete="true" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Prefix Area : </label>
                        <div class="col-md-12">
                        <input type="text" name="prefixarea" id="prefixarea" autocomplete="true" class="form-control" />
                        </div>
                    </div>
                <br />
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-primary btn-block" value="Simpan" />
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
         </form>
        </div>
     </div>
    </div> -->
</div>
<!-- <div id="confirmModal" class="modal hide fade in" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
                <button type="button" class="btn btn-warning"  data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div> -->


    @endsection
    @section('script')
    <script>
        var ctx1 = document.getElementById("myChart1").getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($label); ?>,
                  datasets: [{
                    label: 'My First Dataset',
                    data: <?php echo json_encode($datapremi[0]); ?>,
                    backgroundColor: [
                      'rgb(255, 99, 132)',
                      'rgb(54, 162, 235)',
                      'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            }
        }); 
    </script>
    <script>
        $(function() {
            $('#allData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                  url: '{{ url("/bordero/desktop")}}',
                  data: function (d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    {
                        data: 'borderono',
                        name: 'borderono'
                    },
                    {
                        data: 'reffdt',
                        name: 'reffdt'
                    },
                    {
                        data: 'period1',
                        name: 'period1'
                    },
                    {
                        data: 'period2',
                        name: 'period2'
                    },
                    {
                        data: 'asuransi',
                        name: 'asuransi'
                    },
                    {
                        data: 'produk',
                        name: 'produk'
                    },
                    {
                        data: 'reffamt',
                        name: 'reffamt',
                    },
                ]
            });
        });

       
    </script>
    
    
    @endsection