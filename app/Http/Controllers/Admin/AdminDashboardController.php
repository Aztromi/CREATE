<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Event;
use App\Models\User;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;


class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function showAdminDashboard()
    {
        // if(Auth::check() &&)
        $verifiedCount = User::where('approved', 1)->where('verified', 1)->where('type','normal')->count();
        // $verifiedCount = $verifiedCount->count();

        $unverifiedCount = User::where('approved', 1)->where('verified', 0)->where('type','normal')->count();
        

        $applicationCount = User::count();

        $registeredCount = User::where('approved', 1)->count();

        $articlesCount = Article::where('published', 'published')->count();

        $eventsCount = Event::count();

        return view('admin.default.index')
            ->with('articlesCount', $articlesCount)
            ->with('eventsCount', $eventsCount)
            ->with('verifiedCount', $verifiedCount)
            ->with('unverifiedCount', $unverifiedCount)
            ->with('applicationCount', $applicationCount)
            ->with('registeredCount', $registeredCount);
    }


    public function sendTest()
    {
        
        Log::info("B2B Send Triggered");
        // Requires use Illuminate\Support\Facades\Http;

        $val1 = "Actual Value1";
        $val2 = "Actual Value2";

        $targetUrl = 'https://ifexconnect.com/alu4jdkfjsl';

        try {
            $response = Http::post($targetUrl, [
                'B2BKey' => "ADSFdaf9876&DGff7gs65FD*&",
                'val1' => $val1,
                'val2' => $val2,
                'recipient' => "nogidlayan.citem@gmail.com",
                'cc' => "nogidlayan.citem@gmail.com",
                'bcc' => "nogidlayan.citem@gmail.com",
                'senderName' => "CREATEPh B2B Send Test",
                'senderEMail' => "info@createphilippines.com",
                
            ]);

            // Handle the response from the target website
            $statusCode = $response->status();
            $body = $response->body();

            // Process or return the response as needed
            Log::info("Try Body: " . $body);

        }
        catch (\Exception $e) {
            // Handle any errors
            Log::error($e->getMessage());
        }
    }

    public function changePassword() {
        return view('admin.change-password');
    }
}