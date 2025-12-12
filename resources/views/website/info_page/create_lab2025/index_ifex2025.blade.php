@extends('layouts.app')


@section('styles')
    <style>
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

        .featured-creatives h2 {
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

            .section-1-img {
                min-height: 400px !important;
            }

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

            .section-1-img {
                min-height: 600px;
            }

            .section-1-img,
            .section-1-content {
                flex: 0 0 100% !important;
                max-width: 100% !important;
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
            $('.toggle-btn').on('click', function() {
                $(this).find('.toggle-text').hide();
            });

            const images = document.querySelectorAll('.featured-creatives .card img');

            function showImageSequentially(index) {
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

            showImageSequentially(0);

        });

    </script>
@endsection

@section('content')
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
            <div class="col-6 p-0 position-relative section-1-img">
                <img src="/img/static/createlab/body-img.jpg" class="img-fluid w-100 h-100"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                    alt="" />
            </div>

            <div class="col-6 section-1-content">
                <h2>
                    CREATELab’s first edition is set to happen during IFEX Philippines!
                </h2>
                <p>
                    <a href="https://www.ifexconnect.com/ifexphilippines" target="_blank">IFEX Philippines</a> is the
                    country’s biggest
                    business-to-business and export-oriented international trade show for
                    food, beverage, and ingredients. Now in its 18th edition, it is the
                    longest-running food-sourcing show in the Philippines, where the
                    biggest and most trusted brands converge.
                </p>
                <p class="last-p pb-3">
                    Participating IFEX Philippines exhibitors interested in availing of
                    CREATELab’s free design consultations can book their sessions now!
                </p>

                <a href="https://forms.gle/RkrxUE2sARW6bFVM6" target="_blank" class="btn-btn-2 mt-3">REGISTER HERE</a>



                <p class="mt-5">
                    Sessions will be booked during the <span style="font-family: 'Kaleko 105 Bold', sans-serif !important; font-size: 18px;">IFEX Philippines event on May 22-24
                    at the World Trade Center Metro Manila, Pasay City</span>.
                </p>
            </div>
        </div>
    </section>
    
    <section id="creatives" class="container-fluid section-1-container">
        <div class="row section-1 d-flex justify-content-center">
            <div class="col-11 section-1-content light text-center">
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
                            <a href="https://createphilippines.com/profile/jake-nunez" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Jake_Nunez.jpg" alt="">
                                    <div class="card-body">
                                        JAKE ALFRED NUÑEZ
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/louie-daguison" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Weng_Daguison.jpg" alt="">
                                    <div class="card-body">
                                        LOUIE “WENG” DAGUISON
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <!-- <a href="" target="_blank" rel="noopener noreferrer"> -->
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/AuAranas.jpg" alt="">
                                    <div class="card-body">
                                        AU ARANAS
                                    </div>
                                </div>
                            <!-- </a> -->
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/tyron" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/TYRON_GONZALES.jpg" alt="">
                                    <div class="card-body">
                                        TYRON GONZALES
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/Jase_Robles" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Jase_Robles.jpg" alt="">
                                    <div class="card-body">
                                        JASE ROBLES
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <a href="https://createphilippines.com/profile/austin-full" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Austin_Llena.jpg" alt="">
                                    <div class="card-body">
                                        AUSTIN LLENA
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- BACKED OUT
                        <div class="col-3 col-md-4 card-container">
                            <!-- <a href="" target="_blank" rel="noopener noreferrer"> -->
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Bernard_Pena.jpg" alt="">
                                    <div class="card-body">
                                        BERNARD KENNETH PENA
                                    </div>
                                </div>
                            <!-- </a> -->
                        </div>
                        --}}

                        <div class="col-3 col-md-4 card-container">
                            <!-- <a href="" target="_blank" rel="noopener noreferrer"> -->
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Lloyd_Zapanta.png" alt="">
                                    <div class="card-body">
                                        LLOYD ZAPANTA
                                    </div>
                                </div>
                            <!-- </a> -->
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
                            <a href="https://createphilippines.com/profile/Dustin_Jacob_Carbonera" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/DustinCarbonera.jpg" alt="">
                                    <div class="card-body">
                                        DUSTIN CARBONERA
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-3 col-md-4 card-container">
                            <!-- <a href="" target="_blank" rel="noopener noreferrer"> -->
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/CES_ECLE.jpg" alt="">
                                    <div class="card-body">
                                        CES ECLE
                                    </div>
                                </div>
                            <!-- </a> -->
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
                            <a href="https://createphilippines.com/profile/edward-nonay" target="_blank" rel="noopener noreferrer">
                                <div class="card">
                                    <img src="/img/static/createlab/featured-creatives/Edward_Nonay.jpg" alt="">
                                    <div class="card-body">
                                        EDWARD NONAY
                                    </div>
                                </div>
                            </a>
                        </div>
                        

                    </div>
                </section>
                

                <p class="text-center pt-3">
                    The Communication Design Association of the Philippines (CDAP) is a premier organization dedicated to promoting excellence in communication design across the Philippines. Launched by industry leaders, CDAP serves as a hub for professionals in graphic design, branding, advertising, and related disciplines. They aim to elevate the standards of communication design and advocate for the vital role of creative industries in the nation’s economic and cultural development.
                </p>
                {{--
                <div class="accordion p-0 m-0" id="accordionExample">
                    <div id="collapseTwo" class="collapse m-0 p-0" aria-labelledby="headingTwo"
                        data-parent="#accordionExample">
                        <p class="text-center pt-3">
                            The Communication Design Association of the Philippines (CDAP) is a
                            premier organization dedicated to promoting excellence in
                            communication design across the Philippines. Launched by industry
                            leaders, CDAP serves as a hub for professionals in graphic design,
                            branding, advertising, and related disciplines. They aim to elevate
                            the standards of communication design and advocate for the vital role
                            of creative industries in the nation’s economic and cultural
                            development.
                        </p>
                    </div>
                    <div id="headingTwo">
                        <h2 class="mb-0">
                            <p class="toggle-btn m-0 p-0" type="button" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                <span class="toggle-text">See more ▼</span>
                            </p>
                        </h2>
                    </div>
                </div>
                --}}




                <p class="text-center">Want to learn more about CDAP? Click below.</p>

                <div class="cdap-img my-4"><a href="https://cdapdesign.org/" target="_blank"><img
                            src="/img/static/createlab/cdap-logo.png" class="img-fluid" alt="" /></a></div>

                <!-- <a href="#" class="btn-btn-2 button-light text-left">REGISTER HERE</a> -->

                <p class="text-center">
                    <strong>Want to be part of the community? Join the digital space for
                        Filipino creatives!</strong>
                </p>
            </div>


        </div>
    </section>

    <section class="container-fluid section-1-container">
        <div class="row section-1 d-flex justify-content-center">
            <a href="https://www.ifexconnect.com/ifexphilippines" target="_blank" rel="noopener noreferrer" style="padding-left: 0 !important; padding-right: 0 !important;">
                <img class="w-100" src="/img/static/createlab/ifex_2025_banner.png" alt="">
            </a>
        </div>
    </section>


    



    {{-- <section class="container-fluid cta-1 d-flex justify-content-center">
        <h2>JOIN THE DIGITAL SPACE FOR FILIPINO CREATIVES!</h2>
    </section> --}}

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
