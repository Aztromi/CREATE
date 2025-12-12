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
            margin: 0;
        }

        #loadingModal button {
            background-color: #39c5f3;
            color: #000000;
            border: 3px solid #000000;
            border-radius: 15px;
            padding: 10px 40px;
            /* max-width: 200px; */
            margin: 0 auto;
            font-weight: bold;
            letter-spacing: 1px;
        }

        #loadingModal .modal-content {
            background-color: transparent;
            box-shadow: none;
            border: none;
        }

        #loadingModal .modal-img {
            max-width: 80vw;   /* 80% of viewport width */
            max-height: 80vh;  /* 80% of viewport height */
            object-fit: contain; 
            display: block;
            margin: 0 auto;    /* center horizontally */
            border: 5px solid #000000;
        }

        
        footer {
            font-family: "Work Sans", sans-serif !important;
        }

        .contactPartner {
            font-family: "Work Sans", sans-serif !important;
        }

        @font-face {
            font-family: "Kaleko 105";
            /* Make sure this matches the body */
            src: url("/fonts/Kaleko105Book.otf") format("opentype");
            -webkit-font-smoothing: antialiased;
            /* Smooth rendering for WebKit browsers */
        }

        @font-face {
            font-family: "Kaleko 105 Bold";
            /* Make sure this matches the body */
            src: url("/fonts/Kaleko105Bold.otf") format("opentype");
            -webkit-font-smoothing: antialiased !important;
            /* Smooth rendering for WebKit browsers */
        }

        .nav-link {
            font-family: "Work Sans", sans-serif !important;
        }

        .section-1-container {
            padding: 30px 120px !important;
        }

        .section-1 {
            border: 12px solid #000 !important;
        }

        .section-1-vid {
            overflow: hidden;
            position: relative;

            min-height: 300px;

            box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
        }

        .section-1-vid .video-fill,
        .section-1-vid .fallback-img {
            width: 100%;
            height: 100%;
            min-height: 300px;
            object-fit: cover; /* crop instead of stretch */
            position: absolute;
            top: 0;
            left: 0;
        }

        .ifex-leading.f {
            padding-top: 50px;
            padding-bottom: 30px;
            text-align: center;
            font-size: 40px;
        }

        .ifex-leading.f span {
            font-family: "Kaleko 105 Bold", sans-serif;
            font-weight: bold;
        }

        .ifex-leading.l {
            padding-bottom: 50px;
            text-align: center;
        }

        .ifex-leading.l span {
            background-color: transparent;
            padding: 20px;
            border-radius: 40px;
        }

        .ifex-leading.l span:hover {
            cursor: pointer;
            color: #FFFFFF;
            background-color: rgb(226,0,33);
            padding: 20px;
            border-radius: 40px;
            font-family: "Kaleko 105 Bold", sans-serif;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        }

        .ifex-content p.q-container {
            padding-top: 15px;
            padding-top: 15px;
        }

        .quote {
            font-family: "Kaleko 105 Bold", sans-serif;
            font-size: 20px;
        }

        q::before,
        q::after {
            font-size: 30px;
        }

        .ifex-exhibition-hall {
            min-height: 300px;
        }

        /* IMAGES */
        .ifex-exhibition-hall img {
            border-left: 5px solid #000000;
            border-top: 5px solid #000000;
        }

        .ifex-gallery {
            background-color: rgba(255, 197, 50, 1);
            border-top: 5px solid #000000;
        }

        .ifex-gallery .container {
            padding-left: 20px;
            padding-right: 20px;
        }

        .ifex-gallery  .img-container {
            overflow: hidden;
            margin-bottom: 20px;
        }

        .ifex-gallery img {
            width: 100%;
            height: 100%;
            height: 250px;
            object-fit: cover;
            display: block;

            border-radius: 20px;
            border: 5px solid #000000;
            cursor: pointer;
        }

        .ifex-gallery img:hover {
            border: 5px solid 
        }
        /* IMAGES END */

        body {
            font-family: "Kaleko 105", sans-serif !important;
            max-width: 1920px;
            display: flex !important;
            justify-content: center;
            margin: 0 auto !important;
        }

        .banner {
            position: relative;
            width: 100%;
            height: 91vh;
            background: url("/img/static/createlab/banner.jpg") center/cover no-repeat fixed;
            /* Parallax effect */
        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            /* Dark overlay */
        }

        .banner-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 2;
        }

        .banner-content h1 {
            font-family: "Kaleko 105 Bold", sans-serif !important;
            font-size: 90px !important;
            font-weight: 600;
        }

        .intro {
            padding: 60px 180px !important;
        }

        .intro h2 {
            font-family: "Kaleko 105 Bold", sans-serif !important;
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .section-1 p,
        .intro p,
        .cta-2 p,
        .createlab-footer p {
            font-size: 16px !important;
            font-weight: 400 !important;
            letter-spacing: 0.5px;
        }

        .section-1 {
            background-color: #39c5f3;
            color: #000;
        }

        .section-1-content h2 {
            text-align: center;
            font-family: "Kaleko 105 Bold", sans-serif;
            font-size: 45px;
            line-height: 62px;
            margin-bottom: 24px;
        }

        .section-1-content {
            padding: 80px !important;
            text-align: center;
        }

        .section-1-content a {
            color: #000;
            text-decoration: underline;
            font-weight: 600;
            text-align: center;
        }

        .section-1-content p {
            text-align: center;
        }

        .btn-btn-2 {
            background-color: #f180ad;
            font-size: 20px;
            font-weight: 700;
            padding: 12px 28px !important;
            margin-bottom: 24px !important;
            line-height: 20px;
            text-decoration: none !important;
            color: #000 !important;
            border: 2px solid #000;
            border-width: 5px 10px 10px 5px;
            border-top-left-radius: 0px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            transition: ease-in-out 0.3s
        }

        .btn-btn-2.v2 {
            background-color: #ffe41aff;
        }

        .btn-btn-2:hover {
            background-color: #bdd634;
            border-width: 5px 9px 9px 5px;
            border-top-right-radius: 7px;
            border-bottom-right-radius: 7px;
            border-bottom-left-radius: 7px;
        }

        .btn-btn-3 {
            background-color: #f180ad;
            border-radius: 12px;
            font-size: 20px;
            font-weight: 700;
            padding: 12px 28px !important;
            margin-bottom: 24px !important;
            line-height: 20px;
            text-decoration: none !important;
            color: #000 !important;
            border: 2px solid #000;
            transition: ease-in-out 0.3s
        }

        .btn-btn-3:hover {
            background-color: #39c5f3;
        }


        .light {
            color: #000;
            background-color: #39c5f3;
        }

        .light h2,
        .light p {
            text-align: center !important;
        }

        .button-light {
            background-color: #000;
            color: #ffffff !important;
            border: 2px solid #000;
        }

        .button-light:hover {
            background-color: #ffffff;
            color: #000 !important;
            border: 2px solid #000;
        }

        .cdap-img img {
            background-color: #ffffff;
            border: 2px solid #000;
            border-width: 5px 10px 10px 5px;
            border-top-left-radius: 0px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            width: 40%;
            padding: 12px;
            margin-bottom: 24px;
            transition: all ease-in-out 0.3s;
        }

        .cdap-img img:hover {
            background-color: #e1f3f8;
            border-width: 5px 10px 10px 5px;
            transform: translateY(2px) !important;
        }

        .cta-1 {
            background-color: #4084c5;
            color: #ffffff;
            font-family: "Kaleko 105 Bold", sans-serif !important;
            font-size: 20px;
            padding: 30px;
        }

        .cta-1 h2 {
            font-weight: 700 !important;
            margin: 0px;
            font-size: 30px;
            letter-spacing: 1.5px;
            text-align: center;
        }

        .cta-2 {
            background-color: #000;
            color: #ffffff;
            padding: 60px !important;
        }

        .cta-2 img {
            width: 80% !important;
        }

        .cta-2 h2 {
            font-family: "Times New Roman", Times, serif;
            font-size: 60px;
            line-height: 70px;
            margin-bottom: 24px;
        }

        .createlab-footer {
            padding: 60px !important;
            margin-bottom: 120px !important;
            background-color: #e6e6e6;
        }

        .createlab-footer img {
            width: 80% !important;
        }

        .createlab-footer p {
            font-size: 16px !important;
            line-height: 24px !important;
        }

        .featured-creatives {
            
            padding-top: 30px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .featured-creatives h2, .ifex-gallery h2 {
            font-family: "Kaleko 105 Bold", sans-serif !important;
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .featured-creatives .card-container {
            padding: 20px;
            margin: 0px auto;
        }

        .featured-creatives .col-3 {
            flex: 0 0 auto !important;
            width: 25% !important;
        }

        .featured-creatives a {
            text-decoration: none;
            /* color: #000000;
            font-weight: bold; */
        }

        .featured-creatives .spinner-wrapper {
            position: relative;
            display: inline-block;
            margin-top: 20px;
        }

        .spinner-wrapper .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 40px;
            color: #000;
            transform: translate(-50%, -50%);
            /* z-index: 1; */
        }

        .featured-creatives .card {
            opacity: 0;
            border: 0;
            height: 100%;
            background-color: transparent;
            /* border-radius: 20px; */
            transform: scale(1.02);
            transition: opacity 0.3s ease, transform 0.3s ease;
            box-shadow: none;
            transform: translateY(0);
        }

        .featured-creatives .card.loaded {
            opacity: 1;
            transform: scale(1);
        }

        .featured-creatives .card img {
            border-width: 7px 15px 15px 7px;
            border-style: solid;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;

            transform: translateY(0);
            transition: opacity 0.3s ease-in-out, transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, border 0.2s ease-in-out;
        }

        .featured-creatives .card:hover img {   
            border-width: 5px;
            border--color: #000000;
            transform: translateY(-5px);
        }

        .featured-creatives .card-container:nth-child(5n + 1) .card img {
            border-color: #000000;
        }

        .featured-creatives .card-container:nth-child(5n + 1) .card:hover img {
            box-shadow: 15px 15px 0px 0px rgb(0, 171, 228);
            -webkit-box-shadow: 15px 15px 0px 0px rgb(0, 171, 228);
            -moz-box-shadow: 15px 15px 0px 0px rgb(0, 171, 228);
        }

        .featured-creatives .card-container:nth-child(5n + 2) .card img {
            border-color: #000000;
        }

        .featured-creatives .card-container:nth-child(5n + 2) .card:hover img {
            box-shadow: 15px 15px 0px 0px #51409A;
            -webkit-box-shadow: 15px 15px 0px 0px #51409A;
            -moz-box-shadow: 15px 15px 0px 0px #51409A;
        }

        .featured-creatives .card-container:nth-child(5n + 3) .card img {
            border-color: #000000;
        }

        .featured-creatives .card-container:nth-child(5n + 3) .card:hover img {
            box-shadow: 15px 15px 0px 0px #EC8823;
            -webkit-box-shadow: 15px 15px 0px 0px #EC8823;
            -moz-box-shadow: 15px 15px 0px 0px #EC8823;
        }

        .featured-creatives .card-container:nth-child(5n + 4) .card img {
            border-color: #000000;
        }

        .featured-creatives .card-container:nth-child(5n + 4) .card:hover img {
            box-shadow: 15px 15px 0px 0px #F280AE;
            -webkit-box-shadow: 15px 15px 0px 0px #F280AE;
            -moz-box-shadow: 15px 15px 0px 0px #F280AE;
        }

        .featured-creatives .card-container:nth-child(5n + 5) .card img {
            border-color: #000000;
        }

        .featured-creatives .card-container:nth-child(5n + 5) .card:hover img {
            box-shadow: 15px 15px 0px 0px #BDD634;
            -webkit-box-shadow: 15px 15px 0px 0px #BDD634;
            -moz-box-shadow: 15px 15px 0px 0px #BDD634;
        }

        .featured-creatives .card .card-body {
            font-family: "Kaleko 105 Bold", sans-serif !important;
            padding: 10px;
            text-align: center;
            color: #000000;
            font-weight: bold !important;
            vertical-align: middle;
        }



        /* Extra small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {

            .intro {
                padding: 32px 24px !important;
            }

            .banner-content h1 {
                font-size: 40px !important;
                padding: 12px;
            }

            .section-1-container {
                padding: 32px 25px !important;
            }

            .section-1 {
                border: 6px solid #000 !important;
            }

            /* .section-1-img {
                min-height: 400px !important;
            } */

            .cdap-img img {

                width: 75%;
            }

            .section-1-content {
                padding: 24px !important;
                text-align: center;
            }

            .section-1-content h2 {
                font-size: 24px !important;
                line-height: 32px !important;
            }

            p {
                font-size: 14px !important;
            }

            .section-1-content a,
            .btn-btn-2 {
                font-size: 16px;
                letter-spacing: 1px !important;
            }

            .cta-2 {
                padding: 60px 24px !important;
                text-align: center;
            }

            .cta-2 h2{
                font-size: 32px !important;
                line-height: 40px !important;
                padding-bottom: 12px !important;
            }

            .createlab-footer{
                padding: 60px 24px !important;
            }

            .createlab-footer-content {
                padding-top: 24px !important;
                text-align: center;
            }


        }

        /* Medium devices (tablets, 768px and up) */
        @media (max-width: 768px) {
            .banner-content h1 {
                font-size: 40px !important;
                padding: 24px;
            }

            .intro {
                padding: 60px 24px !important;
            }

            .createlab-footer-content {
                margin-top: 24px;
            }
        }

        /* Large devices (desktops, 992p
                        x and up) */
        @media (max-width: 992px) {
            .banner-content h1 {
                font-size: 52px;
            }

            .intro {
                padding: 60px 0px !important;
            }


            .light-img {
                order: 1;
                /* Move image below text */
            }

            .light {
                order: 2;
                /* Move text above image */
            }

            .cta-2 {
                padding: 32px !important;
            }

            .cta-2 h2 {
                font-size: 32px;
                margin-bottom: 0px !important;
            }


            .createlab-footer {
                padding: 60px 32px;
                margin-bottom: 120px;
            }

            .createlab-footer p {
                font-size: 14px;
            }

            .featured-creatives .col-md-4 {
                flex: 0 0 auto !important;
                width: 33.333333% !important;
            }

        }

        @media (max-width: 1200px) {
            .intro {
                padding: 60px 0px !important;
            }

            .section-1-content {
                padding: 60px;
            }

            .section-1-content h2 {
                font-size: 32px;
                line-height: 42px;
            }

            .cta-2 {
                padding: 60px
            }

            .cta-2 h2 {
                font-family: "Times New Roman", Times, serif;
                font-size: 40px;
                line-height: 50px;
                margin-bottom: 24px;
            }


        }
    </style>
@endsection


@section('scripts-bottom')
    <script>
        $(document).ready(function() {
            // $("#loadingModal").modal({ 
            //     backdrop: "static", 
            //     keyboard: false, 
            // });

            
            
            showImageSequentially(0);

            $('.ifex-gallery img').on('click', function(){
                let imgSrc = $(this).attr('src');
                $('#loadingModal img').attr('src', imgSrc);

                $('#loadingModal').modal('show');
            });

            $('#loadingModal button').on('click', function(){
                $('#loadingModal').modal('hide');
            });
            
        });

        function showImageSequentially(index) {
            const images = document.querySelectorAll('.featured-creatives .card img');

            if (index >= images.length) return;

            const img = images[index];
            const card = img.closest('.card');

            const revealCard = () => {
                card.classList.add('loaded');
                $(".featured-creatives .spinner").hide();
                setTimeout(() => showImageSequentially(index + 1), 200); // Delay for next card
            };

            if (img.complete) {
                revealCard();
            } else {
                img.addEventListener('load', revealCard);
            }
        }

    </script>
@endsection

@section('content')

    <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white border-0 shadow-none">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img class="modal-img" src="http://127.0.0.1:8000/img/static/createlab/createlab-banner.png" alt="">
                    
                </div>
                <button>Close</button>
            </div>
        </div>
    </div>
    {{-- <section class="container-fluid banner d-flex align-items-center justify-content-center">
        <div class="container-fluid banner-content">
            <h1>CREATELAB BANNER</h1>
        </div>
    </section> --}}
    
    <section class="container-fluid p-0 m-0">
        <img src="/img/static/createlab/createlab-banner.png" alt="" class="img-fluid">
    </section>

    <section class="container-fluid py-3">
        <div class="row text-center d-flex align-items-center justify-content-center intro">
            <div class="col-lg-12 col-md-11 col-sm-10 text-center">
                <h2>CREATELab</h2>
                <p>
                    <strong>CREATELab</strong> is an initiative of CREATEPhilippines to
                    promote the value of design in achieving business goals. It envisions
                    building a sustainable relationship between creatives and businesses.
                    Set as an on-site design clinic within the two signature events of
                    CITEM, IFEX Philippines and Manila FAME, this project will provide
                    micro, small, and medium enterprises (MSMEs) with expert guidance to
                    enhance their branding and marketing strategies.
                </p>
                <p>
                    In partnership with the Communication Design Association of the
                    Philippines (CDAP), CREATELab brings together qualified professionals
                    from the communication design sector. These experts offer free initial
                    consultations on logo design, web design, marketing collateral, social
                    media strategy, product branding, and other value-adding relevant
                    tools to companies to elevate their businesses. Through these
                    consultation sessions, MSMEs will receive valuable mentorship to
                    refine their marketing assets and branding practices.
                </p>
            </div>
        </div>
    </section>

    <section class="container-fluid section-1-container">
        <div class="row d-flex section-1">
            <div class="col-12 col-lg-6 p-0 section-1-vid">
                <video autoplay muted loop playsinline class="video-fill" poster="fallback.jpg">
                    <source src="https://fameplus.com/assets/images/mf/show_info2024/info_page/video.mp4" type="video/mp4">
                    <img src="https://fameplus.com/uploads/carousel/1755502052462_FAME+_Desktop_Banner_copy.png" alt="Fallback" class="fallback-img"> 
                    <!-- This <img> shows only if video tag isn't supported -->
                </video>
            </div>

            <div class="col-12 col-lg-6 section-1-content">
                <h2>CATCH US SOON IN MANILA FAME!</h2>
                <p class="mb-4">It's that time of the year again when the Philippines’ premier trade show for quality home, fashion, and lifestyle products is gearing to open its doors and showcase the best of Filipino artistry and craftsmanship. For its 73rd edition, Manila FAME will dive into the roots of Filipino design to present objects inspired by design’s original muse, nature.</p>
                <a href="https://fameplus.com/manila_fame" target="_blank" class="btn-btn-2 v2 mt-3">LEARN MORE</a>
                <!-- <p class="mt-5 mb-4">Showcasing, sourcing, or sight-seeing at Manila FAME 2025? Get more out of the experience! CREATELab will also be at the trade show to offer free design and branding consultations to participating exhibitors and visitors. Simply register to attend Manila FAME and book a session with CREATELab to get expert guidance from our communication design professionals.</p> -->
                 <p class="mt-5 mb-4">Simply register to book a session with CREATELab to get expert guidance from our communication design professionals during your visit in Manila FAME</p>
                <a href="https://forms.gle/qKL7hgSzVcFLvJ2H9" target="_blank" class="btn-btn-2 mt-3">REGISTER HERE</a>
                <p class="mt-5">CREATELab consultations will be conducted onsite at <span style="font-family: 'Kaleko 105 Bold', sans-serif !important; font-size: 18px;">Manila FAME 2025, happening on October 16-18 at the World Trade Center Metro Manila, Pasay City, Philippines</span>.</p>

            </div>
        </div>
    </section>

    <section class="container-fluid section-1-container">
        <div class="row d-flex section-1">

            <div class="col-12 col-lg-6 section-1-content ifex-content">
                <h2>CREATELab at IFEX Philippines Results</h2>
                <p><a href="https://www.ifexconnect.com/ifexphilippines" target="_blank" rel="noopener noreferrer">IFEX Philippines</a> is the country’s biggest business-to-business and export-oriented international trade show for food, beverage, and ingredients. Now in its 18th edition, it is the longest-running food-sourcing show in the Philippines, where the biggest and most trusted brands converge.</p>
                <p>120 creative consultation meetings conducted during IFEX Philippines event proper!</p>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="q-container"><span class="quote"><q>Was a really good session. Very insightful and would be impactful for the business down the track. Great idea to have (a program like this) at an expo like this.</q></span><br>Tanteo Food Products</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="q-container"><span class="quote"><q>It's amazing to get consulted by CREATELab during the IFEX event. I'm looking forward to collaborate with the assigned coach to elevate our brand. Hoping to consult and assess our branding to the next event (IFEX).</q></span><br>Ayana's Siling Kinamayo</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="q-container"><span class="quote"><q>Thank you for giving free consultations like this. Definitely a must have every fairs.</q></span><br>Heart of the Islands Holdings, Inc.</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="q-container"><span class="quote"><q>We'd love to have a one-on-one consultation of our MSMEs w/ CREATELab</q></span><br>TLDC, Province of Negros Occ.</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="q-container"><span class="quote"><q>It gives me new perspective & open more creative idea's</q></span><br>Alto Peak Agriventures Corp.</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="q-container"><span class="quote"><q>Good ideas and strong brand marketing strategy</q></span><br>Golden Arrow Food Enterprises</p>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
            </div>

            <div class="col-12 col-lg-6 p-0 position-relative ifex-exhibition-hall">
                <img src="/img/static/createlab/body-img.jpg" class="img-fluid w-100 h-100"
                    style="position: absolute; top: 0; left: 0; object-fit: cover;"
                    alt="" />
            </div>

            <div class="col-12 p-0 position-relative ifex-gallery">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center mt-5 mb-3">
                            <h2>Gallery</h2>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @foreach($gallery_images as $image)
                        <div class="col-6 col-md-4 col-lg-3 img-container">
                            <img src="{{ $image }}" alt="">
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 text-center mb-5">
                            <small>Click the image to expand</small>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    
    <section id="creatives" class="container-fluid section-1-container">
        <div class="row section-1 d-flex justify-content-center">
            <div class="col-12 section-1-content light text-center">

                <h2>Want to meet the Creatives?</h2>
                <p class="text-center">
                    The featured communication design creatives are vetted and endorsed by
                    the Communication Design Association of the Philippines and are
                    registered verified members of CREATEPhilippines.
                </p>
                
                <!-- FEATURED CREATIVES -->
                <section class="container-fluid section-1-container featured-creatives">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2>Featured Creatives</h2>
                        </div>
                        <div class="spinner-wrapper">
                            <i class="fas fa-spinner fa-spin spinner"></i>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/kevin-paul-santos" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/KEVIN_SANTOS.JPG" alt="">
                                    <div class="card-body">
                                        KEVIN PAUL SANTOS
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/pushpin" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Elbert_Or.webp" alt="">
                                    <div class="card-body">
                                        ELBERT OR
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/austin-full" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Austin_Llena2.png" alt="">
                                    <div class="card-body">
                                        AUSTIN LLENA
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/Jase_Robles" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Jase_Robles2.jpg" alt="">
                                    <div class="card-body">
                                        JASE ROBLES
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/gad-castro" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/gad_castro.png" alt="">
                                    <div class="card-body">
                                        GAD CASTRO
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/jonaline-fresco" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/jonaline_fresco.jpg" alt="">
                                    <div class="card-body">
                                        JONALINE FRESCO
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/geno-maglinao" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Maglinao_Geno.png" alt="">
                                    <div class="card-body">
                                        GENO MAGLINAO
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/Leimarie_Graphic_Designing" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Aleah_Marie-Estanislao.jpg" alt="">
                                    <div class="card-body">
                                        LEI ESTANISLAO
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/edward-nonay" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Edward_Nonay.jpg" alt="">
                                    <div class="card-body">
                                        EDWARD NONAY
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/sebastian-gerona" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/sebastian_gerona.jpg" alt="">
                                    <div class="card-body">
                                        SEBASTIAN GERONA
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/johnny-isorena" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/johnny_isorena.jpg" alt="">
                                    <div class="card-body">
                                        JOHNNY ISORENA
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/allie-principe" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/allie_principe.jpg" alt="">
                                    <div class="card-body">
                                        ALLIE PRINCIPE
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/paolo-jose-salgado" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/paolo_salgado.jpg" alt="">
                                    <div class="card-body">
                                        PAOLO SALGADO
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/la-villavicencio" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/LA_VILLAVICENCIO.jpg" alt="">
                                    <div class="card-body">
                                        LA VILLAVICENCIO
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/pierre-chavez" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/pierre_chavez.jpg" alt="">
                                    <div class="card-body">
                                        PIERRE CHAVEZ
                                    </div>
                                </div>
                            </a>
                        </div>

                        

                        
                        

                    </div>
                </section>





               

                <h2>Meet our Partner!</h2>
                
                <p class="text-center pt-3">
                    The Communication Design Association of the Philippines (CDAP) is a premier organization dedicated to promoting excellence in communication design across the Philippines. Launched by industry leaders, CDAP serves as a hub for professionals in graphic design, branding, advertising, and related disciplines. They aim to elevate the standards of communication design and advocate for the vital role of creative industries in the nation’s economic and cultural development.
                </p>
                
                <p class="text-center">Want to learn more about CDAP? Click below.</p>

                <div class="cdap-img my-4"><a href="https://cdapdesign.org/" target="_blank"><img
                            src="/img/static/createlab/cdap-logo.png" class="img-fluid" alt="" /></a></div>

                <!-- <a href="#" class="btn-btn-2 button-light text-left">REGISTER HERE</a> -->

                <br><br>
                

                <h2>Event Supporter</h2>
                <div class="w-100">
                    <div class="container-fluid">
                        <div class="row  d-flex align-items-center justify-content-center">
                            <div class="col col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div style="max-width: 250px;">
                                    <a href="https://www.pagcor.ph" target="_blank">
                                        <img class="img-fluid mx-auto my-3 d-block" src="/img/static/createlab/pagcor_logo.webp" class="img-fluid" alt="" />
                                    </a>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div style="max-width: 250px;">
                                    <img class="img-fluid mx-auto my-3 d-block" src="/img/static/createlab/WACOM_logo.png" class="img-fluid" alt="" />
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>





            </div>
        </div>
    </section>

    {{--
    <section class="container-fluid section-1-container">
        <div class="row section-1 d-flex justify-content-center">
            <a href="https://www.ifexconnect.com/ifexphilippines" target="_blank" rel="noopener noreferrer" style="padding-left: 0 !important; padding-right: 0 !important;">
                <img class="w-100" src="/img/static/createlab/ifex_2025_banner.png" alt="">
            </a>
        </div>
    </section>
    --}}

    <section class="container-fluid cta-1 d-flex justify-content-center ">
        Want to be part of the community? Join the digital space for Filipino creatives!
    </section>
    
    <section class="container-fluid cta-2">
        <div class="row d-flex align-items-center">
            <div class="col-lg-5 col-md-6 text-center p-0">
                <img src="/img/static/x_mipam/heads_3x.webp" class="img-fluid" alt="" />
            </div>

            <div class="col-lg-7 col-md-6">
                <h2>MOST WANTED CREATIVES</h2>

                <p class="last-p mb-5">
                    Share your artistry alongside other Filipino talents in the
                    CREATEPhilippines Directory of Creatives and be ahead of the curve.
                </p>
                <a href="https://createphilippines.com/register/step-1" class="btn-btn-3 text-left">REGISTER NOW</a>
            </div>
        </div>
    </section>

    <section class="container-fluid createlab-footer">
        <div class="row d-flex align-items-center">
            <div class="col-lg-3 col-sm-12 text-center">
                <img src="/img/logo.png" class="img-fluid" alt="" />
            </div>

            <div class="col-lg-9 col-sm-12 createlab-footer-content">
                <p>
                    CREATEPhilippines is the official content and community platform for
                    the Philippine creative industries, spearheaded by the Center for
                    International Trade Expositions and Missions (CITEM), the export
                    promotion arm of the Philippine Department of Trade and Industry
                    (DTI).
                </p>
                <p>
                    As the country’s first government-led initiative of its kind,
                    CREATEPhilippines.com serves as the central resource for news,
                    stories, and updates from the Filipino creative community. It also
                    functions as a comprehensive directory and sourcing platform, enabling
                    Filipino creatives to showcase their portfolios and connect with a
                    global audience.
                </p>
            </div>
        </div>
    </section>
@endsection
