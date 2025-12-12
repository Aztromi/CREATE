@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3"></div>
            <div class="col-xs-12 col-sm-6 text-center">
                <h1 class="text-center">ABOUT CREATEPhilippines</h1>
                <br>
                <img src="{{ asset('img/createph-logo_horizontal.png') }}" class="img-fluid" alt="CREATEPhilippines Logo">
            </div>
        </div>
    </div> 
</section>
<section>
    <div class="container">
        <div class="row">
            <p class="">
                CREATEPhilippines.com is the country's first government-led content and community platform for the local creative industries.
                <br><br>
                It is the ultimate resource for stories and updates on the Philippines' creative community and a centralized directory and sourcing platform where Filipino creatives can share their portfolio to and engage with a global audience.
            </p>
        </div>
    </div>
</section>

@endsection 