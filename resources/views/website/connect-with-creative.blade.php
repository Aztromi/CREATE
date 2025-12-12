@extends('layouts.app')

@section('styles')
    <style>

        .custom-ulist tr td {
            padding-bottom: 10px;
        }

        .custom-ulist {
            margin-bottom: 30px;
        }

        .custom-ulist tr td:first-child {
            width: 20px;
        }
        .custom-ulist tr td:nth-child(2) {
            width: 30px;
            text-align: right;
            vertical-align: top;
        }
        .custom-ulist tr td:nth-child(3) {
            width: 5px;
        }
        .custom-ulist tr td:nth-child(4) {
            vertical-align: top;
        }

        .buttons {
            text-align: center;
        }

        .buttons a {
            font-size: 20px;
            padding: 15px 15px;
            border-radius: 30px;
            margin-bottom: 15px;
            width: 300px;
            color: #FFF;
        }

    </style>
@endsection

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <h1 class="text-center">Connect with a Creative</h1>
            <p class="text-center">Find the Right Creative Professional for Your Needs</p>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>How It Works​</h3>
                <table border="0" class="custom-ulist">
                    <tr>
                        <td></td>
                        <td>✅</td>
                        <td></td>
                        <td>Tell us what you need – Fill out a short form about your project or creative needs.​</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>✅</td>
                        <td></td>
                        <td>We match you with the right Creatives from our Directory – Our Directory includes professionals from visual arts, animation, game development, performing arts, and more.​</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>✅</td>
                        <td></td>
                        <td>Start collaborating! – Once matched, you can directly connect with your chosen creative.​</td>
                    </tr>
                </table>

                <h3>🚀 Get Started​</h3>
                <table border="0" class="custom-ulist">
                    <tr>
                        <td></td>
                        <td>🔹</td>
                        <td></td>
                        <td>Looking for a creative? Fill out our quick form and get matched!</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>🔹</td>
                        <td></td>
                        <td>Are you a Creative? Join our Directory to get discovered by potential clients.</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 buttons">
                <!-- <a href="https://forms.gle/fXg8BtpjonPQrKQx7" class="btn btn-primary" target="_blank">Connect with a Creative</a> -->
                 <a href="{{ route('connect-creative.add') }}" class="btn btn-primary" target="_blank">Connect with a Creative</a>
                <a href="/register" class="btn btn-primary" target="_blank">Join the Directory</a>
            </div>
        </div>
    </div>
</section>

@endsection