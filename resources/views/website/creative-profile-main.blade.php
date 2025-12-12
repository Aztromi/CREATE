@extends('layouts.app')

@section('scripts-bottom')
    <script>
        $('.btn-bkmrk').on('click', function(e){
            e.preventDefault();
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
                    profile_id: contentID
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
                        btn.html('<i class="fa fa-heart fa-solid fs-2" ></i>');
                        btn.data('status', 'active');
                    }
                    else
                    {
                        btn.html('<i class="fa fa-heart fa-regular fs-2" ></i>');
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

@section('content')

<section class="bg_black25">
    <div class="container-fluid">
        {{-- insert url to creative banner in in-line style --}}
        <div class="creative-banner" style="background-image: {{ asset('folder_user-uploads/' . $profileData->user_id . '/Profile/' . $profileData->uindie->cover_photo) }}"></div>
        <div class="row">
            <div class="col-col-xs-12 col-sm-1"></div>
            <div class="col-col-xs-12 col-sm-3">
                <div class="left-hand">
                    <div class="profile-container">
                        <div class="profile-img-holder text-center">
                            <img style="width: 330px;" class="img-fluid" src="
                            
                                @if($profileData->uindie->display_photo)
                                    {{ asset('folder_user-uploads/' . $profileData->user_id . '/Profile/' . $profileData->uindie->display_photo) }}
                                @else
                                    {{ asset('/img/default_profile_img.png') }}
                                @endif
                            " alt="Display Name"
                            onerror="this.onerror=null; this.src='{{ asset('/img/default_profile_img.png') }}';"
                            >
                            @if($profileData->user->verified == 1)<img src="{{ url('/img/verified.png') }}" alt="Verified Creative">@endif
                            {{-- <img src="{{ url('/img/unverified.png') }}" alt="Unverified Creative"> --}}
                        </div>
                        <div class="display-name-holder">
                            <h1>
                                {{-- Insert Display Name --}}
                                {{ $profileData->dispName }}
                            </h1>

                            @auth
                                @if($bkMark == 'true')
                                <a href="" class="btn btn-bkmrk" title="Unfollow creative" data-url="{{ route('user.bookmarks.profile') }}" data-cid="{{ $profileData->id }}" data-status="active">
                                    <i class="fa fa-heart fa-solid fs-2" ></i>
                                </a>
                                @else
                                <a href="" class="btn btn-bkmrk" title="Follow creative" data-url="{{ route('user.bookmarks.profile') }}" data-cid="{{ $profileData->id }}" data-status="inactive">
                                    <i class="fa fa-heart fa-regular fs-2" ></i>
                                </a>
                                @endif
                            @endauth

                            @if(Auth::check() && (Auth::user()->isAdminOG() || Auth::user()->isCreative()))
                            <a href="{{ route('shd.messages.startMessage', ['recipient' => $profileData->user_id]) }}" class="btn " title="Send message">
                                <i class="fa fa-paper-plane fa-regular fs-2" ></i>
                            </a>
                            @endif


                            <!-- SOCIALS LEFT PANE -->

                            @if($profileData->socials->isNotEmpty())
                                <div class="profile-social-holder">
                                    <dl>
                                        <dd>Follow this creative on social!</dd>
                                    </dl>
                                    <ul>
                                        @foreach($profileData->socials as $social)
                                            @if($social->type == 'Facebook')
                                            <li>
                                                <a href="
                                                        @if(substr(trim($social->value), 0, 3) === 'www' || substr(trim($social->value), 0, 3) === 'htt')
                                                            {{ $social->value }}
                                                        @else
                                                            https://www.facebook.com/{{ $social->value }}
                                                        @endif
                                                " target="_blank" rel="noopener noreferrer">
                                                    <i class="fa-brands fa-facebook"></i>
                                                </a>
                                            </li>
                                            @elseif($social->type == 'Instagram')
                                            <li>
                                                <a href="
                                                        @if(substr(trim($social->value), 0, 3) === 'www' || substr(trim($social->value), 0, 3) === 'htt')
                                                            {{ $social->value }}
                                                        @else
                                                            https://www.instagram.com/{{ $social->value }}
                                                        @endif
                                                " target="_blank" rel="noopener noreferrer">
                                                    <i class="fa-brands fa-instagram"></i>
                                                </a>
                                            </li>
                                            @elseif($social->type == 'Twitter')
                                            <li>
                                                <a href="
                                                        @if(substr(trim($social->value), 0, 3) === 'www' || substr(trim($social->value), 0, 3) === 'htt')
                                                            {{ $social->value }}
                                                        @else
                                                            https://www.twitter.com/{{ $social->value }}
                                                        @endif
                                                " target="_blank" rel="noopener noreferrer">
                                                    <i class="fa-brands fa-twitter"></i>
                                                </a>
                                            </li>
                                            @elseif($social->type == 'Youtube')
                                            <li>
                                                <a href="
                                                        @if(substr(trim($social->value), 0, 3) === 'www' || substr(trim($social->value), 0, 3) === 'htt')
                                                            {{ $social->value }}
                                                        @else
                                                            https://www.youtube.com/{{ $social->value }}
                                                        @endif
                                                " target="_blank" rel="noopener noreferrer">
                                                    <i class="fa-brands fa-youtube"></i>
                                                </a>
                                            </li>
                                            @elseif($social->type == 'Tiktok')
                                            <li>
                                                <a href="
                                                        @if(substr(trim($social->value), 0, 3) === 'www' || substr(trim($social->value), 0, 3) === 'htt')
                                                            {{ $social->value }}
                                                        @else
                                                            https://www.tiktok.com/{{ $social->value }}
                                                        @endif
                                                " target="_blank" rel="noopener noreferrer">
                                                    <i class="fa-brands fa-tiktok"></i>
                                                </a>
                                            </li>
                                            @elseif($social->type == 'Behance')
                                            <li>
                                                <a href="
                                                        @if(substr(trim($social->value), 0, 3) === 'www' || substr(trim($social->value), 0, 3) === 'htt')
                                                            {{ $social->value }}
                                                        @else
                                                            https://www.behance.net/{{ $social->value }}
                                                        @endif
                                                " target="_blank" rel="noopener noreferrer">
                                                    <i class="fa-brands fa-behance"></i>
                                                </a>
                                            </li>
                                            @endif
                                            
                                        
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            
                            <hr>
                        </div>
                        <div class="profile-contact-holder">
                            <dl>
                                @if($profileData->hide_address != 1)
                                <dd>Address</dd>
                                    <dt>
                                        
                                        @if($profileData->addressLatest)
                                            @if($profileData->addressLatest->municipality)
                                            {{ $profileData->addressLatest->municipality }}, 
                                            @endif
                                            {{ $profileData->addressLatest->country }} 
                                        @endif
                                        
                                    </dt>
                                @endif

                                
                                @if($profileData->hide_email != 1)
                                <dd>Email Address</dd>
                                    <dt>
                                        @if($profileData->emails->count() === 0)
                                            <a href="mailto:{{ $profileData->user->email }}">{{ $profileData->user->email }}</a>
                                        @else
                                            @foreach($profileData->emails as $email)
                                                <a href="mailto:{{ $email->value }}">{{ $email->value }}</a><br>
                                            @endforeach
                                        @endif
                                    </dt>
                                @endif
                                
                                @if($profileData->websites->count() > 0)
                                <dd>Website</dd>
                                    @foreach($profileData->websites as $website)
                                    <dt>
                                        <a href="{{ $website->value }}" target="_blank" rel="noopener noreferrer">{{ $website->value }}<i class="fa fa-external-link-alt"></i></a>
                                    </dt>
                                    @endforeach
                                @endif
                            </dl>
                        </div>

                        <!-- BOTTOM LEFT PANE -->

                        <hr>

                        @include('components.social-share')

                        
                    </div>


                    <!-- @if($tabView == "works")
                        @include('website.creative-works-filter')
                    @endif -->
                </div>
            </div>
            <div class="col-col-xs-12 col-sm-7">
                <div class="right-hand">
                    <p class="profile-btn-holder">
                        
                        <a class="btn btn-primary @if($tabView=='profile') active @endif" href="{{ route('profile', ['slug' => $profileData->latestSlug->value]) }}">PROFILE</a>
                        <a class="btn btn-primary @if($tabView=='works') active @endif" href="{{ route('works', ['slug' => $profileData->latestSlug->value]) }}">PORTFOLIO</a>
                        
                        
                    </p>

                    {{-- REPLACED. FOR DELETION
                    @if(str_contains(url()->current(), '/profile'))
                        @include('website.creative-profile')
                    @endif
                    @if(str_contains(url()->current(), '/works'))
                        @include('website.creative-works')
                    @endif
                    --}}

                    @if($tabView == "profile")
                        @include('website.creative-profile')
                    @elseif($tabView == "works")
                        @include('website.creative-works')
                    @endif


                </div>
            </div>
            <div class="col-col-xs-12 col-sm-1"></div>
        </div>
    </div>
</section>

@endsection