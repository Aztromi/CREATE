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
                    <h1 class="text-left">Company Name</h1>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <dl>
                                <dt>Website:</dt>
                                    <dd>example.com</dd>
                                <dt>Company Email Address:</dt>
                                    <dd>email@example.com</dd>
                            </dl>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <dl>
                                <dt>Office Number</dt>
                                    <dd>+63 02 8888 8888</dd>
                                <dt>Office Address:</dt>
                                    <dd>Street, City, Zip Code</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <p>
                    In today's fast-paced digital age, creatives are always looking for new and innovative ways to showcase their work and expand their reach. However, many creatives struggle with the business side of their profession, including tasks such as invoicing, project management, and marketing. This is where a business solutions service for creatives can help. By providing customized solutions tailored to the specific needs of creatives, this type of service can help them streamline their processes, increase their efficiency, and ultimately grow their business.
                </p>
                <p>
                    Some of the key services that a business solutions provider can offer to creatives include project management tools, client management software, bookkeeping and invoicing services, and social media management. By outsourcing these tasks, creatives can focus on what they do best – creating amazing content. Additionally, a business solutions service can provide valuable advice and guidance on topics such as branding, marketing, and pricing strategies, helping creatives to grow their brand and increase their income. Ultimately, by partnering with a business solutions service for creatives, creatives can save time and money, while also achieving greater success in their field.
                </p>
            </div>
            <div class="col-xs-12 col-sm-4 inquire-holder">
                <h2>INQUIRE NOW!</h2>
                <div class="row mt-50">

                    <!--Grid column-->
                    <div class="col-xs-12">
                        <form id="contact-form" name="contact-form" action="mail.php" method="POST">

                            <!--Grid row-->
                            <div class="row">

                                <!--Grid column-->
                                <div class="col-xs-12 mb-30">
                                    <div class="md-form">
                                        <input type="text" id="name" name="name" class="form-control" required>
                                        <label for="name" class="">Your name</label>
                                    </div>
                                </div>
                                <!--Grid column-->

                                <!--Grid column-->
                                <div class="col-xs-12 mb-30">
                                    <div class="md-form">
                                        <input type="text" id="email" name="email" class="form-control" required>
                                        <label for="email" class="">Your email</label>
                                    </div>
                                </div>
                                <!--Grid column-->

                            </div>
                            <!--Grid row-->

                            <!--Grid row-->
                            <div class="row">

                                <!--Grid column-->
                                <div class="col-xs-12 mb-30">

                                    <div class="md-form">
                                        <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" required></textarea>
                                        <label for="message">Your message</label>
                                    </div>

                                </div>
                            </div>
                            <!--Grid row-->

                        </form>

                        <div class="text-center text-md-left">
                            <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">SEND</a>
                        </div>
                        <div class="status"></div>
                    </div>
                    <!--Grid column-->

                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Related business solutions partners:</h2>
                <div class="bss-content-holder mt-40">
                    <div class="bss-item">
                        <div>
                            <img src="{{ url('img/static/bss/certifier.jpg') }}" alt="">
                        </div>
                        <div>
                            <h3>Company Name</h3>
                            <p>Description</p>
                            <a href="{{ url('business-solutions-services/directory/asd') }}">
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