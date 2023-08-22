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
                    <h5>Proses</h5>
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
                            <p class="text-muted ">No Register : {{ $data[0]->regid }}</p>
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
                            <div class="swiper-slide">
                                <a href="{{ url('proses/approve/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-check2-circle size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Approve</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('proses/rollback/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-clipboard size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Rollback</p>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('pengajuan/log/'.Crypt::encryptString($data[0]->regid)) }}" class="card text-center">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-door-closed size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Log</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- connectionwiper -->
            <!-- profile information -->
            <!-- <form method="POST" action="{{ url('checker/update')}}"> -->
                
            <div class="row mb-3">
                <div class="col">
                    <h6>Data Nasabah</h6>
                </div>
            </div>
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select @if($data[0]->status == "1") readonly @endif class="form-control" id="cabang" required readonly name="cabang" >
                                <option value="" ></option>
                                @foreach($cab as $c)
                                <option value="{{ $c->comtabid }}" @if($data[0]->cabang == $c->comtabid) selected @endif>{{ $c->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="cabang">Cabang</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select @if($data[0]->status == "1") readonly @endif class="form-control" id="mitra" required readonly name="mitra" >
                                <option value="" ></option>
                                @foreach($mitra as $m)
                                <option value="{{ $m->comtabid }}" @if($data[0]->mitra == $m->comtabid) selected @endif>{{ $m->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="mitra">Mitra</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" required readonly name="nama" value="{{ $data[0]->nama }}" placeholder="Nama" id="nama">
                            <label for="nama">Nama</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" required readonly name="noktp" value="{{ $data[0]->noktp }}" placeholder="No. KTP" id="noktp">
                            <label for="noktp">No KTP</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select @if($data[0]->status == "1") readonly @endif required readonly name="jkel" id="jkel" class="form-control">
                                <option value="L" @if($data[0]->jkel == "L") selected @endif>Laki-laki</option>
                                <option value="P" @if($data[0]->jkel == "P") selected @endif>Perempuan</option>
                            </select>
                            <label for="jkel">Jenis Kelamin</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select @if($data[0]->status == "1") readonly @endif class="form-control" id="pekerjaan" required readonly name="pekerjaan">
                                <option value="" ></option>
                                @foreach($kerja as $k)
                                <option value="{{ $k->comtabid }}" @if($data[0]->pekerjaan == $k->comtabid) selected @endif>{{ $k->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="pekerjaan">Pekerjaan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" required readonly name="tempat_lahir" value="{{ $data[0]->tempat_lahir }}" placeholder="Tempat Lahir" id="tempat_lahir">
                            <label for="tempat_lahir">Tempat Lahir</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" required readonly name="tgllahir" value="{{ $data[0]->tgllahir }}" placeholder="Tanggal Lahir" id="tgllahir" onkeyup="hitungUsia()" >
                            <label for="tgllahir">Tanggal Lahir</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" required readonly name="alamat" value="{{ $data[0]->alamat }}" placeholder="Alamat" id="alamat">
                            <label for="alamat">Alamat</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" required readonly name="nama_ahli_waris" value="{{ $data[0]->nama_ahli_waris }}" placeholder="Nama Ahli Waris" id="nama_ahli_waris">
                            <label for="nama_ahli_waris">Nama Ahli Waris</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" required readonly name="notelp_ahli_waris" value="{{ $data[0]->notelp_ahli_waris }}" placeholder="Nomor Telp. Ahli Waris" id="notelp_ahli_waris">
                            <label for="notelp_ahli_waris">No Telp Ahli Waris</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <select @if($data[0]->status == "1") readonly @endif class="form-control" required readonly name="hubungan" id="hubungan">
                                <option value="" ></option>
                                @foreach($hubungan as $h)
                                <option value="{{ $h->comtabid }}" @if($data[0]->hubungan_ahli_waris == $h->comtab_nm) selected @endif>{{ $h->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="hubungan">Hubungan dengan tertanggung</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4"  id="div-hubungan"  style="display:none;">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control"  id="ket_hubungan"  value=""  placeholder="Keterangan Hubungan" id="ket_hubungan">
                            <label for="ket_hubungan">Ket Hubungan</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <h6>Data Asuransi</h6>
                    </div>
                </div>
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <select class="form-control" required readonly name="produk" id="produk" >
                                <!-- <option value="" ></option> -->
                                @foreach($produk as $p)
                                <option value="{{ $p->comtabid }}" @if($data[0]->produk == $p->comtabid) selected @endif>{{ $p->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="produk">Produk</label>
                           
                        </div>
                    </div>
					<div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <select class="form-control" required readonly name="asuransi" id="asuransi" >
                                <option value="" ></option>
                                @foreach($asuransi as $item)
                                <option @if($data[0]->asuransi == $item->comtabid) selected @endif value="{{ $item->comtabid }}">{{ $item->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="asuransi">Asuransi</label>
                        </div>
                    </div>
					<div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" min="0" required readonly name="tunggakan" value="{{ $data[0]->tunggakan }}" placeholder="Grace Periode" id="tunggakan">
                            <label for="tunggakan">Grace Period (khusus MPP)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="masa" required name="masa" value="{{ $data[0]->masa }}" placeholder="Masa Asuransi" onkeyup="hitungUsia()">
                            <label for="masa">Masa Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" required name="mulai" value="{{ $data[0]->mulai }}" placeholder="Mulai Asuransi" id="mulai" onkeyup="hitungUsia()" onchange="hitungUsia()" >
                            <label for="mulai">Mulai Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" required readonly name="akhir" value="{{ $data[0]->akhir }}" placeholder="Akhir Asuransi" id="akhir">
                            <label for="akhir">Akhir Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="usia-masuk" required readonly value="" name="usia_mulai" readonly placeholder="Usia Saat Mulai Asuransi">
                            <label for="usia-masuk">Usia Pada Mulai Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="usia-akhir" required readonly name="usia_akhir" readonly placeholder="Usia Saat Akhir Asuransi">
                            <label for="usia-akhir">Usia Pada Akhir Asuransi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control currency" required value="{{ $data[0]->up }}" placeholder="Uang Pertanggungan" onkeyup="$('#up').val($(this).inputmask('unmaskedvalue'));hitungpremi(this);">
                            <input type="hidden" class="form-control"required readonly="required readonly" id="up" name="up" value="{{ $data[0]->up }}">
                            <label for="up">Uang Pertanggungan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control currency" required readonly value="{{ $data[0]->premi }}" placeholder="Premium" readonly>
                            <input type="hidden" class="form-control"required readonly="required readonly" id="premi" name="premi" value="{{ $data[0]->premi }}">
                            <label for="premi">Premi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control currency" required readonly value="{{ $data[0]->epremi }}" placeholder="Extra Premium" readonly>
                            <input type="hidden" class="form-control"required readonly="required readonly" id="epremi" name="epremi" value="{{ $data[0]->up }}">
                            <label for="epremi">Extra Premi</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <textarea class="form-control" name="catatan" id="catatan">{{ $data[0]->comment }}</textarea>
                            <label for="catatan">Catatan</label>
                        </div>
                    </div>
                    
                </div>
                <input type="hidden" required readonly name="regid" value="{{ Crypt::encryptString($data[0]->regid) }}">
                <input type="hidden" required readonly name="id" value="{{ Crypt::encryptString($sid) }}">
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
                    <div class="col-12">
                        <div class="card card-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama file </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dokumen as $d)
                                        <tr>
                                            <td><a href="{{ url($d->file.'/'.$d->nama_file) }}" target="pdf-frame">{{ $d->nama_file }} </a>
                                            <th>
                                                <a href="{{ url($d->file.'/'.$d->nama_file) }}" target="pdf-frame" class="btn btn-sm btn-default"><i class="fa fa-file-pdf-o"></i> Document</a>
                                            </th>
                                        </tr>
                                    @endforeach
                                    @foreach($file as $f)
                                        <!-- <tr>
                                            <td>
                                                <img src="{{ $f->file }}" alt="Avatar" style="high:30;width:30%;float:left;margin-right:10px;">
                                            </td>
                                        </tr> -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal fade" id="modal_preview" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Preview Gambar</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <img src="" id="preview-image-modal" style="width: 100%;">                          
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="button-modal"></div>
                                    <div class="col-md-6">
                                        <button type="button" class="text-white btn btn-danger w-100 shadow btn-lg" onclick="$('#modal_preview').modal('hide')">Tutup</button>
                                    </div>
                                    
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
            
            document.getElementById('usia-masuk').value = hitungUsia();
            // document.getElementById('usia-masuk').value = hitungUsia();
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