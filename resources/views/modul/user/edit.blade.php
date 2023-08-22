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
                    <h5>User</h5>
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
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-50 shadow rounded-10 text-white" style="background-color: #E73712;">
                                
                            </figure>
                        </div>
                        <div class="col px-0 align-self-center">
                            <h5>{{ Session::get('login')[0]->username }}</h5>
                            <p class="text-muted ">{{ Session::get('login')[0]->username }} </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- user information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Action</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 px-0">
                    <!-- swiper users connections -->
                    <div class="swiper-container connectionwiper" style="overflow: scroll;">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="{{ url('user/email/'.Crypt::encryptString($data[0]->username)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Email</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('user/reset/'.Crypt::encryptString($data[0]->username)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Reset</p>
                                    </div>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>User</h6>
                </div>
            </div>
            <form action="{{ url('user/update') }}" method="post">
            @csrf
            <input type="hidden" required name="username" value="{{ Crypt::encrypt($data[0]->username) }}">
                <div class="row h-100 mb-4">
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="nama"  required name="nama" value="{{ $data[0]->nama }}" placeholder="Nama">
                            <label for="surnames">Nama</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="email" class="form-control" id="email"  required name="email" value="{{ $data[0]->email }}" placeholder="email">
                            <label for="surnames">email</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="nohp"  required name="nohp" value="{{ $data[0]->nohp }}" placeholder="No HP">
                            <label for="surnames">No HP</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating mb-3">
                            <select class="form-control" required name="level" id="country" >
                                @foreach($hakakses as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->level) selected @endif >{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Hak Akses</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating mb-3">
                            <select class="form-control" required name="cabang" id="country" >
                                @foreach($cabang as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->cabang) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Cabang</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating mb-3">
                            <select class="form-control" required name="mitra" id="country" >
                                @foreach($mitra as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->mitra) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Mitra</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating mb-3">
                            <select class="form-control" required name="parent" id="country" >
                                @foreach($supervisior as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->parent) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Supervisior</label>
                        </div>
                    </div>
                </div>
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
                                <a href="{{ url('user/delete/'.Crypt::encrypt($data[0]->username)) }}" class="btn btn-sm btn-default btn-delete" >Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
       
            <div class="main-container container">
                <div class="row h-100 ">
                    <div class="col-md-6 mb-1">
                        <!-- <button class="btn btn-lg btn-default shadow btn-block" type="submit">Save</button> -->
                        <button class="btn btn-lg btn-default w-100 shadow" type="button" onclick="return save()">Save</button>
                    </div>
                    <div class="col-md-6 mb-1">
                        <button class="btn btn-lg btn-danger w-100 shadow text-white" type="button" onclick="return hapus()">Delete</button>
                    </div>
                </div>
            </div>
            </form>

        </div>
        <!-- main page content ends -->
    </main>
    @endsection
    @section('script')
        <script>
            function save(){
                if($('#nama').val().length == 0) {
                    $("#nama1").css("display", "");
                }else if($('#nohp').val().length == 0) {
                    $("#nohp1").css("display", "");
                } else{
                    $("#confirmpassword1").css("display", "none");
                    $('#confirmModal').modal('show');
                    $('.toast-save').toast('show');
                    $(".btn-save").show();
                    $(".save").show();
                    $(".btn-delete").hide();
                    $(".delete").hide();
                }
                // $('.toast-save').toast('show');
                // $(".btn-save").show();
                // $(".save").show();
                // $(".btn-delete").hide();
                // $(".delete").hide();
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
