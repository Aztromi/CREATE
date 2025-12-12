@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <h1 class="text-center">Business Solutions Services</h1>
            <p class="text-center">
                Frequently Asked Questions
            </p>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <ol>
                    <li>
                        <b>
                            Is signing up as a Business Solutions Partner FREE?
                        </b>
                        <p>
                            Yes, signing up as a Business Solutions Partner is FREE subject to screening.
                            <br>
                            Our Basic package is inclusive of company name, company description, logo, contact information, featured services and a dedicated inquiry form.
                        </p>
                    </li>
                    <li>
                        <b>
                            Who can be part of the Business Solutions Services Program?
                        </b>
                        <p>
                            Private companies, government entities, professionals such as creative and technical consultants and certifying bodies from both local and overseas.
                        </p>
                    </li>
                    <li>
                        <b>
                            What services do I need to be a Business Solutions Partner?
                        </b>
                        <p>
                            Your solutions should be geared towards exporters and aspiring exporters. This can be related to trainings, logistics, export marketing, design, product development or other relevant services. Note that companies will be screened prior to acceptance as an Business Solutions Partner.
                        </p>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>


@include('website.bss.contact')
@endsection