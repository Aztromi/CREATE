<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Story;
use App\Models\UProfile;

use Auth;

class CreativeWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        return redirect()->route('admin.creativeWorks.list');
    }

    public function list(){
        return view('admin.creative-works.list')
            ->with('uType', 'admin')
            ->with('addLink', route('admin.creativeWorks.add'));
    }

    public function showAddForm(){

        $creatives = null;
        if(Auth::user()->isAdminOG()){
            $creatives = UProfile::select('id', 'user_id', 'display_name', 'first_name', 'last_name', 'company_name', 'other_name')
            ->whereHas('user', function($query){
                $query->approvedVerifiedUnverified();
            })
            ->get();

            $creatives = $creatives->sortBy('dispName');

        }

        return view('admin.creative-works.form')
            ->with('creatives', $creatives)
            ->with('uType', 'admin')
            ->with('uProcess', 'add')
            ->with('tmce_url_base', '/folder_user-uploads/admin')
            ->with('tmce_url_img', route('shd.creativeWorks.tmceImgUpload'));
    }

    public function showEditForm($slug = null){
        if(is_null($slug)){
            return redirect()->route('admin.creativeWorks.list');
        }

        $exist = Story::whereHas('slugs', function($query) use ($slug){
                $query->where('value', $slug);
            })
        ->first();

        if(!$exist){
            abort(401);
        }

        $masthead = '/folder_user-uploads/' . $exist->ownerable_id . '/stories/' . $exist->cover_image;

        return view('admin.creative-works.form')
            ->with('uType', 'admin')
            ->with('uProcess', 'edit')
            ->with('slug', $slug)
            ->with('masthead', $masthead)
            ->with('tmce_url_base', '/folder_user-uploads/admin')
            ->with('tmce_url_img', route('shd.creativeWorks.tmceImgUpload'));
    }
}
