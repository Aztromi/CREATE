@extends('layouts.app')

@section('styles')
<style>
    .txtLink {
        color: #3aa4f3;
    }

    .col label {
        line-height: 25px;
    }
    
</style>
@endsection

@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
        @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>
                    <h1>
                        Upload Requirements
                    </h1>
                    <!-- <p>
                        Before we activate your Directory Page, kindly submit samples of your works below. If you want to be a Verified Creative, please upload your Business Permit and BIR Certificate of Registration along with your sample works.
                    </p> -->
                    <hr>
  
                    <form class="mt-30" id="frm-uploadVerified" method="POST" action="{{route('user.register.upload-verified-verify')}}" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="reg_type" value="{{ $reg_type }}">
                        <div class="row mb-20 mt-50">
                            <h3>
                                Verified Account
                            </h3>
                        </div>
                        <div class="inputGroup1">
                            <div class="row vWork-1" id="groupWorks">
                                <div class="col">
                                    <label for="portfolios" class="form-label"><span class="fs-4 fw-bolder">Upload sample works</span> <span style="color: red;">*</span><br><small>Accepted file types: .pdf, .jpg, .png, .gif</small></label>
                                    <input class="form-control" type="file" id="portfolios" name="portfolios[]" multiple accept=".pdf, .png, .jpg, .gif" required>
                                    @error('portfolios.*')
                                        <div class="error-message text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row" id="groupDrive">
                                <div class="col">
                                    <label class="form-label" for="drive-link"><span class="fs-4 fw-bolder">Sample Works Drive Link</span>  <span style="color: red;">*</span></label>
                                    <input class="form-control" type="url" placeholder="Drive Link" id="drive-link" name="drive-link" required>
                                </div>
                            </div>

                            <div class="row mb-3 p-1">
                                <div class="col">
                                    <input type="checkbox" class="form-check-input" name="driveCheck" id="driveCheck" value="drive_check">
                                    <label class="form-label" for="driveCheck">Upload Drive Link Instead </label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        @if($reg_type == 'exhibitor')
                                            <label for="permits" class="form-label"><span class="fs-4 fw-bolder">Permit to Operate</span> <span style="color: red;">*</span><br><i>(Either of the following: BIR 2303 Form, Mayor’s Business Permit, Certification from Academe)</i> <br><small>Accepted file types: .pdf, .png, or .jpg</small></label>
                                        @else
                                            <label for="permits" class="form-label"><span class="fs-4">Upload a valid <b>business permit</b> <i><span class="fs-5">(for businesses)</span></i> or <b>identification</b> <i><span class="fs-5">(for individuals)</span></i>.</span>  <span style="color: red;">*</span><br><small>Accepted file types: .pdf, .png, or .jpg</small></label>
                                        @endif
                                        <input class="form-control" type="file" id="permits" name="permits[]" multiple accept=".pdf, .png, .jpg" required>
                                        @error('permits.*')
                                            <div class="error-message text-danger pt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if($reg_type != 'exhibitor')
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="birs" class="form-label"><span class="fs-4">Upload a <b>BIR Certificate of Registration</b> <i><span class="fs-5">(for businesses)</span></i>.</span> <br><small>Accepted file types: .pdf, .png, or .jpg</small></label>
                                        <input class="form-control" type="file" id="birs" name="birs[]" multiple accept=".pdf, .png, .jpg">
                                        @error('birs.*')
                                            <div class="error-message text-danger pt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                @if($reg_type == 'exhibitor')
                                    By submitting this Exhibitor application for the CREATEPhilippines 2024: Performing Arts Market, you agree to comply with these <a href="#" id="termsMIPAM" class="txtLink">Terms & Conditions</a> and any additional guidelines or rules provided by the event organizers.
                                @else
                                    Submitted sample works will automatically be uploaded to your Directory Page once it is activated
                                    <br><br>
                                    Note: You may edit and/or delete any content visible on your Directory Page.
                                @endif
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col text-end">
                                <!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalUploadRequirementsVerified">SUBMIT</button> -->
                                <a href="{{route('user.register.step-four', ['type' => $reg_type])}}" class="btn btn-secondary btn-lg">BACK</a>
                                <button class="btn btn-primary btn-lg" type="reset">CLEAR</button>
                                <button class="btn btn-primary btn-lg" type="submit">NEXT</button>
                                
                                
                            </div>
                        </div>
                            

                        
                    </form>
                    <!-- <hr>
                    <div class="mt-50 mb-50">
                        <p>
                            Submitted sample works will automatically be uploaded to your Directory Page once it is activated
                            <br><br>
                            Note: You may edit and/or delete any content visible on your Directory Page.
                        </p>
                    </div> -->
                </section>

            </div>
        </div>
        
    </div>
</div>


@include('register.terms_mipam')


@endsection

@section('scripts-bottom')
<script>

    function presetWorks($type)
    {
        switch($type){
            case 'drive':
                $('#groupDrive').show();
                $('#drive-link').prop('required', true);
                $('#drive-link').prop('disabled', false);

                $('#groupWorks').hide();
                $('#portfolios').prop('required', false);
                $('#portfolios').prop('disabled', true);
            break;
            case 'upload':
                $('#groupDrive').hide();
                $('#drive-link').prop('required', false);
                $('#drive-link').prop('disabled', true);
                
                $('#groupWorks').show();
                $('#portfolios').prop('required', true);
                $('#portfolios').prop('disabled', false);
            break;
        }

    }
    $(document).ready(function(){

        presetWorks('upload')

        $('#driveCheck').on('change', function() {
            if ($(this).is(':checked')) {
                presetWorks('drive');
            } else {
                presetWorks('upload');
            }
        });
        
        $('#frm-uploadVerified').on('reset', function(e) {
            // e.preventDefault();
            // $(this).reset();
            presetWorks('upload');
        });

        $('#termsMIPAM').on('click', function(e) {
            e.preventDefault();

            $('#modal-terms-mipam').modal('show');
        });
    });
</script>
@endsection