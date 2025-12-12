@extends('layouts.app')



@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
            @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>
                        <div class="row mb-30">
                            <h3>
                                PREFERRED UPLOAD
                            </h3>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <a href="
                                
                                @if($type == 'verified')
                                    {{ route('user.register.upload-verified') }}
                                @else
                                    {{ route('user.register.upload-basic') }}
                                @endif
                                " class="btn btn-secondary btn-lg hover-highlight">
                                    <h3>Upload Files Directly to the Website</h3>
                                    <p>Select this option if you want to directly upload your files to our website. This is a convenient and straightforward method. Simply use the provided file upload feature to securely transfer your files directly to our server.</p>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col">
                                <a href="{{ route('user.register.upload-link') }}" class="btn btn-secondary btn-lg hover-highlight">
                                    <h3>Share a Drive Link</h3>
                                    <p>Choose this option if you prefer to share a link to your files from a cloud storage service such as Google Drive. After uploading your files to your cloud drive, generate a shareable link and provide it during the submission process.</p>
                                    <p>This option is suitable for those who want to keep their files in their cloud storage while easily sharing access with us.</p>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <a href="{{ route('user.register.upload-type') }}" class="btn btn-primary btn-lg hover-highlight">Back</a>
                            </div>
                        </div>
                </section>
            </div>
        </div>
        
    </div>
</div>


@endsection