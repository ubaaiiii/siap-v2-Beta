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
                    <h5>cabang</h5>
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

                            <h5>{{ Auth::guard('admin')->user()->username }}</h5>
                            <p class="text-muted ">{{ Auth::guard('admin')->user()->username }} </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- user information -->

            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Cabang</h6>
                </div>
            </div>
            <form action="{{ url('cabang/update') }}" method="post">
            @csrf
            <!-- <input type="hidden" name="id_member_cabang"> -->
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="desk"  value="{{ $data[0]->msdesc }}" placeholder="Instagram" id="desk">
                            <label for="desk">Deskripsi</label>
                            <p class="text-danger" id="desk1" style="display: none;">Please fill in this field</p>
                        </div>
                    </div>
                    <input type="hidden" name="msid" value="{{ Crypt::encrypt($data[0]->msid) }}">
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
                                <!-- <a href="{{ url('profile/cabang/delete/'.$data[0]->msid) }}" class="btn btn-sm btn-default btn-delete" >Delete</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
       
            <div class="main-container container">
                <div class="row h-100 ">
                    <div class="col-md-12 mb-1">
                        <!-- <button class="btn btn-lg btn-default shadow btn-block" type="submit">Save</button> -->
                        <button class="btn btn-lg btn-default w-100 shadow" type="button" onclick="return save()">Save</button>
                    </div>
                    <!-- <div class="col-md-6 mb-1">
                        <button class="btn btn-lg btn-danger w-100 shadow text-white" type="button" onclick="return hapus()">Delete</button>
                    </div> -->
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
                if($('#desk').val().length == 0) {
                    $("#desk1").css("display", "");
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

