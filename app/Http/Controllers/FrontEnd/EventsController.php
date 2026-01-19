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
        $featured_singers = [
            [
                'name' => 'August Wahh',
                'description' => 'She is a singer-songwriter who blends experimental R&B and Nu Soul, making captivating beats and a sultry, intimate edge rooted in vulnerability and human expression. Her music feels raw and unfiltered, leaning more on the emotional truth.',
                'genre' => 'NEO SOUL, HYPER POP, R&B, ELECTRONIC',
                'image' => 'BMC_artist_1.png',
                'insta_link' => 'https://www.instagram.com/augustwahh/?hl=en',
                'listen_link' => 'https://open.spotify.com/artist/4NsvRUCOVV4KrWRfF65Rcj',
                'style' => 'rgba(185, 130, 188, 0.7)',
                'loading' => 'august',
            ],
            [
                'name' => 'bird.',
                'description' => 'A four-piece vibecore band that crafts feel-good, uplifting tunes infused with shoegaze and dreampop textures, balancing elements of band-driven sound, mainstream pop, and indie music. Their music is a safe space made for moments where you can breathe and let loose.',
                'genre' => 'VIBECORE INFUSED WITH SHOEGAZE & DREAMPOP TEXTURES',
                'image' => 'BMC_artist_2.png',
                'insta_link' => 'https://www.instagram.com/bird.mnl/?hl=en',
                'listen_link' => 'https://open.spotify.com/artist/5ZR9GMo2iB8nxetEtvRdey?si=yTXR0oDxT6a2Gl73n3xbZQ',
                'style' => 'rgba(227, 247, 151, 0.7)',
                'loading' => 'bird'
            ],
            [
                'name' => 'Delinquent Society',
                'description' => 'A hip-hop duo forged through years of shared history and experimentation. Their impact is driven by high-energy live performances and a consistent stream of creative output, earning recognition not only for their musicality but also for a distinctive visual and fashion-forward identity.',
                'genre' => 'ALTERNATIVE HIP HOP',
                'image' => 'BMC_artist_3.png',
                'insta_link' => 'https://www.instagram.com/delinquentsociety_/?hl=en',
                'listen_link' => 'https://open.spotify.com/artist/4WUC1M0EpVDrx7xKILoLy6',
                'style' => 'rgba(248, 118, 240, 0.7)',
                'loading' => 'delinquent'
            ],
            [
                'name' => 'ONE CLICK STRAIGHT',
                'description' => 'A band that breaks free from restrictive genre norms, blending indie-pop electronic rock into an ever-evolving sound. Their authentic songwriting resists reliance on a single formula, instead embracing experimentation to craft music that is distinctive, dynamic, and stylistically bold.',
                'genre' => 'INDIE POP ELECTRONIC ROCK',
                'image' => 'BMC_artist_4.png',
                'insta_link' => 'https://www.instagram.com/oneclickstraight/',
                'listen_link' => 'https://open.spotify.com/artist/457BGAQIRpxlvY5gcbDjUQ',
                'style' => 'rgba(248, 118, 240, 0.7)',
                'loading' => 'straight'
            ],
            [
                'name' => 'Pedicab',
                'description' => 'Fusing punk attitude with disco rhythms, this band helped reshape Philippine alternative music. Their sound is widely regarded as a modern classic, driven by a bold mix of spoken-word vocals, pulsating synthesizers, and an uncompromising approach that makes their music raw, danceable, and unmistakably forward-thinking.',
                'genre' => 'DISCO PUNK, SYNTH PUNK, POST PUNK, NEW WAVE',
                'image' => 'BMC_artist_5.png',
                'insta_link' => 'https://www.instagram.com/pedicabmanila/?hl=en',
                'listen_link' => 'https://open.spotify.com/artist/270BokezkycFfTTlGEKVKZ?si=te6zr85bRf65vX99aebBUQ',
                'style' => 'rgba(227, 247, 151, 0.7)',
                'loading' => 'pedicab'
            ],
            [
                'name' => 'PLAYERTWO',
                'description' => 'This creative force pushes boundaries with every music release, carving out a distinct sound within alternative hip-hop. Anchored by punchy beats, playful lyricism, and genre-bending instincts, they’ve gained widespread visibility and emerged as trendsetters in the industry.',
                'genre' => 'ENERGETIC AND ROWDY ALTERNATIVE HIP HOP',
                'image' => 'BMC_artist_6.png',
                'insta_link' => 'https://www.instagram.com/weareplayertwo_/?hl=en',
                'listen_link' => 'https://open.spotify.com/artist/4wjgqUtfS9TNfMHhjEqAb7?si=wAe-PmTfQkOKaLUmM1Lg8w',
                'style' => 'rgba(185, 130, 188, 0.7)',
                'loading' => 'player'
            ],
        ];
        $content = [
            [
                "title" => "B2B Interactions & Networking",
                "description" => [
                    "Connect with international counterparts in curated roundtable sessions",
                    "Speak on panels and join global conversations",
                    "Engage in business matching and pitching sessions with agencies, buyers, and industry partners"
                ]
            ],
            [
                "title" => "Creative Hubs & Conferences",
                "description" => [
                    "Experience a festival-meets-business environment designed to foster meaningful connections",
                    "Explore key creative spaces across Bangkok’s creative district",
                    "Build relationships with studios, companies, and institutions",
                ]
            ],
            [
                "title" => "Talent & Artistry Showcase",
                "description" => [
                    "Perform in and utilize six official Philippine showcase slots",
                    "Present to over 100 festival programmers, music supervisors, and delegates from across Asia",
                    "Spark collaborations and connect with industry leaders",
                ]
            ],
        ];
        $singers = collect($featured_singers)
            ->map(fn($item) => (object) $item);
        return view('website.info_page.2026_bangkok.index', ['featured_singers' => $singers, 'content' => $content]);
    }

    public function animahenasyon25()
    {
        return view('website.info_page.2025_animahenasyon.index');
    }
}
