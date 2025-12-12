<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UProfile;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        if(Auth::check())
        {
            return view('dashboard.content.index');
        }
        else
        {
            return redirect()->route('login');
        }
        
    }

    public function getUserStats(Request $request) {

        $user = Auth::user();

        $profile = $user->profile()->withCount(['views', 'bookmarks'])->first();

        $portfolios = $user->stories();
        $portfolioCount = $portfolios->where('published_status', 1)->count();
        $totalPortfolioViews = $portfolios->withCount('views')->get()->sum('views_count');

        $stats = $profile ? [
            'profileViews' => $profile->views_count,
            'followers' => $profile->bookmarks_count
        ] : [
            'profileViews' => 0,
            'followers' => 0
        ];

        $stats['portfolioCount'] = $portfolioCount ? $portfolioCount : 0;
        $stats['totalPortfolioViews'] = $totalPortfolioViews ? $totalPortfolioViews : 0;


        return response()->json($stats);
    }

    public function changePassword() {
        return view('dashboard.content.change-password');
    }

    public function passwordvalidateAndSave(Request $request) {

        if(!$request->filled(['p_current','p_new'])) {
            return response()->json('Unauthorized. Missing fields', 401);
        }

        $user = Auth::user();

        if(!Hash::check($request->input('p_current'), $user->password)) {
            return response()->json(['check' => false], 200);
        }

        $user->password = Hash::make($request->input('p_new'));
        $user->updated_at = Carbon::now();
        $user->save();

        // Log the user out
        Auth::logout();

        // invalidate the session and regenerate the session ID to avoid session fixation attacks
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return response()->json(['check' => true], 200);
        
    }
}
