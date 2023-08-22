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
                    <h5>Edit Notifikasi</h5>
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
                                    $teks = $data[0]->level;
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
                            <h3 class="mb-0 text-color-theme">{{ $data[0]->level }}</h3>
                            <p class="text-muted ">Tgl Mulai : {{ $data[0]->tgl_mulai }}</p>
                        </div>
                    </div>
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
                                <a class="card text-center" onclick="return hapus()">
                                    <div class="card-body">
                                        <div class="avatar avatar-50 shadow-sm mb-2 rounded-10 theme-bg text-white">
                                            <i class="bi bi-clipboard size-32"></i>
                                        </div>
                                        <p class="text-color-theme size-12 small">Hapus</p>
                                    </div>
                                </a>
                            </div>
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
            <?php $pesan = explode('|',$data[0]->pesan); ?>
            <form method="POST" action="{{ url('push_notif/update')}}">
                @csrf
                <div class="row h-100 mb-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <select class="form-control" required tabindex="-2" required name="level" id="select-level" data-live-search="true">
                                <option value="ALL" @if($data[0]->level == "ALL") selected @endif>ALL</option>
                                @foreach($tipeuser as $row)
                                    <option value="{{ $row->comtabid }}" @if($data[0]->level == $row->comtabid) selected @endif>{{ $row->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Level User</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4" id="select-cabang">
                        <div class="form-group form-floating  mb-3">
                            <select class="form-control" tabindex="-2" name="cabang" id="select-kas" style="width: 100%">
                                <option value="ALL" @if($data[0]->cabang == "ALL") selected @endif>ALL</option>
                                @foreach($cabang as $row)
                                    <option value="{{ $row->comtabid }}" @if($data[0]->cabang == $row->comtabid) selected @endif>{{ $row->comtab_nm }}</option>
                                @endforeach
                            </select>
                            <label for="country">Cabang</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group  mb-3">
                            <label for="surnames">Nama</label>
                            <select name="username" id="username" class="form-control select2" style="width: 100% !important;">
                                <!-- <option>Cari Nama</option> -->
                                <option value="ALL" @if($data[0]->cabang == "ALL") selected @endif>ALL</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4" id="select-tipe">
                        <div class="form-group form-floating  mb-3">
                            <select class="form-control" tabindex="-2" name="tipe" id="select-kas" style="width: 100%">
                                <option selected disabled hidden></option>
                                <option value="info" data-judul="Informasi.." @if($pesan[0] == 'info') selected @endif>Information</option>
                                <option value="success" data-judul="Berhasil!" @if($pesan[0] == 'success') selected @endif>Success</option>
                                <option value="error" data-judul="Gagal!" @if($pesan[0] == 'error') selected @endif>Error</option>
                                <option value="warning" data-judul="Perhatian!" @if($pesan[0] == 'warning') selected @endif>Warning</option>
                            </select>
                            <label for="country">Tipe Pesan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="judul" required name="judul" value="{{ $pesan[1] }}" placeholder="Judul Pesan">
                            <label for="surnames">Judul Pesan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group form-floating  mb-3">
                            <input type="text" class="form-control" id="judul" required name="isi" value="{{ $pesan[2] }}"  placeholder="Judul Pesan">
                            <label for="surnames">Isi Pesan</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" id="mulai" required name="tgl_mulai" value="{{ $data[0]->tgl_mulai }}" placeholder="Tanggal Mulai">
                            <label for="surnames">Tanggal Mulai</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group form-floating  mb-3">
                            <input type="date" class="form-control" id="akhir" required name="tgl_selesai" value="{{ $data[0]->tgl_selesai }}"  placeholder="Tanggal Akhir">
                            <label for="surnames">Tanggal Akhir</label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ Crypt::encryptString($data[0]->id) }}">
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
                                    <a href="{{ url('push_notif/delete/'.Crypt::encryptString($data[0]->id)) }}" class="btn btn-sm btn-default btn-delete" >Delete</a>
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
                        <button class="btn btn-lg btn-danger w-100 shadow text-white back-btn" type="button">Batal</button>
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script>
            $(function() {
                $('.select2').select2({
                   // minimumInputLength: 3,
                   allowClear: true,
                   theme: 'bootstrap4',
                   placeholder: 'Masukan Nama atau Regid',
                   ajax: {
                      dataType: 'json',
                      url: '{{ url("/push_notif/get_nama") }}',
                      delay: 100,
                      data: function(params) {
                        return {
                          search: params.term,
                          level: document.getElementById('select-level').value,
                          cabang: document.getElementById('select-cabang').value,
                        }
                      },
                      processResults: function (data, page) {
                      return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.nama,
                                id: item.id_admin
                            }
                        })
                      };
                    },
                  }
              }).on('select2:select', function (evt) {
                 var data = $(".select2 option:selected").text();
                 // alert("Data yang dipilih adalah "+data);
              });
          });
        </script>
        
    @endsection
