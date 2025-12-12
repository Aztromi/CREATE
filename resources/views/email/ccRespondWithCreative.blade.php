<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connect with Creatives Recommendations</title>

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,500;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet"> 

    <style>
        * {
            font-family: 'Work sans', sans-serif;
            font-size: 16px;
        }
        a {
            color:#217CCD
        }
        p {
            margin-bottom:10px
        }
        table {
            margin:10px auto; width:100%; max-width:700px;
        }
        th {
            background-color:#000000; width:100%; padding-top:40px; padding-bottom:40px; text-align: center
        }
        td.content-holder {
            padding-top:40px; padding-bottom:40px;
        }
        td.footer {
            border-top:2px solid #000000; padding-top:10px
        }
        img.logo {
            height:50px; margin:0 auto;
        }
        img.logoC {
            height:30px; margin:0 auto;
        }
        .btn-verify {
            background-color:#217CCD; color:#ffffff; font-size:16px; font-weight:bold; padding:15px; border-radius:5px;text-decoration:none
        }
    </style>
</head>
<body>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th>
                <img src="https://citem.com.ph/createph_assets/createph-logo_horizontal.png" alt="" class="logo">
            </th>
        </tr>
        <tr>
            <td class="content-holder">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="20"></td>
                        <td>
                            <p>Dear {{ $name }}:</p>
                            <p>Good day!</p>
                            <p>Thank you for your interest in connecting with and potentially collaborating with a Filipino creative through CREATEPhilippines.</p>
                            <p>This is to acknowledge that we have received your submission via our Connect with a Creative website form:</p>
                            <div style="padding-left: 15px;">
                                <p>You are looking for: <b>{{ $looking_for }}</b></p>
                                <p>
                                    Type of Creative Professional:
                                    <br>
                                    <ul>
                                        @foreach($professional_types as $pType)
                                            <li>{{ $pType->value }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                                <p>
                                    Goal:
                                    <br>
                                    <ul>
                                        @foreach($project_goals as $gType)
                                            <li>{{ $gType->value }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                            </div>
                            <p>Based on your requirements and upon checking our Directory of Creatives, we are pleased to share the following Creative profiles that may be a good match for you:</p>
                            <p>
                                <ol>
                                    @foreach($creatives as $creative)
                                        <li>{{ $creative->profile->dispName }}: <a href="{{ route('works', ['slug' => $creative->profile->latestSlug->value]) }}" target="_blank" rel="noopener noreferrer">{{ route('works', ['slug' => $creative->profile->latestSlug->value]) }}</a></li>
                                    @endforeach
                                </ol>
                            </p>
                            <p>Thank you!</p>
                        </td>
                        <td width="20"></td>
                    </tr>
                    <tr><td colspan="3" height="30"></td></tr>
                    <tr>
                        <td width="20"></td>
                        <td>
                            <b>CREATEPhilippines</b>
                        </td>
                        <td width="20"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <p>
                                <b>FOLLOW US ON SOCIAL</b>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100"></td>
                                    <td align="center">
                                        <a href="https://www.facebook.com/createphilippines/">
                                            <!-- FACEBOOK -->
                                            
                                             <img width="40" src="https://createphilippines.com/img/socials/social_fb_150.png" alt="">
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="https://www.instagram.com/createphilippines/">
                                            <!-- INSTAGRAM -->
                                            <img width="40" src="https://createphilippines.com/img/socials/social_insta_150.png" alt="">
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="https://www.linkedin.com/company/create-philippines/">
                                            <!-- LINKEDIN -->
                                            <img width="40" src="https://createphilippines.com/img/socials/social_linkedin_150.png" alt="">
                                        </a>
                                    </td>
                                    <td align="center" target="_blank" rel="noopener noreferrer">
                                        <a href="https://vb.me/786fc3">
                                            <!-- VIBER -->
                                            <img width="40" src="https://createphilippines.com/img/socials/social_viber_150.png" alt="">
                                        </a>
                                    </td>
                                    <td width="100"></td>
                                </tr>
                            </table>    
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>