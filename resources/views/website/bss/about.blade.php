@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <div class="col col-sm-2"></div>
            <div class="col col-sm-8">
                <h1 class="text-center">Business Solutions Services</h1>
                <p class="text-center">
                    Business Solutions Services is a program featuring private companies, government institutions, organizations, and individuals that offer services, solutions or products that help exporters meet their goals in all aspects of the business, from inception to operations.
                </p>
                <a href="{{ url('/business-solutions-services/faq/') }}" class="btn btn-primary" >FAQs</a>
            </div>
        </div>
    </div>
</section>
<section class="bg_light_grey">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12 text-center">
                <h2>
                    FEATURED PARTNERS
                </h2>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col col-xs-12">
                <div id="featuredPartnerCarousel" class="carousel slide multi-item" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/31f?text=1">
                                <h3>Company Name</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/e66?text=2">
                                <h3>Company Name</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/7d2?text=3">
                                <h3>Company Name</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400?text=4">
                                <h3>Company Name</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/aba?text=5">
                                <h3>Company Name</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/fc0?text=6">
                                <h3>Company Name</h3>
                                <p>Description</p>
                            </a>
                        </div>
                    </div>
                    <a class="carousel-control-prev bg-transparent w-aut" href="#featuredPartnerCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next bg-transparent w-aut" href="#featuredPartnerCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
                <div class="text-center mt-60">
                    <a href="{{ route('business-solutions-services.directory') }}" class="btn btn-primary">
                        SEE MORE PARTNERS
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12 text-center">
                <h2>
                    MSME PROGRAMS AND OFFERS
                </h2>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col col-xs-12">
                <div id="msmeProgramCarousel" class="carousel slide multi-item" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/31f?text=1">
                                <h3>Program</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/e66?text=2">
                                <h3>Program</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/7d2?text=3">
                                <h3>Program</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400?text=4">
                                <h3>Program</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/aba?text=5">
                                <h3>Program</h3>
                                <p>Description</p>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="">
                                <img src="//via.placeholder.com/500x400/fc0?text=6">
                                <h3>Program</h3>
                                <p>Description</p>
                            </a>
                        </div>
                    </div>
                    <a class="carousel-control-prev bg-transparent w-aut" href="#msmeProgramCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next bg-transparent w-aut" href="#msmeProgramCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
                <div class="text-center mt-60">
                    <a href="{{ route('business-solutions-services.programs-and-offers') }}" class="btn btn-primary">
                        SEE MORE PROGRAMS AND OFFERS
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg_light_grey">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12 text-center">
                <h2>
                    Find the right Business Solutions Partner for you.
                </h2>
                <p>
                    Browse our listing of companies for all your export needs.
                </p>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col col-xs-12 text-center">
                <ul class="list_img">
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('img/static/bss/certifier.jpg') }}" alt="Category: Certifier">
                        </div>
                        <div>
                            <h3>
                                Category
                            </h3>
                            <p>
                                Description
                            </p>
                            <a href="">
                                Learn more <i class="fas fa-external-link"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


@include('website.bss.contact')
@endsection