<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Models\User;
use App\Models\SectorList;

class DirectoryController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $show = $request->has('show') ? $request->input('show') : 'verified'; // Force show=verified if show parameter does not exist
        $sort = $request->input('sort', '');
        $categories = $request->input('categories', []);

        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $creatives = User::approvedVerifiedUnverified()
            ->has('profile')
            ->with([
                'profile' => function($query1){
                    $query1->with(['uindie', 'latestSlug']);
                },
                'stories' =>function($query2){
                    $query2->where('published_status', 1);
                }
            ])
            ->whereHas('profile', function($query3) use ($search, $categories){
                $query3->where(function($q) use ($search) {
                    $q->where('display_name', 'LIKE', "%{$search}%")
                    ->orWhere('company_name', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('other_name', 'LIKE', "%{$search}%");
                });

                if(!empty($categories)) {
                    $query3->whereHas('sectors', function($query4) use ($categories){
                        $query4->whereIn('category', $categories);
                    });
                }
            });

        if($show != '') {
            switch($show) {
                case 'unverified':
                    $creatives = $creatives->where('verified', 0);
                    break;
                case 'verified':
                    $creatives = $creatives->where('verified', 1);
                    break;
            }
        }
        
        $creatives = $creatives->get()
            ->filter(fn($c) => $c->profile && $c->profile->latestSlug)
            ->map(function($c){
                return [
                    'c_id' => $c->id,
                    'name' => $c->profile->dispName ?? '',
                    'profile_photo' => optional($c->profile->uindie)->display_photo ? asset('folder_user-uploads/' . $c->id . '/Profile/' . $c->profile->uindie->display_photo) : asset('img/default_profile_img.png'),
                    'link' => route('works', ['slug' => optional($c->profile->latestSlug)->value ?? '']),
                    'date' => $c->profile->updated_at,
                    'verified' => $c->verified == 1 ? true : false,
                    'stories' => $c->stories
                ];
            });

        switch($sort) {
            case 'latest':
                $creatives = $creatives->sortByDesc('date')->values();
                break;
            case 'name':
                $creatives = $creatives->sortBy('name')->values();
                break;
            default:
                $creatives = $creatives->shuffle();
                break;
        }

        $paginated = new LengthAwarePaginator(
            $creatives->slice($offset, $perPage)->values(),
            $creatives->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        $categories = SectorList::select('category')
            ->where('status', 'Active')
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get();

        return view('website.directory', [
            'creatives' => $paginated,
            'categories' => $categories
        ]);
    }

    public function getCreatives(Request $request) {
        $page = $request->has('page') ? (int)$request->input('page') : 1;
        $sort = 'verified';
        $perPage = 10;

        $creatives = User::approvedVerifiedUnverified()
            ->has('profile')
            // ->whereHas('stories', function($query){
            //     $query->where('published_status', 1);
            // })
            ->with([
                'profile' => function($query1){
                    $query1->with(['uindie', 'latestSlug']);
                },
                'stories' =>function($query2){
                    $query2->where('published_status', 1);
                }
            ])
            ;

            //Additional Filter Here

            if($sort == 'verified') {
                $creatives = $creatives->orderByRaw("
                    CASE 
                        WHEN verified = 1 THEN 1
                        WHEN verified = 0 THEN 2
                        ELSE 3
                    END
                ");
            }

            $creatives = $creatives->inRandomOrder();

            $totalRecords = $creatives->count();
            $maxPages = ceil($totalRecords / $perPage);

            // Ensure the page number is within valid range
            $page = max(1, min($page, $maxPages));

            // Fetch records for the requested page
            $results = $creatives->skip(($page - 1) * $perPage)
                            ->take($perPage)
                            ->get();

            $compiled = [];

            foreach($results as $result) {
                $stories = null;
                if($result->stories) {
                    $stories = [];
                    foreach($result->stories->chunk(3) as $chunk) {
                        $chunk = [];

                        foreach($chunk as $story) {
                            $chunk[] = [
                                'latestSlug' => $story->latestSlug->value,
                                'cover_image' => $story->cover_image,
                                'ownerable_id' => $story->ownerable_id
                            ];
                        }
                    }
                }

                $compiled[] = [
                    'creative_id' => $result->id,
                    'display_photo' => $result->profile->uindie->display_photo ? asset('folder_user-uploads/' . $result->id . '/Profile/' . $result->profile->uindie->display_photo) : asset('/img/default_profile_img.png'),
                    'dispName' => $result->profile->dispName,
                    'verified' => $result->verified,
                    'latestSlug' => $result->profile->latestSlug ? $result->profile->latestSlug->value : '',
                    'stories' => $stories
                ];
            }

            return response()->json([
                'result' => $compiled,
                'current_page' => $page,
                'max_page' => $maxPages
            ]);
    }
}
