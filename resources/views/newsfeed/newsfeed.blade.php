@extends('layouts.app')

@section('content')

<section class="bg_black newfeed-nav">
    <div class="container">
        <div class="col-xs-12">
            <p class="text-center profile-btn-holder">
                <a class="btn btn-primary {{ Request::path() == 'newsfeed/articles' ? 'active' : '' }}" href="{{ url('/newsfeed/articles') }}">ARTICLES</a>
                <a class="btn btn-primary {{ Request::path() == 'newsfeed/works' ? 'active' : '' }}" href="{{ url('/newsfeed/works') }}">WORKS</a>
                <a class="btn btn-primary {{ Request::path() == 'newsfeed/announcement' ? 'active' : '' }}" href="{{ url('/newsfeed/announcement') }}">ANNOUNCEMENTS</a>
            </p>
        </div>
    </div>
</section>
@if(str_contains(url()->current(), '/newsfeed/articles'))
    @include('newsfeed.articles')
@endif
@if(str_contains(url()->current(), '/newsfeed/works'))
    @include('newsfeed.works')
@endif
@if(str_contains(url()->current(), '/newsfeed/announcement'))
    @include('newsfeed.announcement')
@endif


@endsection