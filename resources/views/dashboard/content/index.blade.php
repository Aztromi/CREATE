@extends('dashboard.index')

@section('styles')
    <style>
        body {
            background-color: #000000 !important;
        }

        .content-wrapper {
            background-color: #000000 !important;
            color: #FFFFFF;

        }

        .dash-stats {
            /* border: 1px solid #000000; */
            border-radius: 20px;
            text-align: center;
            padding: 0;
            margin-top: 25px;
            margin-left: 10px;
            margin-right: 10px;
            box-shadow: rgba(255, 255, 255, 0.26) 0px 3px 8px;
            /* box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; */
        }
        
        .dash-stats .stat-value {
            padding: 30px 10px 5px 10px;
            font-weight: bold;
            font-size: 25px;
            color:rgb(170, 170, 170);
        }

        .dash-stats .stat-label {
            padding: 5px 10px 30px 10px;
            font-size: 14px;
            line-height: 16px;
            color:rgb(170, 170, 170);
        }

        .info-header {
            border: 1px solid rgb(220, 220, 220);
            margin-top: 50px;
            padding: 0 40px;
            border-radius: 20px;
        }

        .info-header div:first-child {
            padding: 30px 0;
            font-size: 18px;
            line-height: 25px;
        }

        .info-header div:last-child {
            vertical-align: bottom;
        }
        
        .info-services {
            margin-top: 50px;
        }

        .info-services .card-container, .info-presense .card-container {
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .info-services .card-container .card, .info-presense .card-container .card {
            border-radius: 20px;
            height: 100%;
            color: #FFFFFF;
        }
        
        .info-services .card-container a .card:hover, .info-presense .card-container a .card:hover {
            background-color:rgb(220, 220, 220);
            color: #000000;
            text-align: center;
        }

        .info-services .card .card-body .standout, .info-presense .card .card-body .standout {
            font-weight: bold;
            color:rgb(24, 126, 236);
        }

        .info-services .card-container .card .card-footer, .info-presense .card-container .card .card-footer {
            border: 0;
            padding: 0;
            background-color: transparent;
            color:rgb(100, 100, 100);
            font-size: 12px;
            text-align: center;
            visibility: hidden;
        }

        .info-services .card-container .card:hover .card-footer, .info-presense .card-container .card:hover .card-footer {
            visibility: visible;
        }

        .info-services .card {
            background-color: #000000;
        }

        .info-services .card .img-container {
            padding: 0 50px;
            border-radius: 20px;
        }

        .info-services > .card-container:nth-child(4n+1) .img-container {
            background-color: #3DB1E7;
        }
        .info-services > .card-container:nth-child(4n+2) .img-container {
            background-color: #DA508A;
        }
        .info-services > .card-container:nth-child(4n+3) .img-container {
            background-color: #B15DC6;
        }
        .info-services > .card-container:nth-child(4n+4) .img-container {
            background-color: #39CFBB;
        }

        .info-services .card .card-body, .info-presense .card .card-body {
            padding-top: 12px;
        }

        .info-services .card .card-body .head, .info-presense .card .card-body .head {
            font-weight: bold;
            font-size: 18px;
            line-height: 20px;
            padding-bottom: 8px;
        }

        .info-services .card .card-body .desc, .info-presense .card .card-body .desc {
            font-size: 16px;
            line-height: 20px;
        }
        
        .info-presense .card {
            background-color: #000000;
        }

        .info-presense > .card-container .img-container {
            padding: 15px 100px;
            border-radius: 20px;
            background-color: rgb(23,21,21);
        }

        @media (max-width: 1300px) {
            .info-services .card .img-container {
                padding: 0 30px;
            }

            .info-presense > .card-container .img-container {
                padding: 15px 30px;
            }
        }

        @media (max-width: 520px) {
            .info-services .card .img-container {
                padding: 0 5px;
            }

            .info-presense > .card-container .img-container {
                padding: 5px 5px;
            }
        }

    </style>
@endsection

@section('userDashboard')
 
<section>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Dashboard</h1>
                <hr>
                <!-- <p>
                    Hi, <b>{{ Auth::user()->name }}</b>!
                    <br>
                    Today is <b>{{ date('F d, Y') }}</b>.
                </p> -->
            </div>
        </div>
        @userverifiedunverified
        <div class="row">
            <div class="col-12">
                <h3>Profile Engagement</h3>
            </div>
            <div class="col-5 col-md-3 col-lg-2 dash-stats follows">
                <div class="stat-value">-</div>
                <div class="stat-label">Followers</div>
            </div>

            <div class="col-5 col-md-3 col-lg-2 dash-stats portfolioPosted">
                <div class="stat-value">-</div>
                <div class="stat-label">Total Posts</div>
            </div>

            <div class="col-5 col-md-3 col-lg-2 dash-stats profileVisits">
                <div class="stat-value">-</div>
                <div class="stat-label">Total Profile Visits</div>
            </div>

            <div class="col-5 col-md-3 col-lg-2 dash-stats portfolioVisits">
                <div class="stat-value">-</div>
                <div class="stat-label">Total Posts Views</div>
            </div>
        </div>
        @enduserverifiedunverified

        <div class="row info-header">
            <div class="col-12 col-lg-6 my-auto">
                <h1>Welcome Creative!</h1>
                <span>As a valued member of the CREATEPhilippines Directory, you’ll gain access to exclusive services and benefits that will help you grow your creative career or business. </span>
            </div>
            <div class="col-12 col-lg-6 d-flex align-items-end">
                <img src="/img/exhibitor/dashboard/banner.png" class="img-fluid" alt="">
            </div>
        </div>

        <div class="row info-services">
            <div class="col-6 col-lg-3 card-container">
                <div class="card">
                    <div class="img-container">
                        <img src="/img/exhibitor/dashboard/Connect.png" class="img-fluid" alt="">
                    </div>
                    <div class="card-body">
                        <div class="head">Connect with potential clients</div>
                        <div class="desc">Our Connect With a Creative feature bridges the gap between you and your next potential client or opportunity for collaboration.</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 card-container">
                <a href="https://forms.gle/1qxP2LQLVEYSuWay5" target="_blank" rel="noopener noreferrer">
                    <div class="card">
                        <div class="img-container">
                            <img src="/img/exhibitor/dashboard/Calendar.png" class="img-fluid" alt="">
                        </div>
                        <div class="card-body">
                            <div class="head">Promote your events</div>
                            <div class="desc">Get your events featured on our website’s Calendar of Creative Events and expand your audience reach. <span class="standout">Submit your events here</span>.</div>
                        </div>
                        <div class="card-footer">
                            Click to Submit your event
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3 card-container">
                <div class="card">
                    <div class="img-container">
                        <img src="/img/exhibitor/dashboard/Monthly_creative.png" class="img-fluid" alt="">
                    </div>
                    <div class="card-body">
                        <div class="head">Monthly Creative Feature</div>
                        <div class="desc">Stand out as our Creative of the Month! Qualified applicants will have their profiles and their work promoted as exclusive content across our platforms. Nominate your works here.</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 card-container">
                <div class="card">
                    <div class="img-container">
                        <img src="/img/exhibitor/dashboard/Networking.png" class="img-fluid" alt="">
                    </div>
                    <div class="card-body">
                        <div class="head">Networking Activities</div>
                        <div class="desc">Get exclusive invites to our networking events where you can learn from, collaborate, and grow with like-minded creatives and industry professionals.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-2">
            <div class="col-12">
                <h2>Maximize your presence in the Directory of Creatives</h2>
            </div>
        </div>
        <div class="row info-presense">
            <div class="col-6 col-lg-4 mx-auto card-container">
                <div class="card">
                    <div class="img-container">
                        <img src="/img/exhibitor/dashboard/Update.png" class="img-fluid" alt="">
                    </div>
                    <div class="card-body">
                        <div class="head">Update your profile</div>
                        <div class="desc">Make sure your profile details are updated. This way, interested collaborators can easily contact you.</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mx-auto card-container">
                <div class="card">
                    <div class="img-container">
                        <img src="/img/exhibitor/dashboard/Upload.png" class="img-fluid" alt="">
                    </div>
                    <div class="card-body">
                        <div class="head">Upload your works and portfolio</div>
                        <div class="desc">Doing so will make your work accessible to a wider network of potential clients.</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 mx-auto card-container">
                <div class="card">
                    <div class="img-container">
                        <img src="/img/exhibitor/dashboard/verify.png" class="img-fluid" alt="">
                    </div>
                    <div class="card-body">
                        <div class="head">Verify your account</div>
                        <div class="desc">A verified account lets potential clients know you’re legit and ready for business. Upload your business documents: BIR 2303, valid ID (for individuals), and Mayor’s Permit (for companies).</div>
                    </div>
                </div>
            </div>
    </div>

        

    </div>
</section>

@endsection

@section('scripts-bottom')
    <script>
        $(document).ready(function(){
            @userverifiedunverified
            $.ajax({
                url: "{{ route('user.getUserStats') }}",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                xhrFields: {
                    withCredentials: true
                },
                success: async function(response) {
                    $('.follows .stat-value').html(response.followers);
                    $('.profileVisits .stat-value').html(response.profileViews);
                    $('.portfolioVisits .stat-value').html(response.totalPortfolioViews);
                    $('.portfolioPosted .stat-value').html(response.portfolioCount);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            @enduserverifiedunverified
        });
    </script>



@endsection