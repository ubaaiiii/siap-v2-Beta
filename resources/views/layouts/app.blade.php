<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ url('assets/img/favicon180.png') }}" sizes="180x180">
    <link rel="icon" href="{{ url('assets/img/favicon32.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ url('assets/img/favicon16.png') }}" sizes="16x16" type="image/png">
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- bootstrap icons -->


    <!-- ############################################# CSS ############################################# -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- swiper carousel css -->
    <link rel="stylesheet" href="{{ url('assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css') }}">
    <!-- style css for this template -->
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" id="style">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('assets/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Datatable -->
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.3/css/dataTables.jqueryui.min.css" rel="stylesheet">

    <!-- Daterangepicker -->
    <link rel="stylesheet" href="{{ url('assets/vendor/daterangepicker/daterangepicker.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}

    <!-- Video.js -->
    <!-- link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" / -->
    <link href="{{ url('assets/css/video-js.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/css/videojs-playlist-ui.vertical.css') }}" rel="stylesheet" />


    <!-- ############################################# JS ############################################# -->
    <!-- Jquery -->
    <script src="{{ url('assets/js/jquery-3.3.1.min.js') }}"></script>

    <!-- Moment -->
    <script src="{{ url('assets/js/moment.min.js') }}"></script>
    <!-- Daterangepicker -->
    <script src="{{ url('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Required jquery and libraries -->
    <script src="{{ url('assets/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/jquery.inputmask.min.js') }}"></script>
    <!-- cookie js -->
    <script src="{{ url('assets/js/jquery.cookie.js') }}"></script>
    <!-- Customized jquery file  -->
    <script src="{{ url('assets/js/main.js') }}"></script>
    <script src="{{ url('assets/js/color-scheme.js') }}"></script>

    <!-- Video.js -->
    <script src="{{ url('assets/js/video.min.js') }}"></script>
    <script src="{{ url('assets/js/videojs-playlist.min.js') }}"></script>
    <script src="{{ url('assets/js/videojs-playlist-ui.min.js') }}"></script>
    <!-- Chart js script -->
    <script src="{{ url('assets/vendor/chart-js-3.3.1/chart.min.js') }}"></script>
    <!-- Progress circle js script -->
    <script src="{{ url('assets/vendor/progressbar-js/progressbar.min.js') }}"></script>
    <!-- swiper js script -->
    <script src="{{ url('assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js') }}"></script>
    <!-- page level custom script -->
    <script src="{{ url('assets/js/app.js') }}"></script>
    <!-- Datatables -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.12.1/pagination/input.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <!-- Select2 -->
    <!-- <script src="{{ url('assets/vendor/select2/js/select2.full.min.js') }}"></script> -->
    <style>
        /* @media screen and (min-width: 768px) {
            .tampilan-mobile {
                display: none !important;
                position: fixed;
            }
        } */
    </style>
    @yield('style')

</head>
<body class="body-scroll" data-page="index">
    <!-- loader section -->
    <div class="container-fluid loader-wrap">
        <div class="row h-100">
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto text-center align-self-center">
                <div class="loader-cube-wrap loader-cube-animate mx-auto">
                    <img src="{{ asset(config('app.logo', 'assets/img/logo.png')) }}" alt="Logo">
                </div>
                <h2 class="mt-4"><strong>Please wait...</strong></h2>
            </div>
        </div>
    </div>
    @php
        $urlnya = explode("/", substr($_SERVER['REQUEST_URI'], 1));

        // remove adm from url
        if (($key = array_search("adm", $urlnya)) !== false) {
            unset($urlnya[$key]);
        }

        // get the first value of array
        foreach ($urlnya as $key => $value) {
            $route = $value;
            continue;
        }
    @endphp
    <!-- loader section ends -->
    <!-- Sidebar main menu -->
    @include('layouts.sidebar')
    <!-- Sidebar main menu ends -->

        @yield('content')
        <!-- main page content ends -->

    <!-- Footer -->
    <div class="tampilan-mobile">
	    <footer class="footer">
	        <div class="container ">
	            <ul class="nav nav-pills nav-justified">
	                <li class="nav-item">
	                    <a class="nav-link {{ ($route == 'index' ? 'active' : '') }}" href="{{ url('index') }}">
	                        <span>
	                            <i class="nav-icon bi bi-house"></i>
	                            <span class="nav-text">Home</span>
	                        </span>
	                    </a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="{{ url('index?q=statistics') }}">
	                        <span>
	                            <i class="nav-icon bi bi-laptop"></i>
	                            <span class="nav-text">Statistics</span>
	                        </span>
	                    </a>
	                </li>
	                <li class="nav-item centerbutton">
	                    <div class="nav-link">
	                        <span class="theme-radial-gradient">
	                            <i class="close bi bi-x"></i>
	                            {{-- <i class="nav-icon bi bi-clipboard-data"></i> --}}
	                            <img src="{{ url('assets/img/centerbutton.svg') }}" class="nav-icon" alt="" />
	                        </span>
	                        <div class="nav-menu-popover justify-content-between">
	                            <button type="button" class="btn btn-lg btn-icon-text"
	                                onclick="window.location.replace('{{ url('pengajuan') }}');">
	                                <i class="bi bi-person-plus size-32"></i><span>Pengajuan</span>
	                            </button>
	                            <button type="button" class="btn btn-lg btn-icon-text"
	                                onclick="window.location.replace('{{ url('Formulir_SPPA.docx') }}');">
	                                <i class="bi bi-file-earmark-arrow-down size-32"></i><span>Form SPPA</span>
	                            </button>
	                            <button type="button" class="btn btn-lg btn-icon-text"
	                                onclick="window.location.replace('{{ url('pembatalan') }}');">
	                                <i class="bi bi-receipt size-32"></i><span>Pembatalan</span>
	                            </button>
	                            <button type="button" class="btn btn-lg btn-icon-text"
	                                onclick="window.location.replace('{{ url('klaim') }}');">
	                                <i class="bi bi-receipt-cutoff size-32"></i><span>Klaim</span>
	                            </button>
	                        </div>
	                    </div>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link {{ ($route == 'sertifikat' ? 'active' : '') }}" href="{{ url('sertifikat') }}">
	                        <span>
	                            <i class="nav-icon bi bi-patch-check"></i>
	                            <span class="nav-text">Sertifikat</span>
	                        </span>
	                    </a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link {{ ($route == 'laporan' ? 'active' : '') }}" href="{{ url('laporan') }}">
	                        <span>
	                            <i class="nav-icon bi bi-file-earmark-ruled"></i>
	                            <span class="nav-text">Laporan</span>
	                        </span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </footer>
	</div>
    <!-- Footer ends-->
    <div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-10" id="alert">
        <div class="toast toast-berhasil mb-3 fade hide" role="alert" aria-live="assertive" aria-atomic="true" id="alertSave"
            data-bs-animation="true">
            <div class="toast-header">
                <img src="{{ asset('assets/img/logo.png') }}"  width="20px" class="rounded me-2" alt="...">
                <strong class="me-auto">SELAMAT!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <div class="row">
                    <div class="col berhasil">
                        Apakah Anda yakin ingin menyimpan ini?
                    </div>
                    <div class="col error">
                        Apakah Anda yakin ingin menghapus ini?
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PWA app install toast message -->
    <!-- <div class="position-fixed bottom-0 start-50 translate-middle-x  z-index-10">
        <div class="toast mb-3" role="alert" aria-live="assertive" aria-atomic="true" id="toastinstall"
            data-bs-animation="true">
            <div class="toast-header">
                <img src="{{ url('assets/img/favicon32.png') }}" class="rounded me-2" alt="...">
                <strong class="me-auto">Install PWA App</strong>
                <small>now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <div class="row">
                    <div class="col">
                        Click "Install" to install PWA app & experience indepedent.
                    </div>
                    <div class="col-auto align-self-center ps-0">
                        <button class="btn-default btn btn-sm" id="addtohome">Install</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    @yield('script')
    <script>
    // Kita lakukan binding pada window, saat DOM content di load, halaman di load, ataupun diresize maka kita lakukan
    // $(window).bind('DOMContentLoaded load resize', function() {
       // pengecekan ukuran width window, bila widthnya lebih kecil atau sama dengan 500
       // if($(window).innerWidth() <= 500) {
       //    // Kita remove class navbar-fixed
       //    $('#mynavbar').removeClass('navbar-fixed');
       // }else{
       //    // diluar dari kondisi diatas kita akan add class navbar-fixed
       //    $('#mynavbar').addClass('navbar-fixed');
       // }
    // });
    </script>
    <script>
        function hitungUsia($masa = null) {
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
                // var years = date_tglmulai.diff(date_tgllahir, 'year');
                // date_tgllahir.add(years, 'years');
                // var months = date_tglmulai.diff(date_tgllahir, 'months');
                // date_tgllahir.add(months, 'months');
                // var days = date_tglmulai.diff(date_tgllahir, 'days');
                // console.log(years,months,days);

                var tahun_masuk = date_tglmulai.diff(date_tgllahir, 'year');
                // date_tgllahir.add(tahun_masuk, 'years');

                // date_tgllahir.add(masa, 'months');
                date_tgllahir.add(-masa, 'months');

                var years = date_tglmulai.diff(date_tgllahir, 'year');
                date_tgllahir.add(years, 'years');

                var months = date_tglmulai.diff(date_tgllahir, 'months');
                date_tgllahir.add(months, 'months');

                var days = date_tglmulai.diff(date_tgllahir, 'days');

                // console.log('tgl akhir:',date_tglmulai.format('YYYY-MM-DD'));
                // console.log(years + ' years ' + months + ' months ' + days + ' days');
                console.log(years,tahun_masuk);

                $('#akhir').val(date_tglmulai.format('YYYY-MM-DD'));
                // var tahun_masuk = years;
                if (months >= 6) tahun_masuk++;
                $('#usia-masuk').val(tahun_masuk + " tahun ");
                $('#usia-akhir').val(years + " tahun " + months + " bulan " + days + " hari");
            }
        }
        function hitungpremi(b) {
            var asuransi    = $('#asuransi').val();
            var produk      = $('#produk').val();
            var jkel        = $('#jkel').val();
            var usia        = $('#usia-masuk').val();
            var masa        = $('#masa').val();
            var up          = $('#up').val();
            // console.log(asuransi);
            // up = b.value;
            $.ajax({
                type : 'get',
                url : '{{ url("hitungpremi") }}',
                data:{'up':up,'asuransi':asuransi,'produk':produk,'jkel':jkel,'usia':usia,'masa':masa},
                success:function(premi){
                    $('#total_premi').val(premi);
                    if (premi == 0) {
                        $(':input[type="submit"]').prop('disabled', true);
                    } else {
                        $(':input[type="submit"]').prop('disabled', false);
                    }
                    // var table = "#t"+tfilter;
                    // console.log(premi);
                }
            })
        }
        $(document).ready(function() {
            // $('.select2').on('select2:select', function (e) {
            //     $(this).focus();
            // });
            $(".currency").inputmask("decimal", {
                alias: "numeric",
                groupSeparator: ",",
                autoGroup: true,
                digits: 2,
                radixPoint: ".",
                digitsOptional: false,
                placeholder: "0",
            });
            $('#hubungan').on('select2:clear',function(){
                $('#div-hubungan').css('display','none');
            });

            $('#hubungan').on('select2:select',function(){
                console.log('hubungan selected');
                var v = $(this).val();

                if (v=="HB07") {
                    $('#div-hubungan').removeAttr('style');
                    $('#ket-hubungan').prop('required',true);
                } else {
                    $('#div-hubungan').css('display','none');
                    $('#ket-hubungan').removeAttr('required');
                }
            });
            // $('.select2').select2();
            // $('.select2bs4').select2({
            //   theme: 'bootstrap4'
            // })
            // rumah = document.querySelector('#allData');
            // rumah.classList.remove('dataTable');
        });
    </script>
    <!-- @if ($message = Session::get('error'))
    <script>
      $('.toast-berhasil').toast('show');
    </script>
    @endif -->
    <script>

        // function hitungUsia() {
        //     var tgllahir = $('#tgllahir').val(),
        //         mulai    = $('#mulai').val(),
        //         masa     = 0;

        //     if (tgllahir.length > 0 && mulai.length > 0) {
        //         tgllahir = tgllahir.split('-');
        //         mulai    = mulai.split('-');

        //         if ($('#masa').val().length > 0) {
        //             masa = $('#masa').val();
        //         }

        //         var date_tglmulai = moment([parseInt(mulai[0]), parseInt(mulai[1]) - 1, parseInt(mulai[2])]);
        //         var date_tgllahir = moment([parseInt(tgllahir[0]), parseInt(tgllahir[1]) - 1, parseInt(tgllahir[2])]);

        //         date_tgllahir.add(-masa, 'months');

        //         var years = date_tglmulai.diff(date_tgllahir, 'year');
        //         date_tgllahir.add(years, 'years');

        //         var months = date_tglmulai.diff(date_tgllahir, 'months');
        //         date_tgllahir.add(months, 'months');

        //         var days = date_tglmulai.diff(date_tgllahir, 'days');

        //         date_tglmulai.add(masa, 'months');

        //         // console.log('tgl akhir:',date_tglmulai.format('YYYY-MM-DD'));

        //         // console.log(years + ' years ' + months + ' months ' + days + ' days');

        //         $('#akhir').val(date_tglmulai.format('YYYY-MM-DD'));
        //         $('#usia').val(years + " tahun " + months + " bulan " + days + " hari");
        //     }
        // }
        // function tandaPemisahTitik(b) {
        //       var _minus = false;
        //       if (b < 0) _minus = true;
        //       b = b.toString();
        //       b = b.replace(".", "");
        //       b = b.replace("-", "");
        //       c = "";
        //       panjang = b.length;
        //       j = 0;
        //       for (i = panjang; i > 0; i--) {
        //          j = j + 1;
        //          if (((j % 3) == 1) && (j != 1)) {
        //             c = b.substr(i - 1, 1) + "." + c;
        //          } else {
        //             c = b.substr(i - 1, 1) + c;
        //          }
        //       }
        //       if (_minus) c = "-" + c;
        //       return c;
        //    }
        //    function numbersonly(ini, e) {
        //       if (e.keyCode >= 49) {
        //          if (e.keyCode <= 57) {
        //             a = ini.value.toString().replace(".", "");
        //             b = a.replace(/[^\d]/g, "");
        //             b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
        //             ini.value = tandaPemisahTitik(b);
        //             return false;
        //          } else if (e.keyCode <= 105) {
        //             if (e.keyCode >= 96) {
        //                //e.keycode = e.keycode - 47;
        //                a = ini.value.toString().replace(".", "");
        //                b = a.replace(/[^\d]/g, "");
        //                b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode - 48);
        //                ini.value = tandaPemisahTitik(b);
        //                //alert(e.keycode);
        //                return false;
        //             } else {
        //                return false;
        //             }
        //          } else {
        //             return false;
        //          }
        //       } else if (e.keyCode == 48) {
        //          a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
        //          b = a.replace(/[^\d]/g, "");
        //          if (parseFloat(b) != 0) {
        //             ini.value = tandaPemisahTitik(b);
        //             return false;
        //          } else {
        //             return false;
        //          }
        //       } else if (e.keyCode == 95) {
        //          a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
        //          b = a.replace(/[^\d]/g, "");
        //          if (parseFloat(b) != 0) {
        //             ini.value = tandaPemisahTitik(b);
        //             return false;
        //          } else {
        //             return false;
        //          }
        //       } else if (e.keyCode == 8 || e.keycode == 46) {
        //          a = ini.value.replace(".", "");
        //          b = a.replace(/[^\d]/g, "");
        //          b = b.substr(0, b.length - 1);
        //          if (tandaPemisahTitik(b) != "") {
        //             ini.value = tandaPemisahTitik(b);
        //          } else {
        //             ini.value = "";
        //          }
        //          return false;
        //       } else if (e.keyCode == 9) {
        //          return true;
        //       } else if (e.keyCode == 17) {
        //          return true;
        //       } else {
        //          //alert (e.keyCode);
        //          return false;
        //       }
        //    }
    </script>
    @if ($message = Session::get('success'))

        <script type="text/javascript">
           swal ( "Good" ,  "{{ Session::get('success') }}" ,  "success" );
        </script>
    @endif
    @if ($message = Session::get('error'))

        <script type="text/javascript">
           swal ( "Gagal" ,  "{{ Session::get('error') }}" ,  "error" );
        </script>
    @endif
</body>
</html>
