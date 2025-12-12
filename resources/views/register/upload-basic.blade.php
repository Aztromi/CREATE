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
                    <form id="frm_uploadBasic" class="mt-30" method="POST" action="{{route('user.register.upload-basic-verify')}}" enctype="multipart/form-data">
                    @csrf
                        <div class="row mb-20">
                            <h3>
                                Basic Account
                            </h3>
                        </div>
                        <div class="row mb-30 work-1">
                            <div class="col">
                                <div class="mb-3">
                                    <!-- <label for="formFile" class="form-label">Upload sample works. Accepted file types: .pdf, .png, .gif, .mp4, or .mp3</label> -->
                                    <label for="files" class="form-label">Upload sample works. Accepted file types: .pdf, .png, .jpg, .gif</label>
                                    <input class="form-control" type="file" id="files" name="files[]" multiple accept=".pdf, .png, .jpg, .gif" required>
                                    @error('files.*')
                                        <div class="error-message text-danger pt-1">{{ $message }}</div>
                                    @enderror
                                    <!-- <a class="btn addWork" id="addWork2">
                                        <i class="fas fa-plus"></i>
                                    </a> -->
                                  </div>
                            </div>
                        </div>
                        <!-- <div class="row mb-30 work-2" style="display:none">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload sample works. Accepted file types: .pdf, .png, .gif, .mp4, or .mp3</label>
                                    <input class="form-control" type="file" id="formFile">
                                    <a class="btn addWork" id="addWork3">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                  </div>
                            </div>
                        </div>
                        <div class="row mb-30 work-3" style="display:none">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload sample works. Accepted file types: .pdf, .png, .gif, .mp4, or .mp3</label>
                                    <input class="form-control" type="file" id="formFile">
                                    {{-- <a class="btn addWork" id="addWork4">
                                        <i class="fas fa-plus"></i>
                                    </a> --}}
                                  </div>
                            </div>
                        </div> -->
                        <div class="row mb-30">
                            <div class="col">
                                <!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalUploadRequirementsBasic">SUBMIT</button> -->
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

<!-- Modal --- BASIC ACCOUNT -->
<!-- <div class="modal fade" id="modalUploadRequirementsBasic" tabindex="-1" role="dialog" aria-labelledby="modalUploadRequirementsBasicLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUploadRequirementsBasicLabel">
            Successful upload
          </h5>
        </div>
        <div class="modal-body">
            <p>
                Your sample works have been successfully sent for processing.
                <br><br>
                We’ll review your information and come back to you within 48 hours. Kindly anticipate an email once your Directory Page has been activated. 
                <br><br>
                Once activated, Basic Accounts may still have their accounts Verified by submitting and uploading your Business Documents through your Dashboard.
                <br><br>
                For inquiries, please email <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a>.
            </p>
        </div>
      </div>
    </div>
</div> -->



@endsection