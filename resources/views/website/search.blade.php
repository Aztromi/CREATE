@extends('layouts.app')

@section('styles')
<style>
    .search-sml-msg{
        color: black;
        text-align: center;
    }
</style>
@endsection

@section('scripts-bottom')
    <script>
        $(document).ready(function(){
            $('#search-input-main').focus();
        });

      
        $('#search-button-main').on('click', function(e){
            e.preventDefault();
            checkSearch();
        });

        $('#search-input-main').keypress(function(e){
            // e.preventDefault();
            if(e.which === 13)
            {
                checkSearch();        
            }
        });

        function checkSearch()
        {
            val = $('#search-input-main').val().trim();

            if(val.length > 0)
            {
                // runSearch(val);
                $('#search-frm').submit();
            }
            else
            {
                $('#search-input-main').val('');
                $('#search-input-main').focus();
            }
        }

        function runSearch(valToSearch)
        {
            pUrl = $('#search-frm').attr('action');
            btn = $('#search-button-main');
            btnOld = btn.html();

            $.ajax({
                url: pUrl,
                type: 'POST',
                data: $('#search-frm').serialize(),
                // {value: valToSearch},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                },
                success: function(response) {
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log('FAIL');
                    console.log(valToSearch);
                },
                complete: function() {
                    btn.html(btnOld);
                }
            });
        }
    </script>
@endsection

@section('content')

<section class="bg_black ">



    <section class="content">
      <div class="container-fluid">

        <div class="row justify-content-center">
          <div class="col-sm-11 col-md-8 col-xl-8">
              <h1 class="text-center">Search</h1>
              <form id="search-frm" method="POST" action="{{ route('search-init') }}">
                @csrf
              <div class="input-group">
                <div class="form-control">
                    <input id="search-input-main" name="search-input-main" type="search" id="form1" class="form-control" value="{{ $sVal ?? ''}}" placeholder="Search...">
                </div>
                <button id="search-button-main" type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
                </div>  
              </form>
          </div>
        </div>

        @if(isset($works) && isset($creatives) && isset($articles))
        <div class="row justify-content-center">
          <div class="col-11">
            <div class="card card-primary card-tabs mt-4">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-works-tab" data-toggle="pill" href="#custom-tabs-one-works" role="tab" aria-controls="custom-tabs-one-works" aria-selected="true">Works</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profiles-tab" data-toggle="pill" href="#custom-tabs-one-profiles" role="tab" aria-controls="custom-tabs-one-profiles" aria-selected="false">Profiles</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-articles-tab" data-toggle="pill" href="#custom-tabs-one-articles" role="tab" aria-controls="custom-tabs-one-articles" aria-selected="false">Articles</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-works" role="tabpanel" aria-labelledby="custom-tabs-one-works-tab">
                    <!-- Works START -->
                    <section class="bg_black ">
                        <div class="container">
                            <div class="row text-center">
                                <div class="col-xs-12 center-block col-sm-8">
                                    <h1 class="text-center">Creative Works</h1>
                                    <!-- <p class="text-center">
                                        Discover a wealth of knowledge and inspiration from industry experts and thought leaders through CREATEPhilippines' collection of articles.
                                    </p> -->
                                </div>
                            </div>
                        </div>
                    </section>
                    <section >
                        <div class="container">
                            <div class="search">
                                <div class="row">
                                    {{-- WORKS --}}
                                    @if($works)

                                        @foreach($works as $work)
                                        <a href="{{ route('creative-works.view', ['slug' => $work->latestSlug->value]) }}">
                                            <article>
                                                <div>
                                                    <img src="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $work->cover_image) }}" alt="{{ $work->title }}" class="img-fluid">
                                                </div>
                                                <div>
                                                    <b>{{ $work->title }}</b>
                                                    {{-- <p>By <strong>{{ $lArticle->author }}</strong>, {{ \Carbon\Carbon::parse($lArticle->date)->format('F d, Y') }}</p> --}}
                                                </div>
                                            </article>
                                        </a>
                                        @endforeach

                                        {{ $works->links() }}
                                        
                                    @else
                                        <div class="search-sml-msg">No Creative Works Match</div>
                                    @endif

                                    
                                </div>
                            </div>
                        </div>
                    </section>
                  <!-- Works END -->
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profiles" role="tabpanel" aria-labelledby="custom-tabs-one-profiles-tab">
                     <!-- Profiles START -->
                      <section class="bg_black ">
                          <div class="container">
                              <div class="row text-center">
                                  <div class="col-xs-12 center-block col-sm-8">
                                      <h1 class="text-center">Profiles</h1>
                                      <!-- <p class="text-center">
                                          Discover a wealth of knowledge and inspiration from industry experts and thought leaders through CREATEPhilippines' collection of articles.
                                      </p> -->
                                  </div>
                              </div>
                          </div>
                      </section>
                      <section >
                          <div class="container">
                            <div class="search">
                                <div class="row">
                                    {{-- PROFILES --}}
                                    @if($creatives)
                                        @foreach($creatives as $creative)
                                        <a href="{{ route('works', ['slug' => $creative->profile->latestSlug->value]) }}">
                                            <article>
                                                <div>
                                                    <img src="
                                                    @if($creative->profile->uindie->display_photo)
                                                        {{ asset('folder_user-uploads/' . $creative->id . '/Profile/' . $creative->profile->uindie->display_photo) }}
                                                    @else
                                                        {{ asset('/img/default_profile_img.png') }}
                                                    @endif
                                                    " alt="{{ $creative->profile->dispName }}" class="img-fluid">
                                                </div>
                                                <div>
                                                    <b>{{ $creative->profile->dispName }}</b>
                                                    {{-- <p>By <strong>{{ $lArticle->author }}</strong>, {{ \Carbon\Carbon::parse($lArticle->date)->format('F d, Y') }}</p> --}}
                                                </div>
                                            </article>
                                        </a>
                                        @endforeach

                                        {{ $creatives->links() }}

                                    @else
                                        <div class="search-sml-msg">No Profile Match</div>
                                    @endif
                            

                                    
                                </div>
                            </div>
                          </div>
                      </section>
                    <!-- Profiles END -->
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-articles" role="tabpanel" aria-labelledby="custom-tabs-one-articles-tab">
                     <!-- Articles START -->
                    <section class="bg_black ">
                        <div class="container">
                            <div class="row text-center">
                                <div class="col-xs-12 center-block col-sm-8">
                                    <h1 class="text-center">Articles</h1>
                                    <!-- <p class="text-center">
                                        Discover a wealth of knowledge and inspiration from industry experts and thought leaders through CREATEPhilippines' collection of articles.
                                    </p> -->
                                </div>
                            </div>
                        </div>
                    </section>
                    <section >
                        <div class="container">
                            <div class="search">
                                <div class="row">
                                    {{-- ARTICLES --}}
                                    @if(!empty($articles))

                                    @foreach($articles as $article)
                                    <a href="{{ route('articles.view', ['slug' => $article->latestSlug->value]) }}">
                                        <article>
                                            <div>
                                                <img src="{{ asset('folder_articles/' . $article->asset->path) }}" alt="{{ $article->name }}" class="img-fluid">
                                            </div>
                                            <div>
                                                <b>{{ $article->name }}</b>
                                                {{-- <p>By <strong>{{ $lArticle->author }}</strong>, {{ \Carbon\Carbon::parse($lArticle->date)->format('F d, Y') }}</p> --}}
                                            </div>
                                        </article>
                                    </a>
                                    @endforeach

                                    {{ $articles->links() }}

                                    @else
                                        <div class="search-sml-msg">No Articles match</div>
                                    @endif


                                    
                                </div>
                            </div>
                        </div>
                    </section>
                  <!-- Articles END -->
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          
        </div>
        @endif



      </div>
    </section>
</section>


@endsection