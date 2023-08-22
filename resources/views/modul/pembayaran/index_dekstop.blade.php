@extends('layouts.app')
    @section('style')
    <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
    
    @endsection
    @section('content')
    <main class="h-100">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <div class="logo-small">
                        <img src="{{ asset(config('app.logo', 'assets/img/logo.png')) }}" alt="">
                        <h5>{{ config('app.title', 'SIAPLAKU') }}</h5>
                    </div>
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
            <!-- wallet balance -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <!-- <figure class="avatar avatar-44 rounded-10">
                                <img src="assets/img/user1.jpg" alt="">
                            </figure> -->
                        </div>
                        <div class="col px-0 align-self-center">
                            <h5 class="mb-0 text-color-theme">{{ $data['judul']}}</h5>
                            <p class="text-muted size-12"></p>
                        </div>
                        <div class="col-auto">
                            <!-- <button name="create_record" tool-tip="Tambah data" id="create_record" class="btn btn-44 btn-light shadow-sm">
                                <i class="bi bi-plus-circle"></i>
                            </button> -->
                            <button onclick="return document.getElementById('form').style.display='block'" tool-tip="Tambah data" id="create_record" class="btn btn-44 btn-light shadow-sm" onclick="">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                            <a href="{{ url('Formulir_SPPA.docx') }}" tooltip="Download Formulir" class="btn btn-44 btn-default shadow-sm ms-1">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <div id="form" style="display: none;">
                            <form method="post" action="{{ url('pembayaran/store') }}" />
                            @csrf
                                <div class="row h-100 mb-4">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group form-floating  mb-3">
                                            <select class="form-control" required tabindex="-2" required name="jenis_transaksi" id="select-transaksi" data-live-search="true">
                                                <option value="premi">Pembayaran Premium</option>
                                                <option value="refund">Pembayaran Refund</option>
                                                <option value="klaim">Pembayaran Klaim</option>
                                            </select>
                                            <label for="country">Jenis Transaksi</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4" id="group-kas" style="display:none;">
                                        <div class="form-group form-floating  mb-3">
                                            <select class="form-control" tabindex="-2" name="jenis_kas" id="select-kas" style="width: 100%">
                                                <option></option>
                                                <option value="masuk">Masuk</option>
                                                <option value="keluar">Keluar</option>
                                            </select>
                                            <label for="country">Jenis Kas</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group form-floating  mb-3">
                                            <input type="date" class="form-control" id="tgl_bayar" required name="tgl_bayar"  placeholder="Tanggal Bayar">
                                            <label for="surnames">Tanggal Bayar</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4" id="jumlah-bayar" style="display:none;">
                                        <div class="form-group form-floating  mb-3">
                                            <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar"  placeholder="Jumlah Bayar">
                                            <label for="surnames">Jumlah Bayar</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group  mb-3">
                                            <label for="surnames">Nama</label>
                                            <select name="regid" id="regid" class="form-control select2" style="width: 100% !important;">
                                                <option>Cari Nama</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="form-group form-floating  mb-3">
                                            <button class="btn btn-default btn-lg shadow-sm w-100">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                       <div class="table-responsive">
                            <table id="allData" class="table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Paid ID</th>
                                        <th>No Register</th>
                                        <th>Nama</th>
                                        <th>UP</th>
                                        <th>Premi</th>
                                        <th>Tgl Bayar</th>
                                        <th>Total Bayar</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main page content ends -->
    </main>
    <!-- <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Record</h4>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4" >Name Area : </label>
                        <div class="col-md-12">
                        <input type="text" name="namearea" id="namearea" autocomplete="true" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Note Area : </label>
                        <div class="col-md-12">
                        <input type="text" name="notearea" id="notearea" autocomplete="true" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Prefix Area : </label>
                        <div class="col-md-12">
                        <input type="text" name="prefixarea" id="prefixarea" autocomplete="true" class="form-control" />
                        </div>
                    </div>
                <br />
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-primary btn-block" value="Simpan" />
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
         </form>
        </div>
     </div>
    </div> -->
</div>
<!-- <div id="confirmModal" class="modal hide fade in" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
                <button type="button" class="btn btn-warning"  data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div> -->

    @endsection
    @section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#select-transaksi').on('change', function()
        {
            if (this.value == "refund") {
                document.getElementById('group-kas').style.display='block';
                document.getElementById('jumlah-bayar').style.display='none';
            }else if (this.value == "klaim") {
                document.getElementById('jumlah-bayar').style.display='block';
                document.getElementById('group-kas').style.display='none';
            }else{
                document.getElementById('group-kas').style.display='none';
                document.getElementById('jumlah-bayar').style.display='none';
            }
        });
        $(function() {
            $('#allData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                  url: '{{ url("/pembayaran/desktop")}}',
                  data: function (d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    {
                        data: 'paidid',
                        name: 'paidid',
                    },
                    {
                        data: 'regid',
                        name: 'regid'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'up',
                        name: 'up',
                        render: $.fn.dataTable.render.number( ',', 'Rp' )
                    },
                    {
                        data: 'premi',
                        name: 'premi',
                        render: $.fn.dataTable.render.number( ',', 'Rp' )
                    },
                    {
                        data: 'paiddt',
                        name: 'paiddt'
                    },
                    {
                        data: 'paidamt',
                        name: 'paidamt',
                        render: $.fn.dataTable.render.number( ',', 'Rp' )
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    
                ]
            });
            // $(".select2").select2({
            //     minimumInputLength: 3,
            //     theme: 'bootstrap4',
            //     closeOnSelect: false,
            //   });
            $('.select2').select2({
                   minimumInputLength: 3,
                   allowClear: true,
                   theme: 'bootstrap4',
                   placeholder: 'Masukan Nama atau Regid',
                   ajax: {
                      dataType: 'json',
                      url: '{{ url("/pembayaran/get_nama") }}',
                      delay: 100,
                      data: function(params) {
                        return {
                          search: params.term,
                          jenis_transaksi: document.getElementById('select-transaksi').value,
                          jenis_kas: document.getElementById('select-kas').value,
                        }
                      },
                      processResults: function (data, page) {
                      return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                      };
                    },
                  }
              }).on('select2:select', function (evt) {
                 var data = $(".select2 option:selected").text();
                 // alert("Data yang dipilih adalah "+data);
              });
            // $('.select2').select2();
        });
       
    </script>
    
    
    @endsection