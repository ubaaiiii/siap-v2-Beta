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
                <div class="col-auto align-self-center">
                    <a href="transactions.html" class="small">Cara Download File</a>
                </div>
            </div>
            
            	
	            <div class="row">
	                <div class="col-12">
	                    <div class="card mb-3">
	                        <div class="card-body">
	                            <div class="row">
	                                <div class="col-auto">
	                                    <div class="avatar avatar-44 shadow-sm rounded-10">
	                                        <i class="bi bi-file-text"></i>
	                                    </div>
	                                </div>
	                                <div class="col align-self-center ps-0">
	                                    <p class="small mb-1"><a href="{{ url('pengajuan/report/skkt/'.Crypt::encryptString($regid)) }}" class="fw-medium">Form SKKT ( ASKRED) UPDATED</a> </p>
	                                    <p>SURAT KETERANGAN KESEHATAN TERTANGGUNG ASURANSI KREDIT MULTI GUNA</p>
	                                </div>
	                                
	                                <div class="col-auto">
		                                <a href="{{ url('pengajuan/report/skkt/'.Crypt::encryptString($regid)) }}" class="btn btn-44 btn-light text-primary shadow-sm upload" >
	                                        <i class="bi bi-download"></i> 
	                                    </a>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>
			                
	                </div>
	                <div class="col-12">
	                    <div class="card mb-3">
	                        <div class="card-body">
	                            <div class="row">
	                                <div class="col-auto">
	                                    <div class="avatar avatar-44 shadow-sm rounded-10">
	                                        <i class="bi bi-file-text"></i>
	                                    </div>
	                                </div>
	                                <div class="col align-self-center ps-0">
	                                    <p class="small mb-1"><a href="{{ url('pengajuan/report/lpfk/'.Crypt::encryptString($regid)) }}" class="fw-medium">Laporan Pemeriksaan Fisik (LPK) - PLN INS</a> </p>
	                                    <p>Laporan Pemeriksaan Fisik Kesehatan</p>
	                                </div>
	                                
	                                <div class="col-auto">
		                                <a href="{{ url('pengajuan/report/lpfk/'.Crypt::encryptString($regid)) }}" class="btn btn-44 btn-light text-primary shadow-sm upload" >
	                                        <i class="bi bi-download"></i> 
	                                    </a>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>
			         </div>
			         <div class="col-12">
	                    <div class="card mb-3">
	                        <div class="card-body">
	                            <div class="row">
	                                <div class="col-auto">
	                                    <div class="avatar avatar-44 shadow-sm rounded-10">
	                                        <i class="bi bi-file-text"></i>
	                                    </div>
	                                </div>
	                                <div class="col align-self-center ps-0">
	                                    <p class="small mb-1"><a href="{{ url('pengajuan/report/spa/'.Crypt::encryptString($regid)) }}" class="fw-medium">SPA - PLN INS</a> </p>
	                                    <p>SURAT PERMINTAAN ASURANSI</p>
	                                </div>
	                                
	                                <div class="col-auto">
		                                <a href="{{ url('pengajuan/report/spa/'.Crypt::encryptString($regid)) }}" class="btn btn-44 btn-light text-primary shadow-sm upload" >
	                                        <i class="bi bi-download"></i> 
	                                    </a>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>
			         </div>
			         <div class="col-12">
	                    <div class="card mb-3">
	                        <div class="card-body">
	                            <div class="row">
	                                <div class="col-auto">
	                                    <div class="avatar avatar-44 shadow-sm rounded-10">
	                                        <i class="bi bi-file-text"></i>
	                                    </div>
	                                </div>
	                                <div class="col align-self-center ps-0">
	                                    <p class="small mb-1"><a href="{{ url('pengajuan/report/spm/'.Crypt::encryptString($regid)) }}" class="fw-medium">SPM - PLN INS</a> </p>
	                                    <p>Surat Pengantar Medis</p>
	                                </div>
	                                
	                                <div class="col-auto">
		                                <a href="{{ url('pengajuan/report/spm/'.Crypt::encryptString($regid)) }}" class="btn btn-44 btn-light text-primary shadow-sm upload" >
	                                        <i class="bi bi-download"></i> 
	                                    </a>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>
			         </div>
			         <div class="col-12">
	                    <div class="card mb-3">
	                        <div class="card-body">
	                            <div class="row">
	                                <div class="col-auto">
	                                    <div class="avatar avatar-44 shadow-sm rounded-10">
	                                        <i class="bi bi-file-text"></i>
	                                    </div>
	                                </div>
	                                <div class="col align-self-center ps-0">
	                                    <p class="small mb-1"><a href="{{ url('pengajuan/report/spkk/'.Crypt::encryptString($regid)) }}" class="fw-medium">SPKK - PLN INS</a> </p>
	                                    <p>SURAT PERNYATAAN dan KRONOLOGI KEMATIAN</p>
	                                </div>
	                                
	                                <div class="col-auto">
		                                <a href="{{ url('pengajuan/report/spkk/'.Crypt::encryptString($regid)) }}" class="btn btn-44 btn-light text-primary shadow-sm upload" >
	                                        <i class="bi bi-download"></i> 
	                                    </a>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>
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