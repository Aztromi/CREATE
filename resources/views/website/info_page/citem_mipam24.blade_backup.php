@extends('layouts.app')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body, html { 
            background-color: #130F23!important;
            color: #ffffff!important;
            overflow-x:hidden!important;
            position: relative
        }
        section { padding: 60px 0!important }
        section.nopad { padding: 0!important }
        h1 {
            margin-bottom: 40px!important;
            font-family: "Raleway", sans-serif;
        }
        h2 { 
            font-weight: 300px!important;
            font-family: "Raleway", sans-serif!important;
        }
        h3 {
            font-family: "Raleway", sans-serif!important; 
            font-weight: 300px!important;
        } 
        img {
            position: relative;
            z-index: 1;
        }
        .ff-raleway-header {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500; 
            font-size: 70px;
            font-style: normal;
            position: relative;
            z-index: 1; 
        }
        .ff-raleway-body {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto; 
            font-weight: 300; 
            font-style: normal;
            z-index: 1; 
        }
        .ahref-light a {
            color: #ffffff;
            position: relative;
            z-index: 2
        }
        .text-color-white { color:#ffffff!important }
        .text-color-red { color:#D92757!important }
        .text-color-yellow { color:#F9C52E!important }
        .text-color-orange { color:#F37158!important }
        .text-color-green { color:#3CBB8D!important }
        .text-color-purple { color:#C44F9E!important }
        .text-color-blue { color:#4084C5!important }
        .fullBanner {
            height: 100vh;
            max-height: 1000px;
        }
        .cxm-bannerlogo { height: 250px }
        .event-year {
            text-align: center;
            font-weight: 700; 
            font-size: 100px;
            line-height: 100px;
            letter-spacing: 70px;
            text-indent: 70px;
            color: #F9C52E;
            margin-bottom: 50px
        }
        .subheader {
            font-size: 30px;
            font-weight: 400;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
            line-height: 35px;
        }
        .cta-register, .cta-register-2, .cta-view, .cta-view-2  { text-decoration: none; z-index: 1; position: relative }
        .cta-register > div, .cta-view > div {
            margin: 0 20px;
            border-radius: 30px;
            font-size: 20px;
            padding: 15px 30px;
            font-weight: 500;
            min-width: 350px;
            display: inline-block
        }
        .cta-register-2 > div, .cta-view-2 > div {
            border-radius: 30px;
            font-size: 20px;
            padding: 10px 25px; 
            font-weight: 500;
            display: inline-block;
            margin: 0 20px;
            min-width: 255px;
            text-align: center;
        }
        .cta-register > div, .cta-register-2 > div {
            background-color: #ffffff!important;
            color: #000000!important;
        }
        .cta-view > div {
            background-color: #C44F9E!important;
            color: #ffffff!important;
        }
        .cta-view-2 > div {
            background-color: #4084C5!important;
            color: #ffffff!important;
        }
        .rs-container {
            margin: 0 auto;
            width: 25vw;
            text-align: center;
        }
        .rs-container > div > span:first-child {
            display: block;
            margin: 0;
            padding: 0;
            font-weight: 500;
            font-size: 25px;
        }
        .rs-container > div {
            padding: 15px;
            width: 150px;
        }
        div.kick-off-container {
            background-color: #4084C5;
            padding: 40px 40px 25px;
            border-radius: 40px;
            position: relative;
            z-index: 1;
        }
        .ksc-border {
            border-left: 1px solid #fff;
            height: 100%;
            width: 1px;
            margin: 0 auto;
        }
        .key-topics-list > li {
            list-style: none;
            display: inline-block;
            margin: 15px;
        }
        .key-topics-list > li > div {
            padding: 7px 30px;
            border: 1px solid #ffffff;
            border-radius: 30px;
        }
        .ktc-title {
            font-size: 20px;
            color:#F37158;
            font-weight: 700;
            letter-spacing: 3px; 
            margin: 30px auto 10px
        }
        .tfic-img {
            height: 120px;
            margin-top:50px
        }
        .viber-qr {
            height: 200px;
            margin-top:20px
        }
        .cta-socmed > div:nth-child(1) {
            font-size: 25px;
            line-height: 30px;
            font-weight: 500;
        }
        .cta-socmed > div:nth-child(2) {
            font-size: 30px;
            line-height: 30px;
            font-weight: 500;
            color: #3CBB8D;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .cta-socmed > div:nth-child(3) > a {
            text-decoration: none;
            font-size: 30px;
            margin-right: 20px;
        } 
        .cta-viber > div:nth-child(1) {
            font-size: 30px;
            line-height: 30px;
            font-weight: 700;
            color: #3CBB8D;
        }
        .orgcoop-logos {
            height: 80px;
            width: auto !important;
        }
        .cta-createivesdir {
            font-size: 25px;
            letter-spacing: 5px;
            text-align: center;
            font-weight: 700;
            background-color: #4084C5;
            padding: 20px!important
        }
        .mostwanted-container { background-color: #000000; }
        .most-wntd {
            font-family: 'Newsreader', serif!important;
            font-size: 50px;
            line-height: 60px;
            margin-bottom: 15px;
        }
        .incfs-25 { font-size: 25px; }
        .perf-container > p > b, .spk-container > p > b {
            font-size: 25px;
        }
        .spk-container {
            text-align: center
        }
        .btn-colsched {
            width: 33%;
            margin: 0!important;
            border: none!important;
            border-top-left-radius: 15px!important;
            border-top-right-radius: 15px!important;
            border-bottom-left-radius: 0px!important;
            border-bottom-right-radius: 0px!important;
            font-size: 25px!important;
            background-color: #C44F9E!important;
            color: #ffffff!important
        }
        .btn-colsched.btn_active {
            background-color: #ffffff!important;
            color: #000000!important
        }
        .activities-holder {
            padding: 40px;
            border: 1px solid #cecece50;
            text-align: left
        }
        .incfs-25 > b {
            margin-left: 20px;
            margin-right: 20px;
        }
        /* SCHEDULE */
        .schedule-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ffffff80;
            padding: 40px 0;
        }
        .schedule-item:last-child {
           border-bottom: none;
        }
        .time {
            width: 25%;
            font-size: 25px;
            font-weight:bolder
        }
        .details {
            width: 70%;
        }
        .activity {
            font-weight: bold;
            font-size: 25px;
        }
        .person {
            font-style: italic;
            font-size: 20px;
            line-height: 30px;
        }
        /* ABSTRACT */
        .ballerina {
            position: absolute;
            top: 250px;
            left: -130px;
            z-index: 1
        }
        .dancew {
            position: absolute;
            top: 495px;
            left: 230px;
            z-index: 1
        }
        .dancem {
            position: absolute;
            top: 450px; 
            right: -350px;
            transform: rotate(10deg);
            width: 700px;
            z-index: 1
        }
        .gymnast {
            position: absolute;
            top: 430px;
            right: 200px;
            width: 600px;
            z-index: 1
        }
        .note01 {
            position: absolute; 
            top: 2000px;
            left: 20px;
            z-index: 1;
            width: 200px;
            transform: rotate(20deg);
        }
        .bulb01 {
            position: absolute;
            top: 2350px;
            right: 20px;
            z-index: 1;
            transform: rotate(5deg);
            width: 270px;
        }
        .ylwshp01 {
            position: absolute;
            top: 650px;
            left: -300px;
            z-index: 0;
            transform: rotateY(180deg) rotate(-25deg);
            width: 650px;
        }
        .redshp01 {
            position: absolute;
            top: 1150px;
            left: 220px;
            z-index: 0;
            transform: rotate(-35deg);
            width: 400px;
        }
        .redshp02 {
            position: absolute;
            top: 2450px;
            right: -150px;
            z-index: 0;
            transform: rotate(35deg);
            width: 350px;
        }
        .ylwshp02 {
            position: absolute; 
            top: 400px;
            right: 350px;
            z-index: 0;
            transform: rotate(-25deg);
            width: 400px;
        }
        .grnshp01 {
            position: absolute; 
            top: 350px;
            right: -100px;
            z-index: 0;
            transform: rotate(-25deg);
            width: 300px;
        }
        .blushp01 {
            position: absolute; 
            top: 1100px;
            right: 110px;
            z-index: 0;
            width: 500px;
        }
        .orgshp01 {
            position: absolute; 
            top: 2000px;
            left: -110px;
            z-index: 0;
            width: 200px;
        }
        .spl01 {
            position: absolute; 
            top: 0;
            right: 0;
            z-index: 0;
        }
        .spl01-rev {
            position: absolute; 
            top: 0;
            left: 0;
            z-index: 0;
            transform: rotateY(180deg)
        }
        .spl02 {
            position: absolute; 
            top: 300px;
            right: 200px;
            z-index: 0;
            transform: rotate(30deg)
        }
        .spl02-rev {
            position: absolute; 
            top: 300px;
            left: 200px;
            z-index: 0;
            transform: rotateY(180deg) 
        }
        .spl03 {
            position: absolute; 
            top: 850px;
            left: 50px;
            z-index: 0;
        }
        .spl03-rev {
            position: absolute; 
            top: 650px;
            right: 150px;
            z-index: 0;
            transform: rotateY(180deg) 
        }
        .spl04 {
            position: absolute; 
            top: 1150px;
            right: 50px;
            z-index: 0;
            transform: rotateY(180deg) 
        }
        .spl05 {
            position: absolute; 
            top: 1250px;
            left: 100px;
            z-index: 0;
            transform: rotateY(180deg) 
        }
        .spl06 { 
            position: absolute; 
            top: 1250px;
            left: 40%;
            z-index: 0; 
        }
        .spl07 {
            position: absolute; 
            top: 1600px;
            left: 250px;
            z-index: 0;
        }
        .spl08 {
            position: absolute; 
            top: 1600px;
            right: 0;
            z-index: 0;
        }
        .spl09 {
            position: absolute; 
            top: 2000px;
            right: 70px;
            z-index: 0;
        }
        .spl10 {
            position: absolute; 
            top: 2550px;
            right: 120px;
            z-index: 0;
        }
        /* VIDEO */
        .video-container {
            position: relative;
            height: 100vh;
            max-height:1000px;
            min-height:500px;
            overflow: hidden;
            z-index: 11;
        }
        #banner-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75); /* Adjust the alpha channel for the desired transparency */
            z-index: 1;
        }
        .content {
            position: absolute;
            z-index: 999;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
        @media only screen and (max-width: 576px) {
            .ballerina, .dancew, .dancem, .gymnast, .note01, .bulb01, .ylwshp01, .redshp01, .redshp02, .ylwshp02, .grnshp01, .blushp01, .orgshp01, .spl01, .spl01-rev, .spl02, .spl02-rev, .spl03, .spl03-rev, .spl04, .spl05, .spl06, .spl07, .spl08, .spl09, .spl10 {
                display: none;
            }
            .cxm-bannerlogo { width: 80%; height: auto; }
            .event-year {
                font-size: 80px;
                letter-spacing: 30px;
                text-indent: 30px;
                margin-bottom: 40px;
            }
            .rs-container { margin: 0 auto; width: 90vw; }
            .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
            .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div {
                display: block;
                width: 100%;
                margin: 0 0 20px;
            }
            .perf-container { padding: 0 20vw; }
            .perf-container img { width: 60vw }
            .spk-holder { text-align: center; margin: 40px auto 30px }
            .incfs-25 > b {
                margin-left: 10px;
                margin-right: 10px;
            }
            .key-topics-list > li { margin: 7px 2px }
            .key-topics-list > li > div { padding: 5px 20px; }
            .btn-colsched { width: 32%; }
            .activities-holder { padding: 0 25px; }
            .schedule-item { display: block; padding: 30px 0 }
            .time {
                width: 100%;
                font-size: 20px; 
                font-weight: bolder;
                margin-bottom: 10px;
            }
            .details { width: 100%; }
            .orgcoop-logos { height: auto }
            .logos-mobile-mb { margin-bottom: 30px }
            .mostwanted-container > div.p-5 { padding: 20px 30px!important }
            .align-center-mobile { text-align: center }
            .ksc-border { display: none }
            .cta-socmed, .jkc-left {
                width: 100%!important;
                margin-bottom: 40px;
                padding-bottom: 30px;
                border-bottom: 1px solid #fff;
            }
            .cta-viber, .jkc-right { width: 100%!important; }
            .tfic-img { margin-bottom: 30px }
        }
        @media only screen and (min-width: 577px) and (max-width: 768px) {
            .dancew, .dancem, .note01, .bulb01, .ylwshp01, .redshp01, .redshp02, .ylwshp02, .grnshp01, .blushp01, .orgshp01, .spl02, .spl03, .spl03-rev, .spl04, .spl05, .spl08, .spl09, .spl10, .hide-mobile {
                display: none;
            }
            .ballerina {
                top: 140px;
                width: 300px;
                left: -90px;
            }
            .gymnast {
                top: 140px;
                right: -185px;
                width: 400px;
                transform: rotateY(180deg);
            }
            .spl02-rev { top: 600px; }
            .spl06 { top: 750px; left: 70% }
            .spl07 { top: 1000px; left: 30px; }
            .cxm-bannerlogo { 
                width: 40%; 
                height: auto; 
                margin-top: 40px
            }
            .event-year {
                font-size: 80px;
                letter-spacing: 30px;
                text-indent: 30px;
                margin-bottom: 40px;
            }
            .rs-container { width: 70vw }
            .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
            .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
            .perf-container { padding: 0 20vw; }
            .perf-container > p > b, .spk-container > p > b { font-size: 18px }
            .incfs-25 > b { margin-left: 10px; margin-right: 10px; }
            .key-topics-list > li { margin: 7px 2px }
            .key-topics-list > li > div { padding: 5px 20px; }
            .btn-colsched { width: 32%; }
            .activities-holder { padding: 0 25px; }
            .schedule-item { display: block; padding: 30px 0 }
            .time {
                width: 100%;
                font-size: 20px; 
                font-weight: bolder;
                margin-bottom: 10px;
            }
            .details { width: 100%; }
            .orgcoop-logos { height: auto; width: 65vw !important; }
            .logos-mobile-mb { margin-bottom: 30px }
            .mostwanted-container > div.p-5 { padding: 20px 30px!important }
            .mwc-note { width: 70vw!important; margin-right: 0; margin-left: auto; }
            .px-5.logo-holder-left { padding-left: 20px!important; padding-right: 20px!important; }
        }
        @media only screen and (min-width: 769px) and (max-width: 991px) {
            .dancew, .dancem, .bulb01, .ylwshp01,  .redshp02, .grnshp01, .blushp01, .spl03, .spl03-rev, .spl04, .spl05, .spl08, .spl09, .spl10, .hide-mobile {
                display: none;
            }
            .ballerina {
                top: 140px;
                width: 300px;
                left: -90px; 
            }
            .gymnast {
                top: 140px;
                right: -185px;
                width: 400px;
                transform: rotateY(180deg);
            }
            .spl02-rev { top: 600px; }
            .spl06 { top: 750px; left: 70% }
            .spl07 { top: 1000px; left: 30px; }
            .orgshp01, .note01 { top: 2400px; }
            .redshp01 { top: 760px; left: -190px; }
            .ylwshp02 { top:700px; right:-200px }
            .note01 { left: -10px; width: 150px; }
            .cxm-bannerlogo { 
                width: 40%; 
                height: auto; 
                margin-top: 40px
            }
            .event-year {
                font-size: 80px;
                letter-spacing: 30px;
                text-indent: 30px;
                margin-bottom: 40px;
            }
            .rs-container { width: 70vw }
            .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
            .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
            .perf-container { padding: 0 20vw; }
            .perf-container > p > b, .spk-container > p > b { font-size: 18px }
            .incfs-25 > b { margin-left: 10px; margin-right: 10px; }
            .key-topics-list > li { margin: 7px 2px }
            .key-topics-list > li > div { padding: 5px 20px; }
            .btn-colsched { width: 32%; }
            .activities-holder { padding: 0 25px; }
            .schedule-item { display: block; padding: 30px 0 }
            .time {
                width: 100%;
                font-size: 20px; 
                font-weight: bolder;
                margin-bottom: 10px;
            }
            .details { width: 100%; }
            .orgcoop-logos { height: auto; width: 65vw !important; }
            .logos-mobile-mb { margin-bottom: 30px }
            .mostwanted-container > div.p-5 { padding: 20px 30px!important }
            .mwc-note { width: 70vw!important; margin-right: 0; margin-left: auto; }
            .px-5.logo-holder-left { padding-left: 20px!important; padding-right: 20px!important; }
        }
        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .dancew, .dancem, .bulb01, .ylwshp01,  .redshp02, .grnshp01, .blushp01, .spl03, .spl03-rev, .spl04, .spl05, .spl08, .spl09, .spl10, .hide-mobile {
                display: none;
            }
            .ballerina {
                top: 140px;
                width: 300px;
                left: -90px; 
            }
            .gymnast {
                top: 140px;
                right: -185px;
                width: 400px;
                transform: rotateY(180deg);
            }
            .spl02-rev { top: 600px; }
            .spl06 { top: 750px; left: 70% }
            .spl07 { top: 1000px; left: 30px; }
            .orgshp01, .note01 { top: 2400px; }
            .redshp01 { top: 760px; left: -190px; }
            .ylwshp02 { top:700px; right:-200px }
            .note01 { left: -10px; width: 150px; }
            .cxm-bannerlogo { 
                width: 40%; 
                height: auto; 
                margin-top: 40px
            }
            .event-year {
                font-size: 80px;
                letter-spacing: 30px;
                text-indent: 30px;
                margin-bottom: 40px;
            }
            .rs-container { width: 70vw }
            .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
            .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
            .perf-container { padding: 0 20vw; }
            .perf-container > p > b, .spk-container > p > b { font-size: 18px }
            .incfs-25 > b { margin-left: 10px; margin-right: 10px; }
            .key-topics-list > li { margin: 7px 2px }
            .key-topics-list > li > div { padding: 5px 20px; }
            .btn-colsched { width: 32%; }
            .activities-holder { padding: 0 25px; }
            .time { font-size: 22px }
            .orgcoop-logos { height: auto; width: 65vw !important; }
            .logos-mobile-mb { margin-bottom: 30px }
            .mostwanted-container > div.p-5 { padding: 20px 30px!important }
            .mwc-note { width: 70vw!important; margin-right: 0; margin-left: auto; }
            .px-5.logo-holder-left { padding-left: 20px!important; padding-right: 20px!important; }
            .mostwanted-container > div.p-5 { width: 50% }
        }
        @media only screen and (min-width: 1200px) and (max-width: 1399px) {
            .dancew, .dancem, .ylwshp01, .grnshp01, .blushp01, .spl03, .spl03-rev, .hide-mobile {
                display: none;
            }
            .ballerina {
                top: 140px;
                width: 300px;
                left: -90px; 
            }
            .gymnast {
                top: 140px;
                right: -185px;
                width: 400px;
                transform: rotateY(180deg);
            }
            .spl02-rev { top: 600px; }
            .spl05 { top: 2550px }
            .spl09 { top: 1800px }
            .spl06 { top: 750px; left: 70% }
            .spl07 { top: 1000px; left: 30px; }
            .orgshp01, .note01 { top: 2400px; }
            .redshp01 { top: 760px; left: -190px; }
            .redshp02 { top: 2700px; width: 300px } 
            .bulb01 { top: 2650px; width: 240px }
            .ylwshp02 { top:700px; right:-200px }
            .note01 { left: -10px; width: 150px; }
            .cxm-bannerlogo { 
                width: 40%; 
                height: auto; 
                margin-top: 40px
            }
            .event-year {
                font-size: 80px;
                letter-spacing: 30px;
                text-indent: 30px;
                margin-bottom: 40px;
            }
            .rs-container { width: 70vw }
            .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
            .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
            .perf-container { padding: 0 20vw; }
            .perf-container > p > b, .spk-container > p > b { font-size: 18px }
            .incfs-25 > b { margin-left: 10px; margin-right: 10px; }
            .key-topics-list > li { margin: 7px 2px }
            .key-topics-list > li > div { padding: 5px 20px; }
            .btn-colsched { width: 32%; }
            .activities-holder { padding: 0 25px; }
            .time { font-size: 22px }
            .orgcoop-logos { height: auto; width: 65vw !important; }
            .logos-mobile-mb { margin-bottom: 30px }
            .mostwanted-container > div.p-5 { padding: 20px 30px!important }
            .mwc-note { width: 75vw!important; margin-right: 0; margin-left: auto; }
            .px-5.logo-holder-left { padding-left: 20px!important; padding-right: 20px!important; }
            .mostwanted-container > div.p-5 { width: 50% }
        }
        @media only screen and (min-width: 1400px) and (max-width: 1699px) {
            .dancew, .dancem, .ylwshp01, .grnshp01, .blushp01, .spl03, .spl03-rev, .hide-mobile {
                display: none;
            }
            .ballerina {
                top: 140px;
                width: 300px;
                left: -90px; 
            }
            .gymnast {
                top: 140px;
                right: -185px;
                width: 400px;
                transform: rotateY(180deg);
            }
            .spl02-rev { top: 600px; }
            .spl05 { top: 2550px }
            .spl09 { top: 1800px }
            .spl06 { top: 750px; left: 70% }
            .spl07 { top: 1000px; left: 30px; }
            .orgshp01, .note01 { top: 2400px; }
            .redshp01 { top: 760px; left: -190px; }
            .redshp02 { top: 2700px; width: 300px } 
            .bulb01 { top: 2650px; width: 240px }
            .ylwshp02 { top:700px; right:-200px }
            .note01 { left: -10px; width: 150px; }
            .cxm-bannerlogo { 
                width: 40%; 
                height: auto; 
                margin-top: 40px
            }
            .event-year {
                font-size: 80px;
                letter-spacing: 30px;
                text-indent: 30px;
                margin-bottom: 40px;
            }
            .rs-container { width: 70vw }
            .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
            .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
            .perf-container { padding: 0 20vw; }
            .perf-container > p > b, .spk-container > p > b { font-size: 18px }
            .incfs-25 > b { margin-left: 10px; margin-right: 10px; }
            .key-topics-list > li { margin: 7px 2px }
            .key-topics-list > li > div { padding: 5px 20px; }
            .btn-colsched { width: 32%; }
            .activities-holder { padding: 0 25px; }
            .time { font-size: 22px }
            .orgcoop-logos { height: auto; width: 65vw !important; }
            .logos-mobile-mb { margin-bottom: 30px }
            .mostwanted-container > div.p-5 { padding: 20px 30px!important }
            .mwc-note { width: 75vw!important; margin-right: 0; margin-left: auto; }
            .px-5.logo-holder-left { padding-left: 20px!important; padding-right: 20px!important; }
            .mostwanted-container > div.p-5 { width: 50% }
        }
    </style>   
@endsection
 
@section('scripts-bottom')
    <script>
        $('.btn-colsched').click(function() {
            const clickedButton = $(this);
            const targetId = clickedButton.attr('aria-controls');

            // Remove active class from all buttons
            $('.btn-colsched').removeClass('btn_active');

            // Add active class to clicked button
            clickedButton.addClass('btn_active');

            // Hide all collapse sections
            $('.collapse').collapse('hide');

            // Show specific collapse section based on clicked button's aria-controls attribute
            $(`#${targetId}`).collapse('show');
        });

        // Schedule Data
        const scheduleData = {
            "scheduleDay1": [
                {
                    "timeStart": "8:30 AM",
                    "timeEnd": "9:00 AM",
                    "duration": "30 minutes",
                    "activity": "Registration",
                    "personInCharge": "CCP",
                    "remarks": ""
                },
                {
                    "timeStart": "9:00 AM",
                    "timeEnd": "9:15 AM",
                    "duration": "15 minutes",
                    "activity": "Opening Program",
                    "personInCharge": "CCP",
                    "remarks": ""
                },
                {
                    "timeStart": "9:15 AM",
                    "timeEnd": "9:45 AM",
                    "duration": "30 minutes",
                    "activity": "CCP Overview",
                    "personInCharge": "CCP",
                    "remarks": ""
                },
                {
                    "timeStart": "9:45 AM",
                    "timeEnd": "10:00 AM",
                    "duration": "15 minutes",
                    "activity": "Break",
                    "personInCharge": "",
                    "remarks": ""
                },
                {
                    "timeStart": "10:00 AM",
                    "timeEnd": "11:30 AM",
                    "duration": "90 minutes",
                    "activity": "SESSION 1: Production Management & Event Logistics 1",
                    "personInCharge": "Ms. Lorraine Macatangay, CCP",
                    "remarks": "Overview of Production Management (Terminologies, Objective, Profile of PM, Production Schedule, Safe Spaces Handbook)"
                },
                {
                    "timeStart": "11:30 AM",
                    "timeEnd": "12:00 PM",
                    "duration": "30 minutes",
                    "activity": "SESSION 1: Q & A",
                    "personInCharge": "Ms. Lorraine Macatangay, CCP",
                    "remarks": ""
                },
                {
                    "timeStart": "12:00 PM",
                    "timeEnd": "1:00 PM",
                    "duration": "60 minutes",
                    "activity": "Lunch Break",
                    "personInCharge": "",
                    "remarks": ""
                },
                {
                    "timeStart": "1:00 PM",
                    "timeEnd": "2:30 PM",
                    "duration": "90 minutes",
                    "activity": "SESSION 2: Production Management & Event Logistics 2",
                    "personInCharge": "Ms. Lorraine Macatangay, CCP",
                    "remarks": "Personnel Management, Finance and Legal Documentation (Team, Org Structure, Contract, Taxes, Budget, Liquidation, Procurement)"
                },
                {
                    "timeStart": "2:30 PM",
                    "timeEnd": "3:00 PM",
                    "duration": "30 minutes",
                    "activity": "SESSION 2: Q & A",
                    "personInCharge": "Ms. Lorraine Macatangay, CCP",
                    "remarks": ""
                },
                {
                    "timeStart": "3:00 PM",
                    "timeEnd": "3:15 PM",
                    "duration": "15 minutes",
                    "activity": "Break",
                    "personInCharge": "",
                    "remarks": ""
                },
                {
                    "timeStart": "3:15 PM",
                    "timeEnd": "4:45 PM",
                    "duration": "90 minutes",
                    "activity": "SESSION 3: Production Management & Event Logistics 3",
                    "personInCharge": "Ms. Lorraine Macatangay, CCP",
                    "remarks": "Logistics Planning and Management (Supplier Coordination, Scheduling, Tech Riders, Mounting & Dismantling, Production Book)"
                },
                {
                    "timeStart": "4:45 PM",
                    "timeEnd": "5:15 PM",
                    "duration": "30 minutes",
                    "activity": "SESSION 3: Q & A",
                    "personInCharge": "Ms. Lorraine Macatangay, CCP",
                    "remarks": ""
                },
                {
                    "timeStart": "5:15 PM",
                    "timeEnd": "6:00 PM",
                    "duration": "45 minutes",
                    "activity": "MENTORING",
                    "personInCharge": "",
                    "remarks": ""
                }
            ],
            "scheduleDay2": [
                {
                "timeStart": "8:30 AM",
                "timeEnd": "9:00 AM",
                "duration": "30 minutes",
                "activity": "Registration",
                "personInCharge": "CCP",
                "remarks": ""
                },
                {
                "timeStart": "9:00 AM",
                "timeEnd": "9:30 AM",
                "duration": "30 minutes",
                "activity": "Recap of Day 1 / Ice Breaker Activity",
                "personInCharge": "CCP",
                "remarks": "*no morning break, coffee available in conference room"
                },
                {
                "timeStart": "9:30 AM",
                "timeEnd": "11:00 AM",
                "duration": "90 minutes",
                "activity": "SESSION 1: Tour Planning & Management 1",
                "personInCharge": "CCP / Ms. Chinggay Bernardo /Madz Regional Partner",
                "remarks": "Overview of Tour Planning & Management (Preparing artists & production, Sponsorship Package, Marketing & Promotions, Sponsorship & Linkages)"
                },
                {
                "timeStart": "11:00 AM",
                "timeEnd": "11:30 AM",
                "duration": "30 minutes",
                "activity": "SESSION 1: Q & A",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "11:30 AM",
                "timeEnd": "12:30 PM",
                "duration": "60 minutes",
                "activity": "Lunch Break",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "12:30 PM",
                "timeEnd": "2:00 PM",
                "duration": "90 minutes",
                "activity": "SESSION 2: Tour Planning & Management 2",
                "personInCharge": "CCP / Ms. Chinggay Bernardo / Madz / Regional Partner",
                "remarks": "Logistics and Travel Preparation (Itinerary, Budget, Travel Preparation, Travel Requirements)"
                },
                {
                "timeStart": "2:00 PM",
                "timeEnd": "2:30 PM",
                "duration": "30 minutes",
                "activity": "SESSION 2: Q & A",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "2:30 PM",
                "timeEnd": "2:50 PM",
                "duration": "20 minutes",
                "activity": "Break",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "2:50 PM",
                "timeEnd": "4:20 PM",
                "duration": "90 minutes",
                "activity": "SESSION 3: Tour Planning and Management 3",
                "personInCharge": "CCP / Ms. Chinggay Bernardo / Madz / Regional Partner",
                "remarks": "Tour Execution and Venue Management (Venue, Technical Equipment, Production Cargo, Logistical Arrangements)"
                },
                {
                "timeStart": "4:20 PM",
                "timeEnd": "4:50 PM",
                "duration": "30 minutes",
                "activity": "SESSION 3: Q & A",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "4:50 PM",
                "timeEnd": "5:30 PM",
                "duration": "40 minutes",
                "activity": "MENTORING",
                "personInCharge": "",
                "remarks": ""
                }
            ],
            "scheduleDay3": [
                {
                "timeStart": "8:30 AM",
                "timeEnd": "9:00 AM",
                "duration": "30 minutes",
                "activity": "Registration",
                "personInCharge": "CCP",
                "remarks": ""
                },
                {
                "timeStart": "9:00 AM",
                "timeEnd": "9:15 AM",
                "duration": "15 minutes",
                "activity": "Recap of Day 2",
                "personInCharge": "CCP",
                "remarks": "FOCUS"
                },
                {
                "timeStart": "9:15 AM",
                "timeEnd": "10:15 AM",
                "duration": "60 minutes",
                "activity": "SESSION 1: Sustaining Your Arts Organization",
                "personInCharge": "CITEM",
                "remarks": "Pricing the Production"
                },
                {
                "timeStart": "10:15 AM",
                "timeEnd": "10:35 AM",
                "duration": "20 minutes",
                "activity": "SESSION 1: Q & A",
                "personInCharge": "",
                "remarks": "Finding Resources (Cash Support, Sponsorship, Pledges, Donations)"
                },
                {
                "timeStart": "10:35 AM",
                "timeEnd": "10:55 AM",
                "duration": "20 minutes",
                "activity": "Break",
                "personInCharge": "",
                "remarks": "Selling Rights and Buying Rights (Rights Liscensing like Korea Management Commission, specifically if we are to participate in International Arts Fair/Market)"
                },
                {
                "timeStart": "10:55 AM",
                "timeEnd": "11:55 AM",
                "duration": "60 minutes",
                "activity": "SESSION 2: Business Matters and Funding Strategies",
                "personInCharge": "CITEM",
                "remarks": ""
                },
                {
                "timeStart": "11:55 AM",
                "timeEnd": "12:15 PM",
                "duration": "20 minutes",
                "activity": "SESSION 2: Q & A",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "12:15 PM",
                "timeEnd": "1:15 PM",
                "duration": "60 minutes",
                "activity": "Lunch Break",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "1:15 PM",
                "timeEnd": "2:15 PM",
                "duration": "60 minutes",
                "activity": "SESSION 3: Storytelling and Pitching",
                "personInCharge": "CITEM",
                "remarks": ""
                },
                {
                "timeStart": "2:15 PM",
                "timeEnd": "2:35 PM",
                "duration": "20 minutes",
                "activity": "SESSION 3: Q & A",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "2:35 PM",
                "timeEnd": "3:00 PM",
                "duration": "25 minutes",
                "activity": "Break",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "3:00 PM",
                "timeEnd": "4:00 PM",
                "duration": "60 minutes",
                "activity": "SESSION 4: Branding and Marketing",
                "personInCharge": "CITEM",
                "remarks": ""
                },
                {
                "timeStart": "4:00 PM",
                "timeEnd": "4:20 PM",
                "duration": "20 minutes",
                "activity": "SESSION 4: Q & A",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "4:20 PM",
                "timeEnd": "5:00 PM",
                "duration": "40 minutes",
                "activity": "MENTORING",
                "personInCharge": "",
                "remarks": ""
                },
                {
                "timeStart": "5:00 PM",
                "timeEnd": "5:15 PM",
                "duration": "15 minutes",
                "activity": "Wrap Up / Closing Remarks",
                "personInCharge": "CCP, CITEM, Venue Partner",
                "remarks": ""
                },
                {
                "timeStart": "5:15 PM",
                "timeEnd": "5:30 PM",
                "duration": "15 minutes",
                "activity": "Awarding of Certificates",
                "personInCharge": "CCP / CITEM",
                "remarks": ""
                }
            ],
        };
        const containers = {
            "scheduleDay1": document.getElementById('schedule-container-day1'),
            "scheduleDay2": document.getElementById('schedule-container-day2'),
            "scheduleDay3": document.getElementById('schedule-container-day3')
        };

        Object.keys(scheduleData).forEach(day => {
            const scheduleContainer = containers[day];
            scheduleData[day].forEach(item => {
                const scheduleItem = document.createElement('div');
                scheduleItem.className = 'schedule-item';

                const time = document.createElement('div');
                time.className = 'time';
                time.innerText = `${item.timeStart} - ${item.timeEnd}`;
                scheduleItem.appendChild(time);

                const details = document.createElement('div');
                details.className = 'details';

                const activity = document.createElement('div');
                activity.className = 'activity';
                activity.innerText = item.activity;
                details.appendChild(activity);

                // const person = document.createElement('div');
                // person.className = 'person';
                // person.innerText = item.personInCharge;
                // details.appendChild(person);

                // if (item.remarks) {
                // const remarks = document.createElement('div');
                // remarks.className = 'remarks';
                // remarks.innerText = item.remarks;
                // details.appendChild(remarks);
                // }

                scheduleItem.appendChild(details);
                scheduleContainer.appendChild(scheduleItem);
            });
        });

        // jQuery script for smooth scrolling with padding
        $(document).ready(function() {
            $('.scroll-link').click(function(event) {
                event.preventDefault(); // Prevent default anchor click behavior
                
                // Get the target element ID from the href attribute
                var targetId = $(this).attr('href');
                
                // Scroll to the target element with padding
                $('html, body').animate({
                    scrollTop: $(targetId).offset().top - 100 // Adding 100px padding on top
                }, 2000); // Animation speed of 2 seconds
            });
        });
    </script>
@endsection

@section('content') 
    
    {{-- BANNER --}}
    <section class="fullBanner">
        <div class="container-fluid text-center ahref-light">
            <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}" alt="CREATEPhilippines x MIPAM logo" class="mx-auto cxm-bannerlogo">
            <br><div class="event-year">2024</div>

            <h1 class="ff-raleway-header">
                NAVIGATE THE 
                <br>TOURING CIRCUIT
            </h1>
            <div>
                <p class="subheader">
                    A Capacity-Building Program for the Performing Arts
                </p>
            </div>
            <div>
                <a href="https://bit.ly/3VFwMJR" class="btn-lg cta-register" target="_blank">
                    <div>REGISTER NOW</div>
                </a>
                <a href="#schedule" class="btn-lg cta-view scroll-link">
                    <div>VIEW 3-DAY SCHEDULE</div>
                </a>
            </div>
        </div>
    </section>
    {{-- LOCATIONS --}}
    {{-- PARALLAX VIDEO --}}
    <div class="video-container">
        <video autoplay muted loop id="banner-video">
            <!-- Replace 'your-video.mp4' with your video file -->
            <source src="{{ asset('img/static/x_mipam/createxmipam.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>
        <div class="content">
            <div class="rs-container">
                <img src="{{ asset('img/static/x_mipam/ntc-loc3x.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid">
            </div>
        </div>
    </div>
     {{-- <section>
        <div class="container ">
            <div class="rs-container">
                <img src="{{ asset('img/static/x_mipam/ntc-loc3x.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid">
            </div>
        </div>
    </section>  --}}
    {{-- KICK-OFF --}} 
    <section>
        <div class="orgshp01">
            <img src="{{ asset('img/static/x_mipam/abstract/shp01-orange.png') }}" alt="organic blue shape" class="img-fluid">
        </div>
        <div class="redshp02">
            <img src="{{ asset('img/static/x_mipam/abstract/shp01-red.png') }}" alt="organic red shape" class="img-fluid">
        </div>
        <div class="note01">
            <img src="{{ asset('img/static/x_mipam/abstract/drawings/note.png') }}" alt="musical note outline drawing" class="img-fluid">
        </div>
        <div class="bulb01">
            <img src="{{ asset('img/static/x_mipam/abstract/drawings/bulb.png') }}" alt="bulb outline drawing" class="img-fluid">
        </div>
        <div class="spl07">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl06.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="spl08">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl20.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="spl09">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl05.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="spl10">
            <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes" class="img-fluid">
        </div>
        <div class="container ahref-light kick-off-container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3 jkc-left">
                    <h2>KICKOFF CEREMONY</h2>
                    <p>
                        July 11, UP Manila &mdash; Little Theater
                    </p>
                </div>
                <div class="col-xs-12 col-md-1">
                    <div class="ksc-border"></div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 jkc-right">
                    <p class="mt-10">
                        Thank you for joining us at the kickoff event of <b>NAVIGATE THE TOURING CIRCUIT</b>! Continue elevating your career in the performing arts by participating in our next training sessions.
                    </p>
                    <a href="https://createphilippines.com/createph-x-mipam/gallery" class="btn-lg cta-view text-center">
                        <div>View Gallery</div>
                    </a>
                </div>
            </div>  
        </div>
        <div class="container mt-50">
            <div class="row pb-5">
                <div class="col-xs-12 col-md-4 text-center">
                    <h2 class="text-color-yellow">MODERATOR</h2>
                    <div class="spk-container mt-30">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/mod_samodio.png') }}" alt="Jill Samodio, Navigating the Tour Circuit Moderator" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Jill Samodio</b>
                            <br>DLSU Culture & Arts Director
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <h2 class="text-color-yellow spk-holder">SPEAKERS</h2>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_marasigan.png') }}" alt="Dennis Marasigan, speaker for the cretive industry and global market" class="mx-auto img-fluid mb-20">
                                <p>
                                    <b class="text-color-yellow">The Creative Industry & Global Market</b>
                                    <br><b>Mr. Dennis N. Marasigan</b>
                                    <br>CCP Vice President & Artistic Director 
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="spk-container">
                                <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_belarmino.png') }}" alt="Vanini Belarmino, speaker for Charting Alternative Paths: The Future of Performance" class="mx-auto img-fluid mt-20 mb-20">
                                <p>
                                    <b class="text-color-yellow">
                                        Charting Alternative Paths:
                                        <br>The Future of Performance
                                    </b>
                                    <br><b>Ms. Vanini B. Belarmino</b> 
                                    <br>Belarmino&Partners Founder & Managing Director
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <h2 class="text-color-green">WITH A SPECIAL PERFORMANCE FROM</h2>
                <div class="mx-auto col-xs-12 col-sm-4 col-md-3 mt-30 perf-container">
                    <img src="{{ asset('img/static/x_mipam/performer01bw.png') }}" alt="Navigating the Tour Circuit Road Show Locations" class="mx-auto img-fluid mb-20">
                    <p>
                        <b class="text-color-yellow">Christell</b>
                        <br>Singer, Salinlahi
                        <br>Opening Performance
                    </p>
                </div>
            </div>
        </div> 
    </section>  
    
    {{-- TRAINING --}}
    <section id="schedule">
        <div class="container text-center ahref-light">
            <div>
                <h2 class="text-color-yellow">ENRICH YOUR KNOWLEDGE IN THE TRADE OF PERFORMING ARTS</h2>
                <div class="incfs-25 mb-30">
                    <b>CLARK</b>●<b>DAPITAN</b>●<b>BOHOL</b>
                </div>
                <p>
                    Elevate your craft and artistry with <b>NAVIGATE THE TOURING CIRCUIT</b>, an intensive capacity-building program designed to empower Filipino performing groups and companies. Sharpen your tour planning skills and develop essential business acumen to conquer the touring circuit.
                </p>
                <h3 class="ktc-title">KEY TOPICS COVERED:</h3>
                <ul class="key-topics-list mb-40">
                    <li>
                        <div>
                            Product Management
                        </div>
                    </li>
                    <li>
                        <div>
                            Marketing
                        </div>
                    </li>
                    <li>
                        <div>
                            Pitching
                        </div>
                    </li>
                    <li>
                        <div>
                            Legal
                        </div>
                    </li>
                    <li>
                        <div>
                            Budgeting
                        </div>
                    </li>
                    <li>
                        <div>
                            Sponsorship
                        </div>
                    </li>
                    <li>
                        <div>
                            Funding
                        </div>
                    </li>
                    <li>
                        <div>
                            Branding
                        </div>
                    </li>
                    <li>
                        <div>
                            Venue Management
                        </div>
                    </li>
                    <li>
                        <div>
                            Logistics
                        </div>
                    </li>
                    <li>
                        <div>
                            Licensing
                        </div>
                    </li>
                    <li>
                        <div>
                            Personnel Management
                        </div>
                    </li>
                </ul>
                <a href="https://bit.ly/3VFwMJR" class="btn-lg cta-register-2 ">
                    <div>REGISTER FOR FREE</div>
                </a> 
                {{-- <a href="#moderators" class="btn-lg cta-view-2 scroll-link">
                    <div>VIEW SPEAKERS</div>
                </a> --}}
            </div>
        </div>
    </section>
    {{-- SCHEDULE --}}
    <section class="nopad">
        <div class="container text-center ahref-light">
            <div>
                <h2 class="text-color-yellow mb-10">
                    Navigate the Touring Circuit
                    <br><small class="text-color-white">3-Day Program Schedule</small>
                </h2>
                <p class="mb-40">
                    <em>This schedule is for all locations:</em> Clark, Dapitan, and Bohol.
                </p>
                <div class="my-40">
                    <div>
                        <button class="btn btn-colsched btn_active" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="true" aria-controls="multiCollapseExample1" id="db_id">
                            <b>DAY 1</b>
                        </button>
                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2" id="ds_id">
                            <b>DAY 2</b>
                        </button>
                        <button class="btn btn-colsched" type="button" data-toggle="collapse" data-target="#multiCollapseExample3" aria-expanded="false" aria-controls="multiCollapseExample3" id="hs_id">
                            <b>DAY 3</b>
                        </button>
                    </div>
                    <div>
                        <div> 
                            <div class="activities-holder collapse multi-collapse show" id="multiCollapseExample1">
                                <div id="schedule-container-day1"></div>
                            </div>
                            <div class="activities-holder collapse multi-collapse" id="multiCollapseExample2">
                                <div id="schedule-container-day2"></div>
                            </div>
                            <div class="activities-holder collapse multi-collapse" id="multiCollapseExample3">
                                <div id="schedule-container-day3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="my-5" id="moderators">
                <h2 class="text-color-yellow">MODERATED BY</h2>
                <div class="row">
                    <div class="mx-auto col-xs-12 col-sm-5 col-md-3 mt-30 perf-container">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/mod_samodio.png') }}" alt="Jill Samodio, Navigating the Tour Circuit Moderator" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Jill Samodio</b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="my-5">
                <h2 class="text-color-yellow">SPEAKERS</h2>
                <div class="row">
                    <div class="mx-auto col-xs-12 col-sm-3 mt-30 perf-container">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_marasigan.png') }}" alt="Dennis Marasigan, speaker for the cretive industry and global market" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Dennis Marasigan</b>
                            <br>The Creative Industry & Global Market
                        </p>
                    </div>
                    <div class="mx-auto col-xs-12 col-sm-3 mt-30 perf-container">
                        <img src="{{ asset('img/static/x_mipam/speakers_moderators/spk_belarmino.png') }}" alt="Vanini Belarmino, speaker for Charting Alternative Paths: The Future of Performance" class="mx-auto img-fluid mb-20">
                        <p>
                            <b class="text-color-yellow">Vanini Belarmino</b>
                            <br>Charting Alternative Paths:
                            <br>The Future of Performance
                        </p>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    {{-- CTA --}}
    <section>
        <div class="container ahref-light comms-cta">
            <div class="row text-center">
                <h2 class="text-color-yellow">THE TOURING CIRCUIT AWAITS YOU</h2>
                <p>
                    Don't miss the chance to enhance your entrepreneurial skills and  business knowledge to seize the opportunities in the global touring market. The capacity-building program will conclude with CREATEPhilippines x Manila International Performing Arts Market (MIPAM) to be held next year.
                </p>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 align-center-mobile">
                    <h3 class="text-color-red">For inquiries:</h3>
                </div>
                <div class="col-xs-12 col-sm-5 col-lg-5 mb-30 align-center-mobile">
                    <a href="mailto:artseducation@culturalcenter.gov.ph">artseducation@culturalcenter.gov.ph</a>
                    <br>8 832 1125 local 1710
                    <br><i class="fab fa-facebook"></i> <a href="" target="_blank">culturalcenterofthephilippines</a>
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4 mb-30 align-center-mobile">
                    <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a>
                    <br>8 833 1258 local 306
                    <br><i class="fab fa-facebook"></i> <a href="" target="_blank">createphilippines</a>
                </div>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <section class="nopad">
        <div class="container ahref-light">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-lg-4 cta-socmed">
                    <div>
                        DON'T FORGET TO USE OUR HASHTAG AND FOLLOW US FOR UPDATES
                    </div>
                    <div class="smcta-hash">
                        #CREATEPHxMIPAM
                    </div>
                    <div>
                        <a href="https://www.instagram.com/createphilippines/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/createphilippines/" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://x.com/CreatePHILS" target="_blank">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/create-philippines/?viewAsMember=true" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw" target="_blank">
                            <i class="fab fa-viber"></i>
                        </a>
                    </div>
                    <div>
                        <img src="{{ asset('img/static/x_mipam/TheFutureIsCreative.png') }}" alt="the future is creative" class="tfic-img">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <div class="ksc-border"></div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-7 cta-viber">
                    <div>
                        LET'S CREATE TOGETHER
                    </div>
                    <p>
                        Join the CREATEPhilippines Viber Community to meet fellow artists and creatives, learn from experts, and find future partners.
                    </p>
                    <a href="https://invite.viber.com/?g2=AQBFxC8QhimCJkzpIaSiO%2Bxwl4FN%2Fb1eGTC7ZQewPJ2SwK1iEMGfZClMJmRpoSWw" target="_blank">
                        <img src="{{ asset('img/static/x_mipam/createph_viber.webp') }}" alt="Create Philippines Viber Community QR Code" class="viber-qr">
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- ORGANIZERS --}}
    <section>
        <div class="container">
            <div class="row text-center">
                <h3>ORGANIZED BY</h3>
                <img src="{{ asset('img/static/x_mipam/organized_by.webp') }}" alt="CITEM logo with Cultural Center of the Philippines" class="mt-30 mb-50 mx-auto orgcoop-logos">
            </div>
            <div class="row text-center mt-50">
                <h3>IN COOPERATION WITH</h3>
                <img src="{{ asset('img/static/x_mipam/in_cooperation_with.webp') }}" alt="Kickoff Rally in Cooperation with UP Manila" class="mt-30 mx-auto orgcoop-logos">
            </div>
        </div>
    </section>
    <hr>
    {{-- MIPAM --}}
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-sm-2 px-5 logo-holder-left">
                    {{-- <img src="{{ asset('img/static/x_mipam/mipam_3x.webp') }}" alt="Manila International Performing Arts Market" class="img-fluid logos-mobile-mb"> --}}
                    <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}" alt="Manila International Performing Arts Market" class="img-fluid logos-mobile-mb">
                </div>
                <div class="col-xs-12 col-sm-8 px-5">
                    <p>
                        Organized by CITEM in partnership with CCP, CREATEPhilippines x MIPAM is an intersection of arts and business, bringing together performing arts groups and key industry players for business-matching and networking opportunities. As the culminating event of NAVIGATING THE TOURING CIRCUIT, CREATEPH x MIPAM will showcase the Philippines’ vibrant performing arts scene, featuring talents that are more than ready to take on the world.
                    </p>
                </div>
            </div>
        </div> 
    </section>
    {{-- CTA: Join Creatives Directory --}}
    <section class="nopad">
        <div class="row cta-createivesdir">
            <div>JOIN THE DIGITAL SPACE FOR FILIPINO CREATIVES</div>
        </div>
        <div class="row mostwanted-container">
            <div class="col-xs-12 col-sm-6 col-lg-2 hide-mobile"></div>
            <div class="col-xs-12 col-sm-6 col-lg-4 p-5">
                <img src="{{ asset('img/static/x_mipam/heads_3x.webp') }}" alt="Manila International Performing Arts Market" class="img-fluid">
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4 p-5">
                <div class="most-wntd">MOST WANTED CREATIVES</div>
                <div>
                    <p>
                        Share your artistry alongside other Filipino talents in the CREATEPhilippines Directory of Creatives and be ahead of the curve.
                    </p>
                    <a href="https://createphilippines.com/register/step-1" class="btn-lg cta-register-2" target="_blank">
                        <div>REGISTER NOW*</div>
                    </a>
                </div>
            </div> 
            <div class="p-5 text-end mwc-note">
                <p>
                    <em>
                        *By registering to the Directory of Creatives, you are also signing-up to the CCP Performing Arts Directory.
                    </em>
                </p>
            </div>
        </div>
    </section>
    {{-- CREATEPhilippines --}}
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-sm-3 px-5 logo-holder-left">
                    <img src="{{ asset('img/static/x_mipam/cphlogo_2_white.webp') }}" alt="CREATEPhilippines white logo" class="img-fluid logos-mobile-mb">
                </div>
                <div class="col-xs-12 col-sm-7 px-5">
                    <p>
                        CREATEPhilippines is organized by the Center for International Trade Expositions and Missions (CITEM), the export promotion arm of the Philippine Department of Trade and Industry (DTI).
                        <br><br>
                        CREATEPhilippines.com is the country's first government-led content and community platform for the local creative industries. It is the ultimate resource for stories and updates on the Philippines' creative community and a centralized directory and sourcing platform where Filipino creatives can share their portfolio to and engage with a global audience.
                    </p>
                </div>
            </div>
        </div> 
    </section>

{{-- Shapes, outlines, splashes --}}
<div class="ballerina">
    <img src="{{ asset('img/static/x_mipam/abstract/ballet2.png') }}" alt="ballerina outline drawing" class="img-fluid">
</div>
<div class="dancew">
    <img src="{{ asset('img/static/x_mipam/abstract/dancew.png') }}" alt="woman bowing outline drawing" class="img-fluid">
</div>
<div class="dancem">
    <img src="{{ asset('img/static/x_mipam/abstract/dancem2.png') }}" alt="male dancing outline drawing" class="img-fluid">
</div>
<div class="gymnast">
    <img src="{{ asset('img/static/x_mipam/abstract/gymnast2.png') }}" alt="woman dancing outline drawing" class="img-fluid">
</div>


<div class="ylwshp01">
    <img src="{{ asset('img/static/x_mipam/abstract/shp05-y.png') }}" alt="organic yellow shape" class="img-fluid">
</div>
<div class="redshp01">
    <img src="{{ asset('img/static/x_mipam/abstract/red02.png') }}" alt="organic red shape" class="img-fluid">
</div>
<div class="ylwshp02">
    <img src="{{ asset('img/static/x_mipam/abstract/shp03-yellow.png') }}" alt="organic yellow shape" class="img-fluid">
</div>
<div class="grnshp01">
    <img src="{{ asset('img/static/x_mipam/abstract/shp03-green.png') }}" alt="organic green shape" class="img-fluid">
</div>
<div class="blushp01">
    <img src="{{ asset('img/static/x_mipam/abstract/shp01-blue.png') }}" alt="organic blue shape" class="img-fluid">
</div>


<div class="spl01">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl02.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl01-rev">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl02.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl02">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl07.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl02-rev">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl07.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl03">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl03-rev">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl01.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl04">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl21.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl05">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl22.png') }}" alt="paint splashes" class="img-fluid">
</div>
<div class="spl06">
    <img src="{{ asset('img/static/x_mipam/abstract/splashes/spl16.png') }}" alt="paint splashes" class="img-fluid">
</div>




@endsection