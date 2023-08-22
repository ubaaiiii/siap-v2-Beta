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
        <div class="card shadow-sm mb-4 cards" style="">
            <script>
                // var screenSize = window.screen.availWidth - 200;
                // var style = 'width: ' + screenSize + 'px !important; margin-left:-350px !important;';
                // console.log(style);
                // $('.cards').attr('style', style);
            </script>
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <!-- <figure class="avatar avatar-44 rounded-10">
                                <img src="assets/img/user1.jpg" alt="">
                            </figure> -->
                    </div>
                    <div class="col px-0 align-self-center">
                        <h5 class="mb-0 text-color-theme test">{{ $data['judul']}}</h5>
                        {{-- <p class="text-muted size-4 col-md-3 col-sm-11">
                            <input type="text" class="form-control" required="" name="range_tanggal" id="range_tanggal">
                        </p> --}}
                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="allData" class="table nowrap">
                            <thead>
                                <tr>
                                    <th>No Register</th>
                                    <th>Nama</th>
                                    <th>Asuransi</th>
                                    <th>Produk</th>
                                    <th>No Sertifikat</th>
                                    <th>Tgl Lahir</th>
                                    <th>Mulai</th>
                                    <th>UP</th>
                                    <th>Premi</th>
                                    <th>Cabang</th>
                                    <th>AO</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No Register</th>
                                    <th>Nama</th>
                                    <th>Asuransi</th>
                                    <th>Produk</th>
                                    <th>No Sertifikat</th>
                                    <th>Tgl Lahir</th>
                                    <th>Mulai</th>
                                    <th>UP</th>
                                    <th>Premi</th>
                                    <th>Cabang</th>
                                    <th>AO</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
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
    function reloadTable() {
        $('#allData').DataTable().ajax.reload();
    }
    $(document).ready(function() {
        var tablenya = $('#allData').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            columnDefs: [
                {
                    targets: [7,8],
                    className: 'dt-body-right'
                },
                @if ($data['user']->layoutmode == 'dark-mode')
                {
                targets: "_all",
                className: 'text-gray'
                },
                @endif
            ],

            order: [0, 'desc'],
            bLengthChange: true,
            pagingType: "input",
            language: {
                url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Indonesian.json"
            },
            colReorder: true,
            ajax: {
                url: '{{ url("/inquiry/data")}}',
                data: function(d) {
                    <?php if (!empty($_GET['q'])) { ?>
                        d.q = "<?= $_GET['q']; ?>";
                    <?php } ?>
                    // d.search = $('input[type="search"]').val();
                },
                // success: function(resp) {
                //     console.log('resp',resp);
                // },
                error: function(resp) {
                    resp = JSON.stringify(resp);
                    if (~resp.indexOf("Sign in")) {
                        Swal.fire(
                            'Harap Login Kembali!',
                            'Sesi login Anda telah berakhir, anda tidak dapat mengakses halaman ini',
                            'error'
                        ).then(() => {
                            window.location = "{{ url('login') }}";
                        })
                    } else {
                        alert(resp);
                    }
                }
            },
            aoColumns: [
                { "data": "regid" },
                { "data": "nama" },
                { "data": "asuransi" },
                { "data": "produk" },
                { "data": "policyno" },
                { "data": "tgllahir" },
                { "data": "mulai" },
                { "data": "up" },
                { "data": "tpremi" },
                { "data": "cabang" },
                { "data": "createby" },
                { "data": "status" },
                { "data": "regid" },
            ],
            "drawCallback": function( settings ) {
                // console.log('init');
                if ($('html').attr('class') == 'dark-mode') {
                    $('table').css('color','white')
                } else {
                    $('table').css('color','black')
                }
            },
            "initComplete": function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;
                        let id = _.kebabCase("search "+title);

                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        input.className = "form-control";
                        input.setAttribute("id", id);
                        column.footer().replaceChildren(input);

                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });

                <?php if (!empty($_GET['q'])) { ?>
                $('#allData_filter input').val('{{ $_GET['q'] }}');
                <?php } ?>
            }
        });

        $(window).focus(function() {
            reloadTable();
        });

        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#range_tanggal').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#range_tanggal').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                'Hari ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Minggu ini': [moment().subtract(6, 'days'), moment()],
                'Sebulan terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });

        $('#range_tanggal').inputmask("99/99/9999 - 99/99/9999");

    });
</script>

@endsection
