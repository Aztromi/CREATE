@extends('layouts.app')

@section('scripts-bottom')
    <script>
        $('.btn-bkmrk').on('click', function(){
            bURL = $(this).data('url');
            cid = $(this).data('cid');
            newStatus = '';

            if($(this).data('status') == 'inactive')
            {
                newStatus = 'add';
            }
            else
            {
                newStatus = 'remove';
            }

            bookmark(bURL, cid, newStatus, $(this), $(this).html());
        });    

        function bookmark(bookmarkURL, contentID, newStatus, btn, btnOld){
            $.ajax({
                url: bookmarkURL,
                type: 'POST',
                data: {
                    new_status: newStatus,
                    story_id: contentID
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                },
                success: function(response) {

                    if(newStatus == 'add')
                    {
                        btn.html('<i class="fa fa-solid fa-bookmark"></i>');
                        btn.data('status', 'active');
                    }
                    else
                    {
                        btn.html('<i class="fa fa-regular fa-bookmark"></i>');
                        btn.data('status', 'inactive');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);

                    btn.html(btnOld);
                
                    

                },
                // complete: function() {
                    
                // }
            });
        }
        
    </script>
@endsection

@section('styles')
<style>
    .card {
        height: 100%;
    }

    .article-view {
        background-color: #F5F5F7 !important;
    }

    .custm-crd-cntainr {
        margin: 15px 0;
    }

    .custm-crd-cntainr a {
        text-decoration: none;
    }

    .custm-crd-cntainr .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        border-radius: 20px;
        border: 0;

        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;

        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px,
                rgba(0, 0, 0, 0.23) 0px 3px 6px;

        transition: background-color 0.3s ease,
                color 0.3s ease,
                transform 0.3s ease,
                box-shadow 0.3s ease;
    }

    .custm-crd-cntainr .card:hover {
        background-color: #151515;
        color: #FFFFFF;

        transform: translateY(-4px);
        box-shadow: rgba(0, 0, 0, 0.25) 0px 6px 12px,
                rgba(0, 0, 0, 0.3) 0px 6px 12px;
    }

    .custm-crd-cntainr .card .card-body {
        flex: 1 1 auto;
        padding-bottom: 0;
        background-color: transparent;
    }

    .custm-crd-cntainr .card .card-footer {
        border: 0;
        margin-top: auto;
        padding-top: 0;
        background-color: transparent;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .custm-crd-cntainr .card .img-container {
        height: 300px;
        width: 100%;

        overflow: hidden;
    }

    .custm-crd-cntainr .card .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;

        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .custm-crd-cntainr .card:hover .img-container img {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    #article-content .content img {
        width: 100%;
        height: 100%;
    }
</style>
@endsection

@section('content')

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-10 center-block article-view">
                <article id="article-content">
                    <div>
                        <img src="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $work->cover_image) }}" alt="Story title" class="img-fluid">
                    </div>
                    <div>
                        @auth
                        <div class="bookmark-holder">
                            @if($bkMark == 'true')
                            <button class="btn btn-bkmrk" data-url="{{ route('user.bookmarks.story') }}" data-cid="{{ $work->id }}" data-status="active">
                                <i class="fa fa-solid fa-bookmark"></i>
                            </button>
                            @else
                            <button class="btn btn-bkmrk" data-url="{{ route('user.bookmarks.story') }}" data-cid="{{ $work->id }}" data-status="inactive">
                                <i class="fa fa-regular fa-bookmark"></i>
                            </button>
                            @endif
                        </div>
                        @endauth
                        <h1>
                            {{ $work->title }}
                        </h1>
                        <p>
                            By {{ $displayName }}
                            <br>{{ \Carbon\Carbon::parse($work->published_at)->format('F d, Y') }}
                        </p>
                        @include('components.social-share')


                        {{-- CONTENT --}}
                        <div class="content">
                        @if(!$work->storyContents->isEmpty())
                            <hr>
                            @foreach($work->storyContents as $content)
                                @if($content->type == 'image')
                                    <img class="img-fluid" src="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $content->value) }}" alt="">
                                {{-- IFRAMES in some Links --}}
                                {{-- @elseif($content->type == 'link')
                                    <a href="{{ $content->value }}">{{ $content->value }}</a> --}}
                                @else
                                    {!! $content->value !!}
                                @endif
                                <br>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </article>
                

                {{-- OTHER CREATIVES' WORKS --}}
                @if(!$otherWorks->isEmpty())
                    <div class="container">
                        <div class="row" style="padding: 10px;">
                            <div class="col-12" style="border-top: 2px solid #151515;"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h2>
                                    More posts from this creative:
                                </h2>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            @foreach($otherWorks as $otherWork)
                                <div class="col col-12 col-md-4 custm-crd-cntainr">
                                    <a href="{{ route('creative-works.view', ['slug' => $otherWork->latestSlug->value]) }}">
                                        <div class="card">
                                            <div class="img-container">
                                                <img src="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $otherWork->cover_image) }}" 
                                                    alt="image info" 
                                                    class="img-fluid"
                                                    onerror="this.onerror=null; this.src='{{ asset('img/banner-default.jpg') }}';"
                                                    >
                                            </div>
                                            <div class="card-body">
                                                <h3>{{ $otherWork->title }}</h3>
                                            </div>
                                            <div class="card-footer">
                                                <p>{{ \Carbon\Carbon::parse($otherWork->published_at)->format('F d, Y') }}</p>
                                            </div>
                                        </div>
                                    </a> 
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif
                
                {{-- RELATED WORKS BY CATEGORY --}}
                {{--
                <h2>
                    Related posts by category:
                </h2>
                <div class="home_stories related-posts">
                    <a href="">
                        <article>
                            <img src="https://createphilippines.com/upload/assets/33D2UTUteYJpeP3tUwCxSW2VXypJ5Hs1mFMQH1W2i2y3q65Dpl.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                    </a>
                    <a href="">
                        <article>
                            <img src="https://createphilippines.com/upload/assets/PEN8sLqNcvMAfSsfHPGgMO04W0sHO0QfgxMu2dIqDZEvt6u8qT.png" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                    </a>
                    <a href="">
                        <article>
                            <img src="https://createphilippines.com/upload/assets/liiK9E9u1R3G5c23Wr4DwUxyiLUFIkFNy9n3Jdbnjlawlr87cm.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                    </a>
                </div>
                --}}
                    
            </div>
        </div>
    </div>
</section>

@endsection