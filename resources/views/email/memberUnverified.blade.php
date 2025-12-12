<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approved Application</title>

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
                            <p>Hi {{ $name }},</p>
                            <p>Welcome to CREATEPhilippines!</p>
                            <p>
                            We’re happy to inform you that we have successfully processed your application to be part of the Directory of Creatives and you can now proceed in setting up your Directory Page. 
                            </p>
                        </td>
                        <td width="20"></td>
                    </tr>
                    <tr><td colspan="3" height="30"></td></tr>
                    <tr>
                        <td width="20"></td>
                        <td>
                            <a href="{{ route('login') }}" class="btn-verify">TAKE ME TO MY CREATEPhilippines ACCOUNT</a>
                        </td>
                        <td width="20"></td>
                    </tr>
                    <tr><td colspan="3" height="25"></td></tr>
                    <tr>
                        <td width="20"></td>
                        <td>
                            <p>Should you need any assistance or have any questions, please do not hesitate to contact us at <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a>. Our team is here to support you every step of the way.</p>
                            <p>Please note that this message is automated, and we kindly request that you refrain from replying directly to this email.</p>
                            <p>Thank you once again, and we look forward to seeing your incredible talent shine on CREATEPhilippines!</p>
                        </td>
                        <td width="20"></td>
                    </tr>
                    <tr><td colspan="3" height="30"></td></tr>
                    <tr>
                        <td width="20"></td>
                        <td>
                            <b>CREATEPhilippines Team</b>
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
                        <td>
                            <p style="font-size:14px;text-align:center">
                                If you have any questions please email us at <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a> or visit our <a href="">FAQs</a>.
                            </p>
                        </td>
                    </tr>
                    <tr><td height="15"></td></tr>
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