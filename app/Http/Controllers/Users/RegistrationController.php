<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\UProfile;
use App\Models\UIndie;
use App\Models\UEmail;
use App\Models\UNumContact;

use App\Models\SectorList;
use App\Models\Sector;

use App\Models\Country;
use App\Models\PHAddress;
use App\Models\UAddress;
use App\Models\UJobTitle;

use App\Mail\RegistrationSubmission;

use App\Models\UploadedRequirement;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Auth;

class RegistrationController extends Controller
{
    private $validRegTypes;

    public function __construct()
    {
        $this->validRegTypes = explode(',', config('app.valid_reg_types'));
    }

    private function checkRegType($prType)
    {
        if(!Auth::check() || is_null($prType) || !in_array($prType, $this->validRegTypes))
        {
            return redirect()->route('user.register.type');
        }

        return null;
    }

    public function showMemberWelcome()
    {
        if(Auth::check() && Auth::user()->verified == -1)
        {
            return view('messages.memberWelcome');
        }
        else{
            abort(401);
        }
    }

    public function showAccountUpdate()
    {
        if(Auth::check() && Auth::user()->verified == -1)
        {
            $profile = UProfile::where('user_id', Auth::user()->id)->first();
            if($profile && $profile->has_profile_reminder == 1)
            {
                return view('messages.accountUpdate');
            }
            else
            {
                abort(401);
            }
            
        }
        else{
            abort(401);
        }
    }

    private function halfPaneStory()
    {
        return User::with('profile')->has('homeStoryLatest')->inRandomOrder()->first();
    }

    public function showStepEventForm()
    {
        $story = $this->halfPaneStory();

        return view('register.step-event')
            ->with('story', $story);
    }

    public function showStep2Form($type = null)
    {

        $redirect = $this->checkRegType($type);
        if($redirect)
        {
            return $redirect;
        }
        

        // if(auth::check() && Auth::user()->verified == -1)
        if(Auth::user()->isMember())
        {
            // $countries = Country::orderByRaw("name = 'Philippines' DESC")->orderBy('name')->get();
            // $user = User::with('profile.emails','profile.numContacts','profile.numContactTypes','profile.uindie','profile.addressLatest','profile.jobTitleFirst')
            $user = User::with('profile.emails','profile.numContacts','profile.numContactTypes', 'profile.addressLatest')
                ->find(Auth::user()->id);

            $story = $this->halfPaneStory();

            return view('register.step-2')
                // ->with('countries', $countries)
                ->with('user', $user)
                ->with('story', $story)
                ->with('reg_type', $type);

        }
        else
        {
            abort(401);
        }
    }

    public function step2Validate(Request $request)
    {
        if(!Auth::check())
        {
            abort(401);
        }
        
        $rules = [
            'fname' => 'required|string|max:200',
            'lname' => 'required|string|max:200',
            'gender' => 'required|string|max:50',
            'mobile' => 'required|numeric|digits_between:7,15',
            'country' => 'required|exists:countries,name',

            // PULLED
            // 'rep' => 'required|string|max:200',
            // 'dispName' => 'required|string|max:100',
            
            
        ];

        $messages = [
            'fname.required' => 'Please add your Firstname. ',
            'fname.string' => 'Only text values are allowed. ',
            'fname.max' => 'Value has exceeded the limit. ',

            'lname.required' => 'Please add your Lastname. ',
            'lname.string' => 'Only text values are allowed. ',
            'lname.max' => 'Value has exceeded the limit. ',

            'gender.required' => 'Required field. ',
            'gender.string' => 'Only text values are allowed. ',
            'gender.max' => 'Value has exceeded the limit. ',
            
            'mobile.required' => 'The mobile field is required.',
            'mobile.numeric' => 'The mobile field must be a numeric value.',
            'mobile.digits_between' => 'The mobile field must be between 7 and 15 digits.',

            'country.required' => 'The country field is required.',
            'country.exists' => 'The selected country is invalid.',

            // PULLED
            // 'rep.required' => 'Please select one. ',
            // 'rep.string' => 'Only text values are allowed. ',
            // 'rep.max' => 'Value has exceeded the limit. ',

            // 'dispName.required' => 'Please select one. ',
            // 'dispName.string' => 'Only text values are allowed. ',
            // 'dispName.max' => 'Value has exceeded the limit. ',
        ];

        if(strlen(trim($request->input('email-alternate'))) > 0)
        {
            $rules['email-alternate'] = 'required|email|max:150|unique:users,email';
            // $rules['email-alternate'] = 'required|email|max:150|unique:users,email|unique:u_emails,value';
            $messages += [
                'email-alternate.required' => 'Alternate E-mail is required.',
                'email-alternate.email' => 'Please enter a valid alternate email address.',
                'email-alternate.max' => 'The length of Alternate E-mail must not exceed 150 characters.',
                'email-alternate.unique' => 'The Alternate E-mail is already in use.',
            ];
        }


        if(strlen(trim($request->input('mobile-alternate'))) > 0)
        {
            $rules['mobile-alternate'] = 'required|numeric|digits_between:7,15';
            $messages += [
                'mobile-alternate.required' => 'The mobile field is required.',
                'mobile-alternate.numeric' => 'The mobile field must be a numeric value.',
                'mobile-alternate.digits_between' => 'The mobile field must be between 7 and 15 digits.',
            ];
        }


        if(strlen(trim($request->input('telephone'))) > 0)
        {
            $rules['telephone'] = 'required|numeric|digits_between:7,15';
            $messages += [
                'telephone.required' => 'The mobile field is required.',
                'telephone.numeric' => 'The mobile field must be a numeric value.',
                'telephone.digits_between' => 'The mobile field must be between 7 and 15 digits.',
            ];
        }


        if(strlen(trim($request->input('m_text'))) > 0)
        {
            $rules['m_text'] = 'required|string|max:100';
            $messages += [
                'm_text.required' => 'Please add a value. ',
                'm_text.string' => 'Only text values are allowed. ',
                'm_text.max' => 'Value has exceeded the limit. ',
            ];
        }

        if(strlen(trim($request->input('country'))) > 0)
        {
            if(trim($request->input('country')) == 'Philippines')
            {
                $rules['regionM'] = 'required|exists:zipcodecurrent,region';
                $rules['provinceM'] = 'required|exists:zipcodecurrent,province';
                $rules['cityM'] = 'required|exists:zipcodecurrent,city_town';

                $messages += [
                    'regionM.required' => 'The region field is required.',
                    'regionM.exists' => 'The selected region is invalid.',

                    'provinceM.required' => 'The province field is required.',
                    'provinceM.exists' => 'The selected province is invalid.',

                    'cityM.required' => 'The city field is required.',
                    'cityM.exists' => 'The selected city is invalid.',
                ];
            }
            else
            {
                $rules['regionI'] = 'required|max:200';
                $rules['cityI'] = 'required|max:200';

                $messages += [
                    'regionI.required' => 'The region field is required.',
                    'regionI.max' => 'Value has exceeded the limit. ',

                    'cityI.required' => 'The city field is required.',
                    'cityI.max' => 'Value has exceeded the limit. ',
                ];

            }
        }
        

        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return with error messages
        if ($validator->fails()) {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
            // return redirect()->back()
            //     ->withErrors($validator)
            //     ->withInput();
        }
        

        $userID = Auth::user()->id;

        $profile = UProfile::whereHas('user', function($query) use ($userID){
                $query->where('id', $userID);
            })->first();

        if(!$profile)
        {
            abort(401);
        }
        
        $profile->update([
            'first_name' => ucwords(trim($request->input('fname'))) ,
            'last_name' => ucwords(trim($request->input('lname'))) ,
            'gender' => trim($request->input('gender')) ,

            // PULLED
            // 'company_name' => $companyAdd,
            // 'display_name' => $displayName,
            // 'other_name' => $otherName,
            
        ]);
        
        $profile->user()->update([
            'name' => ucwords(trim($request->input('fname'))) . ' ' . ucwords(trim($request->input('lname'))),
        ]);
        
        // Alternate E-mail
        $profile->emails()->where('value', '!=', $profile->user->email)->delete();
        if(strlen(trim($request->input('email-alternate'))) > 0)
        {
            if($profile->emails->count() > 0)
            {
                $profile->emails()->create([
                    'value' => trim($request->input('email-alternate')),
                ]);
            }
        }
        // END Alternate E-mail


        // Contacts
            if($profile->numContacts->count() > 0)
            {
                $profile->numContacts()->delete();
            }

            $countryCode = Country::select('dial')->where('name', $request->input('country'))->first();

            $tempData = [];

            $tempData[] = ['number' => trim($request->input('mobile')), 'type' => 'primary', 'country_code' => '+' . $countryCode->dial];

            if(strlen(trim($request->input('mobile-alternate'))) > 0)
            {
                $tempData[] = ['number' => trim($request->input('mobile-alternate')), 'type' => 'alternate', 'country_code' => '+' . $countryCode->dial];
            }

            if(strlen(trim($request->input('telephone'))) > 0)
            {
                $tempData[] = ['number' => trim($request->input('telephone')), 'type' => 'landline', 'country_code' => '+' . $countryCode->dial];
            }

            if(!empty($tempData))
            {
                $profile->numContacts()->createMany($tempData);
            }
        // END Contacts


        // Contact Types
            if($profile->numContactTypes->count() > 0)
            {
                $profile->numContactTypes()->delete();
            }

            if($request->has('m_viber'))
            {
                $profile->numContactTypes()->create([
                    'value' => 'Viber',
                    'type' => 'primary',
                ]);
            }

            if($request->has('m_whatsapp'))
            {
                $profile->numContactTypes()->create([
                    'value' => 'Whatsapp',
                    'type' => 'primary',
                ]);
            }
                
            if(strlen(trim($request->input('m_text'))) > 0)
            {
                $profile->numContactTypes()->create([
                    'value' => trim($request->input('m_text')),
                    'type' => 'other',
                ]);
            }
        // END Contact Types

        

        // Country Address

            $region = '';
            $province = '';
            $city = '';
            $addr1 = '';
            $zip = '';

            if(trim($request->input('country')) == 'Philippines')
            {
                $region = trim($request->input('regionM'));
                $province = trim($request->input('provinceM'));
                $city = trim($request->input('cityM'));
                $addr1 = trim($request->input('addr1'));
                $zip = trim($request->input('zip'));
            }
            else
            {
                $region = trim($request->input('regionI'));
                $city = trim($request->input('cityI'));
                $addr1 = trim($request->input('addr1'));
                $zip = trim($request->input('zip'));
            }


            if($profile->address->count() > 0)
            {
                $profile->address()->delete();
            }

            $profile->address()->updateOrCreate([],[
                'country' => $request->input('country'),
                'region' => $region,
                'province' => $province,
                'municipality' => $city,
                'block_lot' => $addr1,
                'postal_code' => $zip,
            ]);
        // END Country
        
        $profile->user->registrationLogs()->create([
            'step' => '2',
            'ip' => $request->ip()
        ]);


        return response()->json(['validated' => true, 'URLRedirect' => route('user.register.step-three', ['type' => $request->input('reg_type')])], 200);
        // return redirect()->back()->with('success', 'Changes Saved successfully');
        // return redirect()->route('user.register.step-three');

    }

    public function showStep3Form($type = null)
    {
        $redirect = $this->checkRegType($type);
        if($redirect)
        {
            return $redirect;
        }

        if(Auth::user()->isMember())
        {
            // $sectors = SectorList::select('id', 'value', 'category')->where('status', 'Active')->orderBy('category','asc')->orderBy('value','asc')->get();

            // $sectorsData = [];

            // foreach($sectors as $sector)
            // {
            //     $category = $sector->category;
            //     $value = $sector->value;

            //     if(!isset($sectorsData[$category]))
            //     {
            //         $sectorsData[$category] = [];
            //     }

            //     $sectorsData[$category][] = $value;
            // }

            

            $story = $this->halfPaneStory();

            return view('register.step-3')
                // ->with('sectorsData', $sectorsData)
                ->with('story', $story)
                // ->with('profile', $profile)
                ->with('reg_type', $type);
        }
        else
        {
            abort(401);
        }

        
        
    }

    public function getStep3Data(Request $request)
    {
        $profile = UProfile::with('jobTitles','uindie', 'company.addressLatest', 'company.numContacts')
            ->where('user_id', Auth::user()->id)->first();

        return response()->json($profile, 200);
    }

    public function step3Validate(Request $request)
    {   
        if(!auth::check())
        {
            return response()->json(['error' => 'Unauthenticated', 'urlRedirect' => route('login')], 401);
        }

        $profile = UProfile::where('user_id', Auth::user()->id)->first();

        $rules = [
            'rep' => 'required|string|max:250',
            'dispName' => 'required|string|max:100',
        ];

        $messages = [
            'rep.required' => 'Please select one. ',
            'rep.string' => 'Only text values are allowed. ',
            'rep.max' => 'Value has exceeded the limit. ',
            
            'dispName.required' => 'Please select one. ',
            'dispName.string' => 'Only text values are allowed. ',
            'dispName.max' => 'Value has exceeded the limit. ',
        ];

        if(trim($request->input('rep')) != '' && trim($request->input('rep')) != 'Individual / Independent / Freelance / Student')
        {
            $rules['org'] = 'required|string|max:150';
            
            $rules['jobsArr'] = 'required|json|min:1';
            $rules['jobsArr.*'] = 'required|string|max:150';

            $rules['co_size'] = 'required|string|max:50';
            $rules['co_direct'] = 'required|numeric';
            $rules['co_indirect'] = 'required|numeric';

            $rules['rep_fname'] = 'required|string|max:200';
            $rules['rep_lname'] = 'required|string|max:200';
            $rules['rep_gender'] = 'required|string|max:50';
            $rules['rep_mobile'] = 'required|numeric|digits_between:7,15';
            $rules['rep_email'] = 'required|email|max:150';
            
            $messages += [
                'org.required' => 'Please enter your current Company / Academe / Association / Group / Agency. ',
                'org.string' => 'Only text values are allowed. ',
                'org.max' => 'Value has exceeded the limit. ',

                'jobsArr.required' => 'At least one job title/designation is required.',
                'jobsArr.json' => 'Invalid Input.',
                'jobsArr.min' => 'At least one job title/designation is required.',
                'jobsArr.*.string' => 'Each item in the job title/designation must be a string.',
                'jobsArr.*.max' => 'Each job title/designation must not exceed 150 characters.',

                'co_size.required' => 'Required field. ',
                'co_size.string' => 'Only text values are allowed. ',
                'co_size.max' => 'Value has exceeded the limit. ',
                
                'co_direct.required' => 'Required field.',
                'co_direct.numeric' => 'Must be a numeric value.',
                'co_direct.max' => 'Value has exceeded the limit. ',

                'co_indirect.required' => 'Required field.',
                'co_indirect.numeric' => 'Must be a numeric value.',
                'co_indirect.max' => 'Value has exceeded the limit. ',

                'rep_fname.required' => 'Please add the irstname. ',
                'rep_fname.string' => 'Only text values are allowed. ',
                'rep_fname.max' => 'Value has exceeded the limit. ',

                'rep_lname.required' => 'Please add the Lastname. ',
                'rep_lname.string' => 'Only text values are allowed. ',
                'rep_lname.max' => 'Value has exceeded the limit. ',

                'rep_gender.required' => 'Required field. ',
                'rep_gender.string' => 'Only text values are allowed. ',
                'rep_gender.max' => 'Value has exceeded the limit. ',

                'rep_mobile.required' => 'The mobile number field is required.',
                'rep_mobile.numeric' => 'The mobile field must be a numeric value.',
                'rep_mobile.digits_between' => 'The mobile number field must be between 7 and 15 digits.',

                'rep_email.required' => 'E-mail is required.',
                'rep_email.email' => 'Please enter a valid e-mail address.',
                'rep_email.max' => 'The length of E-mail must not exceed 150 characters.',
            ];

            if(!$request->has('same_rep_owner'))
            {
                $rules['owner_fname'] = 'required|string|max:200';
                $rules['owner_lname'] = 'required|string|max:200';
                $rules['owner_gender'] = 'required|string|max:50';
                $rules['owner_email'] = 'required|email|max:150';
                // $rules['owner_mobile'] = 'required|numeric|digits_between:7,15';
                
                $messages += [
                    'owner_fname.required' => 'Please add the firstname. ',
                    'owner_fname.string' => 'Only text values are allowed. ',
                    'owner_fname.max' => 'Value has exceeded the limit. ',

                    'owner_lname.required' => 'Please add the Lastname. ',
                    'owner_lname.string' => 'Only text values are allowed. ',
                    'owner_lname.max' => 'Value has exceeded the limit. ',

                    'owner_gender.required' => 'Required field. ',
                    'owner_gender.string' => 'Only text values are allowed. ',
                    'owner_gender.max' => 'Value has exceeded the limit. ',

                    'owner_email.required' => 'E-mail is required.',
                    'owner_email.email' => 'Please enter a valid e-mail address.',
                    'owner_email.max' => 'The length of E-mail must not exceed 150 characters.',

                    // 'owner_mobile.required' => 'The mobile number field is required.',
                    // 'owner_mobile.numeric' => 'The mobile field must be a numeric value.',
                    // 'owner_mobile.digits_between' => 'The mobile number field must be between 7 and 15 digits.',
                ];

            }

            if(trim($request->input('co_country')) == 'Philippines')
            {
                $rules['co_regionM'] = 'required|string|max:150';
                $messages += [
                    'co_regionM.required' => 'Please select one. ',
                    'co_regionM.string' => 'Only text values are allowed. ',
                    'co_regionM.max' => 'Value has exceeded the limit. ',
                ];

                $rules['co_provinceM'] = 'required|string|max:150';
                $messages += [
                    'co_provinceM.required' => 'Please select one. ',
                    'co_provinceM.string' => 'Only text values are allowed. ',
                    'co_provinceM.max' => 'Value has exceeded the limit. ',
                ];

                $rules['co_cityM'] = 'required|string|max:150';
                $messages += [
                    'co_cityM.required' => 'Please select one. ',
                    'co_cityM.string' => 'Only text values are allowed. ',
                    'co_cityM.max' => 'Value has exceeded the limit. ',
                ];
            }
            else
            {
                $rules['co_regionI'] = 'required|string|max:150';
                $messages += [
                    'co_regionI.required' => 'Required Field. ',
                    'co_regionI.string' => 'Only text values are allowed. ',
                    'co_regionI.max' => 'Value has exceeded the limit. ',
                ];

                $rules['co_cityI'] = 'required|string|max:150';
                $messages += [
                    'co_cityI.required' => 'Required Field. ',
                    'co_cityI.string' => 'Only text values are allowed. ',
                    'co_cityI.max' => 'Value has exceeded the limit. ',
                ];
            }

        }

        


        if($request->input('dispName') == 'other_name')
        {
            $rules['name-other'] = 'required|string|max:150';
            $messages += [
                'name-other.required' => 'Please add your preferred Display Name. ',
                'name-other.string' => 'Only text values are allowed. ',
                'name-other.max' => 'Value has exceeded the limit. ',
            ];
        }


        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return with error messages
        if ($validator->fails()) {
            // return redirect()->back()
            //     ->withErrors($validator)
            //     ->withInput();
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }
        

        // Display Name
        $displayName = trim($request->input('dispName'));
        $otherName = '';
        if($request->input('dispName') == 'other_name')
        {
            $otherName = trim($request->input('name-other'));
        }
        // END Display Name
        

        $profile->update([
            'display_name' => $displayName,
            'other_name' => $otherName,
        ]);

        if($profile->uindie)
        {
            $profile->uindie->update([
                'expertise' => trim($request->input('rep')),
            ]);
        }
        else
        {
            $profile->uindie()->create([
                'type' => 'individual',
                'expertise' => trim($request->input('rep')),
            ]);
        }
        // $profile->uindie->updateOrCreate(['u_profile_id' => $profile->id], [
        //     'expertise' => trim($request->input('rep')),
        // ]);
        

        if($profile->jobTitles->count() > 0)
        {
            $profile->jobTitles()->delete();
        }

        if(trim($request->input('rep')) != '' && trim($request->input('rep')) != 'Individual / Independent / Freelance / Student')
        {
            // Company

                $companyAdd = '';
                if(strlen(trim($request->input('org'))) > 0 || $request->input('dispName') == 'company_name')
                {
                    $companyAdd = trim($request->input('org'));
                }

                $profile->update([
                    'company_name' => $companyAdd,
                ]);
                

                $company_data = [
                    'company_name' => $companyAdd,
                    'company_size' => $request->input("co_size"),
                    'company_direct_workers' => $request->input("co_direct"),
                    'company_indirect_workers' => $request->input("co_indirect"),
                    'rep_fname' => $request->input("rep_fname"),
                    'rep_lname' => $request->input("rep_lname"),
                    'rep_gender' => $request->input("rep_gender"),
                    'rep_email' => $request->input("rep_email"),
                    'rep_mobile' => $request->input("rep_mobile"),
                    
                ];

                if($request->has('same_rep_owner'))
                {
                    $company_data += [
                        'owner_fname' => $request->input("rep_fname"),
                        'owner_lname' => $request->input("rep_lname"),
                        'owner_gender' => $request->input("rep_gender"),
                        'owner_email' => $request->input("rep_email"),
                        'same_rep_owner' => 1,
                    ];
                }
                else
                {
                    $company_data += [
                        'owner_fname' => $request->input("owner_fname"),
                        'owner_lname' => $request->input("owner_lname"),
                        'owner_gender' => $request->input("owner_gender"),
                        'owner_email' => $request->input("owner_email"),
                        'same_rep_owner' => 0,
                    ];
                }


                $profile->company()->updateOrCreate([], $company_data);


            // END Company


            // CO_Country
                $co_region = '';
                $co_province = '';
                $co_city = '';

                if(trim($request->input('co_country')) == 'Philippines')
                {
                    if(strlen(trim($request->input('co_regionM'))) > 0)
                    {
                        $co_region = $request->input('co_regionM');
                    }
                    
                    if(strlen(trim($request->input('co_provinceM'))) > 0)
                    {
                        $co_province = $request->input('co_provinceM');
                    }
                    
                    if(strlen(trim($request->input('co_cityM'))) > 0)
                    {
                        $co_city = $request->input('co_cityM');
                    }
                }
                else
                {
                    if(strlen(trim($request->input('co_regionI'))) > 0)
                    {
                        $co_region = $request->input('co_regionI');
                    }
                    
                    if(strlen(trim($request->input('co_cityI'))) > 0)
                    {
                        $co_city = $request->input('co_cityI');
                    }

                }

                $profile->company->address()->updateOrCreate([],[
                    'country' => $request->input('co_country'),
                    'region' => $co_region,
                    'province' => $co_province,
                    'municipality' => $co_city,
                    'block_lot' => trim($request->input('co_addr1')),
                    'postal_code' => trim($request->input('co_zip')),
                ]);
            // END CO_Country

            // Jobs
                if ($request->has('jobsArr'))
                {
                    $data = $request->input('jobsArr');

                    if (!empty($data))
                    {   
                        $dataRows = json_decode($data, true);

                        foreach ($dataRows as $rowData)
                        {
                            $award = new UJobTitle([
                                'value' => $rowData,
                            ]);
                            
                            $profile->jobTitles()->save($award);
                        }
                    }
                }
            // END Jobs

        }
        else
        {
        //     if ($profile->company && $profile->company->address()->exists()) {
        //         $profile->company->address()->delete();
        //     }
        
            if ($profile->company()->exists()) {
                $profile->company()->delete();

                $profile->company_name = '';
                $profile()->update();
            }
        }

        $profile->user->registrationLogs()->create([
            'step' => '3',
            'ip' => $request->ip()
        ]);


        return response()->json(['validated' => true, 'URLRedirect' => route('user.register.step-four', ['type' => $request->input('reg_type')])], 200);
    }


    public function showStep4Form($type = null)
    {
        $redirect = $this->checkRegType($type);
        if($redirect)
        {
            return $redirect;
        }

        if(Auth::user()->isMember())
        {
            $story = $this->halfPaneStory();
            return view('register.step-4')
                ->with('story', $story)
                ->with('reg_type', $type);
        }
        else
        {
            abort(401);
        }
        
    }

    public function getStep4Data(Request $request)
    {
        $profile = UProfile::with('uindie.expertises')
            ->where('user_id', Auth::user()->id)->first();

        return response()->json($profile, 200);
    }

    public function step4Validate(Request $request)
    {


        if(!Auth::check())
        {
            return response()->json(['error' => 'Unauthenticated', 'urlRedirect' => route('login')], 401);
        }

        $profile = UProfile::where('user_id', Auth::user()->id)->first();

        // if(!isset($profile))
        // {
        //     abort(401);
        // }

        $rules = [
            'expertises' => 'required|array|min:1',
            'expertises.*' => 'string',

            'main-expertise' => 'required|string|max:250',
        ];

        $messages = [
            'expertises.required' => 'At least one interest is required.',
            'expertises.array' => 'The expertises must be an array.',
            'expertises.min' => 'At least one interest is required.',
            'expertises.*.string' => 'Each item in the expertises array must be a string.',

            'main-expertise.required' => 'Required field. ',
            'main-expertise.string' => 'Only text values are allowed. ',
            'main-expertise.max' => 'Value has exceeded the limit. ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return with error messages
        if ($validator->fails()) {
            // return redirect()->back()
            //     ->withErrors($validator)
            //     ->withInput();
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

        // Expertise
            if($profile->uindie->expertises->count() > 0)
            {
                $profile->uindie->expertises()->delete();
            }

            $expertises = [];

            foreach($request->input('expertises') as $expertise)
            {
                $vals = explode('|745|', $expertise);

                if(isset($vals[0], $vals[1], $vals[2]))
                {
                    $expertises[] = ['list_state' => $vals[0], 'category' => $vals[1], 'value' => $vals[2], 'type' => 'expertise'];
                }
            }

            $profile->uindie->expertises()->createMany($expertises);
        // END Expertise

        

        
        $vals = explode('|745|', $request->input('main-expertise'));

        if(isset($vals[0], $vals[1], $vals[2]))
        {
            $main_expertise = ['list_state' => $vals[0], 'category' => $vals[1], 'value' => $vals[2], 'type' => 'main'];
        }

        $profile->uindie->expertises()->create($main_expertise);

        $profile->user->registrationLogs()->create([
            'step' => '4',
            'ip' => $request->ip()
        ]);


        return response()->json(['validated' => true, 'URLRedirect' => route('user.register.upload-verified', ['type' => $request->input('reg_type')])], 200);

    }

    

    // public function processMemberOnly()
    // {
    //     if(Auth::check() && Auth::user()->isMember())
    //     {
    //         $userID = Auth::user()->id;
    //         $profile = UProfile::whereHas('user', function($query) use ($userID){
    //             $query->where('id', $userID);
    //         })->first();

    //         $profile->is_new = 0;
    //         $profile->save();

    //         return redirect()->route('home');
    //     } 
    //     else
    //     {
    //         abort(401);
    //     }
    // }


    // public function showUploadTypeForm()
    // {
    //     if(Auth::check() && Auth::user()->isMember())
    //     {
    //         $story = $this->halfPaneStory();
    //         return view('register.upload-type')
    //             ->with('story', $story);
    //     }
    //     else
    //     {
    //         abort(401);
    //     }
        
    // }


    // public function showUploadAltForm($type = null)
    // {
    //     if($type === null)
    //     {
    //         abort(401);
    //     }
    //     else
    //     {
    //         if(Auth::check() && Auth::user()->isMember())
    //         {
    //             $story = $this->halfPaneStory();
    //             return view('register.upload-alt')
    //                 ->with('type', $type)
    //                 ->with('story', $story);
    //         }
    //         else
    //         {
    //             abort(401);
    //         }
    //     }
    // }


    // public function showUploadLinkForm()
    // {
    //     if(Auth::check() && Auth::user()->isMember())
    //     {
    //         $story = $this->halfPaneStory();
    //         return view('register.upload-link')
    //             ->with('story', $story);
    //     }
    //     else
    //     {
    //         abort(401);
    //     }
        
    // }


    // public function processUploadLinkForm(Request $request)
    // {
    //     if(Auth::check() && Auth::user()->isMember())
    //     {
    //         $rules = [
    //             'drive-link' => 'string|max:255',
    //         ];
    
    //         $validator = Validator::make($request->all(), $rules);
    
    //         if ($validator->fails())
    //         {   
    //             return redirect()->route('user.register.upload-link');
    //         }

    //         $userID = Auth::user()->id;
    //         $profile = UProfile::whereHas('user', function($query) use ($userID){
    //             $query->where('id', $userID);
    //         })->first();
    //         $profile->upload_drive_link = $request->input('drive-link');
    //         $profile->is_new = 0;
    //         $profile->save();

    //         $this->citemEmailNotif(Auth::user()->email, 'link');
            

    //         return redirect()->route('user.register.submission-confirmed');
            
    //     }
    //     else
    //     {
    //         abort(401);
    //     }

    // }


    // public function showBasicUploadForm()
    // {
    //     if(auth::check() && Auth::user()->isMember())
    //     {
    //         $story = $this->halfPaneStory();
    //         return view('register.upload-basic')
    //             ->with('story', $story);
    //     }
    //     else
    //     {
    //         abort(401);
    //     }
    // }

    // public function processBasicUploadForm(Request $request)
    // {
    //     if(auth::check() && Auth::user()->isMember())
    //     {
    //         $validator = Validator::make($request->all(), 
    //             [
    //                 'files.*' => 'required|file|mimes:pdf,png,jpg,gif|max:20000', // Adjust max file size as needed (in kilobytes)
    //             ], 
    //             [
    //                 'files.*.required' => 'Please select at least one file. ',
    //                 'files.*.mimes' => 'Only PDF, PNG, GIF, and JPG files are allowed. ',
    //                 'files.*.max' => 'File size must not exceed 20 MB. ',
    //                 'files.*.file' => 'File not allowed. ',
    //             ]
    //         );

    //         // If validation fails, return with error messages
    //         if ($validator->fails()) {
    //             return redirect()->back()
    //                 ->withErrors($validator)
    //                 ->withInput();
    //         }

    //         $user = User::find(Auth::user()->id);
    //         $path = 'user_requirements/' . Auth::user()->id . '/requirements';
    //         if (!File::exists($path)) {
    //             // If not, create the folder
    //             File::makeDirectory($path, 0755, true, true);
    //         }

    //         // Process and store each uploaded file
    //         foreach ($request->file('files') as $file) {
    //             // Generate a unique filename using the original filename and a random string
    //             $originalFilename = $file->getClientOriginalName();
    //             $extension = $file->getClientOriginalExtension();
    //             $currentDate = now()->format('Ymd_His'); // Format: YearMonthDay_HourMinute
    //             $randomString = Str::random(12);
    //             $filename = $currentDate . '_portfolio_' . $randomString . '.' . $extension;

    //             // Move the file to the storage directory
    //             // $file->storeAs('folder_requirements/' . Auth::user()->id . '/requirements', $filename, 'public');
    //             $file->storeAs($path, $filename);
    //             // Storage::putFileAs($path, $file, $filename);

    //             $fUpload = new UploadedRequirement();
    //             $fUpload->type = 'portfolio';
    //             $fUpload->file = $filename;
    //             $user->uploadedRequirements()->save($fUpload);
    //         }

    //         $profile = $user->profile;
    //         $profile->is_new = 0;
    //         $profile->save();

    //         $user->requests = 1;
    //         $user->save();


    //         $this->citemEmailNotif($user->email, 'basic');


    //         return redirect()->route('user.register.submission-confirmed');

    //     }
    //     else
    //     {
    //         abort(401);
    //     }

    // } 

    public function showVerifiedUploadForm($type = null)
    {
        $redirect = $this->checkRegType($type);
        if($redirect)
        {
            return $redirect;
        }

        if(Auth::user()->isMember())
        {
            $story = $this->halfPaneStory();
            return view('register.upload-verified')
                ->with('story', $story)
                ->with('reg_type', $type);
        }
        else
        {
            abort(401);
        }
    }

    public function processVerifiedUploadForm(Request $request)
    {
        if(auth::check() && Auth::user()->isMember())
        {

            $rules = [
                // 'expertises' => 'required|array|min:1',
                // 'expertises.*' => 'string',
    
                // 'main-expertise' => 'required|string|max:250',

                'permits.*' => 'required|file|mimes:pdf,png,jpg|max:20000',
                
            ];
    
            $messages = [
                'permits.*.required' => 'Please select at least one file. ',
                'permits.*.mimes' => 'Only PDF, PNG, and JPG files are allowed. ',
                'permits.*.max' => 'File size must not exceed 20 MB. ',
                'permits.*.file' => 'File not allowed. ',
            ];

            if($request->input('driveCheck') == 'drive_check')
            {
                $rules['drive-link'] = 'required|string|max:255';
            
                $messages += [
                    'drive-link.required' => 'Please input Drive Link.',
                    'drive-link.url' => 'Please input a valid Drive Link.',
                    'drive-link.max' => 'Drive Link must not exceed allowed number of characters.',
                ];
            }
            else
            {
                $rules['portfolios.*'] = 'required|file|mimes:pdf,png,jpg,gif|max:20000';
            
                $messages += [
                    'portfolios.*.required' => 'Please select at least one file. ',
                    'portfolios.*.mimes' => 'Only PDF, PNG, GIF, and JPG files are allowed. ',
                    'portfolios.*.max' => 'File size must not exceed 20 MB. ',
                    'portfolios.*.file' => 'File not allowed. ',
                ];
            }

            if($request->has('birs'))
            {
                $rules['birs.*'] = 'required|file|mimes:pdf,png,jpg|max:20000';
            
                $messages += [
                    'birs.*.required' => 'Please select at least one file. ',
                    'birs.*.mimes' => 'Only PDF, PNG, and JPG files are allowed. ',
                    'birs.*.max' => 'File size must not exceed 20 MB. ',
                    'birs.*.file' => 'File not allowed. ',
                ];
            }

    
            $validator = Validator::make($request->all(), $rules, $messages);
            
            // if ($validator->fails()) {
            //     return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
            // }
            
            // If validation fails, return with error messages
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $user = User::find(Auth::user()->id);
            $path = 'user_requirements/' . Auth::user()->id . '/requirements';
            if (!File::exists($path)) {
                // If not, create the folder
                File::makeDirectory($path, 0755, true, true);
            }

            if($request->input('driveCheck') == 'drive_check')
            {
                // $userID = Auth::user()->id;
                // $profile = UProfile::whereHas('user', function($query) use ($userID){
                //     $query->where('id', $userID);
                // })->first();
                $user->profile->upload_drive_link = $request->input('drive-link');
                $user->profile->upload_drive_date = now();
                $user->profile->save();
            }
            else
            {
                // Process and store each uploaded file
                foreach ($request->file('portfolios') as $file) {
                    // Generate a unique filename using the original filename and a random string
                    $originalFilename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $currentDate = now()->format('Ymd_His'); // Format: YearMonthDay_HourMinute
                    $randomString = Str::random(12);
                    $filename = $currentDate . '_portfolio_' . $randomString . '.' . $extension;

                    // Move the file to the storage directory
                    // $file->storeAs('folder_requirements/' . Auth::user()->id . '/requirements', $filename, 'public');
                    $file->storeAs($path, $filename);
                    // Storage::putFileAs($path, $file, $filename);

                    $fUpload = new UploadedRequirement();
                    $fUpload->type = 'portfolio';
                    $fUpload->file = $filename;
                    $user->uploadedRequirements()->save($fUpload);
                }
            }
            
            foreach ($request->file('permits') as $file) {
                $originalFilename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $currentDate = now()->format('Ymd_His');
                $randomString = Str::random(12);
                $filename = $currentDate . '_permit_' . $randomString . '.' . $extension;

                $file->storeAs($path, $filename);

                $fUpload = new UploadedRequirement();
                $fUpload->type = 'goverment-document';
                $fUpload->file = $filename;
                $user->uploadedRequirements()->save($fUpload);
            }

            if($request->has('birs'))
            {
                foreach ($request->file('birs') as $file) {
                    $originalFilename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $currentDate = now()->format('Ymd_His');
                    $randomString = Str::random(12);
                    $filename = $currentDate . '_bir_' . $randomString . '.' . $extension;
    
                    $file->storeAs($path, $filename);
    
                    $fUpload = new UploadedRequirement();
                    $fUpload->type = 'bir-document';
                    $fUpload->file = $filename;
                    $user->uploadedRequirements()->save($fUpload);
                }
            }

            return redirect()->route('user.register.registrationSummary', ['type' => $request->input('reg_type')]);
            
        }
        else
        {
            abort(401);
        }

    }




    public function citemEmailNotif($email, $submissionType)
    {
        Mail::to(env('EMAIL_G_RECIPIENT_EMAIL'))
            ->send(new RegistrationSubmission($email, $submissionType));
    }


    public function showUploaded()
    {
        if(auth::check() && Auth::user()->isMember())
        {
            $story = $this->halfPaneStory();
            return view('register.uploaded')
            ->with('story', $story);
        }
        else
        {
            abort(401);
        }
    }

    public function showSummary($type = null)
    {
        $redirect = $this->checkRegType($type);
        if($redirect)
        {
            return $redirect;
        }

        if(!Auth::user()->isMember())
        {
            abort(401);
        }

        $story = $this->halfPaneStory();

        $dateToday = Carbon::today();

        $profile = UProfile::with('user', 'emails','numContacts','numContactTypes', 'addressLatest', 'jobTitles','uindie.expertises', 'company.addressLatest', 'company.numContacts')
            ->with('user.uploadedRequirements', function($query) use ($dateToday){
                $query->whereDate('created_at', $dateToday)->orderBy('created_at', 'desc');
            })
            ->where('user_id', Auth::user()->id)->first();

        if(!$profile)
        {
            abort(401);
        }

        return view('register.register_summary')
            ->with('profile', $profile)
            ->with('reg_type', $type)
            ->with('story', $story)
            ->with('dateToday', $dateToday);
    }

    public function processSubmission(Request $request)
    {
        if(auth::check() && Auth::user()->isMember()){
            $user = User::find(Auth::user()->id);
            $profile = $user->profile;
            $profile->is_new = 0;
            $profile->save();

            $user->requests = 2;
            $user->save();

            $profile->user->registrationLogs()->create([
                'step' => 'upload',
                'ip' => $request->ip()
            ]);

            if($request->input('reg_type') == 'exhibitor')
            {
                $attendance = $profile->attendance->where('fair_code', config('app.event_faircode'))->first();
                if($attendance)
                {
                    $profile->attendance()->update([
                        'fair_code' => config('app.event_faircode'),
                        'status' => 2
                    ]);
                }
                else
                {
                    $profile->attendance()->create([
                        'fair_code' => config('app.event_faircode'),
                        'status' => 2
                    ]);
                }
                

                $this->citemEmailNotif($user->email, 'Exhibitor');
                return redirect()->route('user.register.submission-exhibitor-confirmed');
            }
            else
            {
                $this->citemEmailNotif($user->email, 'Creative');
                return redirect()->route('user.register.submission-confirmed');
            }

        }
        else{
            abort(401);
        }




    }
    
}
