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
                    <h5>Klaim</h5>
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
                            <p class="text-muted ">Tgl Kejadian : {{ $data[0]->tglkejadian }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted ">
                        {{ $data[0]->comment }}
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
                        <!-- STATISTIC marriage  -->
                        <div class="swiper-wrapper" id="statistic_family">
                            @if($data[0]->status !== "1") 
                            <div class="swiper-slide">
                                <a href="{{ url('klaim/approve/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-check2-circle size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Approve</p>
                                    </div>
                                </a>
                            </div>
                            @endif 
                            @if($data[0]->status !== "1") 
                            <div class="swiper-slide">
                                <a href="{{ url('klaim/doc/'.Crypt::encryptString($data[0]->regid).'/DTCLM') }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-file-earmark-arrow-up size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Document</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('klaim/list/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-clipboard size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">List</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('klaim/lengkap/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-door-closed size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Lengkap</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('klaim/rollback/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-door-closed size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Rollback</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('klaim/log/'.Crypt::encryptString($data[0]->regid).'/LTCLM') }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-door-closed size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Log</p>
                                    </div>
                                </a>
                            </div>
                            @endif 
                        </div>
                    </div>
                </div>
            </div>
            <!-- connectionwiper -->
            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            <form method="POST" action="{{ url('klaim/update')}}">
                @csrf
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="regclaim" readonly value="{{ $data[0]->regclaim }}" placeholder="Name" id="regclaim">
                            <label for="names">No Claim</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="regid" readonly value="{{ $data[0]->regid }}" placeholder="Name" id="regid">
                            <label for="names">No Register</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="nama" readonly value="{{ $data[0]->nama }}" placeholder="Name" id="nama">
                            <label for="names">Nama</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="tgllahir" readonly value="{{ 'Usia ' . $data[0]->usia . ' Tahun '. $data[0]->tgllahir }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">Usia & Tanggal Lahir</label> 
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="masa" value="{{ $data[0]->masa. ' Bulan ' . $data[0]->mulai. ' s/d '. $data[0]->akhir }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">Masa Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="up" value="{{ $data[0]->up }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">UP</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="nopeserta" value="{{ $data[0]->nopeserta }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">No Pinjaman</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="nilaios" value="{{ $data[0]->nilaios }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">Nilai Os</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" name="tgllapor" value="{{ $data[0]->tgllapor }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">Tgl Lapor</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" name="tglkejadian" value="{{ $data[0]->tglkejadian }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">Tgl Kejadian</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select name="tmpkejadian" class="form-control">
                                <option value="" ></option>
                                @foreach($tempat_kejadian as $item)
                                <option value="{{ $item->comtabid }}" @if($data[0]->pekerjaan == $item->comtabid) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="surnames">Tempat Kejadian</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select class="form-control" id="country" name="sebab">
                                <option value="" ></option>
                                @foreach($penyebab as $item)
                                <option value="{{ $item->comtabid }}" @if($data[0]->pekerjaan == $item->comtabid) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="surnames">Penyebab Kematian</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="nama_ahli_waris" value="{{ $data[0]->nama_ahli_waris }}" placeholder="nama_ahli_waris" id="names">
                            <label for="names">Nama Ahli Waris</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="notelp_ahli_waris" value="{{ $data[0]->notelp_ahli_waris }}" placeholder="notelp_ahli_waris" id="names">
                            <label for="names">No Telp Ahli Waris</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <select class="form-control" id="country" name="hubungan" id="hubungan">
                                <option value="" ></option>
                                @foreach($hubungan as $h)
                                <option value="{{ $h->comtabid }}" @if($data[0]->hubungan_ahli_waris == $h->comtab_nm) selected @endif>{{ $h->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Hubungan dengan tertanggung</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6"  id="div-hubungan"  style="display:none;">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control"  id="ket_hubungan"  value=""  placeholder="Keterangan Hubungan" id="surnames">
                            <label for="surnames">Ket Hubungan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <textarea class="form-control" name="catatan">{{ $data[0]->comment }}</textarea>
                            <label for="names">Catatan</label>
                        </div>
                    </div>
                    
                </div>
                <input type="hidden" name="regid" value="{{ $data[0]->regid }}">
                <input type="hidden" name="id" value="{{ $sid }}">
                <!-- add edit address form -->
                <div class="row mb-3">
                    <div class="col">
                        <h6>Track Changes</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" value="{{ $data[0]->createby }}" readonly  placeholder="Surname" id="surnames">
                            <label for="surnames">Created By</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" value="{{ $data[0]->createdt }}" readonly  placeholder="Surname" id="surnames">
                            <label for="surnames">Created Date</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" value="{{ $data[0]->editby }}" readonly  placeholder="Surname" id="surnames">
                            <label for="surnames">Updated By</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" value="{{ $data[0]->editdt }}" readonly  placeholder="Surname" id="surnames">
                            <label for="surnames">Updated Date</label>
                        </div>
                    </div>
                </div>
                <br>
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
                                    <a href="{{ url('klaim/delete/'.$data[0]->regid) }}" class="btn btn-sm btn-default btn-delete" >Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row h-100 ">
                    <div class="col-md-6 mb-1">
                        <!-- <button class="btn btn-lg btn-default shadow btn-block" type="submit">Save</button> -->
                        <button class="btn btn-lg btn-default w-100 shadow" type="button" onclick="return save()">Save</button>
                    </div>
                    <div class="col-md-6 mb-1">
                        <button class="btn btn-lg btn-danger w-100 shadow text-white" type="button" onclick="return hapus()">Delete</button>
                    </div>
                </div>
            </form>
 
        <!-- </div> -->
        <!-- main page content ends -->
    </main>
    @endsection
    @section('script')
        <script>
            function save(){
                $('.toast-save').toast('show');
                $(".btn-save").show();
                $(".save").show();
                $(".btn-delete").hide();
                $(".delete").hide();
            }
            function hapus(){
                $('.toast-save').toast('show');
                $(".btn-save").hide();
                $(".save").hide();
                $(".btn-delete").show();
                $(".delete").show();
            }
            function cekUsia() {
                var a = moment($('#mulai').val());
                var b = moment("{{ $data[0]->tgllahir }}");
                
                var years = a.diff(b, 'year');
                b.add(years, 'years');
                
                var months = a.diff(b, 'months');
                b.add(months, 'months');
                
                var days = a.diff(b, 'days');
                
                // console.log(years + ' years ' + months + ' months ' + days + ' days');
                var age = (months >= 6) ? (years+1) : (years);
                // console.log(age);
                // var tgl_mulai = moment();
                if (age > {{ $data[0]->usia }}) {
                    if ([56, 61, 66, 70].includes(age)) {
                        $('#masa-error').show();
                        $('#masa-text').text('Usia debitur berubah dari {{ $data[0]->usia }} tahun menjadi '+age+' tahun, premi akan berubah, harap mengkoreksi kembali rate yang berlaku');
                        $('#div-mulai').addClass('has-error');
                    } else {
                        $('#masa-error').hide();
                        $('#div-mulai').removeClass('has-error');
                    }
                } else if (age < {{ $data[0]->usia }}) {
                    if ([55, 60, 65, 69].includes(age)) {
                        $('#masa-error').show();
                        $('#masa-text').text('Usia debitur berubah dari {{ $data[0]->usia }} tahun menjadi '+age+' tahun, premi akan berubah, harap mengkoreksi kembali rate yang berlaku');
                        $('#div-mulai').addClass('has-error');
                    } else {
                        $('#div-mulai').removeClass('has-error');
                        $('#masa-error').hide();
                    }
                } else {
                    $('#masa-error').hide();
                }
            }
        </script>
        
    @endsection
