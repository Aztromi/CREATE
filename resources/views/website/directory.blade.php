@extends('layouts.app')

@section('styles')
<style>
    /* .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }

    .pagination-link {
    padding: 5px 10px;
    margin: 0 5px;
    color: #000;
    text-decoration: none;
    }

    .pagination-link.active {
    background-color: #f0f0f0;
    } */

    #loadingModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
    }

    #loadingModal .modal-content {
        background-color: transparent;
        box-shadow: none;
        border: none;
    }
    
    .pagination nav[role="navigation"] .flex a:first-of-type,
    .pagination nav[role="navigation"] .flex a:last-of-type,
    .pagination nav[role="navigation"] .flex span:first-of-type,
    .pagination nav[role="navigation"] .flex span:last-of-type {
        display: none;
    }

    .pagination a {
        background-color: transparent !important;
        color: #151515;
        border: 0 !important;
        text-decoration: none;
        margin-top: 10px;
    }

    .pagination a:hover {
        background-color: #31A2F0 !important;
        color: #FFFFFF;
        font-weight: bold;
        border: 0 !important;
        text-decoration: none;
        border-radius: 999px;
    }

    .pagination span[aria-disabled="true"] > span, .pagination span[aria-current="page"] > span {
        background-color:transparent !important;
        border: 0 !important;
        color: #A9A9A9;
    }

    .pagination .shadow-sm {
        box-shadow: none !important;
    }


    .search-sml-msg{
        color: black;
        text-align: center;
    }

    #search {
        border: transparent;
    }

    form.search-form .filter-btn-container .btn {
        border: 0;
        font-size: 12px;
        background-color: transparent;
        color: #151515;
    }

    form.search-form .filter-btn-container .btn:hover {
        border: 1px solid #151515;;
        background-color: #151515;
        color: #FFFFFF;
    }

    form.search-form .input-group.filter {
        margin-top: 10px;
        margin-bottom: 20px;
        background-color: #F5F5F5;
        border-radius: 5px;
        padding: 10px;

        font-size: 12px;
        color: #000000;

        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
    }

    form.search-form .input-group.filter .header{
        font-weight: bold;
        font-size: 13px;
    }

    form.search-form .form-check.cat {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: normal;
        line-height: 1.2;
    }

    form.search-form .form-check.cat .form-check-input {
        width: 1em;
        height: 1em;
        margin-top: 0;
        vertical-align: middle;
        flex-shrink: 0;
    }

    article {
        padding-top: 20px !important;
        min-width: 350px;
    }
    
    .creative_id .profile-img .img-container {
        width: 60px;
        height: 60px;
        padding: 0;

        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }

    .creative_id .profile-img .img-container img {
        width: 100%;
        height: 100%;
        
        object-fit: cover;
        object-position: center;
    }
    
    .creative_id .profile-img .img-container.verified {
        border: 3px solid var(--blue);
    }

    .creative_id .btn-container .col {
        padding-right: 0;
    }

    .creative_id .btn-container a {
        background-color: #FFFFFF;
        color: #000000;
        width: 100%;
        margin: 3px;
        border-radius: 20px;
        padding: 3px 6px;
    }

    .creative_id .btn-container a:hover {
        background-color: #31A2F0;
        color: #FFFFFF;
    }
    
</style>
@endsection

@section('scripts-bottom')
<script>

    const mainSearchField = $('#search-frm #search');

    $(document).ready(function() {

        // $("#loadingModal").modal({ 
        //     backdrop: "static", 
        //     keyboard: false, 
        // });
        checkFilters();
        mainSearchField.focus();
        
    });

    function checkFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        const hasSearchParams =
            urlParams.has('show') && urlParams.get('show') !== '' ||
            urlParams.has('sort') && urlParams.get('sort') !== '';

        if (hasSearchParams || $('.cat-option:checked').length > 0) {
            $('.input-group.filter').toggle();
            $('.filter-btn-container .btn').toggle();
        }
    }

    $('.filter-btn-container .btn').on('click', function(e){
        e.preventDefault();
        resetForm();
    });

    function resetForm(){
        var form = $('#search-frm');
        form.find('input[name="search"]').val('');
        $('.cat-option').prop('checked', false);
        
        $('input[name="show"][value=""]').prop('checked', true);
        $('input[name="sort"][value=""]').prop('checked', true);

        $('.input-group.filter').toggle();
        $('.filter-btn-container .btn').toggle();

        form.find('input[name="search"]').focus();
    }

    $('#search-button-main').on('click', function(e){
        e.preventDefault();
        checkSearch();
    });

    mainSearchField.keypress(function(e){
        // e.preventDefault();
        if(e.which === 13)
        {
            checkSearch();        
        }
    });

    function checkSearch()
    {
        val = mainSearchField.val().trim();

        if(val.length > 0)
        {
            // runSearch(val);
            $('#search-frm').submit();
        }
        else
        {
            mainSearchField.val('');
            mainSearchField.focus();
        }
    }
    
    $('.btn-clear').on('click', function(e){
        e.preventDefault();
        resetForm();
    });
    
</script>
@endsection



@section('content')

<!-- Full-screen modal -->
<div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white">
            <div class="modal-body text-center">
                <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
            </div>
        </div>
    </div>
</div>

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-12 col-sm-8 center-block">
                <h1 class="text-center">Work with these Filipino Creatives</h1>
                <p class="text-center">
                    Find and connect with top Filipino creative talents across various industries through CREATEPhilippines' comprehensive directory.
                </p>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">

        <!-- SEARCH -->
        <div class="row justify-content-center">
          <div class="col col-md-10 mx-auto">
            <div class="container">
                <h1 class="text-center">Directory</h1>
                <form class="search-form" id="search-frm" method="GET" action="{{ route('directory') }}">
                    <div class="input-group">
                        <div class="form-control">
                            <input id="search" name="search" type="search" id="form1" class="form-control" value="{{ request('search') }}" placeholder="Search...">
                        </div>
                        <button id="search-button-main" type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="filter-btn-container text-end mt-1 mb-2">
                        <a href="" class="btn btn-primary btn-sm"><i class="fa-solid fa-filter"></i>&nbsp;Filter</a>
                    </div>
                    <div class="input-group filter" style="display: none;">
                        <div class="row">
                            <div class="col-8 col-md-9 col-lg-10">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="header">Categories</span>
                                    </div>
                                    @foreach($categories as $cat)
                                        <div class="col-6 col-md-4 col-lg-3 mb-1">
                                            <div class="form-check cat">
                                                <input 
                                                    class="form-check-input cat-option" 
                                                    type="checkbox" 
                                                    name="categories[]" 
                                                    id="cat-{{ Str::slug($cat->category) }}" 
                                                    value="{{ $cat->category }}"
                                                    {{ in_array($cat->category, request()->input('categories', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cat-{{ Str::slug($cat->category) }}">
                                                    {{ $cat->category }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-lg-2">
                                <div class="row">

                                    <!-- Show Header -->
                                    <div class="col-12">
                                        <span class="header">Show</span>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check cat">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="show" 
                                                id="show-0" 
                                                value=""
                                                {{ !request('show') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show-0">
                                                All
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check cat">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="show" 
                                                id="show-1" 
                                                value="verified"
                                                {{ request('show') == 'verified' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show-1">
                                                Verified Only
                                            </label>
                                        </div>
                                    </div>

                                    {{--
                                    <!-- <div class="col-12">
                                        <div class="form-check cat">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="show" 
                                                id="show-2" 
                                                value="unverified"
                                                {{ request('show') == 'unverified' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show-2">
                                                Unverified
                                            </label>
                                        </div>
                                    </div> -->
                                    --}}
                                    
                                    <!-- Sort Header -->
                                    <div class="col-12 mt-3">
                                        <span class="header">Sort</span>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check cat">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="sort" 
                                                id="sort-0" 
                                                value=""
                                                {{ !request('sort') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sort-0">
                                                Random
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check cat">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="sort" 
                                                id="sort-1" 
                                                value="latest"
                                                {{ request('sort') == 'latest' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sort-1">
                                                Latest
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check cat">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="sort" 
                                                id="sort-2" 
                                                value="name"
                                                {{ request('sort') == 'name' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sort-2">
                                                Name
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3 text-end">
                                <button class="btn btn-primary btn-sm btn-filter">Filter</button>
                                <button class="btn btn-secondary btn-sm btn-clear">Clear</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            
          </div>
        </div>
        
        <div class="row">
            <div class="col col-md-10 mx-auto">
                <div class="container">
                <div class="creativedirectory">
                        @if($creatives->isEmpty())
                            <center><span>No results found.</span></center>
                        @else
                            @foreach($creatives as $creative)
                                <article>
                                    <div class="creative_id">
                                        <div class="container-fluid">
                                            <div class="row justify-content-center">
                                                <div class="col-3 col-md-2 col-lg-1 profile-img my-auto">
                                                    <div class="img-container @if($creative['verified']) verified @endif">
                                                        <img src="{{ $creative['profile_photo'] }}" alt="{{ $creative['name'] }}"
                                                            onerror="this.onerror=null; this.src='{{ asset('/img/default_profile_img.png') }}';">
                                                    </div>
                                                </div>
                                                <div class="col-9 col-md-7 col-lg-9 my-auto">
                                                    <span>{{ $creative['name'] }}</span>
                                                    @if($creative['verified'])
                                                        &ensp;<i class="fas fa-check-circle verified"></i>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-2">
                                                    <div class="row mt-2 mb-2 btn-container">
                                                        @if($creative['link'])
                                                        <div class="col col-6 col-md-12">
                                                            <a class="btn btn-profile" href="{{ $creative['link'] }}">See Full Profile</a>
                                                        </div>
                                                        @endif
                                                        @if(Auth::check() && (Auth::user()->isAdminOG() || Auth::user()->isCreative()))
                                                        <div class="col col-6 col-md-12">
                                                            <a class="btn btn-message" href="{{ route('shd.messages.startMessage', ['recipient' => $creative['c_id']]) }}">Send Message</a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="creative_collection">
                                        <div class="container text-center my-3">
                                            <div class="row mx-auto my-auto">
                                                @if(optional($creative['stories'])->isNotEmpty())
                                                    <!-- Unique ID for each creative's carousel -->
                                                    <div id="directoryCarousel_{{ $creative['c_id'] }}" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner" role="listbox">
                                                            @if(optional($creative['stories'])->isNotEmpty())
                                                                @php
                                                                    $storiesPerSlide = 3; // Number of items per slide
                                                                @endphp
                                                            
                                                                @foreach($creative['stories']->chunk($storiesPerSlide) as $chunk)
                                                                    <div class="carousel-item @if($loop->first) active @endif">
                                                                        <div class="row justify-content-center">
                                                                            @foreach($chunk as $story)
                                                                                <div class="col-md-4 align-content-center">
                                                                                    <a href="{{ route('creative-works.view', ['slug' => $story->latestSlug->value]) }}">
                                                                                        <img src="{{ asset('folder_user-uploads/' . $creative['c_id'] . '/stories/' . $story->cover_image) }}" 
                                                                                            alt="{{ $creative['c_id'] }}COMP{{ $story->ownerable_id }}" 
                                                                                            onerror="this.onerror=null; this.src='{{ asset('img/banner-default.jpg') }}';"
                                                                                            class="img-fluid"
                                                                                            loading="lazy"
                                                                                            decoding="async">
                                                                                    </a>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <p>This creative has not yet uploaded any works.</p>
                                                            @endif
                                                        
                                                        </div>
                                                        <!-- Dynamic controls referencing unique IDs -->
                                                        <a class="carousel-control-prev bg-transparent w-aut" href="#directoryCarousel_{{ $creative['c_id'] }}" role="button" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        </a>
                                                        <a class="carousel-control-next bg-transparent w-aut" href="#directoryCarousel_{{ $creative['c_id'] }}" role="button" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <p>
                                                        This creative has not yet uploaded any works.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row pagination mt-5">
            <div class="col-12">
                <center>{{ $creatives->links() }}</center>
                
            </div>
        </div>
    </div>
</section>


@endsection
