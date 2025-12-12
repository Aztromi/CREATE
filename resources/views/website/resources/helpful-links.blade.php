@extends('layouts.app')

@section('styles')
    <style>
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

        .col-6 {
            width: initial !important;
        }

        .Hlinks .row {
            margin-bottom: 50px;
        }

        .Hlinks .card-container {
            margin-bottom: 20px;
        }

        .Hlinks .card-container .card-link {
            height: 100%;
            border: 0;

        }

        .Hlinks .card-container .card-link img {
            width: 100%;
            height: 180px;
            object-fit: cover;

        }

        .Hlinks .card-container .card-link .card-title {
            font-weight: bold;
            font-size: 25px;
        }

        .Hlinks .card-container .card-link .card-footer {
            border: 0;
            background-color: #FFFFFF;
            border-radius: 0;
        }

        .Hlinks .card-container .card-link .card-footer a {
            font-weight: bold;
            color: #31A2F0;
            text-decoration: none;
        }



    </style>
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
            <div class="row">
                <div class="col-xs-12 col-sm-4"></div>
                <div class="col-xs-12 col-sm-4 text-center">
                    <h1 class="text-center">HELPFUL LINKS</h1>
                    <p class="text-center" style="line-height: 20px;">Get access to a curated collection of useful links, tools, and educational content to boost your creative skills, grow your business, and stay inspired.</p>
                </div>
            </div>
        </div> 
    </section>
    <section class="bg_light_grey">
        <div class="container Hlinks">
            @foreach($hLinks as $group)
            <div class="row">
                <div class="col-12 group-title">
                    <h2>{{ $group->name }}</h2>
                    <hr>
                </div>
                @foreach($group->helpfulLinks as $link)
                <!-- <div class="card-container col-12 col-md-6 col-xl-3"> -->
                <div class="card-container col-12 col-md-4 col-xl-4">
                    <div class="card card-link">
                        <img src="/helpful-links/{{ $link->img }}" alt="">
                        <div class="card-body">
                            <div class="card-title">{{ $link->name }}</div>
                            <div class="card-text">
                                {!! $link->description !!}
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="card-link">
                                <a href="{{ $link->website }}" target="_blank">Click to Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach

        </div>
    </section>

@endsection

@section('scripts-bottom')
    <script>
        $(document).ready(function(){
            // $("#loadingModal").modal({ 
            //     backdrop: "static", 
            //     keyboard: false, 
            // });

            // initLoad();
        });

        async function initLoad() {
            $('#loadingModal').show();
            try {
                // const response = await getLinks();
                // setLinks(response);

            } catch(error) {
                console.log(error);
                alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
            } finally {
                $('#loadingModal').hide();
            }
        }

        function getLinks() {
            return new Promise((resolve, reject) => {
                // let formData = new FormData();
                // formData.append('page', $page);
                $.ajax({
                    url: "{{ route('resources.get-helpful-links') }}",
                    type: 'POST',
                    dataType: 'json',
                    // data: formData,
                    // processData: false, // Prevent jQuery from processing the data
                    // contentType: false, // Prevent jQuery from setting the content type
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    // beforeSend: function() {
                    //     // $("#loadingModal").modal('show');
                    // },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        reject(xhr.responseText);
                    }
                    // ,
                    // complete: function(xhr, status) {
                    //     $('#loadingModal').modal('hide');
                    // }
                });
            });

        }

        function setLinks(response) {
            console.log(response);

            // $('.Hlinks .row').empty();
            let groups = response.groups;
            $.each(groups, function(index, value) {
                    console.log(value.name);

                    // let groupID = "G" + value.id;
                    $('.Hlinks .row').append(`
                        <div id="G` + index + `" class="row">
                            <div class="col-12 group-title">
                                <h2>` + value.name + `</h2>
                                <hr>
                            </div>
                        </div>
                    `);
                    

                    // $.each(value.helpful_links, function(index, value2) {
                    //         $('.Hlinks .row #' + groupID).append(value2.name + "<br>");
                    // });
            });



        }
        
    </script>

@endsection
