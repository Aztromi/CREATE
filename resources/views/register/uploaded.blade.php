@extends('layouts.app')

@section('content')

<div class="bg_black25">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-xs-12 col-sm-6 login-banner" style="background-image:url('{{ asset('folder_user-uploads/' . $story->id . '/stories/' . $story->homeStoryLatest->cover_image) }}')">
                <section>
                    <div>
                        <h1>
                            
                        </h1>
                    </div>
                </section>
                <div class="artBy">
                    <p>
                        Artwork by {{ $story->profile->dispName}}
                    </p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 mt-60 mb-60">
                <section>
                    <!-- <h1>
                        Welcome to CreatePhilippines!
                    </h1>
                    <hr>
                    <p>
                        Your email is now verified.
                    </p>
                    <p>
                        Setup your account now to connect with other creatives and unlock more website features.
                    </p>
                    <a href="{{ url('register/step-2') }}" class="btn btn-primary">SETUP ACCOUNT NOW</a>
                    &nbsp;&nbsp;&nbsp;<a href="#" class="text-white">I'll do it later.</a> -->

                    <p>
                        Your sample works have been successfully sent for processing.
                        <br><br>
                        We’ll review your information and come back to you within 48 hours. Kindly anticipate an email once your Directory Page has been activated. 
                        <br><br>
                        Once activated, Basic Accounts may still have their accounts Verified by submitting and uploading your Business Documents through your Dashboard.
                        <br><br>
                        For inquiries, please email <a style="color: white;" href="mailto:createph@citem.com.ph"><strong>createph@citem.com.ph</strong></a>.
                    </p>

                </section>
            </div>
        </div>
        
    </div>
</div>

@endsection