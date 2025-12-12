@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <h1 class="text-center">Welcome to CREATEPhilippines!</h1>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="container" align="center">
            <!-- <h3>Your e-mail is now verified</h3> -->
            <p>You may now setup your CREATEPhilippines account.</p>
            <a href="{{ route('user.register.step-two') }}" class="btn btn-primary btn-lg">SETUP MY ACCOUNT</a>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">I'LL DO IT LATER</a>
            
        </div>
    </div>
</section>

@endsection