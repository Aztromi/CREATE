<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\SectorList;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;

use Auth;

class TagController extends Controller
{
    public function getTagsSelection(Request $request) {

        //Get tags with Selections

        if(!($request->has('type') && in_array($request->input('type'), ['article', 'work', 'connect_creative']))) {
            return response()->json('Unauthorized', 400);
        }

        $class = $request->input('type') == 'article' ? Article::class : ($request->input('type') == 'work' ? Story::class : null);
        $entry_id = $request->input('eID', '');
        
        $tags = $entry_id
            ? Tag::where([
                    'taggable_type' => $class,
                    'taggable_id' => $entry_id
                ])
                ->get()
            : collect();
        
        if($tags->isNotEmpty()) {
            $tags = $tags->pluck('name')->toArray();
        } else {
            $tags = [];
        }
        
        // $cats = SectorList::select('category', 'value')
        //     ->where('status', 'Active')
        //     ->orderBy('category')
        //     ->orderBy('value')
        //     ->get()
        //     ->groupBy('category');

        $cats = SectorList::select('category', 'value')
            ->where('status', 'Active')
            ->orderBy('category')
            ->orderBy('value')
            ->get()
            ->groupBy('category')
            ->map(function ($items, $category) {
                return $items->map(function ($item) use ($category) {
                    return [
                        'category' => $category,
                        'name' => $item->value,
                    ];
                });
            });

        return response()->json([
            'validated' => true,
            'tags' => $tags,
            'cats' => $cats
        ], 200);
    }
}
