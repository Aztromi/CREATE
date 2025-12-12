<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use Illuminate\Database\Eloquent\Builder;

use App\Models\Story;

use Auth;

class StoriesController extends Controller
{
    public function view($slug)
    {
        $work = Story::with('storyContents', 'latestSlug')
            ->whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
            ->whereHas('user', function($query){
                $query->approvedVerifiedUnverified();
            })
            ->first();

        if(!$work)
        {
            abort(404);
        }

        $otherWorks = Story::with('latestSlug')->where('ownerable_type', $work->ownerable_type)->where('ownerable_id', $work->ownerable_id)->where('id', '<>', $work->id)->take(5)->get();
        

        $displayName = $work->user->profile->dispName;


        $bkMark = 'false';

        if(Auth::check())
        {
            $userId = Auth::user()->id;

            $workBookmark = $work->bookmarks()->where('user_id', $userId)->count();
            if($workBookmark>0)
            {
                $bkMark = 'true';
            }
        }
        else
        {
            $userId = 0;
        }

        $work->views()->create([
            'user_id' => $userId
        ]);

        return view('website.creative-workView')
            ->with('bkMark', $bkMark)
            ->with(compact('work', $work))
            ->with(compact('otherWorks', $otherWorks))
            ->with('displayName', $displayName);
    }
}
