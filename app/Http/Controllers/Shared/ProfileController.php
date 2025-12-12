<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

use App\Models\Country;
use App\Models\Slug;
use App\Models\UCompany;
use App\Models\UJobTitle;
use App\Models\UProfile;

use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('sharedAdminUser');
    }

    public function getProfileData(Request $request)
    {
        $profileID = $request->input('uID');

        $profile = UProfile::with('awards', 'latestSlug', 'uindie.expertises', 'uindie.clients', 'addressLatest', 'websites', 'socials', 'jobTitles', 'sectors', 'emails', 'numContacts', 'numContactTypes', 'company.addressLatest', 'company.numContacts')
            ->with('user.uploadedRequirements', function($query){
                $query->orderBy('created_at', 'desc');
            })
            ->where('user_id', $profileID)->first();

        if(!$profile)
        {
            // return response()->json('Error', 422);
            abort(401);
        }

        return response()->json($profile, 200);
    }


    public function updateProfile(Request $request)
    {   
        if(!auth::check())
        {
            return response()->json(['error' => 'Unauthenticated', 'urlRedirect' => route('login')], 401);
        }

        $profile = UProfile::where('user_id', $request->input('uID'))->first();
        // $profile = UProfile::where('user_id', Auth::user()->id)->first();

        $display_photo = $profile->uindie->display_photo;
        $cover_photo = $profile->uindie->cover_photo;

        $rules = [
            'fname' => 'required|string|max:200',
            'lname' => 'required|string|max:200',
            'gender' => 'required|string|max:50',
            'mobile' => 'required|numeric|digits_between:7,15',
            'country' => 'required|exists:countries,name',
            
            'rep' => 'required|string|max:250',
            'dispName' => 'required|string|max:100',
            'interests' => 'required|array|min:1',
            'interests.*' => 'string',
            'expertises' => 'required|array|min:1',
            'expertises.*' => 'string',

            // REMOVED jobsArr
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

            

            'rep.required' => 'Please select one. ',
            'rep.string' => 'Only text values are allowed. ',
            'rep.max' => 'Value has exceeded the limit. ',
            
            'dispName.required' => 'Please select one. ',
            'dispName.string' => 'Only text values are allowed. ',
            'dispName.max' => 'Value has exceeded the limit. ',
            
            'interests.required' => 'At least one interest is required.',
            'interests.array' => 'The interests must be an array.',
            'interests.min' => 'At least one interest is required.',
            'interests.*.string' => 'Each item in the interests array must be a string.',

            'expertises.required' => 'At least one interest is required.',
            'expertises.array' => 'The expertises must be an array.',
            'expertises.min' => 'At least one interest is required.',
            'expertises.*.string' => 'Each item in the expertises array must be a string.',

            // REMOVED jobsArr
        ];

        if ($request->has('profile-photo') && $request->has('profile-photo-change') && $request->input('profile-photo-change') == 1) {
            // $rules = [
            //     'profile-photo' => 'required|image|mimes:jpeg,png,jpg',
            // ];

            $rules['profile-photo'] = 'required|image|mimes:jpeg,png,jpg';

            $messages += [
                'profile-photo.required' => 'Profile Photo is required.',
                'profile-photo.image' => 'The uploaded file must be an image.',
                'profile-photo.mimes' => 'The image must be of type: jpeg, png, jpg.',
            ];
        }

        if ($request->has('masthead') && $request->has('masthead-change') && $request->input('masthead-change') == 1) {
            // $rules = [
            //     'masthead' => 'required|image|mimes:jpeg,png,jpg',
            // ];

            $rules['masthead'] = 'required|image|mimes:jpeg,png,jpg';

            $messages += [
                'masthead.required' => 'Profile Photo is required.',
                'masthead.image' => 'The uploaded file must be an image.',
                'masthead.mimes' => 'The image must be of type: jpeg, png, jpg.',
            ];
        }
        
        
        if(strlen(trim($request->input('email-alternate'))) > 0)
        {
            if($profile->emails->where('value', trim($request->input('email-alternate')))->count() == 0)
            {
                $rules['email-alternate'] = 'required|email|max:150|unique:users,email|unique:u_emails,value';
                $messages += [
                    'email-alternate.required' => 'Alternate E-mail is required.',
                    'email-alternate.email' => 'Please enter a valid alternate email address.',
                    'email-alternate.max' => 'The length of Alternate E-mail must not exceed 150 characters.',
                    'email-alternate.unique' => 'The Alternate E-mail is already in use.',
                ];
            }
        }

        if(strlen(trim($request->input('mobile-alternate'))) > 0)
        {
            $rules['mobile-alternate'] = 'required|numeric|digits_between:7,15';
            $messages += [
                'mobile-alternate.required' => 'The alternate mobile field is required.',
                'mobile-alternate.numeric' => 'The alternate mobile field must be a numeric value.',
                'mobile-alternate.digits_between' => 'The alternate mobile field must be between 7 and 15 digits.',
            ];
        }


        if(strlen(trim($request->input('telephone'))) > 0)
        {
            $rules['telephone'] = 'required|numeric|digits_between:7,15';
            $messages += [
                'telephone.required' => 'The Landline field is required.',
                'telephone.numeric' => 'The Landline field must be a numeric value.',
                'telephone.digits_between' => 'The Landline field must be between 7 and 15 digits.',
            ];
        }

        if(trim($request->input('country')) == 'Philippines')
        {
            $rules['regionM'] = 'required|string|max:150';
            $messages += [
                'regionM.required' => 'Please select one. ',
                'regionM.string' => 'Only text values are allowed. ',
                'regionM.max' => 'Value has exceeded the limit. ',
            ];

            $rules['provinceM'] = 'required|string|max:150';
            $messages += [
                'provinceM.required' => 'Please select one. ',
                'provinceM.string' => 'Only text values are allowed. ',
                'provinceM.max' => 'Value has exceeded the limit. ',
            ];

            $rules['cityM'] = 'required|string|max:150';
            $messages += [
                'cityM.required' => 'Please select one. ',
                'cityM.string' => 'Only text values are allowed. ',
                'cityM.max' => 'Value has exceeded the limit. ',
            ];
        }
        else
        {
            $rules['regionI'] = 'required|string|max:150';
            $messages += [
                'regionI.required' => 'Required Field. ',
                'regionI.string' => 'Only text values are allowed. ',
                'regionI.max' => 'Value has exceeded the limit. ',
            ];

            $rules['cityI'] = 'required|string|max:150';
            $messages += [
                'cityI.required' => 'Required Field. ',
                'cityI.string' => 'Only text values are allowed. ',
                'cityI.max' => 'Value has exceeded the limit. ',
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
        
        // if(strlen(trim($request->input('org'))) > 0 || $request->input('dispName') == 'company_name')
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

            // Adress goes here
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

        if($request->has('clientsArr') && strlen(trim($request->input('clientsArr'))) > 0)
        {
            $rules['clientsArr'] = 'required|json|min:1';
            $rules['clientsArr.*'] = 'required|string|max:150';

            $messages += [
                'clientsArr.required' => 'At least one client is required.',
                'clientsArr.json' => 'Invalid Input.',
                'clientsArr.min' => 'At least one client is required.',
                'clientsArr.*.string' => 'Each item in the Client list must be a string.',
                'clientsArr.*.max' => 'Each Client Name must not exceed 150 characters.',
            ];

        }

        // Socials
            if(strlen(trim($request->input('facebook'))) > 0)
            {
                $rules['facebook'] = 'string|max:150';
                $messages += [
                    'facebook.string' => 'Only text values are allowed. ',
                    'facebook.max' => 'Value has exceeded the limit. ',
                ];
            }
            if(strlen(trim($request->input('instagram'))) > 0)
            {
                $rules['instagram'] = 'string|max:150';
                $messages += [
                    'instagram.string' => 'Only text values are allowed. ',
                    'instagram.max' => 'Value has exceeded the limit. ',
                ];
            }
            if(strlen(trim($request->input('twitter'))) > 0)
            {
                $rules['twitter'] = 'string|max:150';
                $messages += [
                    'twitter.string' => 'Only text values are allowed. ',
                    'twitter.max' => 'Value has exceeded the limit. ',
                ];
            }
            if(strlen(trim($request->input('youtube'))) > 0)
            {
                $rules['youtube'] = 'string|max:150';
                $messages += [
                    'youtube.string' => 'Only text values are allowed. ',
                    'youtube.max' => 'Value has exceeded the limit. ',
                ];
            }
            if(strlen(trim($request->input('tiktok'))) > 0)
            {
                $rules['tiktok'] = 'string|max:150';
                $messages += [
                    'tiktok.string' => 'Only text values are allowed. ',
                    'tiktok.max' => 'Value has exceeded the limit. ',
                ];
            }
            if(strlen(trim($request->input('behance'))) > 0)
            {
                $rules['behance'] = 'string|max:150';
                $messages += [
                    'behance.string' => 'Only text values are allowed. ',
                    'behance.max' => 'Value has exceeded the limit. ',
                ];
            }
        // END Socials

        if($request->has('webArr') && strlen(trim($request->input('webArr'))) > 0)
        {
            $rules['webArr'] = 'required|json|min:1';
            $rules['webArr.*'] = 'required|string|max:150';

            $messages += [
                'webArr.required' => 'At least one website is required.',
                'webArr.json' => 'Invalid Input.',
                'webArr.min' => 'At least one website is required.',
                'webArr.*.string' => 'Each item in the Website list must be a string.',
                'webArr.*.max' => 'Each Website` must not exceed 150 characters.',
            ];

        }

        if($request->has('awardsArr') && strlen(trim($request->input('awardsArr'))) > 0)
        {
            $rules['awardsArr'] = 'required|json|min:1';
            $rules['awardsArr.*'] = 'required|string|max:150';

            $messages += [
                'awardsArr.required' => 'At least one award/recognition is required.',
                'awardsArr.json' => 'Invalid Input.',
                'awardsArr.min' => 'At least one award/recognition is required.',
                'awardsArr.*.string' => 'Each item in the Awards/Recognitions list must be a string.',
                'awardsArr.*.max' => 'Each Award/Recognition detail must not exceed 150 characters.',
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

        // PHOTOS
            
            // PROFILE PHOTO
            if($request->has('profile-photo') && $request->file('profile-photo')  && $request->has('profile-photo-change') && $request->input('profile-photo-change') == 1) {

                // Retrieve the uploaded file
                $image = $request->file('profile-photo');
        
                // Define the size
                $size = 800;
        
                // Path to store images
                $userId = Auth::id();
                $path = "user_uploads/{$userId}/Profile";
        
                // Load the image using Intervention Image
                $img = Image::make($image->getRealPath());
        
                // Crop to square if the image is not square
                if ($img->width() > $img->height()) {
                    $img->crop($img->height(), $img->height());
                } elseif ($img->height() > $img->width()) {
                    $img->crop($img->width(), $img->width());
                }
        
                // Resize the image to 800x800 if necessary
                $img->resize($size, $size, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // Prevent upsizing smaller images
                });
        
                // Generate the filename using MD5 of the current timestamp and a random 3-character string
                $baseFilename = md5(time());
                $randomString = Str::random(3); // Generate a random 3-character string
                $filename = "{$baseFilename}{$randomString}." . $image->getClientOriginalExtension();
        
                // Save the image to the desired location using Storage::put
                Storage::put("{$path}/{$filename}", (string) $img->encode());
        
                // Save the filename and owner_id to the database
                $display_photo = "$filename"; 
                // ImageModel::updateOrCreate(
                //     ['owner_id' => $userId],
                //     ['large' => "{$path}/{$filename}"]
                // );
                
            }
            else if($profile->uindie->display_photo && $request->has('profile-photo') && !$request->file('profile-photo') && $request->input('profile-photo-change') == 1){
                $display_photo = '';
            }


            // MASTHEAD
            if($request->has('masthead') && $request->file('masthead')  && $request->has('masthead-change') && $request->input('masthead-change') == 1) {


                // Retrieve the uploaded file
                $image = $request->file('masthead');
        
                $maxWidth = 1400;
                $maxHeight = 1000;
        
                // Path to store images
                $userId = Auth::id();
                $path = "user_uploads/{$userId}/Profile";
        
                // Load the image using Intervention Image
                $img = Image::make($image->getRealPath());
        
                // Resize to 1400px width if the width is greater than 1400px
                if ($img->width() > $maxWidth) {
                    $img->resize($maxWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize(); // Prevent upsizing
                    });
                }

                // Crop the height to 1000px if it's greater than 1000px
                if ($img->height() > $maxHeight) {
                    $img->crop($img->width(), $maxHeight);
                }
        
                // Generate the filename using MD5 of the current timestamp and a random 3-character string
                $baseFilename = md5(time());
                $randomString = Str::random(3); // Generate a random 3-character string
                $filename = "{$baseFilename}{$randomString}." . $image->getClientOriginalExtension();
        
                // Save the image to the desired location using Storage::put
                Storage::put("{$path}/{$filename}", (string) $img->encode());
        
                // Save the filename and owner_id to the database
                $cover_photo = "$filename"; 
                // ImageModel::updateOrCreate(
                //     ['owner_id' => $userId],
                //     ['large' => "{$path}/{$filename}"]
                // );
                
            }
            else if($profile->uindie->cover_photo && $request->has('masthead') && !$request->file('masthead') && $request->input('masthead-change') == 1){
                $cover_photo = '';
            }

        // END PHOTOS




        // PRIVACY
            $hEmail = 0;
            $hContact = 0;
            $hAddress = 0;

            if($request->has('hEmail'))
            {
                $hEmail = 1;
            }
            if($request->has('hContact'))
            {
                $hContact = 1;
            }
            if($request->has('hAddress'))
            {
                $hAddress = 1;
            }
        // END PRIVACY


        // Company
            $companyAdd = '';
            if(strlen(trim($request->input('org'))) > 0 || $request->input('dispName') == 'company_name')
            {
                $companyAdd = trim($request->input('org'));
            }
        // END Company
        
        // Display Name
        $displayName = trim($request->input('dispName'));
        $otherName = '';
        if($request->input('dispName') == 'other_name')
        {
            $otherName = trim($request->input('name-other'));
        }
        // END Display Name

        // Brief Description - About
            $about = trim($request->input('briefDesc'));
            $about = $about === '' ? '' : Str::limit($about, 250);
        // END Brief Description - About

        $profile->update([
            'first_name' => ucwords(trim($request->input('fname'))) ,
            'last_name' => ucwords(trim($request->input('lname'))) ,
            'gender' => trim($request->input('gender')) ,
            'about' => $about,
            'hide_email' => $hEmail,
            'hide_contact' => $hContact,
            'hide_address' => $hAddress,
            'company_name' => $companyAdd,
            'display_name' => $displayName,
            'other_name' => $otherName,
            'has_profile_reminder' => 0,
        ]);

        $profile->uindie->update([
            'display_photo' => $display_photo ?: null,
            'cover_photo' => $cover_photo ?: null,
            'expertise' => trim($request->input('rep')),
        ]);

        $profile->user->update([
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

        

        // Country
            

            $region = '';
            $province = '';
            $city = '';
            $adr1 = '';
            $adr2 = '';
            $zip = '';

            if(trim($request->input('country')) == 'Philippines')
            {
                if(strlen(trim($request->input('regionM'))) > 0)
                {
                    $region = $request->input('regionM');
                }
                
                if(strlen(trim($request->input('provinceM'))) > 0)
                {
                    $province = $request->input('provinceM');
                }
                
                if(strlen(trim($request->input('cityM'))) > 0)
                {
                    $city = $request->input('cityM');
                }
            }
            else
            {
                if(strlen(trim($request->input('regionI'))) > 0)
                {
                    $region = $request->input('regionI');
                }
                
                if(strlen(trim($request->input('cityI'))) > 0)
                {
                    $city = $request->input('cityI');
                }

            }

            if(strlen(trim($request->input('addr1'))) > 0)
            {
                $adr1 = $request->input('addr1');
            }

            if(strlen(trim($request->input('addr2'))) > 0)
            {
                $adr2 = $request->input('addr2');
            }

            if(strlen(trim($request->input('zip'))) > 0)
            {
                $zip = $request->input('zip');
            }

            $profile->address()->updateOrCreate([],[
                'country' => $request->input('country'),
                'region' => $region ?? null,
                'province' => $province ?? null,
                'municipality' => $city ?? null,
                'street' => $adr2 ?? null,
                'block_lot' => $adr1 ?? null,
                'postal_code' => $zip ?? null,
            ]);
        // END Country

        
        

        // NEWADD

            

            if($profile->jobTitles->count() > 0)
            {
                $profile->jobTitles()->delete();
            }

            if(trim($request->input('rep')) != '' && trim($request->input('rep')) != 'Individual / Independent / Freelance / Student')
            {
                // Company

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

                    if ($profile->company) {
                        $profile->company->update($company_data);
                    } else {
                        $company = new UCompany($company_data);
                        $profile->company()->save($company);
                    }


                // END Company


                // CO_Country
                    $co_region = '';
                    $co_province = '';
                    $co_city = '';
                    $adr1 = '';
                    $adr2 = '';
                    $zip = '';

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

                    
                    $profile->company->address()->updateOrCreate([],
                        [
                            'country' => $request->input('co_country'),
                            'region' => $co_region ?? null,
                            'province' => $co_province ?? null,
                            'municipality' => $co_city ?? null,
                            'street' => null,
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
                if ($profile->company && $profile->company->address()->exists()) {
                    $profile->company->address()->delete();
                }
            
                if ($profile->company()->exists()) {
                    $profile->company()->delete();
                }
            }
        // END NEWADD



        // Socials
            if($profile->socials->count() > 0)
            {
                $profile->socials()->delete();
            }

            if(strlen(trim($request->input('facebook'))) > 0)
            {
                $profile->socials()->create([
                    'value' => trim($request->input('facebook')),
                    'type' => 'Facebook',
                ]);
            }

            if(strlen(trim($request->input('instagram'))) > 0)
            {
                $profile->socials()->create([
                    'value' => trim($request->input('instagram')),
                    'type' => 'Instagram',
                ]);
            }

            if(strlen(trim($request->input('twitter'))) > 0)
            {
                $profile->socials()->create([
                    'value' => trim($request->input('twitter')),
                    'type' => 'Twitter',
                ]);
            }

            if(strlen(trim($request->input('youtube'))) > 0)
            {
                $profile->socials()->create([
                    'value' => trim($request->input('youtube')),
                    'type' => 'Youtube',
                ]);
            }

            if(strlen(trim($request->input('tiktok'))) > 0)
            {
                $profile->socials()->create([
                    'value' => trim($request->input('tiktok')),
                    'type' => 'Tiktok',
                ]);
            }

            if(strlen(trim($request->input('behance'))) > 0)
            {
                $profile->socials()->create([
                    'value' => trim($request->input('behance')),
                    'type' => 'Behance',
                ]);
            }
        // END Socials


        // Web
            if($profile->websites->count() > 0)
            {
                $profile->websites()->delete();
            }
            
            if ($request->has('webArr') && strlen(trim($request->input('webArr'))) > 0)
            {
                $data = $request->input('webArr');

                if (!empty($data))
                {   
                    $dataRows = json_decode($data, true);

                    $web = [];
                    foreach ($dataRows as $rowData)
                    {
                        $web[] = ['value' => $rowData];
                    }
                    $profile->websites()->createMany($web);
                }
            }
        // END Web


        // Interests
            if($profile->sectors->count() > 0)
            {
                $profile->sectors()->delete();
            }

            $interests = [];

            foreach($request->input('interests') as $interest)
            {
                $vals = explode('|745|', $interest);

                if(isset($vals[0], $vals[1], $vals[2]))
                {
                    $interests[] = ['list_state' => $vals[0], 'category' => $vals[1], 'value' => $vals[2]];
                }
            }

            $profile->sectors()->createMany($interests);
        // END Interests


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
                    $expertises[] = [
                        'list_state' => $vals[0],
                        'category' => $vals[1],
                        'value' => $vals[2],
                        'type' => 'expertise'
                    ];
                }
            }

            if ($request->has('main-expertise') && $request->filled('main-expertise')) {
                $vals = explode('|745|', $request->input('main-expertise'));
                if(isset($vals[0], $vals[1], $vals[2])){
                    $expertises[] = [
                        'list_state' => $vals[0],
                        'category' => $vals[1],
                        'value' => $vals[2],
                        'type' => 'main'
                    ];
                }
            }

            $profile->uindie->expertises()->createMany($expertises);
        // END Expertise


        // Clients
            if($profile->uindie->clients->count() > 0)
            {
                $profile->uindie->clients()->delete();
            }
            
            if ($request->has('clientsArr') && strlen(trim($request->input('clientsArr'))) > 0)
            {
                $data = $request->input('clientsArr');

                if (!empty($data))
                {   
                    $dataRows = json_decode($data, true);

                    foreach ($dataRows as $rowData)
                    {
                        $profile->uindie->clients()->create(['name' => $rowData]);
                    }
                }
            }
        // END Clients




        // Awards
            if($profile->awards->count() > 0)
            {
                $profile->awards()->delete();
            }
            
            if ($request->has('awardsArr') && strlen(trim($request->input('awardsArr'))) > 0)
            {
                $data = $request->input('awardsArr');

                if (!empty($data))
                {   
                    $dataRows = json_decode($data, true);

                    foreach ($dataRows as $rowData)
                    {
                        $profile->awards()->create([
                            'name' => $rowData['award'],
                            'source' => $rowData['presenter'],
                            'year' => $rowData['year'] ?? null,
                        ]);
                    }
                }
            }
        // END Awards


        // SLUG
        if(in_array($profile->user->verified, [0,1])){
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
        
        $profile->logsProfileStateChange()->create([
            'updated_by' => Auth::user()->id,
            'new_state' => 'Profile Updated',
        ]);

        // return redirect()->back()->with('success', 'Changes Saved successfully');
        return response()->json(['validated' => true], 200);
                   
        

    }


}
