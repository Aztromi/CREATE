<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UProfile;
use App\Models\Story;

use Auth;

class ProfilesController extends Controller
{
    public function viewPublic(Request $request)
    {
        $slug = $request->slug;
        

        if($request->is('profile/*'))
        {
            $tabView="profile";

            $profileData = UProfile::with('latestSlug', 'uindie.expertises', 'addressLatest', 'emails', 'websites', 'socials', 'jobTitleLatest', 'emails', 'sectors', 'bookmarks')
            ->whereHas('user', function($query){
                $query->approvedVerifiedUnverified();
            })
            ->whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
            ->first();

            if(!$profileData)
            {
                abort(404);
            }


            $bkMark = 'false';

            if(Auth::check())
            {
                $userId = Auth::user()->id;
                
                $profileBookmark = $profileData->bookmarks()->where('user_id', $userId)->count();
                if($profileBookmark>0)
                {
                    $bkMark = 'true';
                }

            }
            else
            {
                $userId = 0;
            }

            $profileData->views()->create([
                'user_id' => $userId
            ]);

            return view('website.creative-profile-main')
            ->with('tabView', $tabView)
            ->with('bkMark', $bkMark)
            ->with(compact('profileData', $profileData));
            
        }
        else if($request->is('works/*'))
        {
            $tabView="works";

            $profileData = UProfile::with('user.stories', 'user.storyPreviews', 'latestSlug', 'uindie', 'emails', 'websites', 'socials', 'emails')
            ->whereHas('user', function($query){
                $query->approvedVerifiedUnverified();
            })
            ->whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
            ->first();

            if($profileData === null)
            {
                abort(404);
            }

            $userID = $profileData->user->id;

            $articles = Story::articles()
                ->whereHas('user', function($query) use ($userID){
                    $query->where('id', $userID);
                })
                ->where('published_status', 1)
                ->orderBy('title')->get();

            $videos = Story::videos()
                ->whereHas('user', function($query) use ($userID){
                    $query->where('id', $userID);
                })
                ->where('published_status', 1)
                ->orderBy('title')->get();

                
            $bkMark = 'false';

            if(Auth::check())
            {
                $userId = Auth::user()->id;

                

                $profileBookmark = $profileData->bookmarks()->where('user_id', $userId)->count();
                if($profileBookmark>0)
                {
                    $bkMark = 'true';
                }

            }
            else
            {
                $userId = 0;
            }

            return view('website.creative-profile-main')
            ->with('tabView', $tabView)
            ->with('bkMark', $bkMark)
            ->with(compact('profileData', $profileData))
            ->with(compact('articles', $articles))
            ->with(compact('videos', $videos));
        }

        
    }
}
