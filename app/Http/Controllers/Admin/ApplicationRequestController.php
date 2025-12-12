<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\UserUnVerified;
use App\Mail\UserVerified;
use App\Mail\UserDisapproved;

use App\Models\User;
use App\Models\Slug;

use App\Mail\EmailVerification;

use Auth;

class ApplicationRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin.og']);
    }

    public function applicationRequests()
    {
        // $users = User::allUsers()->with('vLabel', 'profile')->orderBy('created_at', 'desc')->paginate(10);

        $users = User::allUsers()->with('vLabel', 'profile')
            // ->whereNotNull('email_verified_at')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.registered-users.application-requests')
            ->with('users', $users);
    }
    
    public function userApproval(Request $request)
    {
        $user = User::find($request->uID);

        if(!isset($user))
        {
            return response()->json(['errors' => 'Not found'], 422);
        }

        $user->approved = $request->newApproval;
        $user->save();

        if($request->newApproval == 1){
            $newState = 'Approved';
        }
        else if($request->newApproval == 0){
            $newState = 'Disapproved';
        }

        $profile = $user->profile()->first();
        $profile->logsProfileStateChange()->create([
            'updated_by' => Auth::user()->id,
            'new_state' => $newState,
        ]);

        return response()->json(['validated' => true, 'message' => 'Update successful!'], 200);
    }

    public function userDeny(Request $request)
    {
        $user = User::find($request->uID);

        if(!isset($user))
        {
            return response()->json(['errors' => 'Not found'], 422);
        }

        $profile = $user->profile()->first();

        $profile->logsProfileStateChange()->create([
            'updated_by' => Auth::user()->id,
            'new_state' => 'Denied Request #' . $user->requests,
        ]);

        $user->requests = 0;
        $user->save();

        // !!! MAIL SERVICE OF DENIED REQUEST !!!

        Mail::to($user->email)
                ->send(new UserDisapproved($user->name));

        return response()->json(['validated' => true, 'message' => 'Update successful!'], 200);
    }


    public function userStatus(Request $request)
    {
        $user = User::find($request->uID);
        $profile = $user->profile()->first();
        
        $user->verified = $request->newStatus;
        $user->approved = 1;
        $user->requests = 0;
        $user->save();

        $profile->has_profile_reminder = 1;
        $profile->save();

        if($request->newStatus == 1){
            $newState = 'Verified';
        }
        else if($request->newStatus == 0){
            $newState = 'Unverified';
        }

        $profile->logsProfileStateChange()->create([
            'updated_by' => Auth::user()->id,
            'new_state' => $newState,
        ]);

        // SLUG
        if(in_array($request->newStatus, [0,1])){
            $baseSlug = Str::slug($profile->dispName);
            $slug = $profile->slugs()->where('value', $baseSlug)->first();

            if($slug){
                $slug->touch();
            }
            else{
                $suffix = 0;
                $uniqueSlug = $baseSlug;

                do{
                    $currentSlug = $suffix > 0 ? $baseSlug . '-' . str_pad($suffix, 2, '0', STR_PAD_LEFT) : $baseSlug;

                    $exists = Slug::where('value', $currentSlug)->exists();

                    if($exists){
                        $suffix++;
                    }
                    else{
                        $uniqueSlug = $currentSlug;
                    }

                } while($exists);

                $profile->slugs()->create([
                    'value' => $uniqueSlug,
                ]);
            }
        }
        

        // VERIFIED CHANGE
        if($request->newStatus == 0)
        {
            Mail::to($user->email)
                ->send(new UserUnVerified($user->name));
        }
        else if($request->newStatus == 1)
        {
            Mail::to($user->email)
                ->send(new UserVerified($user->name));
        }


        

        return response()->json(['validated' => true, 'message' => 'Update successful!'], 200);
    }

    public function resendRegistrationLink(Request $request) {
        Mail::to('charlesbautista70@yahoo.com')
            ->send(new EmailVerification('University Of The Philippines', 'charlesbautista70@yahoo.com', '8df89bb2dc9484271d8ea265dfa7cbf6a9d72928bcac1c2c979ab554191e4394'));

    }

   


}