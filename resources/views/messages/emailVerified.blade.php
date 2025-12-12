@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <h1 class="text-center">E-mail Verified</h1>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="container" align="center">
            <h3>Your e-mail is now verified</h3>
            <p>You may now login with your CREATEPhilippines account.</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
            
        </div>
    </div>
</section>

@endsection