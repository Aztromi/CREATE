<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\UProfile;
use App\Models\Story;

use Auth;

class BookmarkController extends Controller
{
    public function index(){
        return view('dashboard.content.bookmarks');
    }

    public function bookmarkArticle(Request $request)
    {
        if(Auth::check())
        {
            $userId = Auth::user()->id;
            $article = Article::find($request->input('article_id'));

            if(!$article == null)
            {
                $article->bookmarks()->where('user_id', $userId)->delete();

                if($request->input('new_status') == 'add')
                {
                    $article->bookmarks()->create([
                        'user_id' => $userId
                    ]);
                }
            }
            else
            {
                return response()->json(['message' => 'Error.'], 422);
            }

            return response()->json(['message' => 'Bookmark processed.'], 200);
        }
    }

    public function bookmarkProfile(Request $request)
    {
        // $userId = $request->input('user_id');
        // $profile = UProfile::find($request->input('profile_id'));
        
        // $profile->bookmarks()->create([
        //     'user_id' => $userId
        // ]);

        if(Auth::check())
        {
            $userId = Auth::user()->id;
            $profile = UProfile::find($request->input('profile_id'));

            if(!$profile == null)
            {
                $profile->bookmarks()->where('user_id', $userId)->delete();

                if($request->input('new_status') == 'add')
                {
                    $profile->bookmarks()->create([
                        'user_id' => $userId
                    ]);
                }
            }
            else
            {
                return response()->json(['message' => 'Error.'], 422);
            }

            return response()->json(['message' => 'Bookmark processed.'], 200);
        }



    }

    public function bookmarkStory(Request $request)
    {
        // $userId = $request->input('user_id');
        // $story = Story::find($request->input('story_id'));
        
        // $story->bookmarks()->create([
        //     'user_id' => $userId
        // ]);


        if(Auth::check())
        {
            $userId = Auth::user()->id;
            $story = Story::find($request->input('story_id'));

            if(!$story == null)
            {
                $story->bookmarks()->where('user_id', $userId)->delete();

                if($request->input('new_status') == 'add')
                {
                    $story->bookmarks()->create([
                        'user_id' => $userId
                    ]);
                }
            }
            else
            {
                return response()->json(['message' => 'Error.'], 422);
            }

            return response()->json(['message' => 'Bookmark processed.'], 200);
        }
    }

    public function getBookmarksData(Request $request){
        // $articles = Articles::paginate(10);

        // $query = $request->input('search');
        $page = $request->input('page', 1);
        $perPage = 10;

        switch($request->input('type')){
            case 'Works':
                $content = Story::select('id', 'ownerable_id', 'title', 'cover_image')
                    ->has('latestSlug')
                    ->with('latestSlug')
                    ->where('published_status', 1);
                    // ->skip(($page - 1) * $perPage)
                    // ->paginate(10);
                    // ->take($perPage)
                    // ->get();

                break;
            case 'Profiles':
                $content = UProfile::select('id', 'user_id', 'display_name', 'first_name', 'last_name', 'company_name', 'other_name')
                    ->whereHas('user', function($query){
                        $query->where('approved', 1)->whereIn('verified', [0,1]);
                    })
                    ->has('uindie')->has('latestSlug')
                    ->with('uindie', 'latestSlug');
                break;
            case 'Articles':
                $content = Article::select('id', 'name', 'published')
                    ->has('asset')->has('latestSlug')
                    ->with('asset')->with('latestSlug')
                    ->where('published', 'published');
                break;
        }

        
        $content = $content->whereHas('bookmarks', function($query){
            $query->where('user_id', Auth::user()->id);
        });
        $count = ceil($content->count()/10);
        $content = $content->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'type' => $request->input('type'),
            'content' => $content,
            'count' => $count,
            'page' => (int)$page
        ]);

    }
}
