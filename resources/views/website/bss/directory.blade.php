@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-12 col-sm-8 center-block">
                <h1 class="text-center">
                    Business Solutions for Creatives
                </h1>
                <p class="text-center">
                    Here are our trusted business solutions service partners for creatives, offering a diverse range of services to support and enhance the success of your creative endeavors.
                </p>
            </div>
        </div>
    </div>
</section>
<section class="bg_lightgrey">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-3 col-md-2">
                <div class="profile-container sf-container">
                    <p>SEARCH</p>
                    <input type="search" placeholder="search">

                    <hr>

                    <p>SORT BY</p>
                    <div class="radio-field">
                        <input type="radio" name="sort" id="sort-by-latest" value="">
                        <label for="">Latest uploads</label>
                    </div>
                    <div class="radio-field">
                        <input type="radio" name="sort" id="sort-by-alphabetical" value="">
                        <label for="">Alphabetical</label>
                    </div>
                    
                    <hr>
                
                    <p>FILTER BY</p>
                    <div class="checkbox-field">
                        <input type="checkbox" name="sort" id="filter-by-category" value="">
                        <label for="">category</label>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-8">
                <h2>Featured Partners</h2>
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
                <hr>
                <h2>Business Solutions Partners</h2>
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
            <div class="col-xs-12 col-sm-1"></div>
        </div>
    </div>
</section>

@include('website.bss.contact')
@endsection