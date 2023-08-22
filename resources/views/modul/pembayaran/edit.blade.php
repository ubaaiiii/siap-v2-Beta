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
                    <h5>Edit Pembayaran</h5>
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
                                <?php 
                                    $thumbnail = "";
                                    $teks = $data[0]->nama;
                                    $teks = explode(",", $teks);
                                    foreach($teks as $t){
                                        $kata = substr($t,0,1);
                                        $thumbnail .= $kata." ";
                                    }
                                    if (isset($teks[0])) {
                                        echo substr($teks[0],0,1);
                                    }
                                    if (isset($teks[1])) {
                                        echo substr($teks[1],0,1);
                                    }
                                ?>
                            </figure>
                        </div>
                        <div class="col px-0 align-self-center">
                            <h3 class="mb-0 text-color-theme">{{ $data[0]->nama }}</h3>
                            <p class="text-muted ">Tgl Sebelumnya : {{ $data[0]->paiddt }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <h6>Action</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 px-0">
                    <!-- swiper users connections -->
                    <div class="swiper-container connectionwiper" style="overflow: scroll;">
                        <!-- STATISTIC marriage  -->
                        <div class="swiper-wrapper" id="statistic_family">
                           
                            <div class="swiper-slide">
                                <a href="{{ url('pengajuan/log/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-door-closed size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Log</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a class="card text-center" onclick="return hapus()">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-clipboard size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Hapus</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- connectionwiper -->
            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            <form method="POST" action="{{ url('pembayaran/update')}}">
                @csrf
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="paididview" required readonly value="{{ $data[0]->paidid }}" placeholder="Name" id="paidid">
                            <label for="names">Paid ID</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="regid" required readonly value="{{ $data[0]->regid }}" placeholder="Name" id="regid">
                            <label for="names">Reg ID</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="nama" required readonly value="{{ $data[0]->nama }}" placeholder="Name" id="nama">
                            <label for="names">Nama</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="paiddt" required readonly value="{{ $data[0]->paiddt }}" placeholder="Name" id="paiddt">
                            <label for="names">Tanggal Sebelumnya</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" name="tglpaid" required placeholder="Name" id="tglpaid">
                            <label for="names">Tanggal Paid</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="number" class="form-control" name="jumlah_bayar" required placeholder="Name" id="jumlah_bayar" value="{{ $data[0]->paidamt }}">
                            <label for="names">Total Pembayaran</label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="paidid" value="{{ $id }}">
                <br>
                <div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-10" id="konfirmasi">
                    <div class="toast toast-save mb-3 fade hide" role="alert" aria-live="assertive" aria-atomic="true" id="toastSimpan"
                        data-bs-animation="true">
                        <div class="toast-header">
                            <img src="{{ asset('assets/img/logo_inch.png') }}"  width="20px" class="rounded me-2" alt="...">
                            <strong class="me-auto">PERHATIAN!</strong>
                            <!-- <small>now</small> -->
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <div class="row">
                                <div class="col save">
                                    Apakah Anda yakin ingin menyimpan ini?
                                </div>
                                <div class="col delete">
                                    Apakah Anda yakin ingin menghapus ini?
                                </div>
                                <div class="col-auto align-self-center ps-0">
                                    <button class="btn btn-sm btn-default btn-save" type="submit">Save</button>
                                    <a href="{{ url('pembayaran/delete/'.Crypt::encryptString($data[0]->paidid).'/'.Crypt::encryptString($data[0]->regid)) }}" class="btn btn-sm btn-default btn-delete" >Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row h-100 ">
                    <div class="col-md-6 mb-1">
                        <!-- <button class="btn btn-lg btn-default shadow btn-block" type="submit">Save</button> -->
                        <button class="btn btn-lg btn-default w-100 shadow" type="button" onclick="return save()">Save</button>
                    </div>
                    <div class="col-md-6 mb-1">
                        <button class="btn btn-lg btn-danger w-100 shadow text-white back-btn" type="button">Batal</button>
                    </div>
                </div>
            </form>
 
        <!-- </div> -->
        <!-- main page content ends -->
    </main>
    @endsection
    @section('script')
        <script>
            function save(){
                $('.toast-save').toast('show');
                $(".btn-save").show();
                $(".save").show();
                $(".btn-delete").hide();
                $(".delete").hide();
            }
            function hapus(){
                $('.toast-save').toast('show');
                $(".btn-save").hide();
                $(".save").hide();
                $(".btn-delete").show();
                $(".delete").show();
            }
            
        </script>
        
    @endsection
