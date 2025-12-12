<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;

use Auth;

class ArticlesController extends Controller
{
    public function index()
    {
        $featuredArticle = Article::has('asset')->with('asset', 'latestSlug')
            ->where([
                ['featured', 1],
                ['published', 'published']
            ])
            ->orderBy('date', 'desc')->first();

        $latestArticles = Article::has('asset')->with('asset', 'latestSlug')
            ->where([
                ['published', 'published'],
                ['id', '<>', $featuredArticle->id]
            ])
            // ->latest()->take(20)->get();
            ->latest()->paginate(10);
            
            // To be replaced with pagination approacH
            // return view('website.articles')
            //     ->with('featuredArticle', $featuredArticle)
            //     ->with(compact('latestArticles', $latestArticles));

            // PAGINATION APPROACH
            return view('website.articles', ['latestArticles' => $latestArticles])
            ->with('featuredArticle', $featuredArticle);
    }

    public function view($slug)
    {
        $article = Article::has('asset')->with('asset', 'latestSlug', 'bookmarks')
            ->whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
            ->where('published', 'published')
            ->first();

        if(!$article)
        {
            abort(404);
        }


        
        $randomRelatedArticles = Article::has('asset')->with('asset', 'latestSlug')
            ->where([
                ['published', 'published'],
                ['industry', $article->industry],
                ['id', '<>', $article->id]
            ])
            ->inRandomOrder()->take(3)->get();


        $bkMark = 'false';

        if(Auth::check())
        {
            $userId = Auth::user()->id;

            $articleBookmark = $article->bookmarks()->where('user_id', $userId)->count();
            if($articleBookmark>0)
            {
                $bkMark = 'true';
            }
        }
        else
        {
            $userId = 0;
        }

        $article->views()->create([
            'user_id' => $userId
        ]);

        return view('website.articleView')
            ->with('article', $article)
            ->with('bkMark', $bkMark)
            ->with(compact('randomRelatedArticles', $randomRelatedArticles));
    }
}
