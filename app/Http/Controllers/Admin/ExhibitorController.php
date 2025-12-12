<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\SectorList;
use App\Models\UProfile;

class ExhibitorController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.exhibitors.list');
    }

    public function list()
    {
        return view('admin.exhibitor.list');
    }

    public function getExhibitorList(Request $request)
    {
        $profile = UProfile::has('attendanceLatest')->with(['attendanceLatest', 'user:id'])->orderBy('created_at', 'desc')->get();

        
        return response()->json(['validated' => true, 'profile' => $profile], 200);
    }

    public function showProfileForm($id = null)
    {
        if($id == null)
        {
            return redirect()->route('admin.exhibitors.list');
        }

        

        // $profile = UProfile::has('attendanceLatest')->with([
        //         'attendanceLatest:id,status',
        //         'user:id,requests,approved,verified'
        //     ])
        //     ->where('id', $id)->first();

        $profile = UProfile::has('attendanceLatest')
            ->where('user_id', $id)->first();

        if($profile)
        {
            // $countries = Country::orderByRaw("name = 'Philippines' DESC")->orderBy('name')->get();

            // $sectors = SectorList::where('status','Active')->orderBy('category', 'asc')->orderBy('value', 'asc')->get();

            return view('admin.registered-users.member-details')
                ->with('displayType', 'exhibitor')
                ->with('uID', $profile->user_id);
                // ->with(compact('profile', $profile))
                // ->with('sectors', $sectors)
                // ->with('countries', $countries)
                ;
        }
        else
        {
            return redirect()->route('admin.exhibitors.list');
        }
    }

    public function statusChange(Request $request)
    {

        $profile = UProfile::has('attendanceLatest')->with('attendanceLatest')->where('user_id', $request->input('uID'))->first();
        
        if(!$profile->attendanceLatest)
        {
            return response()->json(['validated' => false], 200);
        }

        $profile->attendanceLatest->status = $request->input('newStatus');
        $profile->attendanceLatest->update();

        return response()->json(['validated' => true], 200);

    }
}
