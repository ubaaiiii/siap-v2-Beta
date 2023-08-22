@extends('layouts.app')
    @section('content')
    <!-- Begin page -->
    <main class="container-fluid h-100">
         <!-- Header -->
         <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-light btn-44 back-btn">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <div class="col align-self-center text-center">
                    <h5>Maintenance</h5>
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
        <div class="row h-100 ">
            <div class="col-12 col-md-6 col-lg-5 col-xl-3 mx-auto py-4 text-center align-self-center">
                <figure class="mw-100 text-center mb-3">
                    <img src="{{ asset('assets/img/maintenance.png') }}" alt="" class="mw-100">
                </figure>
                <h1 class="mb-0 text-color-theme">Oops!...</h1>
                <h5 class="mb-3">Page is under maintenance</h5>
                <p class="text-muted mb-4">The page you are looking for is under maintenance. Please try again sometime or go back to home page.</p>
                <a href="{{ url('index') }}" target="_self" class="btn btn-default btn-lg">Back to Home</a>
            </div>
        </div>
    </main>
    <!-- Page ends-->
    @endsection