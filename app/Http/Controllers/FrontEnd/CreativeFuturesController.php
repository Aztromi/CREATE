<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

class CreativeFuturesController extends Controller
{
    public function index($lyear = null)
    {
        $page = "main";
        if($lyear <> null)
        {
            $latestYear = $lyear;
            $creativeFutures = Event::with('asset', 'latestSlug')->whereYear('event_start', $latestYear)->orderBy('present_order', 'asc')->get();
        }
        
        if($lyear == null || empty($creativeFutures))
        {
            $latestYear = Event::select(Event::raw('MAX(YEAR(event_start)) AS year'))
                ->value('year');

            return redirect()->route('events.creative-futures', ['lyear' => $latestYear]);
            
            // $creativeFutures = Event::with('asset', 'latestSlug')->whereYear('event_start', $latestYear)->orderBy('present_order', 'asc')->get();

            

        }

        $years = Event::selectRaw('YEAR(event_start) as year')
            ->groupBy('year')->orderBy('year', 'desc')
            ->get();

        return view('website.events.creative-futures-main')
            ->with('page', $page)
            ->with('years', $years)->with('latestYear', $latestYear)
            ->with('creativeFutures', $creativeFutures);


        // return view('website.events.creative-futures-main');
    }

    public function session($slug = null)
    {
        if($slug == null)
        {
            return redirect()->route('events.creative-futures');
        }
        else
        {
            
            $event = Event::with('asset', 'latestSlug')
                ->whereHas('slugs', function($query) use ($slug){
                    $query->where('value', $slug);
                })->first();
            
            $randomEvents = Event::with('asset', 'latestSlug')
                ->where('event_start', $event->event_start)
                ->inRandomOrder()->take(3)->get();

            return view('website.events.creative-futures-session')
                ->with('event', $event)
                ->with('randomEvents', $randomEvents);
        }
        
    }

    public function speakers()
    {
        $page = "speakers";

        $years = Event::selectRaw('YEAR(event_start) as year')
            ->groupBy('year')->orderBy('year', 'desc')
            ->get();

        return view('website.events.creative-futures-main')
            ->with('page', $page)
            ->with('years', $years);
    }
}
