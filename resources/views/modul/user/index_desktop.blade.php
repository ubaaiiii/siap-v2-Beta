@extends('layouts.app')
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
                            <a  onclick="return document.getElementById('form').style.display='block'" tooltip="Tambah data" id="create_record" class="btn btn-44 btn-light shadow-sm">
                                <i class="bi bi-plus-circle"></i>
                            </a>
                            <a href="{{ url('Formulir_SPPA.docx') }}" tooltip="Download Formulir" class="btn btn-44 btn-default shadow-sm ms-1">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <div id="form" style="display: none;">
                            <form method="post" action="{{ url('user/store') }}" />
                            @csrf
                                <div class="row h-100 mb-4">
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="form-group form-floating  mb-3">
                                            <input type="text" class="form-control" id="nip"  name="nip"  placeholder="NIP">
                                            <label for="surnames">NIP</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="form-group form-floating  mb-3">
                                            <input type="text" class="form-control" id="nama"  name="nama"  placeholder="Nama">
                                            <label for="surnames">Nama</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="form-group form-floating  mb-3">
                                            <input type="email" class="form-control" id="email"  name="email"  placeholder="email">
                                            <label for="surnames">email</label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6">
                                        <div class="form-group form-floating  mb-3">
                                            <input type="text" class="form-control" id="nohp"  name="nohp"  placeholder="No HP">
                                            <label for="surnames">No HP</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group form-floating mb-3">
                                            <select class="form-control" name="level" id="country" >
                                                <option value="" ></option>
                                                @foreach($hakakses as $item)
                                                <option value="{{ $item->comtabid }}">{{ $item->comtab_nm }}</option>
                                                @endforeach
                                            </select>
                                            <label for="country">Hak Akses</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group form-floating mb-3">
                                            <select class="form-control" name="cabang" id="country" >
                                                <option value="" ></option>
                                                @foreach($cabang as $item)
                                                <option value="{{ $item->comtabid }}">{{ $item->comtab_nm }}</option>
                                                @endforeach
                                            </select>
                                            <label for="country">Cabang</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group form-floating mb-3">
                                            <select class="form-control" name="mitra" id="country" >
                                                <option value="" ></option>
                                                @foreach($mitra as $item)
                                                <option value="{{ $item->comtabid }}">{{ $item->comtab_nm }}</option>
                                                @endforeach
                                            </select>
                                            <label for="country">Mitra</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group form-floating mb-3">
                                            <select class="form-control" name="parent" id="country" >
                                                <option value="" ></option>
                                                @foreach($supervisior as $item)
                                                <option value="{{ $item->comtabid }}">{{ $item->comtab_nm }}</option>
                                                @endforeach
                                            </select>
                                            <label for="country">Supervisior</label>
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
                                        <th>Action </th>
                                        <th>Username</th>
                                        <th>Password </th>
                                        <th>Nama</th>
                                        <th>Parent</th>
                                        <th>Cabang</th>
                                        <th>Mitra</th>
                                        <th>Level</th>
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
    <script>
        $(function() {
            $('#allData').DataTable({
                processing: true,
                serverSide: true,
                pagingType: "input",
                ajax: {
                  url: '{{ url("/user/desktop")}}',
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
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'supervisor',
                        name: 'supervisor'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'parent',
                        name: 'parent'
                    },
                    {
                        data: 'cab',
                        name: 'cab'
                    },
                    {
                        data: 'mitra',
                        name: 'mitra'
                    },
                    {
                        data: 'utype',
                        name: 'utype'
                    },     
                ]
            });
        });
       
    </script>
    
    
    @endsection