@extends('layouts.app')
    @php
        $dashboard->pending     = ($dashboard->pending == null) ? 0 : $dashboard->pending;
        $dashboard->verif       = ($dashboard->verif == null) ? 0 : $dashboard->verif;
        $dashboard->realisasi   = ($dashboard->realisasi == null) ? 0 : $dashboard->realisasi;
        $dashboard->approve     = ($dashboard->approve == null) ? 0 : $dashboard->approve;
        $dashboard->approved    = ($dashboard->approved == null) ? 0 : $dashboard->approved;
        $dashboard->active      = ($dashboard->active == null) ? 0 : $dashboard->active;
        $dashboard->validasi    = ($dashboard->validasi == null) ? 0 : $dashboard->validasi;
    @endphp
    @section('content')
    <!-- Begin page -->
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
            <!-- welcome user -->
            <div class="row mb-4">
                <div class="col-auto">
                    <div class="avatar avatar-50 shadow rounded-10">
                        <img src="https://cdn-icons-png.flaticon.com/512/3237/3237472.png" alt="">
                    </div>
                </div>
                <div class="col align-self-center ps-0">
                    <h4 class="text-color-theme"><span class="fw-normal">Hai</span>, {{ $session->nama }}</h4>
                    @php
                        $time = date("H") + 7;
                        /* Set the $timezone variable to become the current timezone */
                        $timezone = date("e");
                        /* If the time is less than 11:00 hours, show good morning */
                        if ($time < "11") {
                            $day = "Pagi";
                        } else
                        /* If the time is grater than or equal to 11:00 hours, but less than 15:00 hours, so good afternoon */
                        if ($time >= "11" && $time < "15") {
                            $day = "Siang";
                        } else
                        /* Should the time be between or equal to 15:00 and 19:00 hours, show good evening */
                        if ($time >= "15" && $time < "19") {
                            $day = "Sore";
                        } else
                        /* Finally, show good night if the time is greater than or equal to 19:00 hours */
                        if ($time >= "19") {
                            $day = "Malam";
                        }
                    @endphp
                    <p class="text-muted">Selamat {{ $day }}</p>
                </div>
            </div>
            <!-- money request received -->
            {{-- <div class="row mb-4 hideonprogress">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-44 shadow-sm rounded-10">
                                        <img src="{{ asset('assets/img/user3.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="small mb-1"><a href="profile.html" class="fw-medium">SIAPMITRA</a> <span
                                            class="text-muted">Info</span></p>
                                    <p>News <span class="text-muted">$</span> <small class="text-muted">info terkini</small>
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-44 btn-default shadow-sm">
                                        <i class="bi bi-arrow-up-right-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-12">
                                <div class="progress bg-none h-2 hideonprogressbar" data-target="hideonprogress">
                                    <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- swiper credit cards -->
            <!-- Dark mode switch -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input class="form-check-input darkmodeswitch" type="checkbox" id="darkmodeswitch">
                                <label class="form-check-label text-muted px-2 " for="darkmodeswitch">Aktifkan Dark Mode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('.darkmodeswitch').click(function(e){
                        if ($('html').attr('class') == undefined) {
                            $('html').addClass('light-mode');
                        }
                        $.ajax({
                            url     : "{{ url('admin/ganti_sesi') }}",
                            type    : "POST",
                            data    : [
                                'class' : $('html').attr('class')
                            ],
                            success : function(resp){
                                console.log('success', resp);
                            },
                            error   : function(resp){
                                console.log('error', resp);
                            },
                        });
                    });

                });
            </script>
            
            <!-- offers banner -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card theme-bg text-center">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <h1>Sistem Informasi Asuransi Perbankan</h1>
                                    <p class="size-12 text-muted">
                                        Solusi asuransi kredit 
                                    </p>
                                    <div class="tag border-dashed border-opac">
                                        Cepat Tepat Transparan 
                                    </div>
                                </div>
                                <div class="col-6 align-self-center ps-0">
                                    <img src="{{ asset('assets/img/offergraphics.png') }}" alt="" class="mw-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(!in_array($session->level, ['broker']))
                <!-- connection -->
                <div class="row mb-3">
                    <div class="col">
                        <h6 class="title">Kontak Broker</h6>
                    </div>
                    {{-- <div class="col-auto">
                        <a href="userlist.html" class="small">View all</a>
                    </div> --}}
                </div>
                <div class="row mb-3">
                    <div class="col-12 px-0">
                        <!-- swiper users connections -->
                        <div class="swiper-container connectionwiper">
                            <div class="swiper-wrapper">
                                @foreach($kontak as $kt)
                                    <div class="swiper-slide">
                                        <a href="https://wa.me/62{{ substr($kt->nohp,1) }}" target="_blank" class="card text-center">
                                            <div class="card-body">
                                                <figure class="avatar avatar-50 shadow-sm mb-1 rounded-10">
                                                    <img src="assets/img/{{ $kt->photo }}" alt="">
                                                </figure>
                                                <p class="text-color-theme size-12 small">{{ $kt->nama }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                {{-- <div class="swiper-slide">
                                    <a href="https://wa.me/6281224208914" target="_blank" class="card text-center">
                                        <div class="card-body">
                                            <figure class="avatar avatar-50 shadow-sm mb-1 rounded-10">
                                                <img src="assets/img/user2.jpg" alt="">
                                            </figure>
                                            <p class="text-color-theme size-12 small">Fauzyah</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="https://wa.me/628111200279" target="_blank" class="card text-center">
                                        <div class="card-body">
                                            <figure class="avatar avatar-50 shadow-sm mb-1 rounded-10">
                                                <img src="assets/img/user1.jpg" alt="">
                                            </figure>
                                            <p class="text-color-theme size-12 small">Ozzy</p>
                                        </div>
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- tabs structure -->
            <ul class="nav nav-pills nav-justified tabs mb-3" id="assetstabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ empty($_GET['q']) ? "active" : ( ($_GET['q'] == "dashboard") ? "active" : "" ) }}" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard"
                        type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ empty($_GET['q']) ? "" : ( ($_GET['q'] == "dashboard") ? "" : "active" ) }}" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics"
                        type="button" role="tab" aria-controls="statistics" aria-selected="false">Statistik</button>
                </li>
            </ul>
            <div class="tab-content" id="assetstabsContent">
                <div class="tab-pane fade {{ empty($_GET['q']) ? "show active" : ( ($_GET['q'] == "dashboard") ? "show active" : "" ) }}" id="dashboard" role="tabpanel" >
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="card shadow-sm mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto px-0">
                                                <div class="avatar avatar-40 bg-warning text-white shadow-sm rounded-10-end">
                                                    <i class="search bi bi-search" style="cursor: pointer" onclick="cari_inquiry()"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                {{-- <p class="text-muted size-12 mb-0">Cari Data</p> --}}
                                                <input type="text" class="form-control" required="" name="cari_data" placeholder="Cari data disini.."
                                                    id="cari_data">
                                            </div>
                                            <script>
                                                function cari_inquiry() {
                                                    var q = $('#cari_data').val();
                                                    window.location.href = "{{ url('inquiry?q=') }}" + q;
                                                }
                                                $(document).ready(function(){
                                                    $('#cari_data').on('keypress', function(e){
                                                        if (e.which=13) {
                                                            cari_inquiry();
                                                        }
                                                    })
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                @if(in_array($session->level, ['mkt','smkt','checker','schecker']))
                                    <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=pending') }}">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <div class="circle-small">
                                                            <div id="cp_pending"></div>
                                                            <div class="avatar avatar-30 alert-secondary text-secondary rounded-circle">
                                                                <i class="bi bi-globe"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto align-self-center ps-0">
                                                        <p class="small mb-1 text-muted">Pending</p>
                                                        <?= $dashboard->pending; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                @if(in_array($session->level, ['broker']))
                                    <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=realisasi') }}">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <div class="circle-small">
                                                            <div id="cp_realisasi"></div>
                                                            <div class="avatar avatar-30 alert-warning text-warning rounded-circle">
                                                                <i class="spinner-border"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto align-self-center ps-0">
                                                        <p class="small mb-1 text-muted">Realisasi</p>
                                                        <?= $dashboard->realisasi; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=approve') }}">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="circle-small">
                                                        <div id="cp_approve"></div>
                                                        <div class="avatar avatar-30 alert-warning text-warning rounded-circle">
                                                            <i class="bi bi-check2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto align-self-center ps-0">
                                                    <p class="small mb-1 text-muted">Approve</p>
                                                    <?= $dashboard->approve; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=verifikasi') }}">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="circle-small">
                                                        <div id="cp_verif"></div>
                                                        <div class="avatar avatar-30 alert-success text-success rounded-circle">
                                                            <i class="bi bi-clipboard-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto align-self-center ps-0">
                                                    <p class="small mb-1 text-muted">Verifikasi</p>
                                                    <?= $dashboard->verif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=approved') }}">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="circle-small">
                                                        <div id="cp_approved"></div>
                                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                                            <i class="bi bi-check2-circle"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto align-self-center ps-0">
                                                    <p class="small mb-1 text-muted">Approved</p>
                                                    <?= $dashboard->approved; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=active') }}">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="circle-small">
                                                        <div id="cp_active"></div>
                                                        <div class="avatar avatar-30 alert-danger text-danger rounded-circle">
                                                            <i class="bi bi-bookmark-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto align-self-center ps-0">
                                                    <p class="small mb-1 text-muted">Active</p>
                                                    <?= $dashboard->active; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=validasi') }}">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="circle-small">
                                                        <div id="cp_validasi"></div>
                                                        <div class="avatar avatar-30 alert-success text-success rounded-circle">
                                                            <i class="bi bi-patch-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto align-self-center ps-0">
                                                    <p class="small mb-1 text-muted">Validasi</p>
                                                    <?= $dashboard->validasi; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 col-lg-3" href="{{ url('inquiry?q=paid') }}">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="circle-small">
                                                        <div id="cp_paid"></div>
                                                        <div class="avatar avatar-30 alert-primary text-primary rounded-circle">
                                                            <i class="bi bi-shield-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto align-self-center ps-0">
                                                    <p class="small mb-1 text-muted">Paid</p>
                                                    <?= $dashboard->paid; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- <!-- Transactions -->
                    <div class="row mb-3">
                        <div class="col">
                            <h6 class="title">Pengajuan Terkahir</h6>
                        </div>                        
                    </div>
                    <div class="row mb-4">
                        <div class="col-12 px-0">
                            <ul class="list-group list-group-flush bg-none">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-50 shadow rounded-10 ">
                                                <img src="assets/img/company4.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <p class="text-color-theme mb-0">Zomato</p>
                                            <p class="text-muted size-12">Food</p>
                                        </div>
                                        <div class="col align-self-center text-end">
                                            <p class="mb-0">-25.00</p>
                                            <p class="text-muted size-12">Debit Card 4545</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-50 shadow rounded-10">
                                                <img src="assets/img/company5.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <p class="text-color-theme mb-0">Uber</p>
                                            <p class="text-muted size-12">Travel</p>
                                        </div>
                                        <div class="col align-self-center text-end">
                                            <p class="mb-0">-26.00</p>
                                            <p class="text-muted size-12">Debit Card 4545</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-50 shadow rounded-10">
                                                <img src="assets/img/company1.png" alt="">
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <p class="text-color-theme mb-0">Starbucks</p>
                                            <p class="text-muted size-12">Food</p>
                                        </div>
                                        <div class="col align-self-center text-end">
                                            <p class="mb-0">-18.00</p>
                                            <p class="text-muted size-12">Cash</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-50 shadow rounded-10">
                                                <img src="assets/img/company3.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <p class="text-color-theme mb-0">Walmart</p>
                                            <p class="text-muted size-12">Clothing</p>
                                        </div>
                                        <div class="col align-self-center text-end">
                                            <p class="mb-0">-105.00</p>
                                            <p class="text-muted size-12">Wallet</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="tab-pane fade {{ empty($_GET['q']) ? "" : ( ($_GET['q'] == "dashboard") ? "" : "show active" ) }}" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <canvas id="grafik"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Blogs -->
            <div class="row mb-3">
                
            </div>
            <div class="row">
                
            </div>
        </div>
        
    </main>
    <!-- Page ends-->
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                // var grafik = document.getElementById("grafik").getContext('2d');
                var speedCanvas = document.getElementById("grafik");
                // Chart.defaults.global.defaultFontFamily = "Lato";
                // Chart.defaults.global.defaultFontSize = 18;
                var dataFirst = {
                    label: "Premi",
                    data: [0, 59, 75, 20, 20, 55, 40],
                    lineTension: 0,
                    fill: false,
                    borderColor: 'red'
                };
                var dataSecond = {
                    label: "UP",
                    data: [20, 15, 60, 60, 65, 30, 70],
                    lineTension: 0,
                    fill: false,
                borderColor: 'blue'
                };
                var speedData = {
                labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
                datasets: [dataFirst, dataSecond]
                };
                var chartOptions = {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                    }
                }
                };
                var lineChart = new Chart(speedCanvas, {
                type: 'line',
                data: speedData,
                options: chartOptions
                });
                @if(in_array($session->level, ['broker']))
                    @foreach ($dashboard_broker as $dbro)
                        var chart_{{ $dbro->id_admin }} = document.getElementById('chart_{{ $dbro->id_admin }}').getContext('2d');
                        var chart_setting_{{ $dbro->id_admin }} = {
                            type: 'doughnut',
                            data: {
                                labels: ['Approval', 'Cancellation', 'Paid', 'Claim'],
                                datasets: [{
                                    label: '# of Votes',
                                    data: [{{ $dbro->approval }}, {{ $dbro->cancelation }}, {{ $dbro->paid }}, {{ $dbro->claim }}],
                                    backgroundColor: ['#FFBD17', '#3AC79B', '#F73563', '#092C9F'],
                                    borderWidth: 0,
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: false,
                                    title: false
                                }
                            }
                        }
                        var chartexe_{{ $dbro->id_admin }} = new Chart(chart_{{ $dbro->id_admin }}, chart_setting_{{ $dbro->id_admin }});
                        var CP_{{ $dbro->id_admin }} = new ProgressBar.Circle(cp_{{ $dbro->id_admin }}, {
                            color: '#5476E6',
                            // This has to be the same size as the maximum width to
                            // prevent clipping
                            strokeWidth: 10,
                            trailWidth: 10,
                            easing: 'easeInOut',
                            trailColor: '#E5EAFB',
                            duration: 1400,
                            text: {
                                autoStyleContainer: false
                            },
                            from: { color: '#5476E6', width: 10 },
                            to: { color: '#5476E6', width: 10 },
                            // Set default step function for all animate calls
                            step: function(state, circle) {
                                circle.path.setAttribute('stroke', state.color);
                                circle.path.setAttribute('stroke-width', state.width);
                                var value = Math.round(circle.value() * 100);
                                if (value === 0) {
                                    //  circle.setText('');
                                } else {
                                    // circle.setText(value + "<small>%<small>");
                                }
                            }
                        });
                        // progressCircles2.text.style.fontSize = '20px';
                        CP_{{ $dbro->id_admin }}.animate({{ ($dbro->keseluruhan > 0) ? round($dbro->keseluruhan/$total,2) : 0 }}); // Number from 0.0 to 1.0
                    @endforeach
                @endif
                // Circle Pending
                @if(in_array($session->level, ['mkt','smkt','checker','schecker']))
                    var CP_pending = new ProgressBar.Circle(cp_pending, {
                        color: '#6C757D',
                        // This has to be the same size as the maximum width to
                        // prevent clipping
                        strokeWidth: 10,
                        trailWidth: 10,
                        easing: 'easeInOut',
                        trailColor: '#E2E3E5',
                        duration: 1400,
                        text: {
                            autoStyleContainer: false
                        },
                        from: { color: '#6C757D', width: 10 },
                        to: { color: '#6C757D', width: 10 },
                        // Set default step function for all animate calls
                        step: function(state, circle) {
                            circle.path.setAttribute('stroke', state.color);
                            circle.path.setAttribute('stroke-width', state.width);
                            var value = Math.round(circle.value() * 100);
                            if (value === 0) {
                                // circle.setText('');
                            } else {
                                //  circle.setText(value + "<small>%<small>");
                            }
                        }
                    });
                @endif
                @if(in_array($session->level, ['broker']))
                    // Circle Realisasi
                    var CP_realisasi = new ProgressBar.Circle(cp_realisasi, {
                        color: '#FFBD17',
                        // This has to be the same size as the maximum width to
                        // prevent clipping
                        strokeWidth: 10,
                        trailWidth: 10,
                        easing: 'easeInOut',
                        trailColor: '#FFF2D1',
                        duration: 1400,
                        text: {
                            autoStyleContainer: false
                        },
                        from: { color: '#FFBD17', width: 10 },
                        to: { color: '#FFBD17', width: 10 },
                        // Set default step function for all animate calls
                        step: function(state, circle) {
                            circle.path.setAttribute('stroke', state.color);
                            circle.path.setAttribute('stroke-width', state.width);
                            var value = Math.round(circle.value() * 100);
                            if (value === 0) {
                                // circle.setText('');
                            } else {
                                //  circle.setText(value + "<small>%<small>");
                            }
                        }
                    });
                @endif
                // Circle Approve
                var CP_approve = new ProgressBar.Circle(cp_approve, {
                    color: '#FFBD17',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#FFF2D1',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: { color: '#FFBD17', width: 10 },
                    to: { color: '#FFBD17', width: 10 },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);
                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            // circle.setText('');
                        } else {
                            //  circle.setText(value + "<small>%<small>");
                        }
                    }
                });
                // Circle Verifikasi
                var CP_verif = new ProgressBar.Circle(cp_verif, {
                    color: '#3AC79B',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#D8F4EB',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: { color: '#3AC79B', width: 10 },
                    to: { color: '#3AC79B', width: 10 },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);
                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            // circle.setText('');
                        } else {
                            //  circle.setText(value + "<small>%<small>");
                        }
                    }
                });
                // Circle Approved
                var CP_approved = new ProgressBar.Circle(cp_approved, {
                    color: '#5476E6',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#E5EAFB',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: { color: '#5476E6', width: 10 },
                    to: { color: '#5476E6', width: 10 },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);
                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            // circle.setText('');
                        } else {
                            //  circle.setText(value + "<small>%<small>");
                        }
                    }
                });
                // Circle Active
                var CP_active = new ProgressBar.Circle(cp_active, {
                    color: '#F73563',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#FEEFF3',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: { color: '#F73563', width: 10 },
                    to: { color: '#F73563', width: 10 },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);
                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            // circle.setText('');
                        } else {
                            //  circle.setText(value + "<small>%<small>");
                        }
                    }
                });
                // Circle Validasi
                var CP_validasi = new ProgressBar.Circle(cp_validasi, {
                    color: '#3AC79B',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#D8F4EB',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: { color: '#3AC79B', width: 10 },
                    to: { color: '#3AC79B', width: 10 },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);
                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            // circle.setText('');
                        } else {
                            //  circle.setText(value + "<small>%<small>");
                        }
                    }
                });
                // Circle Paid
                var CP_paid = new ProgressBar.Circle(cp_paid, {
                    color: '#5476E6',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#E5EAFB',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: { color: '#5476E6', width: 10 },
                    to: { color: '#5476E6', width: 10 },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);
                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            // circle.setText('');
                        } else {
                            //  circle.setText(value + "<small>%<small>");
                        }
                    }
                });
                
                // Number from 0.0 to 1.0
                @if(in_array($session->level, ['mkt','smkt','checker','schecker']))
                    CP_pending.animate({{ ($dashboard->pending == 0) ? 0 : round($dashboard->pending / $dashboard->outstanding, 2) }});
                @endif
                CP_verif.animate({{ ($dashboard->verif == 0) ? 0 : round($dashboard->verif / $dashboard->outstanding, 2) }});
                @if(in_array($session->level, ['broker']))
                    CP_realisasi.animate({{ ($dashboard->realisasi == 0) ? 0 : round($dashboard->realisasi / $dashboard->outstanding, 2) }});
                @endif
                CP_approve.animate({{ ($dashboard->approve == 0) ? 0 : round($dashboard->approve / $dashboard->outstanding, 2) }});
                CP_approved.animate({{ ($dashboard->approved == 0) ? 0 : round($dashboard->approved / $dashboard->outstanding, 2) }});
                CP_active.animate({{ ($dashboard->active == 0) ? 0 : round($dashboard->active / $dashboard->outstanding, 2) }});
                CP_validasi.animate({{ ($dashboard->validasi == 0) ? 0 : round($dashboard->validasi / $dashboard->outstanding, 2) }});
                CP_paid.animate(1);
            });
            // var ctx = document.getElementById("mataChart").getContext('2d');
            // var myChart = new Chart(ctx, {
            //     type: 'doughnut',
            //     data: {
            //         labels: [
            //             'Red',
            //             'Blue',
            //             'Yellow'
            //           ],
            //           datasets: [{
            //             label: 'My First Dataset',
            //             data: [300, 50, 100],
            //             backgroundColor: [
            //               'rgb(255, 99, 132)',
            //               'rgb(54, 162, 235)',
            //               'rgb(255, 205, 86)'
            //             ],
            //             hoverOffset: 4
            //           }]
            //     } 
            // });
            // var myChart = new Chart(ctx, {
            //     type: 'bar',
            //     data: {
            //         labels: <?php echo json_encode($jkel); ?>,
            //     datasets: [{
            //     label: 'Statistik User',
            //     backgroundColor: '#ADD8E6',
            //     borderColor: '#93C3D2',
            //     data: <?php echo json_encode($jumlah_pengajuan); ?>
            //     }],
            //     options: {
            //     animation: {
            //         onProgress: function(animation) {
            //             progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
            //         }
            //       }
            //     }
            //    },
            //  });
            // var ctx1 = document.getElementById("myChart1").getContext('2d');
            // var myChart1 = new Chart(ctx1, {
            //     type: 'line',
            //     data: {
            //         labels: <?php echo json_encode($jkel); ?>,
            //           datasets: [{
            //             label: 'My First Dataset',
            //             data: <?php echo json_encode($jumlah_pengajuan); ?>,
            //             backgroundColor: [
            //               'rgb(255, 99, 132)',
            //               'rgb(54, 162, 235)',
            //               'rgb(255, 205, 86)'
            //             ],
            //             hoverOffset: 4
            //           }]
            //     }
            // }); 
            // var ctx2 = document.getElementById("myChart2").getContext('2d');
            // var myChart2 = new Chart(ctx2, {
            //     type: 'doughnut',
            //     data: {
            //         labels: <?php echo json_encode($jkel); ?>,
            //           datasets: [{
            //             label: 'My First Dataset',
            //             data: <?php echo json_encode($jumlah_pengajuan); ?>,
            //             backgroundColor: [
            //               'rgb(255, 99, 132)',
            //               'rgb(54, 162, 235)',
            //               'rgb(255, 205, 86)'
            //             ],
            //             hoverOffset: 4
            //           }]
            //     }
            // });
        </script>
    @endsection