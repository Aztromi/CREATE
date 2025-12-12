<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecaptchaController extends Controller
{
    public function recaptcha_validate(Request $request)
    {
        $URL = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
                'secret' => config('services.recaptcha.secret'),
                'response' => $request->get('recaptcha'),
                'remoteip' => $remoteip
            ];
        $options = [
                'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
                ]
            ];
        $context = stream_context_create($options);
                // $result = file_get_contents($url, false, $context);
                $result = curl_get_file_contents($URL);
                $resultJson = json_decode($result);
        if ($resultJson->success != true) {
                // return back()->withErrors(['captcha' => 'ReCaptcha Error']);
                return response()->json(['message' => 'Recaptcha Error 1!'], 400);
                }
        if ($resultJson->score >= 0.3) {
                //Validation was successful, add your form submission logic here
                // return back()->with('message', 'Thanks for your message!');
                return response()->json(['message' => 'Thanks for your message!'], 200);
        } else {
                // return back()->withErrors(['captcha' => 'ReCaptcha Error']);
                return response()->json(['message' => 'Recaptcha Error 2!'], 500);
        }
    }

    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }
}
