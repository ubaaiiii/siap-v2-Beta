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
                    <h5>TOPUP</h5>
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
                            <p class="text-muted ">Tgl Lahir : {{ $data[0]->tgllahir }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted ">
                        {{ $data[0]->comment }}
                    </p>
                </div>
            </div>
            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            <form action="{{ url('sertifikat/topup/store') }}" method="post">
                @csrf
            
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select readonly name="produk" class="form-control">
                                @foreach($produk as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->produk) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Nama Produk</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="no_register" value="{{ $data[0]->regid }}" placeholder="No Register" id="names">
                            <label for="names">No Register</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="no_register" value="{{ $data[0]->nopeserta }}" placeholder="No Peserta" id="names">
                            <label for="names">No Peserta</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="tempat_lahir" value="{{ $data[0]->nama }}" placeholder="Tempat Lahir" id="names">
                            <label for="names">Nama</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="tgllahir" value="{{ $data[0]->tgllahir }}" placeholder="Tanggal Lahir" id="names">
                            <label for="names">Tanggal Lahir</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" readonly name="noktp" value="{{ $data[0]->noktp }}" placeholder="No KTP" id="names">
                            <label for="names">No KTP</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select readonly name="jkel" class="form-control">
                                @foreach($jkel as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->jkel) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Jenis Kelamin</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select readonly name="cabang" class="form-control">
                                @foreach($cabang as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->cabang) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Cabang</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select readonly name="pekerjaan" class="form-control">
                                @foreach($pekerjaan as $item)
                                <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->pekerjaan) selected @endif>{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="names">Pekerjaan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" name="mulai" value="{{ $data[0]->mulai }}" placeholder="Mulai Asuransi" id="names">
                            <label for="names">Mulai Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="masa" placeholder="Masa Asuransi" id="names">
                            <label for="names">Masa Asuransi (Dalam Bulan)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="up" placeholder="Masa Asuransi" id="names" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                            <label for="names">Uang Pertanggungan (Dalam Rupiah)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" name="tunggakan" min="0" max="1000" placeholder="Masa Asuransi" id="names">
                            <label for="names">Grace Period (khusus MPP)</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-lg btn-default w-100 shadow" type="button" onclick="return save()">Simpan</button>
                    </div>
                </div>
                <!-- add edit address form -->
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
                                </div>
                            </div>
                        </div>
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
        </script>
        <script>
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
            function hitungUsia() {
                var tgllahir = $('#tgllahir').val(),
                    mulai    = $('#mulai').val(),
                    masa     = 0;
                    
                if (tgllahir.length > 0 && mulai.length > 0) {
                    tgllahir = tgllahir.split('-');
                    mulai    = mulai.split('-');
                    
                    if ($('#masa').val().length > 0) {
                        masa = $('#masa').val();
                    }
                    
                    var date_tglmulai = moment([parseInt(mulai[0]), parseInt(mulai[1]) - 1, parseInt(mulai[2])]);
                    var date_tgllahir = moment([parseInt(tgllahir[0]), parseInt(tgllahir[1]) - 1, parseInt(tgllahir[2])]);
                    
                    date_tgllahir.add(-masa, 'months');
                    
                    var years = date_tglmulai.diff(date_tgllahir, 'year');
                    date_tgllahir.add(years, 'years');
                    
                    var months = date_tglmulai.diff(date_tgllahir, 'months');
                    date_tgllahir.add(months, 'months');
                    
                    var days = date_tglmulai.diff(date_tgllahir, 'days');
                    
                    date_tglmulai.add(masa, 'months');
                    
                    // console.log('tgl akhir:',date_tglmulai.format('YYYY-MM-DD'));
                    
                    // console.log(years + ' years ' + months + ' months ' + days + ' days');
                    
                    $('#akhir').val(date_tglmulai.format('YYYY-MM-DD'));
                    $('#usia').val(years + " tahun " + months + " bulan " + days + " hari");
                }
            }
        </script>
    @endsection
