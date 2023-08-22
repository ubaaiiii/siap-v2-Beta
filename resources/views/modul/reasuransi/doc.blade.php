@extends('layouts.app')
@section('content')
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
                    <h5>Dokumen</h5>
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
                <div class="col-auto align-self-center">
                    <a href="transactions.html" class="small">Cara Download File</a>
                </div>
            </div>
            
            	
	            <div class="row">
	                <div class="col">
	                	@php
	                		$no=1;
	                	@endphp
	                	<!-- @csrf -->
		            	@foreach($dokumen as $dok)
	                    <div class="card mb-3">
	                        <div class="card-body">
	                            <div class="row">
	                                <div class="col-auto">
	                                    <div class="avatar avatar-44 shadow-sm rounded-10">
	                                        <i class="bi bi-file-text"></i>
	                                    </div>
	                                </div>
	                                <div class="col align-self-center ps-0">
	                                    <p class="small mb-1"><a href="{{ url('asset/photo/') }}" class="fw-medium">{{ $dok->dokumen }}</a> <span
	                                            class="text-muted">{{ $dok->tipe }}</span></p>
	                                    <p>{{ $dok->ukuran }} <small class="text-muted">{{ $dok->tglupload }}</small>
	                                    </p>
	                                </div>
	                                
	                                <div class="col-auto">
	                                	@if($dok->ukuran == null)
		                                	@if($vlevel != 'insurance')
		                                		<!-- <input type="file" name="upload{{$no}}" id="upload{{$no}}" style="display: none;">
		                                		<label for="upload{{$no}}">
				                                    <a class="btn btn-44 btn-light text-primary shadow-sm" rel="nofollow" data-toggle="tooltip" data-placement="top" title="Upload Data">
				                                        <i class="bi bi-upload"></i> 
				                                    </a>
				                                </label> -->
				                                <a class="btn btn-44 btn-light text-primary shadow-sm upload" id="{{ $no }}" data-toggle="modal" data-target="#exampleModal">
			                                        <i class="bi bi-upload"></i> 
			                                    </a>
			                                    <!-- <button class="btn btn-44 btn-light text-warning shadow-sm">
			                                        <i class="bi bi-eye"></i>
			                                    </button> -->
			                                @else
			                                	<a class="btn btn-44 btn-light text-primary shadow-sm" rel="nofollow">
			                                        No Data
			                                    </a>
			                                @endif
			                                @if ($dok->tipe == 'jpg' || $dok->tipe == 'png' || $dok->tipe == 'jpeg')
			                                	<button class="btn btn-44 btn-light text-warning shadow-sm"  data-toggle="tooltip" data-placement="top" title="Lihat Data">
			                                        <i class="bi bi-eye"></i>
			                                    </button>
			                                @else
			                                @endif
			                                @if ($vlevel != 'insurance')
			                                    <!-- <button class="btn btn-44 btn-light text-danger shadow-sm" data-toggle="tooltip" data-placement="top" title="Hapus Data">
			                                        <i class="bi bi-trash"></i>
			                                    </button> -->
		                                    @endif
	                                    @else
	                                    @endif
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>
			                
	                	<form action="{{ route('pengajuan.upload') }}" method="post" enctype="multipart/form-data">
	                		@csrf
			                <div id="uploadModal{{ $no++ }}" class="modal hide fade in" data-keyboard="false" data-backdrop="static">
							    <div class="modal-dialog">
							        <div class="modal-content">
							            <div class="modal-header">
							                <h2 class="modal-title">Upload</h2>
							                <button type="button" class="btn btn-warning"  data-bs-dismiss="modal">&times;</button>
							            </div>
							            <div class="modal-body">
							                <div class="row h-100 mb-4">
							                	<div class="col-12">
							                        <div class="form-group form-floating  mb-3">
							                            <input type="file" class="form-control" name="upload" placeholder="Name" id="upload">
							                            <label for="upload">upload</label>
							                        </div>
							                        <input type="hidden" name="jdoc" value="{{ $dok->dokumen }}">
							                        <input type="hidden" name="regid" value="{{ Crypt::encryptString($regid) }}">
							                    </div>
							                </div>
							            </div>
							            <div class="modal-footer">
							                <button type="submit" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
							                <button type="reset" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
							            </div>
							        </div>
							    </div>
							</div>
			            </form>
		                @endforeach
	                </div>
	            </div>
	             <!-- <div class="row h-100 ">
	                <div class="col-12 mb-4">
	                    <button class="btn btn-lg btn-default w-100 mb-4 shadow" type="submit">Simpan</button>
	                </div>
	            </div> -->
        </div>
        <!-- main page content ends -->
    </main>
@endsection
@section('script')
	<script>
		$(document).on('click', '.upload', function(){
                no_id = $(this).attr('id');
                console.log('no_id')
                $('#uploadModal'+no_id).modal('show');
            });
	</script>
@endsection