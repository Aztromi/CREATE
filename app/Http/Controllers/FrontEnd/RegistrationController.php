<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Mail\EmailVerification;

use App\Models\User;
use App\Models\UProfile;
use App\Models\UEmail;

use Auth;

class RegistrationController extends Controller
{
    //Step 1 Registration only

 

    public function showRegistrationForm()
    {
        // TEMP
        // return redirect()->route('serviceRedirect');

        if(!Auth::check())
        {
            $story = User::with('profile')->has('homeStoryLatest')->inRandomOrder()->first();
            return view('register.step-1')
                ->with('story', $story);
        }
        else
        {
            return redirect()->route('home');
        }
    }

    

    public function register(Request $request)
    {
        
        $passwordRules = [
            'required',
            'string',
            'min:8',
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).+$/',
            'regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"',
        ];

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email|unique:u_emails,value',
            // 'password' => $passwordRules,
            'password' => 'required|string|min:8',
        ]);

        

        if ($validator->fails()) {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 200);
        }

        
        $randomVal = Str::random(32);
        $token = hash('sha256', $request->input('email') . time() . $randomVal);

        $fname = ucwords(trim($request->input('firstname')));
        $lname = ucwords(trim($request->input('lastname')));
        $fullname = $fname . ' ' . $lname;

        $newUser = User::create([
            'name' => $fullname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'token' => $token,
            'verified' => -1,
            'approved' => 0,
            'status' => 'inactive',
            'type' => 'normal',
            'requests' => 0,
        ]);

        $newUser->registrationLogs()->create([
            'step' => '1',
            'ip' => $request->ip(),
        ]);

        $newProfile = UProfile::create([
            'user_id' => $newUser->id,
            'first_name' => $fname,
            'last_name' => $lname,
            'about' => '',
            'is_new' => 1,
            'has_profile_reminder' => 0,
        ]);

        $uEmail = new UEmail;
        $uEmail->value = $request->input('email');

        $newProfile->emails()->save($uEmail);




        

        Mail::to($newUser->email)
            ->send(new EmailVerification($newUser->name, $newUser->email, $token));



        return response()->json(['validated' => true, 'message' => 'Registration successful!'], 200);
        
    }
   

    public function validateField(Request $request)
    {
        $passwordRules = [
            'required',
            'string',
            'min:8',
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).+$/',
            'regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"',
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$',
        ];
        $passwordMessages = [
            'password.required' => 'Required Field. ',
            'password.string' => 'Only text values are allowed. ',
            'password.min' => 'Password must be at least 8 characters. ',
            'password.regex' => 'Password does not meet the requirements. Please check and try again. ',
        ];

        $data = $request->all();
        $field = key($data);
        $value  = reset($data);
        switch($field)
        {
            case 'firstname':
                $validator = Validator::make(
                    [$field => $value],
                    [$field => 'required']
                );
            break;
            case 'lastname':
                $validator = Validator::make(
                    [$field => $value],
                    [$field => 'required']
                );
            break;
            case 'email':
                $validator = Validator::make(
                    [$field => $value],
                    [$field => 'required|email|unique:users,email|unique:u_emails,value']
                );
            break;
            case 'password':
                $validator = Validator::make(
                    [$field => $value],
                    [$field => $passwordRules],
                    $passwordMessages
                );
            break;
        }

        if ($validator->fails()) {
            // return response()->json(['validation' => false, 'errors' => $validator->errors()], 422);
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 200);
        }

        return response()->json(['validated' => true, 'message' => 'Field validation successful!'], 200);
    }

    public function verifyEmail($token)
    {
        $user = User::where('token', $token)->first();

        if($user)
        {
            $user->email_verified_at = now();
            $user->status = 'active';
            $user->save();

            return redirect()->route('register.message.verified');

            // Session::put('homeSubsribe', 'hide'); // visible or hide
            // Session::put('homePopup', 'emailVerified');
        }
        else
        {
            return redirect()->route('home');
        }
        

    }
}
