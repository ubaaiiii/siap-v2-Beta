@extends('layouts.app')
@section('content')
	<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
	<main class="h-100">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-light back-btn">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <div class="col align-self-center text-center">
                    <h5>Report</h5>
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
            <!-- list data request money -->
            <div class="row mb-3">
                <div class="col">
                    <h6 class="title">Dokumen Pengajuan</h6>
                </div>
            </div>
						<form action="upload" class="dropzone" id="my-awesome-dropzone" method="POST">
							@csrf
							<div class="form-group form-floating  mb-3">
								<input type="text" class="form-control" name="url" placeholder="../httpdocs/adm/" id="url" value="adm/">
								<label for="url">../httpdocs/adm/</label>
							</div>

						</form>
            
        </div>
        <!-- main page content ends -->
    </main>
@endsection
@section('script')
	<script>
		$(document).ready(function(){
			
		})
	</script>
@endsection