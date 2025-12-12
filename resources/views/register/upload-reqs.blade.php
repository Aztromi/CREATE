@extends('layouts.app')


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
                    <p>
                        Before we activate your Directory Page, kindly submit samples of your works below. If you want to be a Verified Creative, please upload your Business Permit and BIR Certificate of Registration along with your sample works.
                    </p>
                    <hr>
  
                    <form class="mt-30" id="frm-uploadVerified" method="POST" action="{{route('user.register.upload-verified-verify')}}" enctype="multipart/form-data">
                    @csrf
                        <div class="row mb-20 mt-50">
                            <h3>
                                Verified Account
                            </h3>
                        </div>
                        <div class="inputGroup1">
                            <div class="row mb-30 vWork-1">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="portfolios" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif</label>
                                        <input class="form-control" type="file" id="portfolios" name="portfolios[]" multiple accept=".pdf, .png, .jpg, .gif" required>
                                        @error('portfolios.*')
                                            <div class="error-message text-danger pt-1">{{ $message }}</div>
                                        @enderror
                                        <!-- <a class="btn addWork" id="addWorkV2">
                                            <i class="fas fa-plus"></i>
                                        </a> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-30">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="permits" class="form-label">Upload a valid <b>business permit</b> (for businesses) or <b>identification</b> (for individuals). <br>Accepted file types: .pdf, .png, or .jpg</label>
                                        <input class="form-control" type="file" id="permits" name="permits[]" multiple accept=".pdf, .png, .jpg" required>
                                        @error('permits.*')
                                            <div class="error-message text-danger pt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-30">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="birs" class="form-label">Upload a <b>BIR Certificate of Registration</b> (for businesses). <br>Accepted file types: .pdf, .png, or .jpg</label>
                                        <input class="form-control" type="file" id="birs" name="birs[]" multiple accept=".pdf, .png, .jpg" required>
                                        @error('birs.*')
                                            <div class="error-message text-danger pt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row mb-30">
                            <div class="col">
                                <!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalUploadRequirementsVerified">SUBMIT</button> -->
                                <button class="btn btn-primary" type="submit">SUBMIT</button>
                                <button class="btn btn-primary" type="reset">CLEAR</button>
                                <a href="{{route('user.register.upload-type')}}" class="btn btn-secondary">BACK</a>
                            </div>
                        </div>
                            

                        
                    </form>
                    <hr>
                    <div class="mt-50 mb-50">
                        <p>
                            Submitted sample works will automatically be uploaded to your Directory Page once it is activated
                            <br><br>
                            Note: You may edit and/or delete any content visible on your Directory Page.
                        </p>
                    </div>
                </section>

            </div>
        </div>
        
    </div>
</div>



<!-- Modal --- VERIFIED ACCOUNT -->
<!-- <div class="modal fade" id="modalUploadRequirementsVerified" tabindex="-1" role="dialog" aria-labelledby="modalUploadRequirementsVerifiedLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUploadRequirementsVerifiedLabel">
            Successful upload
          </h5>
        </div>
        <div class="modal-body">
            <p>
                Your sample works and documents have been successfully sent for processing.
                <br><br>
                We’ll review your information and come back to you within 48 hours. Kindly anticipate an email once your Directory Page has been activated. 
                <br><br>
                For inquiries, please email <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a>.
            </p>
        </div>
      </div>
    </div>
</div> -->

@endsection