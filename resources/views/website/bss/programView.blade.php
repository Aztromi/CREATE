@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <div class="logo-holder">
                    <img src="{{ url('/img/defaultlogo.png') }}" alt="Company Logo" class="img-fluid">
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div>
                    <p class="text-yellow mb-0">CATEGORY</p>
                    <h1 class="text-left">Program Title</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <p>
                    In today's fast-paced digital age, creatives are always looking for new and innovative ways to showcase their work and expand their reach. However, many creatives struggle with the business side of their profession, including tasks such as invoicing, project management, and marketing. This is where a business solutions service for creatives can help. By providing customized solutions tailored to the specific needs of creatives, this type of service can help them streamline their processes, increase their efficiency, and ultimately grow their business.
                </p>
                <p>
                    Some of the key services that a business solutions provider can offer to creatives include project management tools, client management software, bookkeeping and invoicing services, and social media management. By outsourcing these tasks, creatives can focus on what they do best – creating amazing content. Additionally, a business solutions service can provide valuable advice and guidance on topics such as branding, marketing, and pricing strategies, helping creatives to grow their brand and increase their income. Ultimately, by partnering with a business solutions service for creatives, creatives can save time and money, while also achieving greater success in their field.
                </p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Related programs:</h2>
                <div class="bss-content-holder mt-40">
                    <div class="bss-item">
                        <div>
                            <img src="{{ url('img/static/bss/certifier.jpg') }}" alt="">
                        </div>
                        <div>
                            <h3>Program title</h3>
                            <p>Description</p>
                            <a href="{{ url('business-solutions-services/programs-and-offers/asd') }}">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('website.bss.contact')
@endsection