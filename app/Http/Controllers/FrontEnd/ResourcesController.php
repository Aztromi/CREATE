<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\HelpfulLink;
use App\Models\HelpfulLinkGroup;

class ResourcesController extends Controller
{
    public function helpfulLinks() {

        $hLinks = HelpfulLinkGroup::select('id','name')
            ->with(['helpfulLinks' => function($query){
                $query->select('id','name','description','img','group_id','website')
                    ->where('status',1)
                    ->orderBy('name','asc');
            }])
            ->where('status',1)
            ->orderBy('order','asc')
            ->get();

        return view('website.resources.helpful-links', ['hLinks' => $hLinks]);
    }

    public function getHelpfulLInks() {

        // $groups = HelpfulLinkGroup::select('id','name')
        //     ->whereHas('helpfulLinks', function($query){
        //         $query->where('status', 1);
        //     })
        //     ->where('status', 1)
        //     ->orderBy('order', 'asc')
        //     ->get();

        // $links = HelpfulLink::select('id','name','description','img','group_id','website')
        //     ->whereHas('helpfulLinkGroup', function($query){
        //         $query->where('status', 1);
        //     })
        //     ->where('status', 1)
        //     ->orderBy('group_id','asc')
        //     ->orderBy('name','asc')
        //     ->get();

        // return response()->json([
        //         'groups' => $groups,
        //         'links' => $links
        //     ],200);
    }
}
