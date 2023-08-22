@extends('layouts.app')
    @section('content')
<main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-light btn-44 back-btn" onclick="window.location.replace('profile.html');">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <div class="col align-self-center text-center">
                    <h5>Kalkulator Premi</h5>
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
            
            <!-- profile information -->
            <div class="card card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h6>Detail</h6>
                    </div>
                </div>
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <select disabled class="form-control" id="country" name="produk" readonly>
                                @foreach($produk as $p)
                                <option value="{{ $p->comtabid }}" @if($p->comtabid == $kalkulator->produk) selected @endif>{{ $p->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Produk</label>
                        </div>
                    </div>
					 <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <select disabled class="form-control" id="country" name="asuransi" readonly>
                                @foreach($asuransi as $p)
                                <option value="{{ $p->comtabid }}" @if($p->comtabid == $kalkulator->asuransi) selected @endif>{{ $p->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Asuransi</label>
                        </div>
                    </div>
					 <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <select  disabled class="form-control" id="country" name="jkel" readonly>
                                @foreach($jkel as $p)
                                <option value="{{ $p->comtabid }}" @if($p->comtabid == $kalkulator->jkel) selected @endif>{{ $p->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Jenis Kelamin</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ $kalkulator->tgllahir }}" placeholder="Name" id="names">
                            <label for="names">Tgl Lahir</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ $kalkulator->usia }}" placeholder="Name" id="names">
                            <label for="names">Usia Masuk</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ $kalkulator->jkel }}" placeholder="Name" id="names">
                            <label for="names">Jenis Kelamin</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ $kalkulator->masa }}" placeholder="Name" id="names">
                            <label for="names">Masa Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ $kalkulator->mulai }}" placeholder="Name" id="names">
                            <label for="names">Mulai Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ $kalkulator->akhir }}" placeholder="Name" id="names">
                            <label for="names">Akhir Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ number_format($kalkulator->up) }}" placeholder="Name" id="names">
                            <label for="names">Pinjaman</label>
                        </div>
                    </div>  
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ number_format($kalkulator->premi) }}" placeholder="Name" id="names">
                            <label for="names">Premi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ number_format($kalkulator->up - $kalkulator->premi) }}" placeholder="Name" id="names">
                            <label for="names">Jumlah Diterima</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="name" value="{{ number_format($kalkulator->tunggakan) }}" placeholder="Name" id="names">
                            <label for="names">Grace Period  (khusus produk MPP)</label>
                        </div>
                    </div>   
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <textarea class="form-control" readonly>{{ $kalkulator->comment }}</textarea>
                            <label for="names">Catatan</label>
                        </div>
                    </div>   
                    
                   
                </div>
                <div class="row h-100 ">
                    <div class="col-12 mb-4">
                        <a href="{{ url('kalkulator') }}" class="btn btn-lg btn-default w-100 mb-4 shadow">Hitung Kembali</a>
                    </div>
                </div>
            </div>
            <!-- add edit address form -->
            
        </div>
        <!-- main page content ends -->
    </main>
    @endsection