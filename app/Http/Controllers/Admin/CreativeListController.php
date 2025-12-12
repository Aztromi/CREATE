<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class CreativeListController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.og');
    }
    
    public function index()
    {

        $userProfiles = User::allUsers()->with('profile', 'stories')
            ->orderBy('created_at', 'desc')->get();

        return view('admin.registered-users.creatives-list')
            ->with('userProfiles', $userProfiles);
    }
}
