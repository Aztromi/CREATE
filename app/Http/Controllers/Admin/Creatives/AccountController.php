<?php

namespace App\Http\Controllers\Admin\Creatives;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Country;
use App\Models\SectorList;
use App\Models\UAward;
use App\Models\UJobTitle;
use App\Models\UProfile;

use Auth;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function showEditForm($id = null)
    {
        // $profile = UProfile::where('user_id', $id)->first();

        // if(!$profile){
        //     return redirect()->route('admin.application-requests');
        // }

        // return view('admin.registered-users.member-details')
        //     ->with('displayType', 'creative')
        //     ->with(compact('profile', $profile))
        //     ->with('sectors', $sectors)
        //     ->with('countries', $countries);

        if(!Auth::check()){
            return redirect()->route('login');
        }

        if(Auth::user()->isAdminOG()){
            $uID = $id;
        }
        else{
            $uID = Auth::user()->id;
        }

        $profile = UProfile::where('user_id', $uID)->first();

        // if(!$profile || !$profile->uindie){
        //     abort(401);
        // }

        $p_images = $profile->uindie()->select('display_photo', 'cover_photo')->first();

        if(Auth::user()->isAdminOG()){
            $uState = $profile->user()->select('verified', 'approved', 'requests', 'email_verified_at')->first();
        }
        else{
            $uState = null;
        }
        
        return view('admin.registered-users.member-details')
            ->with('p_images', $p_images)
            ->with('displayType', 'creative')
            ->with('uID', $uID)
            ->with('uState', $uState);


    }

    
}
