@extends('layouts.app')

@section('content')

<div class="bg_black25">
    <div class="container-fluid">
        <div class="row text-center">
        @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6 mt-60 mb-60">
                <section>
                    <h1>
                        Welcome to CREATEPhilippines!
                    </h1>
                    <hr>
                    <p>
                        Your email is now verified.
                    </p>
                    <p>
                        Setup your account now to connect with other creatives and unlock more website features.
                    </p>
                    <a href="{{ url('register/step-2') }}" class="btn btn-primary">SETUP ACCOUNT NOW</a>
                    &nbsp;&nbsp;&nbsp;<a href="#" class="text-white">I'll do it later.</a>
                </section>
            </div>
        </div>
        
    </div>
</div>

@endsection