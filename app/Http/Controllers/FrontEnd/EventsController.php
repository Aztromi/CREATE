<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

use App\Models\CreativeEvent;
use App\Models\PGDXGame;
use App\Models\PGDXGameContact;

class EventsController extends Controller
{
    public function creativeEvents()
    {

        $creative_events = CreativeEvent::where('status', 1)
            ->where('date_start', '>=',  now())
            ->orderBy('date_start', 'desc')->get();
        $past_creative_events = CreativeEvent::where('status', 1)
            ->where('date_start', '<',  now())
            ->orderBy('date_start', 'desc')
            ->paginate(9);
        $weeks = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        return view('website.events.creativeEvents', ['creative_events' => $creative_events, 'weeks' => $weeks, 'past_creative_events' => $past_creative_events]);
    }

    public function pastEventsApi()
    {
        $events = CreativeEvent::where('status', 1)
            ->where('date_end', '<', now())
            ->orderBy('date_start', 'desc')
            ->paginate(9);
        $events->getCollection()->transform(function ($event) {
            $event->image_url = asset('folder_events/creative-events/' . $event->img);
            return $event;
        });
        return response()->json($events);
    }

    public function citemxmipam24()
    {
        return view('website.info_page.citem_mipam24');
    }

    public function citemxmipam25()
    {
        return view('website.info_page.citem_mipam2025.citem_mipam25_v2');
    }

    public function citemxmipam24gallery()
    {
        $photos = ["20240711_134150_656.jpg", "20240711_134332_822.jpg", "20240711_134857_190.jpg", "20240711_135120_557.jpg", "20240711_135226_252.jpg", "20240711_135319_995.jpg", "20240711_135437_063.jpg", "20240711_135650_789.jpg", "20240711_135834_094.jpg", "20240711_135943_258.jpg", "20240711_140114_843.jpg", "20240711_140214_701.jpg", "20240711_140311_249.jpg", "20240711_140425_120.jpg", "20240711_140529_779.jpg", "20240711_140639_934.jpg", "20240711_140733_907.jpg", "20240711_141337_638.jpg", "20240711_144430_853.jpg", "20240711_153058_847.jpg", "20240711_153201_400.jpg", "20240711_154946_259.jpg", "20240711_160645_916.jpg", "20240711_160742_243.jpg", "20240711_160840_824.jpg", "20240711_161023_430.jpg", "20240711_161209_760.jpg", "20240711_161306_804.jpg", "20240711_161408_755.jpg", "20240711_161759_450.jpg", "20240711_163952_353.jpg", "20240711_164248_479.jpg", "20240711_164542_399.jpg", "20240711_164717_227.jpg", "20240711_164812_874.jpg", "20240711_164912_970.jpg", "20240711_165014_633.jpg", "20240711_165426_973.jpg", "20240711_165555_066.jpg", "20240711_165720_279.jpg", "20240711_165844_695.jpg", "20240711_170128_776.jpg", "20240711_170359_047.jpg", "20240711_170639_196.jpg"];
        // $photos2 = ["Frame%20133.png","Frame%20158.png","Frame%20172.png","Frame%2052.png","Frame%2082.png","Frame%20136.png","Frame%20159.png","Frame%20173.png","Frame%2055.png","Frame%2088.png","Frame%20139.png","Frame%20160.png","Frame%20174.png","Frame%2058.png","Frame%2089.png","Frame%20140.png","Frame%20161.png","Frame%20175.png","Frame%2061.png","Frame%2090.png","Frame%20141.png","Frame%20162.png","Frame%20176.png","Frame%2063.png","Frame%2091.png","Frame%20142.png","Frame%20163.png","Frame%20177.png","Frame%2068.png","Frame%2092.png","Frame%20144.png","Frame%20164.png","Frame%20178.png","Frame%2069.png","Frame%2093.png","Frame%20145.png","Frame%20165.png","Frame%2037.png","Frame%2071.png","Frame%2094.png","Frame%20146.png","Frame%20166.png","Frame%2039.png","Frame%2072.png","Frame%2095.png","Frame%20148.png","Frame%20167.png","Frame%2040.png","Frame%2073.png","Frame%2096.png","Frame%20150.png","Frame%20168.png","Frame%2041.png","Frame%2074.png","Frame%20153.png","Frame%20169.png","Frame%2044.png","Frame%2075.png","Frame%20154.png","Frame%20170.png","Frame%2048.png","Frame%2077.png","Frame%20156.png","Frame%20171.png","Frame%2050.png","Frame%2078.png"];
        $photos2 = ["Frame133.png", "Frame158.png", "Frame172.png", "Frame52.png", "Frame82.png", "Frame136.png", "Frame159.png", "Frame173.png", "Frame55.png", "Frame88.png", "Frame139.png", "Frame160.png", "Frame174.png", "Frame58.png", "Frame89.png", "Frame140.png", "Frame161.png", "Frame175.png", "Frame61.png", "Frame90.png", "Frame141.png", "Frame162.png", "Frame176.png", "Frame63.png", "Frame91.png", "Frame142.png", "Frame163.png", "Frame177.png", "Frame68.png", "Frame92.png", "Frame144.png", "Frame164.png", "Frame178.png", "Frame69.png", "Frame93.png", "Frame145.png", "Frame165.png", "Frame37.png", "Frame71.png", "Frame94.png", "Frame146.png", "Frame166.png", "Frame39.png", "Frame72.png", "Frame95.png", "Frame148.png", "Frame167.png", "Frame40.png", "Frame73.png", "Frame96.png", "Frame150.png", "Frame168.png", "Frame41.png", "Frame74.png", "Frame153.png", "Frame169.png", "Frame44.png", "Frame75.png", "Frame154.png", "Frame170.png", "Frame48.png", "Frame77.png", "Frame156.png", "Frame171.png", "Frame50.png", "Frame78.png"];

        return view('website.info_page.mipam_gallery', compact('photos', 'photos2'));
    }

    public function createlab25()
    {
        // CREATE x IFEX 2025
        // return view('website.info_page.create_lab2025.index_ifex2025');

        $gallery = [
            asset('img/static/createlab/gallery/IFEX2025_Day_1_01.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_2_02.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_2_03.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_1_04.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_1_05.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_1_06.jpg')
        ];

        return view('website.info_page.create_lab2025.index_fame2025', ['gallery_images' => $gallery]);
    }

    public function createlab25_test()
    {
        $gallery = [
            asset('img/static/createlab/gallery/IFEX2025_Day_1_01.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_2_02.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_2_03.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_1_04.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_1_05.jpg'),
            asset('img/static/createlab/gallery/IFEX2025_Day_1_06.jpg')
        ];

        return view('website.info_page.create_lab2025.index_fame2025', ['gallery_images' => $gallery]);
    }

    public function pgdx25()
    {
        return view('website.info_page.2025_pgdx.index');
    }

    public function mipamxsonic25()
    {
        return view('website.info_page.2025_mipamxsonic.index');
    }
    public function bmc26()
    {
        return view('website.info_page.2026_bangkok.index');
    }

    public function animahenasyon25()
    {
        return view('website.info_page.2025_animahenasyon.index');
    }
}
