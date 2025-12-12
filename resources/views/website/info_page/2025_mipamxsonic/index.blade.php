@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/website/info_page.css?ver=' . time()) }}" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>

        .raleway-400 {
        font-family: "Raleway", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        }

        section {
            background-color: rgb(20,16,35);
        }

        .h01 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 800;
            font-style: normal;
            font-size: 36px;
            color: #F9C52E;
        }

        .h02 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            font-size: 30px;
            color: #FFFFFF;
        }

        .h03 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            font-size: 24px;
            color: #FFFFFF;
        }

        .h04 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 20px;
            color: #C44E9D;
        }

        .h05 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 20px;
            color: #F37158;
        }

        .h06 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            font-size: 32px;
            line-height: 32px;
            color: #FFFFFF;
        }
        
        .t01 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: 20px;
            color: #FFFFFF;
        }

        .t02 {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
            font-size: 24px;
            color: #3CBB8D;
        }

        .t03 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: 16px;
            line-height: 20px;
            color: #FFFFFF;
        }

        .t04 {
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: italic;
            font-size: 10px;
            line-height: 15px;
            color: #FFFFFF;
        }

        .lbl01 {
            display: block;
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 15px;
            line-height: 18px;
            color: #E6A2C8;
            margin-bottom: 10px;
        }

        .lbl02 {
            display: block;
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            font-size: 15px;
            line-height: 18px;
            color: #261E7E;
            margin-bottom: 10px;
        }

        section.banner .container-fluid{
            position: relative;

        }

        section.banner img {
            display: block;
            width: 100%;
            height: auto;
        }
        
        section.sonik {
            background-image: url("{{ asset('img/static/2025_mipamxsonic/bg_01.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        section.sonik .container {
            background-color: #24406B;
            border-radius: 22px;
        }
        
        .sonik table {
            width: 100%;
            border-collapse: collapse;
            font-family: "Raleway", sans-serif;
            font-size: 16px;
        }

        .sonik th, .sonik td {
            border: 2px solid #DE6953;
            padding: 8px 12px;
            text-align: left;
        }

        .sonik th {
            color: #A23E21;
            background-color: #FA9F10;
            font-weight: 800;
        }

        .sonik tbody tr:nth-child(odd) td {
            background-color: #FA9F10 !important;
        }

        .sonik tbody tr:nth-child(even) td {
            background-color:rgb(255, 185, 72) !important;
        }

        .sonik tbody tr td:first-child {
            font-weight: bold;
        }

        .sonik tr td {
            color: #24406B;
            font-weight: 600;
        }

        .btn.btn-primary.mipam {
            border: 0;
            font-family: "Work Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            
            transition: all 0.3s ease;
        }

        .banner .btn0 {
            font-size: clamp(12px, 2.5vw, 20px);
            line-height: 1.2;
            padding: clamp(12px, 1.5vw, 18px);
            border-radius: 999px;
            color: #000000;
        }
        
        .sonik .btn1, .about .btn2, .about .btn3 {
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.2;
            padding: clamp(15px, 2vw, 20px);
            border-radius: 999px;
            color: #000000;
        }

        .create .btn4, .viber .btn5 {
            font-size: 16px;
            line-height: 16px;
            padding: 10px;
            border-radius: 999px;
        }

        .btn.btn-primary.mipam:not(.btn0):hover {
            background-color: #31A2F0 !important;
            color: #FFFFFF !important;
            
            transform: scale(1.05);
        }

        .btn.btn-primary.mipam.btn0:hover {
            background-color: #31A2F0 !important;
            color: #FFFFFF !important;

            transform: translateX(-50%) scale(1.05);
        }

        .banner .btn0 {
            position: absolute;
            bottom: 1px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;

            background-color: #C34D9B;
        }

        .sonik .btn1 {
            background-color: #FE3B01;
        }

        .about .btn2 {
            display: flex;
            background-color: #D91D57;
            max-width: 600px;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        .about .btn3 {
            background-color: #FDC52F;
            max-width: 500px;
            width: 100%;
            height: 100%;
        }

        .create .btn4 {
            background-color: #F27C9B;
            max-width: 250px;
            width: 100%;
            height: 100%;
            color: #000000;
        }

        .viber .btn5 {
            background-color: #58B658;
            max-width: 250px;
            width: 100%;
            height: 100%;
            color: #FFFFFF;
        }

        section.about {
            background-image: url("{{ asset('img/static/2025_mipamxsonic/bg_02.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        section.about .container {
            background-color:rgb(30, 25, 48);
            border-radius: 22px;
        }

        section.about .about-header-container {
            background-image: url("{{ asset('img/static/2025_mipamxsonic/bg_gif.gif') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
            
        }

        section.about .about-header-container .about-header{
            background-color:rgba(30, 25, 48, 0.9);
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
        }

        .topics {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            /* padding: 20px; */
        }

        .topics .topic {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
            font-size: 20px;
            color: #FFFFFF;
              padding: 8px 20px;
            border: 1px solid #FFFFFF;
            border-radius: 999px;
            white-space: nowrap;
        }

        .org .img-org-container {
            display: flex;
            justify-content: center;
        }

        .org .img-org-container img {
            max-width: 500px;
        }

        .social-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .social-container a {
            background-color: #FFFFFF;
            width: 40px;              /* Equal width and height */
            height: 40px;
            border-radius: 50%;       /* Makes it a perfect circle */
            color: rgb(20,16,35);
            display: flex;            /* Center content inside */
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 16px;          /* Optional: adjust text/icon size */
        }

        .footer .create {
            display: flex;
            background-color: #231F20;
            padding: 40px 20px;
            /* align-items: center; */
        }

        .footer .create .img-contaner {
            margin: 0 auto;
        }

        .footer .create img {
            max-width: 200px;
            width: 100%
        }

        .footer .viber {
            display: flex;
            background-color: #7065EA;
            padding: 40px 20px;
            /* align-items: center; */
        }

        .footer .viber .card {
            background-color: transparent;
            border: 0;
            padding: 0;
        }

        .footer .viber .card .card-footer {
            background-color: transparent;
            border: 0;
            padding-bottom: 0;
        }
        
        .footer .viber img {
            max-width: 250px;
            width: 100%
        }

        
    </style>
@endsection

@section('scripts-bottom')
    <!-- <script>
        window.addEventListener('load', function () {
            const lazyElements = document.querySelectorAll('.lazy-load');
            let index = 0;

            function loadNext() {
                if (index >= lazyElements.length) return;

                const el = lazyElements[index];
                const src = el.getAttribute('data-src');
                if (!src) {
                    index++;
                    loadNext();
                    return;
                }

                // Set the src to start loading the image
                el.src = src;

                // Listen for load event on the actual img element
                el.onload = function () {
                    el.classList.add('loaded');

                    // Remove spinner in the same container
                    const spinner = el.parentElement.querySelector('.spinner-icon');
                    if (spinner) {
                        spinner.style.display = 'none'; // or spinner.remove();
                    }

                    index++;
                    loadNext();
                };

                el.onerror = function () {
                    const spinner = el.parentElement.querySelector('.spinner-icon');
                    if (spinner) {
                        spinner.style.display = 'none';
                    }

                    index++;
                    loadNext();
                };
            }

            loadNext();
        });

    </script> -->
    
@endsection

@section('content')
    {{-- BANNER --}}
    <section class="p-0 banner">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <img class="w-100" src="{{ asset('img/static/2025_mipamxsonic/banner.png') }}" alt="CREATEPhilippines x Sonik Banner">
                    <a href="https://fetedelamusique.helixpay.ph/products/sonik-sessions-1?group=other-events" target="_blank" class="btn btn-primary mipam btn0" rel="noopener noreferrer">REGISTER FOR SONIK SESSIONS NOW</a>
                </div>
            </div>
        </div>
    </section>

    {{-- HEADER TEXT --}}
    <section class="p-3" style="padding-top: 60px !important;">
        <div class="container mb-3">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <span class="h01">
                        CULTIVATING BUSINESS-SAVVY FILIPINO PERFORMING ARTISTS
                    </span>
                </div>
                <div class="col-12 text-center">
                    <span class="t01">
                        <p>CREATEPhilippines is ready for the next step in preparing creatives in the Philippine performing arts industry to conquer the local and international scenes.</p>
                        <p>After a successful multi-city Phase I in 2024 and an equally promising first leg of Phase II of the CREATEPhilippines x Manila International Performing Arts Market (MIPAM) in early 2025, we’re concluding the second phase with a bang.
                    </span>
                </div>
            </div>

        </div>
    </section>

    {{-- SONIK Card --}}
    <section class="p-3 sonik" id="sonik-sessions" style="padding-top: 60px !important;">
        <div class="container mb-3">
            <div class="row">
                <div class="col-12 p-0 banner">
                    <img class="w-100" src="{{ asset('img/static/2025_mipamxsonic/banner_2.png') }}" alt="Sonik Banner">
                </div>
            </div>
            <div class="row mt-5" style="padding-left: clamp(10px, 5vw, 100px); padding-right: clamp(10px, 5vw, 100px);">
                <div class="col-12 text-center mb-4">
                    <span class="h02">
                        SONIK SESSIONS AT FÊTE DE LA MUSIQUE 2025
                    </span>
                </div>
                <div class="col-12 text-justify text-center mb-4">
                    <span class="t01">
                        <p>Powered by CREATEPhilippines and co-presented by Sonik Philippines, <strong>Sonik Sessions</strong> is a series of panel and roundtable discussions about the music industry. These sessions will be held on <strong>June 26</strong> at The Astbury Makati as part of <strong>Fête de la Musique 2025</strong>.</p>
                        <p>With the forums featuring a panel of key VIPs from the music, creative, and policy sectors, attendees can expect to learn about the music industry’s critical role in the creative economy, the intricacies of exporting Filipino music and artists abroad, and the platforms local musicians can leverage to cross borders.</p>
                        <p>Sonik Sessions will conclude with a networking reception, allowing guests to meet and connect with key players from the local and global music ecosystem.</p>
                    </span>
                </div>
                <div class="col-12 mb-5">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">
                                    SONIK SESSIONS SCHEDULE
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1:30 PM</td>
                                <td>Registration open</td>
                            </tr>
                            <tr>
                                <td>2:00 PM</td>
                                <td>Opening remarks</td>
                            </tr>
                            <tr>
                                <td>2:30 PM</td>
                                <td>Keynote: French delegates + IPOPHL</td>
                            </tr>
                            <tr>
                                <td>3:30 PM</td>
                                <td>Panel 1: Exporting Filipino Sound: The Roadmap to Global Success</td>
                            </tr>
                            <tr>
                                <td>4:30 PM</td>
                                <td>Performance by Indistinct Chatter</td>
                            </tr>
                            <tr>
                                <td>5:00 PM</td>
                                <td>Panel 2: Creative Economy 2.0: How Music Drives Economic Growth</td>
                            </tr>
                            <tr>
                                <td>6:00 PM</td>
                                <td>Panel 3: Crossing Borders with Sound: The Power of Digital Platforms in Music Export</td>
                            </tr>
                            <tr>
                                <td>7:00 PM</td>
                                <td>Closing remarks + Performance from Tarsius</td>
                            </tr>
                            <tr>
                                <td>7:15 PM</td>
                                <td>Networking session and a DJ set</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 text-center mb-5">
                    <div class="btn-container">
                        <a href="https://fetedelamusique.helixpay.ph/products/sonik-sessions-1?group=other-events" target="_blank" class="btn btn-primary mipam btn1" rel="noopener noreferrer">REGISTER FOR SONIK SESSIONS NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="p-3 about" style="padding-top: 60px !important;">
        <div class="container mb-3">
            <div class="row about-header-container">
                <div class="about-header" style="padding-left: clamp(10px, 5vw, 100px); padding-right: clamp(10px, 5vw, 100px);">
                    <div class="col-12 text-center mt-5 pt-3 mb-4">
                        <span class="h02">
                            ABOUT CREATEPHILIPPINES x MIPAM
                        </span>
                    </div>
                    <div class="col-12 text-justify text-center mb-5">
                        <span class="t01">
                            <p>The goal of CREATEPhilippines x MIPAM is to build the capacity of Filipino performing artists and musicians. Throughout its various phases, the initiative educates Filipino creatives on the skills they must develop to sustain their artistry, from pitching and securing funding to licensing, branding, touring, and more.</p>
                            <p>Each leg is designed to build on the strong foundation set during the previous ones, in preparation for meeting and doing business with local and international clients at the <strong>CREATEPhilippines x Manila International Performing Arts Market</strong>, scheduled for <strong>2026</strong>.</p>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row phase2">
                <div class="col-12 text-center h03 mt-5 mb-5">
                    PHASE II (2025)
                </div>
                <div class="col-12 p-0 mb-3">
                    <img class="w-100" src="{{ asset('img/static/2025_mipamxsonic/mipam_path1.png') }}" alt="Phase 2 Events">
                </div>
                <div class="col-12 text-center h04 mb-3">
                    Key topics covered:
                </div>
                <div class="col-12 text-center topics mb-5" style="padding-left: clamp(10px, 5vw, 100px); padding-right: clamp(10px, 5vw, 100px);">
                    <div class="topic">Market research</div>
                    <div class="topic">Target market segmentation</div>
                    <div class="topic">Storytelling</div>
                    <div class="topic">Music export</div>
                    <div class="topic">Music supervision</div>
                    <div class="topic">Music technology</div>
                </div>
            </div>
            <div class="row phase1">
                <div class="col-12 text-center h03 mt-5 mb-5">
                    PHASE I (2024)
                </div>
                <div class="col-12 p-0 mb-3">
                    <img class="w-100" src="{{ asset('img/static/2025_mipamxsonic/mipam_path2.png') }}" alt="Phase 1 Events">
                </div>
                <div class="col-12 text-center h05 mb-3">
                    Key topics covered:
                </div>
                <div class="col-12 text-center topics mb-3" style="padding-left: clamp(10px, 5vw, 100px); padding-right: clamp(10px, 5vw, 100px);">
                    <div class="topic">Product management</div>
                    <div class="topic">Marketing</div>
                    <div class="topic">Pitching</div>
                    <div class="topic">Legal</div>
                    <div class="topic">Budgeting</div>
                    <div class="topic">Sponsorship</div>
                    <div class="topic">Funding</div>
                    <div class="topic">Branding</div>
                    <div class="topic">Venue management</div>
                    <div class="topic">Logistics</div>
                    <div class="topic">Personnel management</div>
                    <div class="topic">Licensing</div>
                </div>
            </div>
            <div class="row text-center mt-5 pb-5" style="padding-left: clamp(10px, 5vw, 100px); padding-right: clamp(10px, 5vw, 100px);">
                <div class="col-12 col-md-6 mb-4">
                    <a href="{{ route('events.createph-x-mipam-gallery') }}" target="_blank" class="btn btn-primary mipam btn2" rel="noopener noreferrer">VIEW GALLERY</a>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <a href="https://fetedelamusique.helixpay.ph/products/sonik-sessions-1?group=other-events" target="_blank" class="btn btn-primary mipam btn3" rel="noopener noreferrer">REGISTER FOR SONIK SESSIONS NOW</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ORGANIZER --}}
    <section class="p-3 org" style="padding-top: 60px !important;">
        <div class="container mb-5">
            <div class="row">
                <div class="col-12 text-center h03 mb-4">
                    Organized by
                </div>
                <div class="col-12 img-org-container mb-5">
                    <img class="w-100" src="{{ asset('img/static/2025_mipamxsonic/organizers.png') }}" alt="Organizers">
                </div>

                <div class="col-12 text-center h03 mt-3 mb-4">
                    Follow us
                </div>
                <div class="col-12 social-container mb-2">
                    <a href="https://www.facebook.com/createphilippines/" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f fa-xl"></i></a>
                    <a href="https://www.instagram.com/createphilippines/" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram fa-xl"></i></a>
                    <a href="https://twitter.com/CreatePHILS" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-x-twitter fa-xl"></i></a>
                    <a href="https://www.linkedin.com/company/create-philippines/?viewAsMember=true" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-linkedin-in fa-xl"></i></a>
                    <!-- <a href="" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-tiktok fa-xl"></i></a> -->
                </div>
                <div class="col-12 text-center t02 mt-3 mb-4">
                    #CREATEPHxMIPAM
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <section class="p-3" style="padding-top: 60px !important;">
        <div class="container mb-5 footer">
            <div class="row">
                <div class="col-12 col-md-6 create">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-7 align-content-center">
                                <div class="lbl01">Let the world see what you can do!</div>
                                <div class="h06">Join the Directory of Creatives</div>
                            </div>
                            <div class="col-12 col-md-5 img-container text-center mt-2">
                                <img src="{{ asset('img/static/2025_mipamxsonic/creatives_img.png') }}">
                            </div>
                            <div class="col-12 t03 mt-3">
                                Gain access to exclusive opportunities to showcase your work, collaborate with fellow creatives, and elevate your career to new heights.
                            </div>
                            <div class="col-12 t04 mt-1">
                                *By registering to the Directory of Creatives, you are also signing-up to the CCP Performing Arts Directory.
                            </div>
                            <div class="col-12 btn-container mt-4">
                                <a href="https://createphilippines.com/register" target="_blank" class="btn btn-primary mipam btn4" rel="noopener noreferrer">Register Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 viber">
                    <!-- <div class="container"> -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 align-content-center">
                                        <div class="lbl02">Want to be one of us?</div>
                                        <div class="h06">LET’S CREATE TOGETHER</div>
                                    </div>
                                    <div class="col-12 col-md-6 img-container text-center mt-2">
                                        <img src="{{ asset('img/static/2025_mipamxsonic/viber_img.png') }}">
                                    </div>
                                    <div class="col-12 t03 mt-3">
                                        Join the CREATEPhilippines Viber Community to meet fellow artists and creatives, learn from experts, and find future partners.
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 btn-container mt-4">
                                        <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw&lang=env" target="_blank" class="btn btn-primary mipam btn5" rel="noopener noreferrer">Join Our Community</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>



    

@endsection
