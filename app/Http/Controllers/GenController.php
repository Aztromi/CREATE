<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;

use App\Models\User;
use App\Models\UProfile;


class GenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function changePasswordProcess(Request $request)
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $user = User::find(Auth::user()->id);
        
        if(!$user)
        {
            abort(401);
        }

        $rules = [
            'pass' =>'required|string|min:8|max:150|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"',
            'newPass' =>'required|string|min:8|max:150|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"',
            'rePass' =>'required|string|min:8|max:150|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"',
        ];

        $messages = [
            'pass.required' => 'The current password field is required.',
            'newPass.required' => 'The new password field is required.',
            'rePass.required' => 'The confirm password field is required.',
            
            'pass.min' => 'The current password must be at least 8 characters.',
            'newPass.min' => 'The new password must be at least 8 characters.',
            'rePass.min' => 'The confirm password must be at least 8 characters.',
            
            'pass.max' => 'The current password must not exceed 150 characters.',
            'newPass.max' => 'The new password must not exceed 150 characters.',
            'rePass.max' => 'The confirm password must not exceed 150 characters.',
            
            'pass.regex' => 'The current password must meet the specified requirements.',
            'newPass.regex' => 'The new password must meet the specified requirements.',
            'rePass.regex' => 'The confirm password must meet the specified requirements.',
        ];
        

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails())
        {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

        $pass = trim($request->input('pass'));
        $newPass = trim($request->input('newPass'));
        $rePass = trim($request->input('rePass'));

        if(Hash::check($pass, $user->password))
        {
            return response()->json(['validated' => true], 423);
        }

        if($newPass != $rePass)
        {
            return response()->json(['validated' => true], 424);
        }

        $user->password = $newPass;
        $user->save();
        
        return response()->json(['validated' => true, 'URLRedirect' => route('login')], 200);
    }


    public function uploadProfileImage(Request $request)
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $user = User::find(Auth::user()->id);
        
        if(!$user)
        {
            abort(401);
        }

        $rules = '';
        $banner = '';

        if($request->has('profilePhoto'))
        {
            $rules = [
                'profilePhoto' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=height,min_width=1,min_height=1,max_width=1000,max_height=1000',
            ];
    
            $messages = [
                'profilePhoto.required' => 'Profile Photo is required.',
                'profilePhoto.image' => 'The uploaded file must be an image.',
                'profilePhoto.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
                'profilePhoto.dimensions' => 'Profile photo must have equal width and height, and not be greater than 1000 pixels.',
            ];
        }
        else
        {
            return response()->json(['validated' => false, 'error' => 'Element not found.'], 423);
        }
        

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails())
        {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

        $profile = UProfile::where('user_id', Auth::user()->id)->first();

        if(!$profile)
        {
            abort(401);
        }

        $file = $request->file('profilePhoto');
        $path = '../user_uploads/' . Auth::user()->id . '/Profile';

        $extension = $file->getClientOriginalExtension();
        $currentDate = now()->format('Ymd_His');
        $randomString = Str::random(12);
        $filename = $currentDate . '_profile_' . $randomString . '.' . $extension;

        $file->storeAs($path, $filename);

        if($profile->uindie)
        {
            $profile->uindie->update([
                'display_photo' => $filename,
            ]);
        }

        
        return response()->json(['validated' => true, 'image_path' => asset('folder_user-uploads/' . Auth::user()->id . '/Profile/' . $filename)], 200);


    }


    public function uploadBanner(Request $request)
    {
        if(!Auth::check())
        {
            abort(401);
        }

        $user = User::find(Auth::user()->id);
        
        if(!$user)
        {
            abort(401);
        }

        $rules = '';
        $banner = '';

        switch($request->input('type'))
        {
            case 'profile':
            break;
            case 'banner':
            break;
        }
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg|dimensions:width=height,min_width=1,min_height=1,max_width=1000,max_height=1000',
        ];

        $messages = [
            'image.required' => 'The image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
            'image.dimensions' => 'The image must have equal width and height, and not be greater than 1000 pixels.',
        ];
        

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails())
        {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

    }
}
