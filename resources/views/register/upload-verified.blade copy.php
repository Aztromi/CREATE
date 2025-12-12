@extends('layouts.app')

@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 login-banner" style="background-image:url('{{ asset('folder_user-uploads/' . $story->id . '/stories/' . $story->homeStoryLatest->cover_image) }}')">
                <section>
                    <div>
                        <h1>
                            
                        </h1>
                    </div>
                </section>
                <div class="artBy">
                    <p>
                        Artwork by {{ $story->profile->dispName }}
                    </p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <section>
                    <h1>
                        Upload Requirements
                    </h1>
                    <p>
                        Before we activate your Directory Page, kindly submit samples of your works below. If you want to be a Verified Creative, please upload your Business Permit and BIR Certificate of Registration along with your sample works.
                    </p>
                    <hr>
                
                    <form class="mt-30">
                        <hr>
                        <div class="row mb-20 mt-50">
                            <h3>
                                Verified Account
                            </h3>
                        </div>
                        <div class="row mb-30 vWork-1">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif, .mp4, or .mp3</label>
                                    <input class="form-control" type="file" id="formFile">
                                    <a class="btn addWork" id="addWorkV2">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                  </div>
                            </div>
                        </div>
                        <div class="row mb-30 vWork-2" style="display:none">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif, .mp4, or .mp3</label>
                                    <input class="form-control" type="file" id="formFile">
                                    <a class="btn addWork" id="addWorkV3">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                  </div>
                            </div>
                        </div>
                        <div class="row mb-30 vWork-3" style="display:none">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif, .mp4, or .mp3</label>
                                    <input class="form-control" type="file" id="formFile">
                                    {{-- <a class="btn addWork" id="addWorkV4">
                                        <i class="fas fa-plus"></i>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload a valid <b>business permit</b> (for businesses) or <b>identification</b> (for individuals). <br>Accepted file types: .pdf, .png, or .jpg</label>
                                    <input class="form-control" type="file" id="formFile">
                                  </div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload a <b>BIR Certificate of Registration</b> (for businesses). <br>Accepted file types: .pdf, .png, or .jpg</label>
                                    <input class="form-control" type="file" id="formFile">
                                  </div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalUploadRequirementsVerified">SUBMIT</button>
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
<div class="modal fade" id="modalUploadRequirementsVerified" tabindex="-1" role="dialog" aria-labelledby="modalUploadRequirementsVerifiedLabel" aria-hidden="true">
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
</div>

@endsection