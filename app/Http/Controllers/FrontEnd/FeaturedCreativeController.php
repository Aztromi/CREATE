<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturedCreativeController extends Controller
{
    public function index() {

        $creatives = collect([
            (object) [
                'name' => 'Muri',
                'month_short' => 'MAR',
                'month_long'  => 'MARCH',
                'yt_id' => '-yLNXt3Ifcg',
                'article_title' => 'On her South by Southwest Music Festival debut',
                'article_link' => 'https://createphilippines.com/article/on-her-south-by-southwest-music-festival-debut',
                'background_color' => '#ff5757'
            ],
            (object) [
                'name' => 'Leandro Reyes',
                'month_short' => 'APR',
                'month_long'  => 'APRIL',
                'yt_id' => 'Ok6oEDQ4itw',
                'article_title' => 'Speaking up for spoken word poetry',
                'article_link' => 'https://createphilippines.com/article/speaking-up-for-spoken-word-poetry',
                'background_color' => '#ffae00'
            ],
            (object) [
                'name' => 'Dustin Carbonera',
                'month_short' => 'MAY',
                'month_long'  => '',
                'yt_id' => '1qyeh30nRfI',
                'article_title' => 'Dustin Carbonera designs with an eye to the future',
                'article_link' => 'https://createphilippines.com/article/dustin-carbonera-designs-with-an-eye-to-the-future',
                'background_color' => '#9ce339'
            ],
            (object) [
                'name' => 'Justine Wieneke',
                'month_short' => 'JUN',
                'month_long'  => 'JUNE',
                'yt_id' => 'Q1699Oip-HU',
                'article_title' => 'Justine Wieneke takes calculated risks, all for the love of Pinoy hip-hop',
                'article_link' => 'https://createphilippines.com/article/justine-wieneke-takes-calculated-risks-all-for-the-love-of-pinoy-hip-hop',
                'background_color' => '#ffe1a2'
            ],
            (object) [
                'name' => 'GameOps',
                'month_short' => 'JUL',
                'month_long'  => 'JULY',
                'yt_id' => 'Gz2nfps7h3A',
                'article_title' => 'For GameOps, game development is as much about people as it is about technology',
                'article_link' => 'https://createphilippines.com/article/for-gameops-game-development-is-as-much-about-people-as-it-is-about-technology',
                'background_color' => '#97c2ff'
            ],
            (object) [
                'name' => 'Jill Arteche',
                'month_short' => 'AUG',
                'month_long'  => 'AUGUST',
                'yt_id' => 'j3-tn_i1t1Q',
                'article_title' => 'Life is strange and funny, and that’s just how Jill Arteche likes it',
                'article_link' => 'https://createphilippines.com/article/life-is-strange-and-funny-and-thats-just-how-jill-arteche-likes-it',
                'background_color' => '#ece802ff'
            ],
            (object) [
                'name' => 'Marrie Saplad',
                'month_short' => 'SEP',
                'month_long'  => 'SEPTEMBER',
                'yt_id' => 'WHwD0R5mchQ',
                'article_title' => 'Finding refuge in Marrie Saplad’s art',
                'article_link' => 'https://createphilippines.com/article/finding-refuge-in-marrie-saplads-art',
                'background_color' => '#00cb84ff'
            ],
            (object) [
                'name' => 'Paolo Salgado',
                'month_short' => 'OCT',
                'month_long'  => 'OCTOBER',
                'yt_id' => 'kTFBC5MjPLI',
                'article_title' => 'For Paolo Salgado, brand design work is more than just creating a catchy logo',
                'article_link' => 'https://createphilippines.com/article/for-paolo-salgado-brand-design-work-is-more-than-just-creating-a-catchy-logo',
                'background_color' => '#7151ffff'
            ]
        ]);







        return view('website.featured-creatives', ['creatives' => $creatives]);
    }
}
