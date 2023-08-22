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
                    <h5>View Sertifikat</h5>
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
                            <p class="text-muted ">Created by : {{ $data[0]->createby }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted ">
                        {{ $data[0]->tstatus }}
                    </p>
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
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"> 
                                <a href="{{ url('sertifikat/cert/'.Crypt::encryptString($data[0]->regid)) }}" target="_blank" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-printer-fill"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Sertifikat</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('sertifikat/invoice/'.Crypt::encryptString($data[0]->policyno)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-receipt-cutoff"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Invoice</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('sertifikat/topup/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Topup</p>
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
                    <h6>Basic Information</h6>
                </div>
            </div>
            <div class="row h-100 mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <select class="form-control" id="country" readonly>
                            @foreach($produk as $p)
                            <option @if($p->comtabid == $data[0]->produk) selected @endif>{{ $p->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="names">Produk</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" name="regid" readonly value="{{ $data[0]->regid }}" placeholder="Name" id="names">
                        <label for="names">No Register</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" name="noppinjaman" readonly value="{{ $data[0]->nopeserta }}" placeholder="Name" id="names">
                        <label for="names">No Pinjaman</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->nama }}" placeholder="Name" id="names">
                        <label for="names">Nama</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->tgllahir.' / '.$data[0]->usia.' Tahun' }}" placeholder="Name" id="names">
                        <label for="names">Tgl Lahir / Usia</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->noktp }}" placeholder="Name" id="names">
                        <label for="names">No Ktp</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->jkel }}" placeholder="Name" id="names">
                        <label for="names">Jenis Kelamin</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <select class="form-control" id="country" readonly>
                            @foreach($cabang as $c)
                            <option @if($c->comtabid == $data[0]->cabang) selected @endif>{{ $c->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="names">Cabang</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <select class="form-control" id="country" readonly>
                            @foreach($pekerjaan as $p)
                            <option @if($p->comtabid == $data[0]->pekerjaan) selected @endif>{{ $p->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="names">Pekerjaan</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->masa . ' Bulan / ' . $data[0]->mulai . ' s/d ' . $data[0]->akhir }}" placeholder="Name" id="names">
                        <label for="names">Masa Asuransi</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="Rp. {{ number_format($data[0]->up) }}" placeholder="Name" id="names">
                        <label for="names">UP</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="Rp. {{ number_format($data[0]->premi) }}" placeholder="Name" id="names">
                        <label for="names">Premi</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="Rp. {{ number_format($data[0]->epremi) }}" placeholder="Name" id="names">
                        <label for="names">Extra Premi</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->paiddt }}" placeholder="Name" id="names">
                        <label for="names">Tanggal Bayar</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly name="name" value="{{ $data[0]->tunggakan }}" placeholder="Name" id="names">
                        <label for="names">Grace Preiod (Khusus MPP)</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <textarea class="form-control" readonly>{{ $data[0]->comment}}</textarea>
                        <label for="names">Catatan</label>
                    </div>
                </div>
            </div>
            <!-- add edit address form -->
            
            <div class="row h-100 ">
                <div class="col-12 mb-4 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama file </th>
                                <th>Type</th>
                                <th>Ukuran</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($file as $f)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $f->nama_file }}</td>
                                <td>{{ $f->tipe_file }}</td>
                                <td>{{ $f->ukuran_file }}</td>
                                <td>
                                    <a href="{{ url('assets/'.$f->file) }}" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> Document</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- main page content ends -->
    </main>
    @endsection