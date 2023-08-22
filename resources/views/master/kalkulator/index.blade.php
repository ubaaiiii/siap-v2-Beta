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
                <div class="main-container container">
                    <form action="{{ url('kalkulator/hitung') }}" method="post">
                        @csrf
                        <div class="row h-100 mb-4">
                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="country" name="produk" required>
                                        @foreach($produk as $p)
                                        <option value="{{ $p->comtabid }}">{{ $p->comtab_nm }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Produk</label>
                                </div>
                            </div>
							<div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="country" name="asuransi" required>
                                        @foreach($asuransi as $p)
                                        <option value="{{ $p->comtabid }}">{{ $p->comtab_nm }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Asuransi</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
							<div class="form-group form-floating  mb-3">
								<select  class="form-control" id="country" name="jkel" required>
								@foreach($jkel as $p)
								 <option value="{{ $p->comtabid }}">{{ $p->comtab_nm }}</option>
								@endforeach
								</select>
							<label for="names">Jenis Kelamin</label>
							</div>
							</div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="date" class="form-control" name="tgllahir" required placeholder="Tanggal Lahir" id="names">
                                    <label for="names">Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="date" class="form-control" name="mulai" required placeholder="Name" id="names">
                                    <label for="names">Mulai Asuransi</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="number" class="form-control" name="masa" required placeholder="Name" id="names">
                                    <label for="names">Masa Asuransi</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="text" class="form-control" name="up"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required placeholder="Name" id="names">
                                    <label for="names">Jumlah Pinjaman</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group form-floating  mb-3">
                                    <input type="number" min="0" max="100" class="form-control" name="gp" required placeholder="Name" id="names" value=0>
                                    <label for="names">Grace Period (khusus produk MPP)</label>
                                </div>
                            </div>
                        
                        </div>
                    
                        <!-- add edit address form -->
                        
                        <div class="row h-100 ">
                            <div class="col-12 mb-4">
                                <button class="btn btn-lg btn-default w-100 mb-4 shadow">Hitung</button>
                            </div>
                        </div>
                    </form>
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
        function tandaPemisahTitik(b) {
            var _minus = false;
            if (b < 0) _minus = true;
            b = b.toString();
            b = b.replace(".", "");
            b = b.replace("-", "");
            c = "";
            panjang = b.length;
            j = 0;
            for (i = panjang; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                    c = b.substr(i - 1, 1) + "." + c;
                } else {
                    c = b.substr(i - 1, 1) + c;
                }
            }
            if (_minus) c = "-" + c;
            return c;
        }
        function numbersonly(ini, e) {
            if (e.keyCode >= 49) {
                if (e.keyCode <= 57) {
                    a = ini.value.toString().replace(".", "");
                    b = a.replace(/[^\d]/g, "");
                    b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
                    ini.value = tandaPemisahTitik(b);
                    return false;
                } else if (e.keyCode <= 105) {
                    if (e.keyCode >= 96) {
                        //e.keycode = e.keycode - 47;
                        a = ini.value.toString().replace(".", "");
                        b = a.replace(/[^\d]/g, "");
                        b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode - 48);
                        ini.value = tandaPemisahTitik(b);
                        //alert(e.keycode);
                        return false;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else if (e.keyCode == 48) {
                a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
                b = a.replace(/[^\d]/g, "");
                if (parseFloat(b) != 0) {
                    ini.value = tandaPemisahTitik(b);
                    return false;
                } else {
                    return false;
                }
            } else if (e.keyCode == 95) {
                a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
                b = a.replace(/[^\d]/g, "");
                if (parseFloat(b) != 0) {
                    ini.value = tandaPemisahTitik(b);
                    return false;
                } else {
                    return false;
                }
            } else if (e.keyCode == 8 || e.keycode == 46) {
                a = ini.value.replace(".", "");
                b = a.replace(/[^\d]/g, "");
                b = b.substr(0, b.length - 1);
                if (tandaPemisahTitik(b) != "") {
                    ini.value = tandaPemisahTitik(b);
                } else {
                    ini.value = "";
                }
                return false;
            } else if (e.keyCode == 9) {
                return true;
            } else if (e.keyCode == 17) {
                return true;
            } else {
                //alert (e.keyCode);
                return false;
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var d = new Date();
            function twoDigitDate(d) {
                return ((d.getDate()).toString().length == 1) ? "0" + (d.getDate()).toString() : (d.getDate()).toString();
            };
            function twoDigitMonth(d) {
                return ((d.getMonth() + 1).toString().length == 1) ? "0" + (d.getMonth() + 1).toString() : (d.getMonth() + 1).toString();
            };
            var today_ISO_date = d.getFullYear() + "-" + twoDigitMonth(d) + "-" + twoDigitDate(d); // in yyyy-mm-dd format
            document.getElementById('datepicker').setAttribute("value", today_ISO_date);
            var dd_mm_yyyy;
            $("#datepicker").change(function() {
                changedDate = $(this).val(); //in yyyy-mm-dd format obtained from datepicker
                var date = new Date(changedDate);
                dd_mm_yyyy = twoDigitDate(date) + "/" + twoDigitMonth(date) + "/" + date.getFullYear(); // in dd-mm-yyyy format
                $('#textbox').val(dd_mm_yyyy);
                //console.log($(this).val());
                //console.log("Date picker clicked");
            });
        });
    </script>
    
    
    
    @endsection