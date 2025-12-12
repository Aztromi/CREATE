<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

use App\Models\Country;
use App\Models\Guest;

use App\Mail\ConnectCreativeRequest;

use Auth;

class ConnectCreativeController extends Controller
{
    public function addForm() {


        switch($this->checkRequestorType()) {
            case 1:
                return redirect()->route('admin.connect-creative.adminAdd');
                break;
            case 2:
                return redirect()->route('user.connect-creative.memberAdd');
                break;
            case 3:
                return view('website.connect-creatives.form', ['options' => $this->getFieldOptions(3)]);
                break;
        }
        
    }

    private function checkRequestorType() {
        if(Auth::check() && Auth::user()->isAdmin()) {
            return 1;
        } else if(Auth::check() && (Auth::user()->isMember() || Auth::user()->isCreative())) {
            return 2;
            
        } else {
            return 3;
        }
    }

    protected function getFieldOptions($user_type) {

        switch($user_type) {
            case 1:
                // ADMIN
                $cancel_link = route('admin.index');
                $guest = false;
                break;
            case 2:
                // CREATIVE
                $cancel_link = route('user.index');
                $guest = false;
                break;
            case 3:
                // GUEST
                $cancel_link = route('home');
                $guest = true;
                break;
        }

        $countries = Country::select('name')->orderByRaw("name = 'Philippines' DESC")->orderBy('name')->get();

        $action_link = route('connect-creative.submit');

        $looking_for = [
            'A Creative individual or freelancer to collaborate with',
            'A Creative individual or freelancer to commission or hire for their services',
            'A Creative company or agency to commission or hire for their services',
            'Product/s to buy from a Creative',
            'More Creatives to discover'
        ];

        $professional_types = [
            'Graphic Designer or Illustrator',
            'Photographer and/or Videographer',
            'Visual Artist (e.g., Painter, Sculptor)',
            'Animator or Motion Graphics Artist',
            'Video Editor',
            'Art Director',
            'Fashion Designer and/or Textile Designer',
            'Product/Industrial Designer',
            'Interior Designer',
            'Content Creator',
            'Copywriter',
            'UX/UI Designer',
            'Game Artist and/or Game Developer',
            'Writer / Creative Writer / Scripwriter / Screenwriter',
            'Editor (Publishing)',
            'Web Designer or Developer',
            'Performing Artist (e.g., Musician, Dancer, Actor, Voice Actor)',
            'Theater Director/Playwright',
            'Choreographer',
            'Musician/Composer',
            'Event Planner or Production Manager',
            'Curator'
        ];

        $project_goals = [
            'Promote a business, product, or service',
            'Content Creation & Marketing',
            'Create a personal or artistic piece',
            'Creative Production',
            'Organize an event or performance',
            'Build a digital presence (e.g., social media, website)',
            'Decorate a space with creative works (e.g., murals, installations)'
        ];

        $budget_range = [
            'Below ₱10,000',
            '₱10,000–₱50,000',
            '₱50,000–₱100,000',
            'Over ₱100,000',
            'I’m not sure yet',
            'Not Applicable',
            'Prefer Not to Say'
        ];

        $options = (object) [
            'looking_for' => $looking_for,
            'professional_types' => $professional_types,
            'project_goals' => $project_goals,
            'budget_range' => $budget_range,
            'cancel_link' => $cancel_link,
            'countries' => $countries,
            'guest' => $guest,
            'action_link' => $action_link
        ];

        return $options;

    }

    public function validateAndSaveRequest(Request $request) {
        if ($response = $this->validateRequestForm($request)) {
            return $response;
        }




        try {
            return DB::transaction(function() use ($request) {

                $recipient_email = '';

                if($this->checkRequestorType() == 3) {
                    $user = Guest::create([
                        'name' => $request->input('name'),
                        'company_name' => $request->input('company_name'),
                        'company_email' => $request->input('company_email'),
                        'country' => $request->input('country'),
                        'company_address' => $request->input('company_address')
                    ]);

                    $recipient_email = $user->company_email;

                    $url_redirect = route('home');
                }
                else {
                    $user = Auth::user();

                    if($this->checkRequestorType() == 1) {
                        $url_redirect = route('admin.index');
                    } else if($this->checkRequestorType() == 2) {
                        $url_redirect = route('user.index');
                    } else {
                        $url_redirect = route('home');
                    }

                    $recipient_email = $user->email;
                }

                $microTime = microtime(true);
                $hash = "ccreq" . substr(md5($microTime), 0, 16);

                $request_creative = $user->cc_requests()->create([
                    'custom_id' => $hash,
                    'looking_for' => trim($request->input('looking_for')),
                    'budget_range' => trim($request->input('budget_range')),
                    'other_requirements' => trim($request->input('other_requirements')),
                    'other_exp' => trim($request->input('other_exp')),
                    'status' => 0
                ]);

                foreach($request->input('professional_types') as $key => $value) {
                    $request_creative->professionals()->create([
                        'value' => $value,
                    ]);
                }

                foreach($request->input('project_goals') as $key => $value) {
                    $request_creative->goals()->create([
                        'value' => $value,
                    ]);
                }

                Mail::to('nogidlayan.citem@gmail.com')
                    ->send(new ConnectCreativeRequest($recipient_email));

                return response()->json(['validated' => true, 'urlRedirect' => $url_redirect], 200);
            });
        }
        catch (Throwable $e) {
            \Log::error('Request failed: ' . $e->getMessage());

            return response()->json([
                'validated' => false
            ], 500);

        }
    }


    private function validateRequestForm($request){
        $rules = [
            
            'looking_for' => 'required|string',
            'professional_types' => 'required|array',
            'project_goals' => 'required|array',
            'budget_range' => 'required|string',
            'other_requirements' => 'required|string|max:200',
            'other_exp' => 'required|string|max:200',
        ];

        $messages = [
            'looking_for.required' => 'Please select one.',
            'looking_for.string' => 'Only text values are allowed. ',

            'professional_types.required' => 'Please select at least one.',
            'professional_types.array' => 'The category entries must be submitted as an array.',

            'project_goals.required' => 'Please select at least one.',
            'project_goals.array' => 'The category entries must be submitted as an array.',

            'budget_range.required' => 'Please select one.',
            'budget_range.string' => 'Only text values are allowed. ',

            'other_requirements.required' => 'Required field. ',
            'other_requirements.string' => 'Only text values are allowed. ',
            'other_requirements.max' => 'Value has exceeded the limit. ',

            'other_exp.required' => 'Required field. ',
            'other_exp.string' => 'Only text values are allowed. ',
            'other_exp.max' => 'Value has exceeded the limit. ',
        ];

        if($this->checkRequestorType() == 3){
            $rules['name'] = 'required|string|max:150';
            $rules['company_name'] = 'required|string|max:150';
            $rules['company_email'] = 'required|email|max:150';
            $rules['country'] = 'required|exists:countries,name';
            $rules['company_address'] = 'required|string|max:200';

            $messages += [
                'name.required' => 'Required field. ',
                'name.string' => 'Only text values are allowed. ',
                'name.max' => 'Value has exceeded the limit. ',

                'company_name.required' => 'Required field. ',
                'company_name.string' => 'Only text values are allowed. ',
                'company_name.max' => 'Value has exceeded the limit. ',

                'company_email.required' => 'Alternate E-mail is required.',
                'company_email.email' => 'Please enter a valid alternate email address.',
                'company_email.max' => 'Value has exceeded the limit.',

                'country.required' => 'The country field is required.',
                'country.exists' => 'The selected country is invalid.',

                'company_address.required' => 'Required field. ',
                'company_address.string' => 'Only text values are allowed. ',
                'company_address.max' => 'Value has exceeded the limit. ',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

        return null;
    }
}
