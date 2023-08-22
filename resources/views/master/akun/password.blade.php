@extends('layouts.app')
    @section('content')
<main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                <a class="btn btn-light btn-44" href="{{ url('profile') }} ">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <h5>Ubah Password</h5>
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
                                    $teks = 'U';
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
                            <h3 class="mb-0 text-color-theme">{{ 'Username' }}</h3>
                            <p class="text-muted ">Last Updated : {{ '02-02-2022' }}</p>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-body">
                    <p class="text-muted ">
                        {{ 'Name' }}
                    </p>
                </div> --}}
            </div>
            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block"> 
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form action="{{ url('profile/updatePassword') }} " method="post">
            	@csrf
	            <div class="row h-100 mb-4">
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="password" class="form-control" required name="passwordLama" placeholder="Name" id="names">
	                        <label for="names">Password Lama</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="password" class="form-control" required name="passwordBaru" placeholder="Name" id="password">
	                        <label for="names">Password Baru</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="password" class="form-control" placeholder="Name" required name="konfirmasiPassword" id="konfirmasiPassword" onkeyup="cek()">
	                        <label for="names">Konfirmasi Password</label>
		                    <div id="error" class="text-danger"></div>
	                    </div>
	                </div>
	            </div>
	            <script>
	            	function cek(){
	            		// console.log("ok")
	            		if (document.getElementById('password').value !== document.getElementById('konfirmasiPassword').value) {
	            			document.getElementById('error').innerHTML = "Password Tidak Cocok";
	            		}else{
	            			document.getElementById('error').innerHTML = " ";
	            		}
	            	}
	            </script>
	            <!-- add edit address form -->
	            
	            <div class="row h-100 ">
	                <div class="col-12 mb-4">
	                    <button class="btn btn-lg btn-default w-100 mb-4 shadow" type="submit">Simpan</button>
	                </div>
	            </div>
            </form>
        </div>
        <!-- main page content ends -->
    </main>
    @endsection