<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- ANALYTICS & PIXEL CONNECTION --}}
    @include('components.analytics')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(request()->segment(1))
            {{ ucfirst(str_replace('_', ' ', str_replace('-', ' ', request()->segment(1)))) }} |
        @endif 
        
        @if(request()->segment(2))
            {{ ucfirst(str_replace('_', ' ', str_replace('-', ' ', request()->segment(2)))) }} |
        @endif 
        
        CREATEPhilippines: Promoting Philippine Creative Industries
    </title>

    <link rel="apple-touch-icon" sizes="180x180" href="/img/fav/pbc/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/pbc/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/fav/pbc/favicon-16x16.png">
    <link rel="manifest" href="/img/fav/pbc/site.webmanifest">

    {{-- SEO / META DESCRIPTIONS --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://createphilippines.com">
    

    @if (request()->is('createph-x-mipam') == true)
        <meta property="og:title" content="Boost Your Performing Arts Career">
        <meta property="og:image" content="{{ asset('img/static/share/share-mipam.png') }}">
        <meta property="og:site_name" content="Boost Your Performing Arts Career">
        <meta property="og:description" content="Navigate the Touring Circuit equips Filipino groups with skills & knowledge to conquer the international stage.">
        <meta name="description" content="Navigate the Touring Circuit equips Filipino groups with skills & knowledge to conquer the international stage.">
        <meta name="keywords" content="navigate the touring circuit, philippine performing arts, capacity building">
    @elseif (request()->is('creative-features') == true)
        <meta property="og:title" content="Creative Features: Monthly Spotlight on Filipino Creatives">
        <meta property="og:image" content="{{ asset('img/static/share/share-default.png') }}">
        <meta property="og:site_name" content="CREATEPhilippines: Promoting Philippine Creative Industries">
        <meta property="og:description" content="Discover inspiring stories and spotlights on Filipino creatives. Explore monthly features that celebrate talent, culture, and design at CREATEPhilippines.">
        <meta name="description" content="Discover inspiring stories and spotlights on Filipino creatives. Explore monthly features that celebrate talent, culture, and design at CREATEPhilippines.">
        <meta name="keywords" content="Philippines creative industries, export, talent, events, resources">
    @elseif(isset($article))
        <meta property="og:title" content="{{ $article->name }}">
        <meta property="og:image" content="{{ asset('folder_articles/' . $article->asset->medium_thumbnail) }}">
        <meta property="og:site_name" content="{{ $article->name }}">
    @else
    {{-- DEFAULT SEO Tags --}}
        <meta property="og:title" content="CREATEPhilippines: Promoting the Philippine Creative Industries">
        <meta property="og:image" content="{{ asset('img/static/share/share-default.png') }}">
        <meta property="og:site_name" content="CREATEPhilippines: Promoting Philippine Creative Industries">
        <meta property="og:description" content="CREATEPhilippines empowers the Philippines' creative industries, showcasing them as a global export force. This program fosters connections, growth, and opportunities for Filipino creatives.  Discover talent, events, and resources.">
        <meta name="description" content="CREATEPhilippines empowers the Philippines' creative industries, showcasing them as a global export force. This program fosters connections, growth, and opportunities for Filipino creatives.  Discover talent, events, and resources.">
        <meta name="keywords" content="Philippines creative industries, export, talent, events, resources">
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @yield('scripts-top')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,500;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@700&display=swap" rel="stylesheet"> 

    <!-- Styles -->
    <style>
        /* MAINTENANCE MODAL START */
            nav.navbar {
                z-index: 997 !important;
            }

            .advisoryoverlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 998;
            }
            
            #advisoryModal {
                display: none;
                position: fixed;
                z-index: 999;
                overflow: hidden;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%);
                width: 60vw !important;
                /* height: auto; */
                max-height: 600px;
                background-color: #fff;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
                border-radius: 8px;
            }

            #advisoryModal .modal-content {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
            }

            #advisoryModal .modal-body {
                padding: 1rem;
                overflow-y: auto;
                max-height: 575px;
            }
            
            #advisoryModal .close {
                position: absolute;
                top: 15px;
                right: 20px;
                color: #333;
                font-size: 30px;
                font-weight: bold;
                cursor: pointer;
                z-index: 999;
            }

            @media (max-width: 992px) {
                #advisoryModal {
                    width: 80%;
                }

                #advisoryModal .modal-logo {
                    width: 150px;
                }
            }
        /* MAINTENANCE MODAL END */


        /* PGDX Character Start */

        /* Container for the character, balloon, and link */
        #floating-character {
            position: fixed;   /* Sticks to the same spot on the screen */
            bottom: 20px;      /* 20px from the bottom */
            left: 20px;        /* 20px from the left */
            z-index: 9999;     /* Stays on top of all other content */
            cursor: pointer;
        }

        /* The character image */
        #floating-character img {
            width: 120px; /* Adjust size as needed */
            height: auto;
            display: block;
        }

        /* The speech balloon */
        #floating-character #speech-balloon {
            position: absolute;
            bottom: 100%; /* Position above the image */
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            color: black;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 1.1em;
            font-weight: bold;
            white-space: nowrap; /* Keeps message on one line */
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);

            /* font-family: 'Courier New', Courier, monospace; */
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            
            /* Animation for appearing/disappearing */
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s, visibility 0.4s;
        }

        /* The little triangle pointing down from the balloon */
        #floating-character #speech-balloon::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 10px;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }

        /* PGDX Character End */



    </style>

    @yield('styles')
    <link href="{{ asset('css/app.css?ver='.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/site.css?ver='.time()) }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    {{-- <link href="{{ asset('css/slick.css?ver='.time()) }}" rel="stylesheet"> --}}

    <!-- Fontawesome -->
    <link href="{{ asset('fontawesome/css/all.min.css?ver='.time()) }}" rel="stylesheet">

    {{-- TinyMCE - WYSIWYG Textarea editor
    @include('components.tinymce')
    --}}

    <style>
        body {
            display: none;
        }
        #videomodal {overflow:hidden}
        #videomodal .modal-dialog {
            max-width:80%;
            margin:0 auto
        }
        #videomodal .modal-content {
            background-color: transparent;
            border:0
        }
        #videomodal .modal-body {
            padding:0
        }
        #myVideo {
            width: 100%;
            height: 90%;
        }
        .btncentermodal {
            background-color: #ffffff50;
            color:#C20028;
            border-radius: 50px;
            animation: slide-up 1s ease-in-out infinite; 
            margin-top: 0;
            font-size: 12px;
            padding: 5px 10px;
        }
        .btncentermodal2 {
            background-color: green;
            color:#ffffff;
            border-radius: 50px;
            animation: slide-up 1s ease-in-out infinite; 
            margin-top: 0;
            margin-left: 5vw;
            font-size: 20px;
            padding: 10px 20px;
        }
        video::-webkit-media-controls-play-button,
        video::-webkit-media-controls-timeline,
        video::-webkit-media-controls-current-time-display,
        video::-webkit-media-controls-time-remaining-display,
        video::-webkit-media-controls-seek-back-button,
        video::-webkit-media-controls-seek-forward-button,
        video::-webkit-media-controls-fullscreen-button,
        video::-webkit-media-controls-rewind-button,
        video::-webkit-media-controls-return-to-realtime-button,
        video::-webkit-media-controls-toggle-closed-captions-button {
            display: none;
        }



        /* Support for dropdown submenu */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: 0;
            display: none;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }




        footer .socials-footer ul.social_list>li {
            display: inline-block !important;
        }

        footer .navigation-footer .navbar-nav {
            display: inline-block;
        }
    </style>

    {{-- Google Tag Manager --}}
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NSLWL72P');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NSLWL72P"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    @if(!(request()->is('play') || request()->is('play/tetris') || request()->is('play/snake') ))
        <!-- PGDX Character START -->
            <a href="{{ route('play.leaderboard') }}" id="floating-character" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('/img/character_01.gif') }}" alt="Cute floating character">
                <div id="speech-balloon"></div>
            </a>
        <!-- PGDX Character END -->
    @endif

    <!-- MAINTENANCE MODAL START -->
        {{-- <div id="advisoryOverlay" class="advisoryOverlay"></div>
            <div id="advisoryModal" class="modal">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="close">&times;</span>
                        <div class="container p-4">
                        <div class="row mb-5">
                            <div class="col-12">
                                <img class="modal-logo" width="250" src="https://citem.gov.ph/img/cLogo/CITEM_full_xs.png" alt="">
                            </div>
                        </div>
                        <div class="row mb-4 text-center">
                            <div class="col-12">
                                <span style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 23px;">CITEM ADVISORY</span>
                            </div>
                            <div class="col-12">
                                14 NOVEMBER 2024
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p>To Our Valued Stakeholders,</p>
                                <p>It has come to our attention that unauthorized individuals and entities have been falsely claiming to sell the list of trade buyers for events organized by the Center for International Trade Expositions and Missions (CITEM), such as IFEX Philippines, Manila FAME, and other projects.</p>
                                <p>Please be advised that:
                                    <ol>
                                        <li><strong>CITEM does not sell nor disclose the list of trade buyers</strong> to any third party. All participant information is handled with strict confidentiality in compliance with data privacy laws and agency's commitment to ethical business practices.</li>
                                        <li>Any offers or communications claiming to sell trade buyer lists for CITEM-organized events are fraudulent and unauthorized. These scammers aim to deceive and exploit stakeholders for personal gain.</li>
                                        <li>To verify the authenticity of any communication or inquiry related to CITEM events, please contact CITEM through our official channels:
                                            <ul style="list-style-type:disc">
                                                <li><strong>Website:</strong> <a href="https://citem.gov.ph" target="_blank">CITEM Official Website</a></li>
                                                <li><strong>Email:</strong> <a href="mailto:info@citem.com.ph">info@citem.com.ph</a></li>
                                                <li><strong>Phone:</strong> <a href="tel:+63288312201">+63 (02) 8831-2201</a></li>
                                            </ul>
                                        </li>
                                    </ol>
                                </p>
                                <p>
                                    <span style="font-family: 'Montserrat', sans-serif; font-weight: bold;">What You Can Do:</span>
                                    <ul style="list-style-type:disc">
                                        <li><strong>Do not engage with nor respond to these scammers.</strong> Avoid sharing any personal or financial information.</li>
                                        <li>Report suspicious communications to CITEM through the contact details above.</li>
                                        <li>Regularly check updates on CITEM’s official website and social media channels.</li>
                                    </ul>
                                </p>
                                <p>CITEM remains committed to safeguarding the interests of its stakeholders and promoting secure and trustworthy interactions. Your vigilance and cooperation are essential in combating fraudulent activities.</p>
                                <p>Thank you for your continued trust and support.</p>
                                <br>
                                <p><strong><span style="font-family: 'Montserrat', sans-serif; font-weight: bold;">Center for International Trade Expositions and Missions</span></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-instruct text-center">
                    <small style="color: #C5C5C5;">Scroll up or down to view</small>
                </div>
            </div>
            
                
        </div> --}}
    <!-- MAINTENANCE MODAL END -->

    {{-- @include('components.social-share-initiator') --}}

    <div id="app">
        @include('layouts.header')

        <main>
            @yield('content')
        </main>

        @if (request()->is('contact-us', 'newsfeed/*', 'createph-x-mipam') != true)
            @include('components.contact_form_partner')
        @endif

        @if (request()->is('/'))
            @include('components.survey')
        @endif

        @include('layouts.footer')

        

        {{-- @include('components.subscribe_modal') --}}
    </div> 

    
    @include('components.scripts')
    
    @yield('user-message-scripts')
    

    <script src="{{ asset('js/website/home.js?ver='.time()) }}" defer></script>

    @yield('scripts-bottom')
    <script>



        window.addEventListener('load', function() {
            // Everything is fully loaded, now display the content
            document.body.style.display = 'block';

        });

        $('.dropdown-submenu > a').on("click", function(e) {
            var submenu = $(this).next('.dropdown-menu');
            if (submenu.is(':visible')) {
                submenu.hide();
            } else {
                submenu.show();
            }
            e.stopPropagation(); // prevent parent dropdown from closing
            e.preventDefault();  // prevent navigation
        });



      

        // $(document).ready(function(){
        //     //   MAINTENANCE MODAL START
        //         // Check if the modal has already been shown in the current session
        //         if (!localStorage.getItem('Advisory20241114Shown')) {
        //             $("#advisoryoverlay, #advisoryModal").fadeIn();

        //             $(".close").on("click", function() {
        //                 $("#advisoryoverlay, #advisoryModal").fadeOut();
        //             });

        //             $("#advisoryoverlay").on("click", function() {
        //                 $("#advisoryoverlay, #advisoryModal").fadeOut();
        //             });
                    
        //             localStorage.setItem('Advisory20241114Shown', 'true');
        //         }
        //     //   MAINTENANCE MODAL END
        // });


        
        @if(!(request()->is('play') || request()->is('play/tetris') || request()->is('play/snake') ))
            // PGDX Character Start
                document.addEventListener('DOMContentLoaded', function() {
                    const balloon = document.getElementById('speech-balloon');
                    
                    // Define the messages to cycle through
                    const messages = [
                        "Lets Play!",
                        //"■ ● ✖ ▲"
                        //"□ ○ × △" // Unicode for square, circle, cross, triangle
                    ];
                    
                    let messageIndex = 0;
                    const displayDuration = 2500; // Balloon is visible for 2.5 seconds
                    const cycleInterval = 5000;   // A new message appears every 5 seconds

                    function cycleMessages() {
                        // Set the balloon's text to the current message
                        balloon.textContent = messages[messageIndex];
                        
                        // Make the balloon visible
                        balloon.style.opacity = 1;
                        balloon.style.visibility = 'visible';

                        // Go to the next message for the next cycle
                        messageIndex = (messageIndex + 1) % messages.length;

                        // Set a timer to hide the balloon after a few seconds
                        setTimeout(() => {
                            balloon.style.opacity = 0;
                            balloon.style.visibility = 'hidden';
                        }, displayDuration);
                    }

                    // Start the message cycling process
                    setInterval(cycleMessages, cycleInterval);
                });
            // PGDX Character End
        @endif
        
    </script>

    {{-- Google Translate
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en', 
                includedLanguages: 'en,ar,zh-CN,zh-TW,de,ko,ja,fr,es,pt-BR', 
                autoDisplay: false,
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
     --}}

    {{-- @stack('scripts-bottom') --}}
</body>
</html>






