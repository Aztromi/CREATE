@extends('dashboard.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shared/loadingModal-custom.css?ver='.time()) }}">

    <style>
        .card {
            /* min-width: 500px; */
        }

        .tab {
            text-align: center;
            background-color: #F0F0F0;
            color: #2E2E2E;
            font-weight: bold;
            font-size: 20px;
            padding: 15px;
            cursor: pointer;
        }

        .tab:hover {
            color: #FFFFFF;
            background-color: #0D6EFD;
        }

        .tab-container .tab:first-child {
            border-right: 1px solid #FFFFFF;
        }

        .tab-container .tab:last-child {
            border-left: 1px solid #FFFFFF;
            
        }


        .tab.active {
            background-color: #2E2E2E;
            color: #FFFFFF;
            border: 0;
            cursor: default;
        }

        .tab-content {
            color: #000000;
            padding: 10px;
            border-left: 1px solid #F0F0F0;
            border-right: 1px solid #F0F0F0;
            border-bottom: 1px solid #F0F0F0;
        }

        .tab-content .content-card {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            margin: 10px;
        }

        .tab-content .content-card:hover {
            /* box-shadow: rgba(0, 154, 255, 0.24) 0px 3px 8px; */
            box-shadow: rgba(0, 157, 255, 0.34) 0px 3px 8px;
        }

        .tab-content .content-card a:hover {
            text-decoration: none;
            color: #000000;
        }

        .tab-content .content-card .content-img {
            height: 15vw;
            width: 100%;
            overflow: hidden;
            padding: 0px;
        }

        .tab-content .content-card .content-text {
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 1.5vw;
            line-height: 1.8vw;
        }

        .tab-content .content-card .content-img img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }

        .navs {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .navi {
            display: inline;
            margin-left: 10px;
            margin-right: 10px;
            font-size: 20px;
            font-weight: 400;

            
        }

        .nav-current {
            display: inline;
            font-size: 25px;
            margin-left: 15px;
            margin-right: 15px;
            
        }

        .disable a {
            cursor: default;
            color: #A5A5A5;
        }

        @media (min-width: 992px) {
            .tab-content .content-card .content-img {
                height: 12vw;
            }

            .tab-content .content-card .content-text {
                font-size: 1.5vw;
                line-height: 1.8vw;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .tab-content .content-card .content-img {
                height: 15vw;
            }

            .tab-content .content-card .content-text {
                font-size: 1.8vw;
                line-height: 2.1vw;
            }
        }

        @media (max-width: 767.98px) {
            .tab-content .content-card .content-img {
                height: 25vw;
            }

            .tab-content .content-card .content-text {
                font-size: 2.4vw;
                line-height: 2.7vw;
            }
            
        }

    </style>
@endsection

@section('scripts-bottom')
    <script>
        $(document).ready(function(){
            $("#loadingModal").modal({ 
                backdrop: "static", 
                keyboard: false, 
            }); 

            $('#loadingModal').modal('show');
            $('#main-content').hide();
            
            processData(1, 'Works', false);

            // $('#main-content').show();
            // $('#loadingModal').modal('hide');
        });

        $('.tab').on('click', function(){
            if($(this).hasClass('active')){
                return;
            }
            else{
                $('.tab.active').removeClass('active');
                $(this).addClass('active');

                $type = $(this).find('.content').text();

                processData(1, $type, true);
            }

        });

        function processData(page, type, loading){

            if(loading){
                $('#loadingModal').modal('show');
            }

            getData(page, type)
            .then(function(response){
                setData(response);
            })
            .catch(function(error){
                console.log('Error: ' + error);
            })
            .finally(function(){
                $('#main-content').show();
                $('#loadingModal').modal('hide');
            });

            

        }

        function getData(page, type){
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ route('user.bookmarks.getBookmarksData') }}",
                    data: {
                        page: page,
                        type: type
                    },
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        reject(new Error(response));
                    },
                    complete: function() {}
                });
            });

        }

        function setData(response){
            if(response.count > 0){

                $('.tab-content').empty();

                $.each(response.content, function(index, item) {

                    switch(response.type){
                        case 'Works':
                            $title = item.title;
                            $link = '/creative-work/' + item.latest_slug.value;
                            $imgSrc = '/folder_user-uploads/' + item.ownerable_id + '/stories/' + item.cover_image;
                            break;
                        case 'Profiles':
                            $title = item.disp_name;
                            $link = '/profile/' + item.latest_slug.value;
                            $imgSrc = '/folder_user-uploads/' + item.user_id + '/Profile/' + item.uindie.display_photo;
                            break;
                        case 'Articles':
                            $title = item.name;
                            $link = '/article/' + item.latest_slug.value;
                            $imgSrc = '/folder_articles/' + item.asset.path;
                            break;
                    }
                    

                    $('.tab-content').append(`
                        <div class="col-5 col-md-4 col-lg-3 content-card">
                            <a href="` + $link + `" target="_blank">
                                <div class="row">
                                    <div class="col-12 content-img">
                                        <img src="`+ $imgSrc +`" alt="">
                                    </div>
                                    <div class="col-12 content-text">
                                        `+ $title +`
                                    </div>
                                </div>
                            </a>
                        </div>
                    `);
                });

                $('.navs').show();
                $('.navi.disable').removeClass('disable');

                if(response.page == 1){
                    $('.nav-first').addClass('disable');
                    $('.nav-first a').data('page', 0);
                }
                else {
                    $('.nav-first a').data('page', 1);
                }

                if((response.page - 1) == 0){
                    $('.nav-previous').addClass('disable');
                    $('.nav-previous a').data('page', 0);
                }
                else{
                    $('.nav-previous a').data('page', response.page - 1);
                }

                if((response.page + 1) > response.count){
                    $('.nav-next').addClass('disable');
                    $('.nav-next a').data('page', 0);
                }
                else{
                    $('.nav-next a').data('page', response.page + 1);
                }

                if(response.page == response.count){
                    $('.nav-last').addClass('disable');
                    $('.nav-last a').data('page', 0);
                }
                else{
                    $('.nav-last a').data('page', response.count);
                }
                
                $('.nav-current').text(response.page);

            }
            else{
                $('.navs').hide();
                $('.tab-content').html('<center>None Found.</center>');
            }
        }

        $('.navi a').on('click', function(e){
            e.preventDefault();

            if($(this).data('page') == 0){
                return;
            }

            processData($(this).data('page'), $('.tab.active').find('.content').text(), true);
        });
        
    </script>
@endsection

@section('userDashboard')
<section>

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

    <div class="card col-12">
        <div class="card-body">
            <div class="container" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col mt-4 mb-4 text-center">
                        <h1>BOOKMARKS</h1>
                    </div>
                </div>

                <div class="row tab-container">
                    <div class="col-4 tab active">
                        <div class="content">Works</div>
                    </div>
                    <div class="col-4 tab">
                        <div class="content">Profiles</div>
                    </div>
                    <div class="col-4 tab">
                        <div class="content">Articles</div>
                    </div>
                </div>
                <div class="row tab-content">
                    {{--
                        <div class="col-5 col-md-4 col-lg-3 content-card">
                            <a href="" target="_blank">
                                <div class="row">
                                    <div class="col-12 content-img">
                                        <img src="{{ asset('img/banner-default.jpg') }}" alt="">
                                    </div>
                                    <div class="col-12 content-text">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum delectus earum, soluta rem tenetur, facilis,
                                    </div>
                                </div>
                            </a>
                        </div>
                    --}}
                </div>

                <div class="row navs">
                    <div class="col-12">
                        <div class="navi nav-first disable"><a href="" id="nav-link">First</a></div>
                        <div class="navi nav-previous"><a href="" id="nav-link">Previous</a></div>
                        <div class="nav-current">0</div>
                        <div class="navi nav-next"><a href="" id="nav-link">Next</a></div>
                        <div class="navi nav-last"><a href="" id="nav-link">Last</a></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection