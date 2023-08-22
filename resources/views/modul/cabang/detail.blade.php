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
                    <h5>blood</h5>
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
                                    $teks = $blood[0]->nameblood;
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
                            <h3 class="mb-0 text-color-theme">{{ $blood[0]->nameblood }}</h3>
                            <p class="text-muted ">LU : {{ $blood[0]->updateddate }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted ">
                        {{ $blood[0]->noteblood }}
                    </p>
                </div>
            </div>

            <!-- profile information -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Basic Information</h6>
                </div>
            </div>
            <div class="row h-100 mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating mb-3">
                        <select class="form-control" id="country" readonly>
                            <option selected>{{ $blood[0]->nameblood }}</option>
                        </select>
                        <label for="country">Name Blood</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <textblood class="form-control" readonly>{{$blood[0]->noteblood}}</textblood>
                        <!-- <input type="text" class="form-control" readonly value="{{ $blood[0]->noteblood }}" placeholder="Name" id="names"> -->
                        <label for="names">Note Blood</label>
                    </div>
                </div>
                <!-- <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" value="info@maxartkiller.com"
                            placeholder="Email or Phone" id="emailphone">
                        <label for="emailphone">Email or Phone</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating">
                        <input type="file" class="form-control" id="fileupload">
                        <label for="fileupload">Uplaod File</label>
                    </div>
                </div> -->
            </div>

            <!-- add edit address form -->
            <div class="row mb-3">
                <div class="col">
                    <h6>Track Changes</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly value="{{ $blood[0]->createdby }}"  placeholder="Surname" id="surnames">
                        <label for="surnames">Created By</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly value="{{ $blood[0]->createddate }}"  placeholder="Surname" id="surnames">
                        <label for="surnames">Created Date</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly value="{{ $blood[0]->isused }}"  placeholder="Surname" id="surnames">
                        <label for="surnames">Is Used</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly value="{{ $blood[0]->updatedby }}"  placeholder="Surname" id="surnames">
                        <label for="surnames">Updated By</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly value="{{ $blood[0]->updateddate }}"  placeholder="Surname" id="surnames">
                        <label for="surnames">Updated Date</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-group form-floating  mb-3">
                        <input type="text" class="form-control" readonly value="{{ $blood[0]->isactivated }}"  placeholder="Surname" id="surnames">
                        <label for="surnames">Is Activated</label>
                    </div>
                </div>
                
            </div>

            


        </div>
        <!-- main page content ends -->

    </main>
    @endsection