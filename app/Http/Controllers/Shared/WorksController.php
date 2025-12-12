<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


use App\Models\Story;
use App\Models\User;
use App\Models\UProfile;

use Auth;

class WorksController extends Controller
{
    public function checkGateAdmin(){
        Gate::authorize('access-works-og', Auth::user());
    }

    public function checkGateShared(){
        Gate::authorize('access-works-shared', Auth::user());
    }

    public function getWorks(){
        $this->checkGateShared();

        $stories = Story::select('id', 'ownerable_id', 'title', 'published_status', 'published_at', 'updated_at')
            ->has('latestSlug')->with('latestSlug');

        if(Auth::user()->isCreative()){
            $editLink = route('user.creativeWorks.edit');
            $user_id = Auth::user()->id;
            $stories = $stories->whereHas('user', function($query) use ($user_id){
                    $query->where('id', $user_id);
                });
        }
        else if(Auth::user()->isAdminOG()){
            $editLink = route('admin.creativeWorks.edit');
            $stories = $stories->has('user.profile')->with('user', function($query){
                $query->select('id', 'verified', 'approved', 'name')->with('profile', function($query2){
                        $query2->select('id', 'user_id', 'display_name', 'first_name', 'last_name', 'company_name', 'other_name');
                    });
            });
        }
        else{
            abort(401);
        }

        $stories = $stories->orderBy('updated_at', 'desc')->get();

        return response()->json(['stories' => $stories, 'editLink' => $editLink], 200);
    }

    

    public function processAdd(Request $request) {
        $this->checkGateShared();
        $uID = '';
        if(Auth::user()->isAdminOG() && $request->has('creative')){
            $uID = $request->input('creative');
        }
        else if(Auth::user()->isCreative()){
            $uID = Auth::user()->id;
        }
        else{
            return response()->json('Unauthorized', 401);
        }

        $valReturn = $this->validateForm($request, true);
        if($valReturn){
            return $valReturn;
        }

        $user = User::find($uID);
        
        if(!$user){
            return response()->json('Not found', 404);
        }

        $publish = $request->input('publish') ? 1 : 0;

        $publish_at = null;
        if($publish == 1){
            $publish_at = Carbon::now();
        }

        $tags = $request->input('cField', []);

        // IMAGE
            $image = $request->file('masthead');

            $maxWidth = 1500;
            $maxHeight = 1500;
            $path = 'user_uploads/' .$uID. '/stories';

            $img = Image::make($image->getRealPath());
        
            if ($img->width() > $maxWidth) {
                $img->resize($maxWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // Prevent upsizing
                });
            }
            
            if ($img->height() > $maxHeight) {
                $img->crop($img->width(), $maxHeight);
            }
            
            $baseFilename = md5(time());
            $randomString = Str::random(3); // Generate a random 3-character string
            $filename = "{$baseFilename}{$randomString}." . $image->getClientOriginalExtension();
            
            Storage::put("{$path}/{$filename}", (string) $img->encode());


        // END IMAGE

        $workData = [
            'title' => trim($request->input('title')),
            'category' => 'article',
            'published_status' => $publish,
            'published_at' => $publish_at,
            'ownerable_type' => User::class,
            'ownerable_id' => $uID,
            'cover_image' => $filename,
            'link' => ''
        ];

        $newStory = $user->stories()->create($workData);
        $newStory->storyContents()->create([
            'type' => 'html',
            'value' => $request->input('ta-content')
        ]);
        
        if(!empty($tags)) {
            foreach($tags as $tag) {
                $val = explode("||", $tag);

                $newStory->tags()->create([
                    'category' => $val[0] ?? '',
                    'name' => $val[1] ?? '',
                    'type' => 'tag'
                ]);
            }
        }
        
        
        $this->slugHandler(Story::class, $newStory, trim($request->input('title')), 'add');

        $urlRedirect = $this->userRedirect('creativeWorks');

        return response()->json(['validated' => true, 'message' => 'Successfully Added', 'urlRedirect' => $urlRedirect], 200);

    }

    public function processEdit(Request $request) {
        
        $this->checkGateShared();

        if(!$request->has('slug')){
            return response()->json('Not Found', 404);
        }

        $slug = $request->input('slug');

        
        
        $story = Story::with('user')
            ->whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
            ->first();
            

        if(!$story){
            return response()->json('Not Found', 404);
        }
        
        if(!Auth::user()->isAdminOG() && !(Auth::user()->isCreative() && Auth::user()->id == $story->user->id)){
            return response()->json('Unauthorized', 401);
        }

        if($request->has('masthead-change') && $request->input('masthead-change') == 1) {
            $valReturn = $this->validateForm($request, true);
        }
        else{
            $valReturn = $this->validateForm($request, false);
        }
        
        if($valReturn){
            return $valReturn;
        }

        $publish = $request->input('publish') ? 1 : 0;

        $publish_at = $story->published_at;
        if($publish == 1 && !$publish_at){
            $publish_at = Carbon::now();
        }

        $tags = $request->input('cField', []);

        $filename = $story->cover_image;
        // IMAGE
            if($request->has('masthead-change') && $request->input('masthead-change') == 1) {
                $image = $request->file('masthead');

                $maxWidth = 2000;
                $maxHeight = 2000;
                $path = 'user_uploads/' . $story->ownerable_id . '/stories';

                $img = Image::make($image->getRealPath());
            
                if ($img->width() > $maxWidth) {
                    $img->resize($maxWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize(); // Prevent upsizing
                    });
                }
                
                if ($img->height() > $maxHeight) {
                    $img->crop($img->width(), $maxHeight);
                }
                
                $baseFilename = md5(time());
                $randomString = Str::random(3); // Generate a random 3-character string
                $filename = "{$baseFilename}{$randomString}." . $image->getClientOriginalExtension();
                
                Storage::put("{$path}/{$filename}", (string) $img->encode());

            }
            


        // END IMAGE

        $story->update([
            'title' => trim($request->input('title')),
            'published_status' => $publish,
            'published_at' => $publish_at,
            'cover_image' => $filename,
        ]);

        if($story->storyContents()->exists()){
            $story->storyContents()->delete();    
        }
        $story->storyContents()->create([
            'type' => 'html',
            'value' => $request->input('ta-content')
        ]);

        $story->tags()->delete();

        if(!empty($tags)) {
            foreach($tags as $tag) {
                $val = explode("||", $tag);

                $story->tags()->create([
                    'category' => $val[0] ?? '',
                    'name' => $val[1] ?? '',
                    'type' => 'tag'
                ]);
            }
        }
        
        $this->slugHandler(Story::class, $story, trim($request->input('title')), 'edit');

        return response()->json(['validated' => true, 'message' => 'Successfully Updated', 'urlRedirect' => $this->userRedirect('creativeWorks') ], 200);

    }


    private function validateForm($request, $edit){
        $rules = [
            'title' => 'required|string|max:200',
            'publish' => 'nullable|boolean',
            'ta-content' => 'required|string',

            'cField' => 'required|array',
        ];

        $messages = [
            'title.required' => 'Please add Title. ',
            'title.string' => 'Only text values are allowed. ',
            'title.max' => 'Value has exceeded the limit. ',

            'ta-content.required' => 'Please add the content. ',
            'ta-content.string' => 'Only text values are allowed. ',

            'cField.required' => 'Please provide at least one category entry.',
            'cField.array' => 'The category entries must be submitted as an array.',
        ];

        if($edit){
            $rules['masthead'] = 'required|image|mimes:jpeg,png,jpg';

            $messages += [
                'masthead.required' => 'Image is required.',
                'masthead.image' => 'The uploaded file must be an image.',
                'masthead.mimes' => 'The image must be of type: jpeg, png, jpg.',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

    }

    private function userRedirect($destination){
        $uType = 0;
        $routeName = 'home';

        if(Auth::user()->isAdminOG()){
            $uType = 1;
        }
        else if(Auth::user()->isAdmin()){
            $uType = 2;
        }
        else if(Auth::user()->isUser()){
            $uType = 3;
        }

        switch($destination){
            case 'dashboard':
                switch($uType){
                    case 1: case 2:
                        $routeName = 'admin.index';
                        break;
                    case 3:
                        $routeName = 'user.index';
                        break;
                }
                break;
            case 'creativeWorks':
                switch($uType){
                    case 1:
                        $routeName = 'admin.creativeWorks.index';
                        break;
                    case 2:
                        $routeName = 'admin.index';
                        break;
                    case 3:
                        $routeName = 'user.creativeWorks.index';
                        break;
                }
                break;
        }
        
        return route($routeName);
    }

    public function getStoryData(Request $request){
        $this->checkGateShared();

        if(!$request->has('slug')){
            return response()->json(['urlRedirect' => $this->userRedirect('creativeWorks')], 404);
        }

        $slug = $request->input();

        $story = Story::select('id', 'ownerable_id', 'title', 'published_status')
            ->with('storyContents')
            ->wherehas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            });

        if(Auth::user()->isCreative()){
            $story = $story->where([
                ['ownerable_type', '=', User::class],
                ['ownerable_id', '=', Auth::user()->id]
            ]);
        }

        $story = $story->first();

        if(!$story){
            return response()->json(['urlRedirect' => $this->userRedirect('creativeWorks')], 404);
        }

        $content = null;

        if($story->storyContents()->exists()){
            $contents = $story->storyContents()->orderBy('order', 'asc')->get();
            foreach($contents as $row){
                switch($row->type){
                    case 'image':
                        $content .= '<p><img class="img-fluid" src="/folder_user-uploads/' . $story->ownerable_id . '/stories/' . $row->value . '" alt=""></p>';
                        break;
                    case 'link':
                        $content .= '<p><a href="' . $row->value . '" target="_blank">' . $row->value . '</a></p>';
                        break;
                    default:
                        $content .=  $row->value;
                        break;
                }
                
            }
        }


        return response()->json(['story' => $story, 'content' => $content], 200);
    }

    

    
}
