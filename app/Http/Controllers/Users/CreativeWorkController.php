<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Story;

use Auth;

class CreativeWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.verifiedunverified');
    }

    public function index(){
        return redirect()->route('user.creativeWorks.list');
    }

    public function list(){
        return view('dashboard.content.creative-works.list')
            ->with('uType', 'user')
            ->with('addLink', route('user.creativeWorks.add'));
    }

    public function showAddForm(){
        return view('dashboard.content.creative-works.form')
            ->with('uType', 'user')
            ->with('uProcess', 'add')
            ->with('tmce_url_base', '/folder_user-uploads/admin')
            ->with('tmce_url_img', route('shd.creativeWorks.tmceImgUpload'));
    }

    public function showEditForm($slug = null){
        if(is_null($slug)){
            return redirect()->route('user.creativeWorks.list');
        }

        $exist = Story::where([
                ['ownerable_type', '=', User::class],
                ['ownerable_id', '=', Auth::user()->id]
            ])
            ->whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
        ->first();

        if(!$exist){
            abort(401);
        }

        $masthead = '/folder_user-uploads/' . $exist->ownerable_id . '/stories/' . $exist->cover_image;

        return view('dashboard.content.creative-works.form')
            ->with('uType', 'user')
            ->with('uProcess', 'edit')
            ->with('slug', $slug)
            ->with('masthead', $masthead)
            ->with('tmce_url_base', '/folder_user-uploads/admin')
            ->with('tmce_url_img', route('shd.creativeWorks.tmceImgUpload'));
    }
}
