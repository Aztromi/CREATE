<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use App\Models\Article;
use App\Models\Event;
use App\Models\Story;
use App\Models\StoryContent;
use App\Models\Slug;
use App\Models\User;
use App\Models\UProfile;

use Illuminate\Support\Str;

// use App\Mail\EmailVerification;
// use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{


    public function __construct()
    {
        $this->middleware('admin.super');
    }


    public function test()
    {

        $storyContents = StoryContent::with('ownerable.user')->orderBy('ownerable_type', 'asc')->orderBy('ownerable_id', 'asc')->orderBy('order', 'asc')->get();

        // $storyContents = StoryContent::where([
        //     ['ownerable_type', 'App\Models\Story'],
        //     ['ownerable_id', '91'],
        // ])->get();
        
        $results = [];
        
        foreach($storyContents->groupBy('ownerable_type') as $oType => $oItems)
        {
            foreach($oItems->groupBy('ownerable_id') as $oID => $oItemsSub)
            {
                // <h1>Type: {{ $oType }}&emsp;ID: {{ $oID }}</h1>
                $count = 0;
                $finVal = '';
                foreach($oItemsSub as $item)
                {

                    // {{ $item }}
                    if($item->type == 'image')
                    {
                        $finVal .= '<img src="' . asset('folder_user-uploads/' . $item->ownerable->user->id . '/stories/' . $item->value) . '" alt="">';
                        $finVal .= '<br>';
                    }
                    elseif($item->type == 'link')
                    {
                        $finVal .= '<a href="' . $item->value . '">' . $item->value . '</a>';
                        $finVal .= '<br>';
                    }
                    else
                    {
                        $finVal .= $item->value;
                    }
                  $count++;
                }

                

                $results[] = [
                    'type' => $oType,
                    'id' => $oID,
                    'count' => $count,
                    'finVal' => $finVal
                ];
            
            }
        }

        $jsonResults = json_encode($results);

        return view('test')
            ->with('value', $jsonResults);
    }

    
    public function UserConnectTest()
    {

        // Mail::to('charlesbautista70@yahoo.com')
        //     ->send(new EmailVerification('University Of The Philippines', 'charlesbautista70@yahoo.com', '8df89bb2dc9484271d8ea265dfa7cbf6a9d72928bcac1c2c979ab554191e4394'));

        $token = Str::random(40);

        //Simple User Grab
        $users = User::where('name','like','a%')->take(10)->get();

        $passTest = Hash::make('12345678') . '|||' . Hash::make('6$yH8Uk52ToP');
        // $passTest = Hash::make('$jpF&h96dd8SGr');

        // $userProfile = User::with('Profile')->has('Profile')->take(5)->get(); //WORKING Eager Loading, Relation Enforced
        // $userProfile = User:: with('profile.sector', 'profile.uindie')  //Directory Query
        //     ->has('Profile')
        //     ->where('type', 'normal')->where('approved', 1)
        //     ->inRandomOrder()
        //     ->take(5)->get();   
        
        // Storage::disk('local')->put('example.txt', 'Contents');


        // $profileData = UProfile::with('user', 'uindie', 'address', 'emails', 'websites', 'socials', 'jobTitleLatest', 'emails', 'sector')
        //         ->where('slug', 'jon-ahmed-durano-349')->get();



        // CREATIVE PROFILE IMAGE AND WORKS HEADER IMAGE CHECK
        // $creatives = User::with('profile.uindie')
        // ->with(['stories' => function($query){
        //     // return $query->with('tags')->limit(5);  //TEMP HIDE. For Testing
        //     return $query->with('tags');
        // }])
        // ->where([
        //     ['type', 'normal'],
        //     ['approved', 1]
        // ])
        // ->where(function($query){
        //     $query->where('verified', 1)->orWhere('verified', 0);
        // })
        // // ->inRandomOrder()->paginate(10);  //TEMP HIDE. For Testing
        // ->orderBy('id', 'asc')->paginate(10);

        

        //SLUG TRANSFER TEST | TRIGGER ONLY
        // $profile = Event::where(function($query){
        //     $query->where('slug','<>',null)->where('slug','<>','');
        // })->get();
        
        
        // foreach($profile as $source)
        // {
        //     $slug = new Slug;
        //     $slug->value = $source->slug;
        //     $source->slugs()->save($slug);
        // }
        


        // CREATIVES WORKS CHECK
        // $creativeWorks = Story::with(
        //         ['storyContents' => function($query){
        //             $query->orderBy('order', 'asc');
        //         }], 
        //         ['user' => function($query){
        //             $query->approvedVerifiedUnverified();
        //         }]
        //     )
        //     ->orderBy('ownerable_id')->paginate(10);

        $prasses = [
            [
                'email' => 'macadminbuyer@gmail.com',
                'pass' => Hash::make('4utY5WHR86F'),
                'ids' => 967,
            ],
            ['email' => 'vjsantos@citem.com.ph', 'pass' => Hash::make('santos_citem2023'), 'ids' => 679,],
            ['email' => 'sjnacino@citem.com.ph', 'pass' => Hash::make('nacino_citem2023'), 'ids' => 548,],
            ['email' => 'citembuyeradmin@test.com', 'pass' => Hash::make('4yaX3JGZ55G'), 'ids' => 969,],
            ['email' => 'danaya@citem.com.ph', 'pass' => Hash::make('4dmE3WKQ98V'), 'ids' => 1337,],
            ['email' => 'kcpineda@citem.com.ph', 'pass' => Hash::make('9btV3YMU59S'), 'ids' => 599,],
            ['email' => 'lsantiago@citem.com.ph', 'pass' => Hash::make('2daF4AAT55W'), 'ids' => 544,],
            ['email' => 'laniceto@citem.com.ph', 'pass' => Hash::make('3gyR9CMG45S'), 'ids' => 546,],
            ['email' => 'rfdc00@citem.com.ph', 'pass' => Hash::make('8jeG2JNE57A'), 'ids' => 7065,],
            ['email' => 'cevio@citem.com.ph', 'pass' => Hash::make('9dpN0BKO92U'), 'ids' => 1151,],
            ['email' => 'qcbernardo@citem.com.ph', 'pass' => Hash::make('3ovJ6EYG54K'), 'ids' => 547,],
            ['email' => 'varellano@citem.com.ph', 'pass' => Hash::make('1daI7CFE55Y'), 'ids' => 545,],
        ];

        
        $slugTest = Article::has('slugs')->with('latestSlug')->take(5)->get();

        $users2 = User::allUsers()
            ->has('profile')->with('vLabel', 'profile')->get();
        
            

        return view('UserConnectTest')
            ->with('textHeader','USER DATABASE RESULTS')
            ->with(compact('users',$users))
            ->with(compact('users2', $users2))
            ->with('prasses',$prasses)
            ->with('passTest',$passTest)
            ->with('slugTest', $slugTest)
            ->with('token', $token);
            // ->with(compact('userProfile',$userProfile))
            // ->with(compact('creatives', $creatives))
            // ->with(compact('creativeWorks', $creativeWorks));
            // ->with(compact('profileData',$profileData));
        


    }

    public function stories_index()
    {

        // CREATIVES WORKS CHECK
        $creativeWorks = Story::with(
                ['storyContents' => function($query){
                    $query->orderBy('order', 'asc');
                }], 'user'
                // , 
                // ['user' => function($query){
                //     $query->approvedVerifiedUnverified();
                // }]
            )
            ->orderBy('ownerable_id')->paginate(10);


        return view('tests.test_Stories')
            ->with('creativeWorks', $creativeWorks);
    }
    public function articles_index()
    {
        $articles = Article::has('asset')->with('asset', 'latestSlug', 'bookmarks')
            ->where('published', 'published')->orderBy('id', 'desc')
            ->get();

        return view('tests.test_Articles')
            ->with('articles', $articles);
    }

    public function profiles_index()
    {
        return view('tests.test_Profiles');
    }

    public function upd_index()
    {
        return view('tests.test_upload');
    }

    public function upd_validate(Request $request){

        // $validator = Validator::make($request->all(), [
        //     // 'file_upload.*' => 'required|mimes:pdf,docx|max:10000', // 10 MB limit
        //     'file_upload.*' => 'required|mimes:pdf,docx|max:10000', // 10 MB limit
        // ]);
        
        // $input_data = $request->all();
        // $validator = Validator::make(
        //     $input_data, [
        //     'file_upload' => 'required|array',                
        //     'file_upload.*' => 'required|mimes:pdf,doc,docx|max:10000'
        //     ],[
        //         'file_upload.*.required' => 'Please upload File/s',
        //         'file_upload.*.mimes' => 'Only PDF, DOC, DOCX files are allowed',
        //         'file_upload.*.max' => 'Maximum allowed size for an image is 10MB',
        //     ]
        // );

        // if ($validator->fails())
        // {   
        //     return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        // }

        $validateFile = $request->validate([  //Automatically retuns an error if error is found.
            'file_upload' => 'required|mimes:pdf,docx|max:2048',
        ]);

        

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            // $customFileName = time() . '_' . $file->getClientOriginalName();
            $customFileName = time() . '_' . $file->getClientOriginalExtension();
            $file->storeAs('folder_test', $customFileName); 

            // You can save the custom filename to the database here if needed.

            // return redirect()->back()->with('success', 'File uploaded successfully.');
            return response()->json(['validated' => true, 'message' => 'Upload Successful'], 200);
        }

        return response()->json(['validated' => false, 'errors' => 'No File Selected.'], 422);

        // return response()->json(['validated' => true, 'message' => 'Registration successful!'], 200);

    }
}
