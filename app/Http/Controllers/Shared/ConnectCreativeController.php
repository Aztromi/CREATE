<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\CCRequest;
use App\Models\UProfile;
use App\Models\User;

use App\Mail\ConnectCreativeRecommendWithCreative;
use App\Mail\ConnectCreativeRecommendWithoutCreative;

use App\Http\Controllers\FrontEnd\ConnectCreativeController as BaseController;

class ConnectCreativeController extends BaseController
{
    public function addFormAdmin() {
        return view('admin.connect-creatives.form', ['options' => $this->getFieldOptions(1)]);
    }

    public function list() {
        
        $datas = CCRequest::latest()
            ->with('user.profile', 'guest')
            ->get();
            
        $requests = [];
        
        if($datas){
            foreach ($datas as $data) {
                $requests[] = (object) [
                    'id' => $data->id,
                    'name' => $data->userName,
                    'type' => $data->userType,
                    'status' => $data->status,
                    'statusText' => $data->statusText,
                    'date_requested' => $data->created_at
                ];
            }
        }
        
        return view('admin.connect-creatives.list', ['requests' => $requests]);
    }

    public function response($id = null) {
        
        $request = CCRequest::with('user.profile', 'guest', 'goals', 'professionals', 'responses')
            ->findOrFail($id);

        $base_details = [
            'id' => $request->id,
            'name' => $request->userName,
            'type' => $request->userType,
            'status' => $request->status,
            'statusText' => $request->statusText,
            'date_requested' => $request->created_at,

            'looking_for' => $request->looking_for,
            'budget_range' => $request->budget_range,
            'other_requirements' => $request->other_requirements,
            'other_exp' => $request->other_exp,

            'goals' => $request->goals,
            'professionals' => $request->professionals,
            'responses' => $request->responses,
            'cancel_link' => route('admin.connect-creative.list'),
        ];

        if($request->guest){
            $extra_details = [
                'company_name' => $request->guest->company_name,
                'email' => $request->guest->company_email,
                'country' => $request->guest->country,
                'address' => $request->guest->company_address,
            ];
        } else {
            $extra_details = [
                'company_name' => '',
                'email' => $request->user->email,
                'country' => '',
                'address' => '',
            ];
        }

        $request_details = (object) array_merge($base_details, $extra_details);
        
        return view('admin.connect-creatives.response', ['details'=> $request_details]);
    }

    public function addFormMember() {
        return view('dashboard.content.connect-creatives.form', ['options' => $this->getFieldOptions(2)]);
    }

    public function getCreatives(Request $request) {

        $sub_categories = $request->input('cats');
        $selects = $request->input('selects');

        if (!empty($sub_categories)) {
            $newCategories = array_map(function($cat) {
                $parts = explode('||', $cat, 2);
                return $parts[1] ?? null;
            }, $sub_categories);

            // clean up nulls
            $newCategories = array_filter($newCategories);

            $sub_categories = $newCategories;
        } else {
            $sub_categories = null;
        }

        $creatives = User::approvedVerifiedUnverified()
            ->has('profile')
            ->whereHas('profile', function($query) use ($sub_categories, $selects){

                if($sub_categories) {
                    $query->whereHas('sectors', function($query4) use ($sub_categories){
                        $query4->whereIn('value', $sub_categories);
                    });
                }

                if($selects) {
                    $query->whereNotIn('id', $selects);
                }
            })
            ->with(['profile'])
            ->get()
            ->filter(fn($c) => $c->profile)
            ->map(function($c){
                return [
                    'c_id' => $c->profile->id,
                    'name' => $c->profile->dispName ?? '',
                    'verified' => $c->verified == 1 ? 'Verified' : ($c->verified == 0 ? 'Unverified' : '')
                ];
            })
            ->sortBy('name')
            ->values();
            
            return response()->json(['validated' => true, 'creatives' => $creatives]);
    }

    public function saveRecommendation(Request $request) {
        $id = $request->input('id');
        $selects = $request->input('selects');
        $request_status = 0;


        // $request = CCRequest::findOrFail($id);
        $request = CCRequest::with('user.profile', 'guest', 'goals', 'professionals', 'responses')
            ->findOrFail($id);
        
        if(!empty($selects)) {
            $response = $request->responses()->create([
                'send_type' => 1, //with recommendations
                'status' => 0,
            ]);

            $data = collect($selects)->map(fn($id) => [
                'value' => $id
            ])->toArray();

            $response->creatives()->createMany($data);

            $request_status = 1;
        } else {
            $response = $request->responses()->create([
                'send_type' => 0, //No recommendations
                'status' => 0,
            ]);

            $request_status = 2;
        }
        
        $requester_name = $request->userName;
        $looking_for = $request->looking_for;
        $professional_types = $request->professionals;
        $goals = $request->goals;

        if($request->guest){
            $requester_email = $request->guest->company_email;
        } else {
            $requester_email = $request->user->email;
        }
        
        if( $request_status == 1) { // Mail with Recommendations


            Mail::to($requester_email)
                    ->send(new ConnectCreativeRecommendWithCreative($requester_name, $looking_for, $professional_types, $goals, $response->creatives));

        } elseif( $request_status == 2) { // Mail without Recommendations
            Mail::to($requester_email)
                    ->send(new ConnectCreativeRecommendWithoutCreative($requester_name, $looking_for, $professional_types, $goals));

        }


        $response->update([
            'status' => 1
        ]);

        $request->update([
            'status'=> $request_status
        ]);

        return response()->json(['validated' => true, 'urlRedirect' => route('admin.connect-creative.list')]);
    }

    public function getProfile(Request $request) {
        $id = $request->input('id');

        $profileData = UProfile::with('user', 'latestSlug', 'uindie.expertises', 'addressLatest', 'emails', 'websites', 'socials', 'jobTitleLatest', 'emails', 'sectors', 'bookmarks')
            ->where('id', $id)
            ->whereHas('user', function($query){
                $query->approvedVerifiedUnverified();
            })
            ->first();

        return response()->json(['validated' => true, 'profile'=> $profileData]);
    }
    
}
