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
            <p>We’ll review your information and come back to you within 48 hours. Kindly anticipate an email once your Directory Page has been activated.</p>
            <p>Once activated, Basic Accounts may still have their accounts Verified by submitting and uploading your Business Documents through your Dashboard.</p>
            <p>For inquiries, please email <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a></p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">HOME</a>
            
        </div>
    </div>
</section>

@endsection