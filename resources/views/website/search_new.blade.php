@extends('layouts.app')

@section('styles')
<style>
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
    }

    form.search-form .input-group.filter {
        margin-top: 10px;
        background-color: #F5F5F5;
        border-radius: 5px;
        padding: 10px;

        font-size: 12px;
        color: #000000;
    }

    form.search-form .input-group.filter .header{
        font-weight: bold;
        font-size: 13px;
    }

    form.search-form .form-check.cat {
        display: flex;
        align-items: center; /* CHANGE: Try 'center' instead of 'flex-start' for overall alignment */
        gap: 8px;
        white-space: normal;
        line-height: 1.2;
    }

    form.search-form .form-check.cat .form-check-input {
        width: 1em; /* Adjust for desired square size */
        height: 1em; /* Keep same as width */
        margin-top: 0; /* RESET: Remove margin-top as 'align-items: center' might handle it */
        vertical-align: middle; /* ADD THIS: Explicit vertical alignment */
        flex-shrink: 0;
    }

    .results .card-container {
        margin-top: 30px;
    }

    .results .card-container .card {
        height: 100%;
        border: 0;
        border-radius: 20px;
        border: 1px solid #F5F5F5;
    }
    
    .results .card-container .card .card-img-container {
        position: relative;
    }

    .results .card-container .card .card-img-container img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: transparent;

        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .results .card-container .card .type-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        /* background-color: rgba(0, 0, 0, 0.75); */
        color: #fff;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        text-transform: uppercase;
        font-weight: bold;
    }

    .results .card-container .card .type-badge.article {
        background-color: rgb(50,184,239);
    }

    .results .card-container .card .type-badge.creative {
        background-color: rgb(175,207,40);
    }

    .results .card-container .card .type-badge.creative-work {
        background-color: rgb(237,167,28);
    }

    .results .card-container .card .type-badge.event {
        background-color: rgb(255, 97, 97);
    }
    
    .results .card-container .card .card-body {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border: #F5F5F5;

        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .results .card-container a {
        text-decoration: none;
        line-height: 1.4;
    }

    .results .card-container a:hover .card.article {
        border-width: 2px;
        border-color: rgb(50,184,239);
        
    }

    .results .card-container a:hover .card.article .card-body {
        background-color: rgb(50,184,239);
        color: #FFFFFF;
    }

    .results .card-container a:hover .card.creative {
        border-width: 2px;
        border-color: rgb(175,207,40);
        
    }

    .results .card-container a:hover .card.creative .card-body {
        background-color: rgb(175,207,40);
        color: #FFFFFF;
    }

    .results .card-container a:hover .card.creative-work {
        border-width: 2px;
        border-color: rgb(237,167,28);
    }

    .results .card-container a:hover .card.creative-work .card-body {
        background-color: rgb(237,167,28);
        color: #FFFFFF;
    }

    .results .card-container a:hover .card.event {
        border-width: 2px;
        background-color: rgb(255, 97, 97);
    }

    .results .card-container a:hover .card.event .card-body {
        background-color: rgb(255, 97, 97);
        color: #FFFFFF;
    }

    .pagination nav[role="navigation"] .flex a:first-of-type,
    .pagination nav[role="navigation"] .flex a:last-of-type,
    .pagination nav[role="navigation"] .flex span:first-of-type,
    .pagination nav[role="navigation"] .flex span:last-of-type {
        display: none;
    }

    .pagination a {
        background-color: transparent !important;
        color: #FFFFFF;
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
        color: #858585;
    }

</style>
@endsection

@section('scripts-bottom')
    <script>

        const mainSearchField = $('#search-frm #search');

        $(document).ready(function(){

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

            // Temporary Disable if Category has Value. 1 of 3
            if ($('.cat-option:checked').length > 0) {
                $('input[name="show"][value="articles"]').prop('disabled', true);
                $('input[name="show"][value="events"]').prop('disabled', true);
            }
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

        function resetForm(){
            var form = $('#search-frm');
            form.find('input[name="search"]').val('');
            $('.cat-option').prop('checked', false);

            // Temporary Disable if Category has Value. 2 of 3
            $('input[name="show"][value="articles"]').prop('disabled', false);
            $('input[name="show"][value="events"]').prop('disabled', false);

            $('input[name="show"][value=""]').prop('checked', true);
            $('input[name="sort"][value=""]').prop('checked', true);

            $('.input-group.filter').toggle();
            $('.filter-btn-container .btn').toggle();

            form.find('input[name="search"]').focus();
        }

        $('.filter-btn-container .btn').on('click', function(e){
            e.preventDefault();
            resetForm();
        });


        // Temporary Disable if Category has Value. 3 of 3
        $('.cat-option').on('click', function(){

            if ($('.cat-option:checked').length > 0) {
                $('input[name="show"][value=""]').prop('checked', true);

                $('input[name="show"][value="articles"]').prop('disabled', true);
                $('input[name="show"][value="events"]').prop('disabled', true);
            }
            else {
                $('input[name="show"][value="articles"]').prop('disabled', false);
                $('input[name="show"][value="events"]').prop('disabled', false);
            }
        });

        $('.btn-clear').on('click', function(e){
            e.preventDefault();
            resetForm();
        });
    </script>
@endsection

@section('content')

<section class="bg_black">
    <section class="content">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-sm-11 col-md-8 col-xl-8">
            <h1 class="text-center">Search</h1>
            <form class="search-form" id="search-frm" method="GET" action="{{ route('search') }}">
                <div class="input-group">
                    <div class="form-control">
                        <input id="search" name="search" type="search" id="form1" class="form-control" value="{{ request('search') }}" placeholder="Search...">
                    </div>
                    <button id="search-button-main" type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="filter-btn-container text-end mt-1">
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
                                            value="articles"
                                            {{ request('show') == 'articles' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show-1">
                                            Articles
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check cat">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="show" 
                                            id="show-2" 
                                            value="creatives"
                                            {{ request('show') == 'creatives' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show-2">
                                            Creatives
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check cat">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="show" 
                                            id="show-3" 
                                            value="works"
                                            {{ request('show') == 'works' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show-3">
                                            Creative Works
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check cat">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="show" 
                                            id="show-4" 
                                            value="events"
                                            {{ request('show') == 'events' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show-4">
                                            Events
                                        </label>
                                    </div>
                                </div>


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

        @if($results->isEmpty())
            <div class="row">
                <div class="col-12 text-center mt-5">
                    <p>No results found</p>
                </div>
            </div>
        @else

            <div class="row results justify-content-center">
                @foreach($results as $result)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 card-container">
                        <a href="{{ $result['link'] }}" target="_blank" rel="noopener noreferrer">
                            <div class="card {{ Str::slug($result['type'], '-') }}">
                                <div class="card-img-container position-relative">
                                    <img src="{{ $result['banner'] }}"
                                        alt="{{ $result['name'] }}"
                                        onerror="this.onerror=null; this.src='{{ asset('img/banner-default.jpg') }}';">
                                    <div class="type-badge {{ Str::slug($result['type'], '-') }}">
                                        {{ $result['type'] }}
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{ $result['name'] }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row pagination mt-5">
                <div class="col-12">
                    <center>{{ $results->links() }}</center>
                    
                </div>
            </div>
        @endif



      </div>
    </section>
</section>


@endsection