<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEnd\ArticlesController;
use App\Http\Controllers\FrontEnd\ConnectCreativeController;
use App\Http\Controllers\FrontEnd\DirectoryController;

use App\Http\Controllers\FrontEnd\EventsController;
use App\Http\Controllers\FrontEnd\FeaturedCreativeController as FeaturedCreative;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\PlayController;
use App\Http\Controllers\FrontEnd\ProfilesController;
use App\Http\Controllers\FrontEnd\ResourcesController;

use App\Http\Controllers\FrontEnd\RegistrationController as PublicRegistration;

use App\Http\Controllers\FrontEnd\StoriesController;
use App\Http\Controllers\FrontEnd\UserContactController;

use App\Http\Controllers\FrontEnd\TestController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// !!! FOR STORAGE LINKING. Execute ONCE for any changes to the Filesystem links.
// Route::get('/pushupdate', function () {
//     Artisan::call('storage:link');
// });

Auth::routes();

Route::post('/recaptcha-validate', [App\Http\Controllers\RecaptchaController::class, 'recaptcha_validate'])->name('recaptcha');

// Route::prefix('test')->name('test.')->group(function(){
//     Route::get('/test_articles', [TestController::class, 'articles_index'])->name('articles');
//     Route::get('/test_stories', [TestController::class, 'stories_index'])->name('stories');
//     Route::get('/test_profiles', [TestController::class, 'profiles_index'])->name('profiles');
// });

Route::get('/captcha-test-saldfkdhakufchbadiufhbcdxjn', function () {
    return view('captcha-test');
});

//Guest and All Public User type middleware

/* *********** First Level Pages *********** */

// Route::get('/', function () { return view('website.home'); });
// Route::get('/directory', function () { return view('website.directory'); })->name('directory');

// Route::get('/test', [TestController::class, 'test'])->name('test');

Route::get('/service-redirect', [HomeController::class, 'serviceRedirect'])->name('serviceRedirect');

// TEMP HOME ROUTE. FOR DEV
Route::get('/37r6bcy89h39287yf2cc871', [HomeController::class, 'home']);

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::post('/get-categories', [HomeController::class, 'getCategories'])->name('getCategories');

Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
Route::get('/article/{slug}', [ArticlesController::class, 'view'])->name('articles.view');

//Added redirect for misspelled url
Route::get('/connect-with-creative', function () {
    return redirect()->route('connect-creative.index');
});
route::prefix('connect-with-creatives')->name('connect-creative.')->group(function () {
    Route::get('/', [HomeController::class, 'connectWithCreative'])->name('index');
    Route::get('/request', [ConnectCreativeController::class, 'addForm'])->name('add');
    Route::post('/request/submit', [ConnectCreativeController::class, 'validateAndSaveRequest'])->name('submit');
});


Route::get('/creative-features', [FeaturedCreative::class, 'index'])->name('featuredCreatives');

Route::get('/contact-us', function () {
    return view('website.contact-us');
})->name('contact-us');
Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');

Route::get('/privacy-policy', function () {
    return view('website.privacy-policy');
})->name('privacy-policy');

// Route::post('/searching',  [HomeController::class, 'searchInitial'])->name('search-init');
// Route::get('/search/{value?}',  [HomeController::class, 'search'])->name('search');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/searchuwbh84r7vt2crhx72hcfefubv2c8f2xf', [HomeController::class, 'searchTest'])->name('search-test');

Route::get('/profile/{slug}', [ProfilesController::class, 'viewPublic'])->name('profile');
Route::get('/works/{slug}', [ProfilesController::class, 'viewPublic'])->name('works');
Route::get('/profile', function () {
    return redirect('/directory');
});

//Contact-us Validation and E-mail Send
Route::post('/send-message', [UserContactController::class, 'sendMessage'])->name('send-message');

Route::get('/creative-work/{slug}', [StoriesController::class, 'view'])->name('creative-works.view');

// Route::get('/everything_creative', [EverythingCreativeController::class, 'showPage'])->name('everything-creative');

Route::get('/createph-x-mipam', function () {
    return redirect()->route('events.createph-x-mipam');
})->name('createph-x-mipam');
// CREATE x MIPAM 2024: Route::get('/createph-x-mipam', [EventsController::class, 'citemxmipam24'])->name('createph-x-mipam');
Route::get('/createph-x-mipam/gallery', function () {
    return redirect()->route('events.createph-x-mipam-gallery');
})->name('createph-x-mipam-gallery');


// Events
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('events.creative-events');
    });
    Route::get('/bmc-2026', [EventsController::class, 'bmc26'])->name('bmc-2026');
    Route::get('/createph-x-mipam', [EventsController::class, 'mipamxsonic25'])->name('createph-x-mipam');

    Route::get('/createph-x-mipam/gallery', [EventsController::class, 'citemxmipam24gallery'])->name('createph-x-mipam-gallery');
    Route::get('/create-lab', [EventsController::class, 'createlab25'])->name('create-lab');
    Route::get('/create-lab-test-382yrc2871398cnfb', [EventsController::class, 'createlab25_test'])->name('create-lab-test');
    Route::get('/pgdx-2025', [EventsController::class, 'pgdx25'])->name('pgdx-2025');

    Route::get('/pgdx-2025/play', function () {
        return redirect()->route('play.leaderboard');
    })->name('pgdx-2025.play');
    Route::get('/pgdx-2025/play/{game?}', function ($game = null) {
        return redirect()->route('play.select', ['game' => $game]);
    })->name('pgdx-2025.play.select');

    Route::post('/pgdx-2025/play/generate-id', [PlayController::class, 'pgdx25GenerateID'])->name('pgdx-2025.play.generate-id');
    Route::post('/pgdx-2025/play/save-score', [PlayController::class, 'pgdx25SaveScore'])->name('pgdx-2025.play.save-score');
    Route::post('/pgdx-2025/play/save-contact', [PlayController::class, 'pgdx25SaveContact'])->name('pgdx-2025.play.save-contact');

    Route::get('/animahenasyon-2025', [EventsController::class, 'animahenasyon25'])->name('animahenasyon');


    // CREATIVE FUTURES - DISCONTINUED
    // Route::get('/creative-futures/{lyear?}', [CreativeFuturesController::class, 'index'])->name('creative-futures');
    // Route::get('/creative-futures/speakers/{slug}', [CreativeFuturesController::class, 'speakers'])->name('creative-futures-speakers');
    // Route::get('/creative-futures/sessions/{slug?}', [CreativeFuturesController::class, 'session'])->name('creative-futures-session');

    // Route::get('/calendar', function () { return redirect()->route('home'); })->name('calendar');
    Route::get('/creative-events', [EventsController::class, 'creativeEvents'])->name('creative-events');
    Route::get('/past-creative-events', [EventsController::class, 'pastEventsApi'])->name('past-creative-events');
});

Route::prefix('play')->name('play.')->group(function () {
    Route::get('/', [PlayController::class, 'pgdx25Play'])->name('leaderboard');
    Route::get('/{game?}', [PlayController::class, 'pgdx25PlaySelect'])->name('select');

    Route::post('/generate-id', [PlayController::class, 'pgdx25GenerateID'])->name('generate-id');
    Route::post('/save-score', [PlayController::class, 'pgdx25SaveScore'])->name('save-score');
    Route::post('/save-contact', [PlayController::class, 'pgdx25SaveContact'])->name('save-contact');
});

// Resources
Route::prefix('resources')->name('resources.')->group(function () {
    // Route::get('/laws-and-bills', function () { return view('website.resources.related-laws-and-bills'); })->name('laws-and-bills');
    // Route::get('/news', function () { return view('website.resources.industry-news'); })->name('news');
    Route::get('/', function () {
        return redirect()->route('resources.helpful-links');
    });
    Route::get('/helpful-links', [ResourcesController::class, 'helpfulLinks'])->name('helpful-links');
    Route::post('/get-helpful-links', [ResourcesController::class, 'getHelpfulLinks'])->name('get-helpful-links');
});


// About
Route::prefix('about-us')->name('about-us.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('about-us.create-philippines');
    });
    Route::get('/create-philippines', function () {
        return view('website.about.about-us');
    })->name('create-philippines');
    Route::get('/organizers', function () {
        return view('website.about.organizers');
    })->name('organizers');
    Route::get('/partners', function () {
        return view('website.about.partners');
    })->name('partners');
});



// Business Solutions Services
// Route::prefix('business-solutions-services')->name('business-solutions-services.')->group(function () {
//     Route::get('/about', function () { return view('website.bss.about'); })->name('about');
//     Route::get('/faq', function () { return view('website.bss.faq'); })->name('faq');
//     Route::get('/directory', function () { return view('website.bss.directory'); })->name('directory');
//     Route::get('/directory/{slug}', function () { return view('website.bss.companyView'); })->name('company-view');
//     Route::get('/programs-and-offers', function () { return view('website.bss.programs-and-offers'); })->name('programs-and-offers');
//     Route::get('/programs-and-offers/{slug}', function () { return view('website.bss.programView'); })->name('programs-view');
// });



// REGISTRATION
Route::prefix('register')->name('register.')->group(function () {



    // Route::get('/', function () { return redirect()->route('serviceRedirect'); });
    Route::get('/', function () {
        // if (request()->has('utm_source') && request()->utm_source === 'CreatexMIPAM_2025_March_Wk3') {
        //     return redirect('https://citem.ph/p/25537c');
        // }
        return redirect()->route('register.step-one');
    })->name('index');




    // Route::get('/step-1', function () { return redirect()->route('serviceRedirect'); })->name('step-one');

    Route::get('/step-1', [PublicRegistration::class, 'showRegistrationForm'])->name('step-one');
    Route::post('/step-1', [PublicRegistration::class, 'register'])->name('submit');
    Route::post('/01/validate', [PublicRegistration::class, 'validateField'])->name('step-one-validate');

    Route::get('/verify/{token}', [PublicRegistration::class, 'verifyEmail'])->name('email-verification');
    Route::get('/email-verified', function () {
        return view('messages.emailVerified');
    })->name('message.verified');




    // Transfer to corresponding user type
    // Route::get('/step-2', function () { return view('register.step-2'); })->name('step-two');
    // Route::get('/step-3', function () { return view('register.step-3'); })->name('step-three');
    // Route::get('/step-4', function () { return view('register.step-4'); })->name('step-four');
    // Route::get('/upload-requirements', function () { return view('register.upload-requirements'); })->name('upload-requirements');
});



Route::middleware('web.validuser')->group(function () { //Access for Authenticated Regular users(not Admin).

    // REGISTRATION
    Route::prefix('register')->name('register.')->group(function () {

        // Transfer to corresponding user type


    });

    /* *********** NEWSFEED *********** */
    Route::prefix('newsfeed')->name('newsfeed.')->group(function () {
        Route::get('/', function () {
            return view('newsfeed.newsfeed');
        })->name('index');
        Route::get('/works', function () {
            return view('newsfeed.newsfeed');
        })->name('works');
        Route::get('/articles', function () {
            return view('newsfeed.newsfeed');
        })->name('articles');
        Route::get('/announcement', function () {
            return view('newsfeed.newsfeed');
        })->name('announcement');
    });

    /* *********** NEWSFEED *********** */
});
