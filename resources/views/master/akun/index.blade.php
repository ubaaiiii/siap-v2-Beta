@extends('layouts.app')
@section('content')
<main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <a class="btn btn-light btn-44" href="{{ url('index') }} ">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <h5>Profile</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ url('maintenance') }}" target="_self" class="btn btn-light btn-44">
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
                            <h3 class="mb-0 text-color-theme">{{ $session->username }}</h3>
                            <p class="text-muted ">Last Updated : {{ $data->editdt }}</p>
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
            <form action="{{ url('profile/update') }} " method="post">
            	@csrf
	            <div class="row h-100 mb-4">
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="text" class="form-control" readonly name="username" value="{{ $data->username }}" placeholder="Name" id="names">
	                        <label for="names">Username</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="text" class="form-control" name="nama" value="{{ $data->nama }}" placeholder="Name" id="names">
	                        <label for="names">Name</label>
	                    </div>
	                </div>
	                
	                <div class="col-12 col-md-6">
	                    <div class="form-floating mb-3">
	                        <select class="form-control" id="mitra" disabled name="mitra">
	                        	<!-- <option></option> -->
	                        	@foreach($mitra as $item)
	                            <option value="{{ $item->comtabid }}"  @if($item->comtabid == $data->mitra) selected @endif >{{ $item->comtab_nm }}</option>
	                            @endforeach
	                        </select>
	                        <label for="mitra">Mitra</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-floating mb-3">
	                        <select class="form-control" id="cabang" disabled name="cabang">
	                            @foreach($cabang as $item)
	                            <option value="{{ $item->comtabid }}"  @if($item->comtabid == $data->cabang) selected @endif >{{ $item->comtab_nm }}</option>
	                            @endforeach
	                        </select>
	                        <label for="cabang">Cabang</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="text" class="form-control" name="email" value="{{ $data->email }}"  placeholder="Email" id="email">
	                        <label for="email">Email</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <input type="number" class="form-control" name="nohp" value="{{ $data->nohp }}"  placeholder="No HP" id="nohp">
	                        <label for="nohp">No HP</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <select class="form-control" id="level" disabled name="level">
	                            @foreach($level as $item)
	                            <option value="{{ $item->comtabid }}"  @if($item->comtabid == $data->level) selected @endif >{{ $item->comtab_nm }}</option>
	                            @endforeach
	                        </select>
	                        <label for="level">Hak Akses</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating  mb-3">
	                        <select class="form-control" id="supervisor" disabled name="parent">
	                            @foreach($parent as $item)
	                            <option value="{{ $item->comtabid }}"  @if($item->comtabid == $data->parent) selected @endif >{{ $item->comtab_nm }}</option>
	                            @endforeach
	                        </select>
	                        <label for="supervisor">Supervisior</label>
	                    </div>
	                </div>
	                <!-- <div class="col-12 col-md-6">
	                    <div class="form-group form-floating mb-3">
	                        <input type="text" class="form-control" value="info@maxartkiller.com"
	                            placeholder="Email or Phone" id="emailphone">
	                        <label for="emailphone">Email or Phone</label>
	                    </div>
	                </div>
	                <div class="col-12 col-md-6">
	                    <div class="form-group form-floating">
	                        <input type="file" class="form-control" id="fileupload">
	                        <label for="fileupload">Uplaod File</label>
	                    </div>
	                </div> -->
	            </div>
	            <!-- add edit address form -->
	            
	            <div class="row h-100 ">
	                <div class="col-6 mb-4">
	                    <button class="btn btn-lg btn-default w-100 mb-4 shadow" type="submit">Edit</button>
	                </div>
	                <div class="col-6 mb-4">
	                    <a  class="btn btn-lg btn-default w-100 mb-4 shadow" href="{{ url('password'.'') }}">Password</a>
	                </div>
	            </div>
            </form>
						<!-- layout modes selection -->
            <div class="row mb-3">
                <div class="col-12">
                    <h6>Layout Mode</h6>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6 d-grid">
                    <input type="radio" class="btn-check" name="layout-mode" checked id="btn-layout-modes-light">
                    <label class="btn btn-warning shadow-sm text-white" for="btn-layout-modes-light">
                        <i class="bi bi-sun fs-4 mb-2 d-block"></i>
                        Light Mode</label>
                </div>
                <div class="col-6 d-grid">
                    <input type="radio" class="btn-check" name="layout-mode" id="btn-layout-modes-dark">
                    <label class="btn btn-dark shadow-sm" for="btn-layout-modes-dark">
                        <i class="bi bi-moon-stars fs-4 mb-2 d-block"></i>
                        Dark Mode</label>
                </div>
            </div>
            <!-- color scheme selection -->
            <div class="row mb-3">
                <div class="col-12">
                    <h6>Color scheme</h6>
                </div>
            </div>
            <div class="row mb-3">                
                <div class="col-12">
                
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-blue" data-title="">
                    <label class="btn bg-blue shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-blue">BL</label>
                
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-indigo" data-title="theme-indigo">
                    <label class="btn bg-indigo shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-indigo">IN</label>
               
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-purple" data-title="theme-purple">
                    <label class="btn bg-purple shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-purple">PL</label>
               
                    <input type="radio" class="btn-check mb-2" name="color-scheme" checked id="btn-color-pink" data-title="theme-pink">
                    <label class="btn bg-pink shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-pink">PK</label>
               
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-red" data-title="theme-red">
                    <label class="btn bg-red shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-red">RD</label>
               
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-orange" data-title="theme-orange">
                    <label class="btn bg-orange shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-orange">OG</label>
              
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-yellow" data-title="theme-yellow">
                    <label class="btn bg-yellow shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-yellow">YL</label>
               
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-green" data-title="theme-green">
                    <label class="btn bg-green shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-green">GN</label>
                
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-teal" data-title="theme-teal">
                    <label class="btn bg-teal shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-teal">TL</label>
               
                    <input type="radio" class="btn-check mb-2" name="color-scheme" id="btn-color-cyan" data-title="theme-cyan">
                    <label class="btn bg-cyan shadow-sm avatar avatar-44 p-0 mb-3 me-2 text-white" for="btn-color-cyan">CN</label>
                </div>
            </div>
            <!-- menu style selection -->
            <div class="row mb-3">
                <div class="col-12">
                    <h6 class="mb-2">Menu Style</h6>
                    <p class="text-muted size-12">Select style of menu sidebar and open menu from top menu button.</p>
                </div>
            </div>
            <div class="row ">
                <div class="col mb-4">
                    <input type="radio" class="btn-check" name="menu-select" id="btn-menu1"
                        data-title="overlay">
                    <label class="btn btn-outline-primary background-btn p-1 text-center border-0" for="btn-menu1">
                        <img src="assets/img/setting-menu-1@2x.png" alt="" class="mw-100 rounded-10"><br><span
                            class="py-2 d-block small">Popover</span>
                    </label>
                </div>
                <div class="col mb-4 ps-0">
                    <input type="radio" class="btn-check" name="menu-select" checked id="btn-menu2" data-title="pushcontent">
                    <label class="btn btn-outline-primary background-btn p-1 text-center border-0" for="btn-menu2">
                        <img src="assets/img/setting-menu-2@2x.png" alt="" class="mw-100 rounded-10"><br><span
                            class="py-2 d-block small">Push Page</span>
                    </label>
                </div>
                <div class="col mb-4 ps-0">
                    <input type="radio" class="btn-check" name="menu-select" id="btn-menu3" data-title="fullmenu">
                    <label class="btn btn-outline-primary background-btn p-1 text-center border-0" for="btn-menu3">
                        <img src="assets/img/setting-menu-3@2x.png" alt="" class="mw-100 rounded-10"><br><span
                            class="py-2 d-block small">Fullscreen</span>
                    </label>
                </div>
            </div>
            <!-- background selection -->
            <div class="row mb-3">
                <div class="col-12">
                    <h6 class="mb-3">Background Image</h6>
                    <p class="text-muted size-12">Background images are visible on <code>dark-bg</code> class used
                        in <a href="splash.html">splash screen</a> and the 
                        <span class="text-color-theme" onclick="event.stopPropagation(); $('body').addClass('menu-open')">Menu sidebar</span>. 
                    </p>
                </div>
            </div>
            <div class="row ">
                <div class="col mb-4">
                    <input type="radio" class="btn-check" name="background-select" checked id="btn-bg1"
                        data-src="backgorund-image.svg">
                    <label class="btn btn-outline-primary background-btn p-1 text-center border-0" for="btn-bg1">
                        <img src="assets/img/darkbg-1.png" alt="" class="mw-100 rounded-10"><br><span
                            class="py-2 d-block small">Shapes</span>
                    </label>
                </div>
                <div class="col mb-4">
                    <input type="radio" class="btn-check" name="background-select" id="btn-bg2"
                        data-src="backgorund-image2.svg">
                    <label class="btn btn-outline-primary background-btn p-1 text-center border-0" for="btn-bg2">
                        <img src="assets/img/darkbg-2.png" alt="" class="mw-100 rounded-10"><br><span
                            class="py-2 d-block small">Character</span>
                    </label>
                </div>
                <div class="col mb-4">
                    <input type="radio" class="btn-check" name="background-select" id="btn-bg3"
                        data-src="backgorund-image3.svg">
                    <label class="btn btn-outline-primary background-btn p-1 text-center border-0" for="btn-bg3">
                        <img src="assets/img/darkbg-3.png" alt="" class="mw-100  rounded-10"><br><span
                            class="py-2 d-block small">Bubble</span>
                    </label>
                </div>
            </div>
        </div>
        <!-- main page content ends -->
    </main>
    @endsection