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
                            
                        </div>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                       <div class="table-responsive">
                            <table id="allData" class="table nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Action </th>
                                        <th>No Register </th>
                                        <th>Nama</th>
                                        <th>Tgl Lahir</th>
                                        <th>Mulai</th>
                                        <th>UP</th>
                                        <th>Premi </th>
                                        <th>Produk </th>
                                        <th>Tenor </th>
                                        <th>No Pinjaman </th>
                                        <th>Cabang </th>
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
    @endsection
    @section('script')
    <script>
        $(function() {
            $('#allData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                  url: '{{ url("/checker/desktop")}}',
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
                        data: 'regid',
                        name: 'regid'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tgllahir',
                        name: 'tgllahir'
                    },
                    {
                        data: 'mulai',
                        name: 'mulai',
                        render: $.fn.dataTable.render.number( ',', '.','', 'Rp' )
                    },
                    {
                        data: 'up',
                        name: 'up',
                        render: $.fn.dataTable.render.number( ',', '.','', 'Rp' )
                    },
                    {
                        data: 'premi',
                        name: 'premi',
                        render: $.fn.dataTable.render.number( ',', '.','', 'Rp' )
                    },                 
                    {
                        data: 'produk',
                        name: 'produk'
                    },
                    {
                        data: 'masa',
                        name: 'masa'
                    },
                    {
                        data: 'nopeserta',
                        name: 'nopeserta'
                    },
                    {
                        data: 'cabang',
                        name: 'cabang'
                    },
                ]
            });
        });
       
    </script>
    
    
    @endsection