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
                            <!-- <a href="{{ url('/pengajuan/add')}}" tool-tip="Tambah data" id="create_record" class="btn btn-44 btn-light shadow-sm">
                                <i class="bi bi-plus-circle"></i>
                            </a>
                            <a href="withdraw.html" class="btn btn-44 btn-default shadow-sm ms-1">
                                <i class="bi bi-arrow-down-circle"></i>
                            </a> -->
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ url('laporan/cetak') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');>
                    @csrf
                    <input type="hidden" name="level" value="<?php echo $vlevel; ?>">
                    <input type="hidden" name="uid" value="<?php echo $userid; ?>">
                    <input type="hidden" name="cab" value="<?php echo $ucab; ?>">
                    <div class="main-container container">
                        <div class="row h-100 mb-4">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="date" class="form-control" name="tgl1" required  placeholder="Name" id="names">
                                    <label for="names">Tanggal Awal</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="date" class="form-control" name="tgl2" required  placeholder="Name" id="names">
                                    <label for="names">Tanggal Akhir</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="produk" required name="sfilter1">
                                        @foreach($produk as $item)
                                        <option value="{{ $item->scode }}">{{ $item->sdesc }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Produk</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="country" required name="sfilter2">
                                        @foreach($sel_cabang as $item)
                                        <option value="{{ $item->scode }}">{{ $item->sdesc }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Cabang</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="country" required name="sfilter3">
                                        @foreach($asuransi as $item)
                                        <option value="{{ $item->scode }}">{{ $item->sdesc }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Asuransi</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="country" required name="treport">
                                        @foreach($report as $item)
                                        <option value="{{ $item->scode }}">{{ $item->sdesc }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Jenis Laporan</label>
                                </div>
                            </div>

                        </div>


                        <!-- add edit address form -->

                        <div class="row h-100 ">
                            <div class="col-12 mb-4">
                                <button  class="btn btn-lg btn-default w-100 mb-4 shadow" type="submit">Cetak</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                ajax: '{{ url("/area/data")}}',
                columns: [
                    {
                        data: 'id_area',
                        name: 'id_area'
                    },
                    {
                        data: 'namearea',
                        name: 'namearea'
                    },
                    {
                        data: 'notearea',
                        name: 'notearea'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });
        });

        $('#create_record').click(function(){
        $('.modal-title').text('Add New Record');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function(event){
            event.preventDefault();
            var action_url = '';
            if($('#action').val() == 'Add')
            {
            // action_url = "{{ url('area.store') }}";
            }
            if($('#action').val() == 'Edit')
            {
            // action_url = "{{ url('area.update') }}";
            }
            $.ajax({
            url: action_url,
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                var html = '';
                if(data.errors)
                {
                html = '<div class="alert alert-danger">';
                for(var count = 0; count < data.errors.length; count++)
                {
                html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
                }
                if(data.success)
                {
                html = '<div class="alert alert-success">' + data.success + '</div>';
                $('#sample_form')[0].reset();
                $('#allData').DataTable().ajax.reload();
                }
                $('#form_result').html(html);
            }
            });
            });
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                url :"{{ url('') }}/area/edit/"+id,
                dataType:"json",
                success:function(data)
                {
                    // console.log(data.result[0].namearea);
                    $('#namearea').val(data.result[0].namearea);
                    $('#notearea').val(data.result[0].notearea);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Record');
                    $('#action_button').val('Edit');
                    $('#action').val('Edit');
                    $('#formModal').modal('show');
                }
                })
                });
            var user_id;
            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });
            $('#ok_button').click(function(){
                $.ajax({
                    url:"area/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#allData').DataTable().ajax.reload();
                        alert('Data Deleted');
                        }, 2000);
                    }
                })
            });
    </script>


    @endsection
