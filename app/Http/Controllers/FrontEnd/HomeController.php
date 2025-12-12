<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

use App\Models\Article;
use App\Models\Asset;
use App\Models\Country;
use App\Models\CreativeEvent;
use App\Models\Event;
use App\Models\PHAddress;
use App\Models\SectorList;
use App\Models\Story;
use App\Models\User;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function home()
    {
        Session::put('homeSubsribe', 'visible'); // visible or hide
        $works = User::approvedVerifiedUnverified()
            ->has('homeStoryLatest.latestSlug')->with('homeStoryLatest.latestSlug', 'profile.uindie')
            ->inRandomOrder()->take(6)->get();
            
        
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
            ->latest()->take(6)->get();

        $latestYear = Event::select(Event::raw('MAX(YEAR(event_start)) AS year'))
                ->value('year');
        $creativeFutures = Event::with('asset', 'latestSlug')->whereYear('event_start', $latestYear)->orderBy('present_order', 'asc')->get();


        
        return view('website.home')
            ->with('works', $works)
            ->with('featuredArticle', $featuredArticle)
            ->with('latestArticles', $latestArticles)
            ->with('creativeFutures', $creativeFutures);

        // return view('fill');
    }

    public function search(Request $request)
    {
        
        $tValue = $request->input('search', '');
        $show = $request->input('show', '');
        $sort = $request->input('sort', '');
        $categories = $request->input('categories', []);
            
        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        // if condition Skips occur
        // $works = collect([]);
        if(!in_array($show, ['', 'works']))
        {
            $works = collect([]);
        }
        else {

            $works = Story::whereHas('user', function ($query) use ($categories) {
                $query->approvedVerifiedUnverified();

                if(!empty($categories)){
                    $query->whereHas('profile', function($query1) use ($categories){
                        $query1->whereHas('sectors', function($query2) use ($categories){
                            $query2->whereIn('category', $categories);
                        });
                    });
                }
            })
            ->with('user', 'storyContents', 'latestSlug')
            ->where('published_status', 1)
            ->where('title', 'LIKE', '%' . $tValue . '%')
            ->get()
            ->map(function($w){
                return [
                    'name' => $w->title,
                    'banner' => $w->cover_image ? asset('folder_user-uploads/' . $w->user->id . '/stories/' . $w->cover_image) : asset('img/banner-default.jpg'),
                    'link' => route('creative-works.view', ['slug' => optional($w->latestSlug)->value]),
                    'type' => 'Creative Work',
                    'date' => $w->published_at
                ];
            });
        }

        if(!in_array($show, ['', 'articles']) || !empty($categories))
        {
            $articles = collect([]);
        }
        else {
            $articles = Article::has('asset')->with('asset', 'latestSlug')
            ->where([
                ['published', 'published']
            ])
            ->where('name', 'LIKE', '%' . $tValue . '%')
            ->latest()
            ->get()
            ->map(function($a){
                return [
                    'name' => $a->name,
                    'banner' => $a->asset && $a->asset->path ? asset('folder_articles/' . $a->asset->path) : asset('img/banner-default.jpg'),
                    'link' => route('articles.view', ['slug' => optional($a->latestSlug)->value]),
                    'type' => 'Article',
                    'date' => $a->date
                ];
            });
        }

        if(!in_array($show, ['', 'creatives']))
        {
            $creatives = collect([]);
        }
        else {
            $creatives = User::approvedVerifiedUnverified()
            ->with('profile.uindie', 'profile.latestSlug')
            ->whereHas('profile', function($query) use ($tValue, $categories){
                $query->where(function($q) use ($tValue) {
                    $q->where('display_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('company_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('first_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('last_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('other_name', 'LIKE', "%{$tValue}%");
                });

                if(!empty($categories)) {
                    $query->whereHas('sectors', function($query2) use ($categories){
                        $query2->whereIn('category', $categories);
                    });
                }
            });
            
            $creatives = $creatives->get()
            ->filter(fn($c) => $c->profile && $c->profile->latestSlug)
            ->map(function($c){
                return [
                    'name' => $c->profile->dispName ?? '',
                    'banner' => optional($c->profile->uindie)->display_photo ? asset('folder_user-uploads/' . $c->id . '/Profile/' . $c->profile->uindie->display_photo) : asset('img/banner-default.jpg'),
                    'link' => route('works', ['slug' => optional($c->profile->latestSlug)->value ?? '']),
                    'type' => 'Creative',
                    'date' => $c->profile->updated_at
                ];
            });
        }

        if(!in_array($show, ['', 'events']) || !empty($categories))
        {
            $creative_events = collect([]);
        }
        else {
            $creative_events = CreativeEvent::where('status', 1)
            ->where('name', 'LIKE', "%{$tValue}%")
            ->get()
            ->map(function($e){
                return [
                    'name' => $e->name,
                    'banner' => $e->img ? asset('/folder_events/creative-events/' . $e->img) : asset('img/banner-default.jpg'),
                    'link' => "events/creative-events#event-" . $e->id,
                    'type' => 'Event',
                    'date' => $e->date_start
                ];
            });
        }
        
        // TEMPORARY SHUFFLE
        switch($sort){
            case 'latest':
                $combined = collect($works)->merge($creatives)->merge($articles)->merge($creative_events)->sortByDesc('date')->values();
            case 'name':
                $combined = collect($works)->merge($creatives)->merge($articles)->merge($creative_events)->sortBy('name')->values();
                break;
            default:
                $combined = collect($works)->merge($creatives)->merge($articles)->merge($creative_events)->shuffle()->values();
                break;
        }
        
        // $combined = $works->merge($creatives)->merge($articles);

        $categories = SectorList::select('category')
            ->where('status', 'Active')
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get();
            


        
        $paginated = new LengthAwarePaginator(
            $combined->slice($offset, $perPage)->values(),
            $combined->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('website.search_new', 
            [
                'results' => $paginated,
                'categories' => $categories
            ]
        );

        
    }


    public function searchTest(Request $request)
    {
        
        $tValue = $request->input('search', '');
        $show = $request->input('show', '');
        $sort = $request->input('sort', '');
        $categories = $request->input('categories', []);
            
        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        // if condition Skips occur
        // $works = collect([]);
        if(!in_array($show, ['', 'works']))
        {
            $works = collect([]);
        }
        else {

            $works = Story::whereHas('user', function ($query) use ($categories) {
                $query->approvedVerifiedUnverified();

                if(!empty($categories)){
                    $query->whereHas('profile', function($query1) use ($categories){
                        $query1->whereHas('sectors', function($query2) use ($categories){
                            $query2->whereIn('category', $categories);
                        });
                    });
                }
            })
            ->with('user', 'storyContents', 'latestSlug')
            ->where('published_status', 1)
            ->where('title', 'LIKE', '%' . $tValue . '%')
            ->get()
            ->map(function($w){
                return [
                    'name' => $w->title,
                    'banner' => $w->cover_image ? asset('folder_user-uploads/' . $w->user->id . '/stories/' . $w->cover_image) : asset('img/banner-default.jpg'),
                    'link' => route('creative-works.view', ['slug' => optional($w->latestSlug)->value]),
                    'type' => 'Creative Work',
                    'date' => $w->published_at
                ];
            });
        }

        if(!in_array($show, ['', 'articles']) || !empty($categories))
        {
            $articles = collect([]);
        }
        else {
            $articles = Article::has('asset')->with('asset', 'latestSlug')
            ->where([
                ['published', 'published']
            ])
            ->where('name', 'LIKE', '%' . $tValue . '%')
            ->latest()
            ->get()
            ->map(function($a){
                return [
                    'name' => $a->name,
                    'banner' => $a->asset && $a->asset->path ? asset('folder_articles/' . $a->asset->path) : asset('img/banner-default.jpg'),
                    'link' => route('articles.view', ['slug' => optional($a->latestSlug)->value]),
                    'type' => 'Article',
                    'date' => $a->date
                ];
            });
        }

        if(!in_array($show, ['', 'creatives']))
        {
            $creatives = collect([]);
        }
        else {
            $creatives = User::approvedVerifiedUnverified()
            ->with('profile.uindie', 'profile.latestSlug')
            ->whereHas('profile', function($query) use ($tValue, $categories){
                $query->where(function($q) use ($tValue) {
                    $q->where('display_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('company_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('first_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('last_name', 'LIKE', "%{$tValue}%")
                    ->orWhere('other_name', 'LIKE', "%{$tValue}%");
                });

                if(!empty($categories)) {
                    $query->whereHas('sectors', function($query2) use ($categories){
                        $query2->whereIn('category', $categories);
                    });
                }
            });
            
            $creatives = $creatives->get()
            ->filter(fn($c) => $c->profile && $c->profile->latestSlug)
            ->map(function($c){
                return [
                    'name' => $c->profile->dispName ?? '',
                    'banner' => optional($c->profile->uindie)->display_photo ? asset('folder_user-uploads/' . $c->id . '/Profile/' . $c->profile->uindie->display_photo) : asset('img/banner-default.jpg'),
                    'link' => route('works', ['slug' => optional($c->profile->latestSlug)->value ?? '']),
                    'type' => 'Creative',
                    'date' => $c->profile->updated_at
                ];
            });
        }

        if(!in_array($show, ['', 'events']) || !empty($categories))
        {
            $creative_events = collect([]);
        }
        else {
            $creative_events = CreativeEvent::where('status', 1)
            ->where('name', 'LIKE', "%{$tValue}%")
            ->get()
            ->map(function($e){
                return [
                    'name' => $e->name,
                    'banner' => $e->img ? asset('/folder_events/creative-events/' . $e->img) : asset('img/banner-default.jpg'),
                    'link' => "events/creative-events#event-" . $e->id,
                    'type' => 'Event',
                    'date' => $e->date_start
                ];
            });
        }
        
        // TEMPORARY SHUFFLE
        switch($sort){
            case 'latest':
                $combined = collect($works)->merge($creatives)->merge($articles)->merge($creative_events)->sortByDesc('date')->values();
            case 'name':
                $combined = collect($works)->merge($creatives)->merge($articles)->merge($creative_events)->sortBy('name')->values();
                break;
            default:
                $combined = collect($works)->merge($creatives)->merge($articles)->merge($creative_events)->shuffle()->values();
                break;
        }
        
        // $combined = $works->merge($creatives)->merge($articles);

        $categories = SectorList::select('category')
            ->where('status', 'Active')
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get();
            


        
        $paginated = new LengthAwarePaginator(
            $combined->slice($offset, $perPage)->values(),
            $combined->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('website.search_new_test', 
            [
                'results' => $paginated,
                'categories' => $categories
            ]
        );

        
    }

    public function getCategories(){
        $categories = SectorList::select('category')->distinct()->orderBy('category')->get();

        return response()->json($categories);
    }
    
    public function serviceRedirect() {
        return view('website.service-redirect');
    }

    public function connectWithCreative() {
        return view('website.connect-with-creative');
    }

    
}
