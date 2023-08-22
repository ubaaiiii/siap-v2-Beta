@extends('layouts.app')
    @section('content')
<main class="h-100 has-header">
        <!-- Header -->
        <header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-light btn-44 back-btn" onclick="window.location.replace('profile.html');">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <div class="col align-self-center text-center">
                    <h5>Revisi</h5>
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
                                    $teks = 'U';
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
                            <h3 class="mb-0 text-color-theme">{{ Session::get('login')[0]->username }}</h3>
                            <p class="text-muted ">{{ Session::get('login')[0]->level }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            <form method="post" action="{{ url('revisi/store') }}" />
            @csrf
            <div class="row h-100 mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <select class="form-control" name="jenrev" id="select-jnsrev" >
                            <!--  -->
                            @foreach($jnsrev as $item)
                            <option value="{{ $item->comtabid }}">{{ $item->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="country">Produk</label>
                       
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <select class="form-control" disabled name="produk" id="country" >
                            <!--  -->
                            @foreach($produk as $p)
                            <option value="{{ $p->comtabid }}">{{ $p->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="country">Produk</label>
                       
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" disabled name="regid" value="{{ $data[0]->regid }}" placeholder="Name" id="names">
                        <label for="names">No Register</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="R7 R-all form-control" disabled name="nopeserta" value="{{ $data[0]->nopeserta }}" placeholder="Name" id="names">
                        <label for="names">No Pinjaman</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" disabled name="nama" value="{{ $data[0]->nama }}" placeholder="Name" id="names">
                        <label for="names">Nama</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="date" class="form-control"  disabled name="noktp" value="{{ $data[0]->tgllahir }}" placeholder="Name" id="names">
                        <label for="names">Tgl Lahir</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="number" class="form-control"  disabled name="noktp" value="{{ $data[0]->noktp }}" placeholder="Name" id="names">
                        <label for="names">No KTP</label>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating mb-3">
                        <select class="form-control" disabled name="jkel" id="country" >
                            
                            @foreach($jkel as $item)
                            <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->jkel) selected @endif >{{ $item->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="country">Jenis Kelamin</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating mb-3">
                        <select class="form-control" id="country" disabled name="mitra" >
                            
                            @foreach($mitra as $item)
                            <option value="{{ $item->comtabid }}" @if($item->comtabid == $data[0]->mitra) selected @endif>{{ $item->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="country">Mitra</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating mb-3">
                        <select class="form-control" id="country" disabled name="cabang" >
                            
                            @foreach($cab as $c)
                            <option value="{{ $c->comtabid }}" @if($item->comtabid == $data[0]->cabang) selected @endif >{{ $c->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="country">Cabang</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating mb-3">
                        <select class="form-control" id="country" disabled name="pekerjaan">
                            
                            @foreach($kerja as $k)
                            <option value="{{ $k->comtabid }}" @if($item->comtabid == $data[0]->pekerjaan) selected @endif >{{ $k->comtab_nm }}</option>
                            @endforeach
                        </select>
                        <label for="country">Pekerjaan</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" id="masa" disabled name="masa" value="{{ $data[0]->masa }}" placeholder="Masa Asuransi" id="surnames">
                        <label for="surnames">Masa Asuransi</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" id="mulai" disabled name="mulai" value="{{ $data[0]->mulai }}" placeholder="Mulai Asuransi" id="surnames">
                        <label for="surnames">Mulai Asuransi</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" id="up" disabled name="up"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="{{ number_format($data[0]->up) }}" placeholder="UP" id="surnames">
                        <label for="surnames">UP</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" id="premi" disabled name="premi"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="{{ number_format($data[0]->premi) }}" placeholder="Premi" id="surnames">
                        <label for="surnames">Premi</label>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating mb-3">
                        <textarea class="form-control" disabled name="subject"></textarea>
                        <label for="emailphone">Catatan</label>
                    </div>
                </div>
                
<!--                 <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating">
                        <input type="file" class="form-control" id="fileupload">
                        <label for="fileupload">Uplaod File</label>
                    </div>
                </div> -->
            </div>
            <!-- add edit address form -->
            
            <div class="row h-100 ">
                <div class="col-12 mb-4">
                    <button  class="btn btn-lg btn-default w-100 mb-4 shadow" type="submit">Simpan</button>
                </div>
            </div>
            </form>
        </div>
        <!-- main page content ends -->
    </main>
    @endsection
    @section('script')
        <script>
            $('#select-jnsrev').on('change', function()
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
            
            $(document).ready(function(){
                $('#hubungan').on('select2:clear',function(){
                    $('#div-hubungan').css('display','none');
                });
                
                $('#hubungan').on('select2:select',function(){
                    var v = $(this).val();
                    
                    if (v=="HB07") {
                        $('#div-hubungan').removeAttr('style');
                        $('#ket-hubungan').prop('required',true);
                    } else {
                        $('#div-hubungan').css('display','none');
                        $('#ket-hubungan').removeAttr('required');
                    }
                });
            })
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
            $(document).ready(function() {
                var d = new Date();
                function twoDigitDate(d) {
                    return ((d.getDate()).toString().length == 1) ? "0" + (d.getDate()).toString() : (d.getDate()).toString();
                };
                function twoDigitMonth(d) {
                    return ((d.getMonth() + 1).toString().length == 1) ? "0" + (d.getMonth() + 1).toString() : (d.getMonth() + 1).toString();
                };
                var today_ISO_date = d.getFullYear() + "-" + twoDigitMonth(d) + "-" + twoDigitDate(d); // in yyyy-mm-dd format
                var dd_mm_yyyy;
                $("#datepicker").change(function() {
                    changedDate = $(this).val(); //in yyyy-mm-dd format obtained from datepicker
                    var date = new Date(changedDate);
                    dd_mm_yyyy = twoDigitDate(date) + "/" + twoDigitMonth(date) + "/" + date.getFullYear(); // in dd-mm-yyyy format
                    $('#textbox').val(dd_mm_yyyy);
                    //console.log($(this).val());
                    //console.log("Date picker clicked");
                });
                $("#form_add").css("display", "none");
                $("#add").click(function() {
                    $("#form_add").fadeToggle(1000);
                });
            });
        </script>
    @endsection