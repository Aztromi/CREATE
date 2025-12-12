<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\EmailUserMessage;
use Illuminate\Support\Facades\Validator;

use App\Models\UserMail;


class UserContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:150',
            'lname' => 'required|string|max:150',
            'em' => 'required|email|max:150',
            'tMessage' => 'required|string|max:250',
        ]);

        $validator->setAttributeNames([
            'fname' => 'Firstname',
            'lname' => 'Lastname',
            'em' => 'E-mail',
            'tMessage' => 'Message',
        ]);

        if ($validator->fails())
        {   
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }


        UserMail::create([
            'firstname' => $request->input('fname'),
            'lastname' => $request->input('lname'),
            'email' => $request->input('em'),
            'message' => $request->input('tMessage'),
        ]);

        Mail::to(env('EMAIL_G_RECIPIENT_EMAIL'))
            ->send(new EmailUserMessage($request->input('fname'), $request->input('lname'), $request->input('em'), $request->input('tMessage')));



        return response()->json(['validated' => true, 'message' => 'Registration successful!'], 200);

    }
}
