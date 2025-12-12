@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <h1 class="text-center">Congratulations!</h1>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="container" align="center">
            
            <p>Thank you for completing your application for CREATEPhilippines: Performing Arts Market 2024.</p>
            <p>The completed form and uploaded requirements will be used to evaluate your participation.</p>
            <p>Your assigned Account Officer will contact you within 48 hours to update you on the status of your application.</p>
            <p>For inquiries, please e-mail <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a></p>
            <p>Thank you.</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">HOME</a>
            
        </div>
    </div>
</section>

@endsection