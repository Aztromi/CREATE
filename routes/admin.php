<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEnd\TestController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AdminDashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ApplicationRequestController as ApplicationRequest;
use App\Http\Controllers\Admin\CreativeListController;
use App\Http\Controllers\Admin\CreativeWorkController as CreativeWorkAdmin;
use App\Http\Controllers\Admin\Creatives\AccountController as CreativeAccount;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\ExhibitorController;
use App\Http\Controllers\Shared\MessageController;
use App\Http\Controllers\Shared\ConnectCreativeController;
use App\Http\Controllers\ThumbnailController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| 
|
*/

//Accessible only to All Admin. All Admin Types.

// Route::get('/B2BSendTest', [AdminDashboard::class, 'sendTest']);

Route::get('/', [AdminDashboard::class, 'showAdminDashboard'])->name('index');
Route::get('/profile', function () {
    return view('admin.users.profile');
})->name('profile');
Route::get('/change-password', [AdminDashboard::class, 'changePassword'])->name('changePassword');

// Route::get('/linkstorage', function () {
//     Artisan::call('storage:link');
// });



// ARTICLES
Route::get('/articles', [ArticleController::class, 'showArticleList'])->name('article-list');
Route::get('/add-article', [ArticleController::class, 'showAddForm'])->name('add-article');
Route::get('/edit-article/{id?}', [ArticleController::class, 'showEditForm'])->name('edit-article');
Route::post('/process-article', [ArticleController::class, 'validateAndSave'])->name('process-article');

// Category
Route::get('/creative-fields', function () {
    return view('admin.category.creative-fields');
})->name('creative-fields');
Route::get('/creative-industries', function () {
    return view('admin.category.creative-industries');
})->name('creative-industries');
Route::get('/add-creative-industry', function () {
    return view('admin.category.form-creative-industry');
})->name('add-creative-industry');
Route::get('/edit-creative-industry', function () {
    return view('admin.category.form-creative-industry');
})->name('edit-creative-industry');
Route::get('/add-creative-field', function () {
    return view('admin.category.form-creative-field');
})->name('add-creative-field');
Route::get('/edit-creative-field', function () {
    return view('admin.category.form-creative-field');
})->name('edit-creative-field');

// Partners - Business Solutions Services
Route::get('/business-solutions-services', function () {
    return view('admin.partners.bss');
})->name('business-solutions-services');
Route::get('/add-business-solutions-partner', function () {
    return view('admin.partners.form-bss');
})->name('add-business-solutions-partner');
Route::get('/edit-business-solutions-partner', function () {
    return view('admin.partners.form-bss');
})->name('edit-business-solutions-partner');
Route::get('/partners', function () {
    return view('admin.partners.partners');
})->name('partners');
Route::get('/add-partner', function () {
    return view('admin.partners.form-partner-details');
})->name('add-partner-details');
Route::get('/edit-partner', function () {
    return view('admin.partners.form-partner-details');
})->name('edit-partner-details');

// Events - Calendar
Route::get('/calendar', function () {
    return view('admin.events.calendar');
})->name('calendar');
Route::get('/add-event', function () {
    return view('admin.events.form-calendar-event');
})->name('add-calendar');
Route::get('/edit-event', function () {
    return view('admin.events.form-calendar-event');
})->name('edit-calendar');
Route::get('/creative-futures', function () {
    return view('admin.events.creative-futures');
})->name('creative-futures');
Route::get('/add-creative-futures-session', function () {
    return view('admin.events.form-creative-futures');
})->name('add-creative-futures-session');
Route::get('/edit-creative-futures-session', function () {
    return view('admin.events.form-creative-futures');
})->name('edit-creative-futures-session');
Route::get('/speakers', function () {
    return view('admin.events.speakers');
})->name('speakers');
Route::get('/add-creative-futures-speaker', function () {
    return view('admin.events.form-speaker');
})->name('add-creative-futures-speaker');
Route::get('/edit-creative-futures-speaker', function () {
    return view('admin.events.form-speaker');
})->name('edit-creative-futures-speaker');

// Users
Route::get('/user-list', function () {
    return view('admin.users.user-list');
})->name('user-list');
Route::get('/user-roles', function () {
    return view('admin.users.user-roles');
})->name('user-roles');
Route::get('/add-user', function () {
    return view('admin.users.user-form');
})->name('add-user');
Route::get('/edit-user-details', function () {
    return view('admin.users.user-form');
})->name('edit-user-details');

// Creative Cities
Route::get('/creative-cities', function () {
    return view('admin.creative-cities.list');
})->name('creative-cities');
Route::get('/add-creative-city', function () {
    return view('admin.creative-cities.form');
})->name('add-creative-city');
Route::get('/edit-creative-city', function () {
    return view('admin.creative-cities.form');
})->name('edit-creative-city');


Route::prefix('upload')->name('upload.')->group(function () {
    Route::post('/article-image-upload', [UploadController::class, 'articleContentImageUpload'])->name('article.image-upload');
});

route::prefix('connect-with-creatives')->name('connect-creative.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.connect-creative.list');
    });
    Route::get('/request', [ConnectCreativeController::class, 'addFormAdmin'])->name('adminAdd');
    Route::get('/list', [ConnectCreativeController::class, 'list'])->name('list');
    Route::get('/response/{id?}', [ConnectCreativeController::class, 'response'])->name('response');
    Route::post('/response/get-creatives', [ConnectCreativeController::class, 'getCreatives'])->name('getCreatives');
    Route::post('/response/get-profile', [ConnectCreativeController::class, 'getProfile'])->name('getProfile');
    Route::post('/response/save-recommendation', [ConnectCreativeController::class, 'saveRecommendation'])->name('saveRecommendation');
});

//Thumbnail Creator
Route::get('/add-thumbnail', [ThumbnailController::class, 'index'])->name('index');
Route::post('/add-thumbnail', [ThumbnailController::class, 'updateThumbnails'])->name('add-thumbnail.update');


Route::middleware('admin.super')->group(function () { //Accessible only to Super Admins.

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return '<h1>Cache facade value cleared</h1>';
    });
    Route::get('/clear-config', function () {
        Artisan::call('config:clear');
        return '<h1>Config facade value cleared</h1>';
    });
    Route::get('/clear-view', function () {
        Artisan::call('view:clear');
        return '<h1>View facade value cleared</h1>';
    });
    Route::get('/clear-route', function () {
        Artisan::call('route:clear');
        return '<h1>Route facade value cleared</h1>';
    });


    //     //ROUTE GOES HERE
    Route::get('/user-connect-test', [TestController::class, 'UserConnectTest']);
    //     Route::get('/test_articles', [TestController::class, 'articles_index'])->name('test.articles');
    //     Route::get('/test_stories', [TestController::class, 'stories_index'])->name('test.stories');
    //     Route::get('/test_profiles', [TestController::class, 'profiles_index'])->name('test.profiles');
    //     Route::get('/test_upd', [TestController::class, 'upd_index']);
    //     Route::post('/upd_vld', [TestController::class, 'upd_validate'])->name('test.upd.vld');

});


Route::middleware(['admin.og'])->group(function () { //Accessible only to OG Admins and Super Admins.

    // Registered website users

    Route::get('/creatives-list', [CreativeListController::class, 'index'])->name('creatives-list');
    Route::get('/member-list', function () {
        return view('admin.registered-users.member-list');
    })->name('member-list');
    // Route::get('/view-details/{id}', function () { return view('admin.registered-users.view-details'); })->name('view-details');
    // Route::get('/add-member', function () { return view('admin.registered-users.form'); })->name('add-member');
    Route::get('/edit-details/{id?}', [CreativeAccount::class, 'showEditForm'])->name('edit-details');
    Route::post('/edit-details/process', [CreativeAccount::class, 'processEdit'])->name('edit-details.process');


    Route::get('/application-requests', [ApplicationRequest::class, 'applicationRequests'])->name('application-requests');
    Route::post('/application-requests/approval', [ApplicationRequest::class, 'userApproval'])->name('application-requests-approval');
    Route::post('/application-requests/status', [ApplicationRequest::class, 'userStatus'])->name('application-requests-status');
    Route::post('/application-requests/deny', [ApplicationRequest::class, 'userDeny'])->name('application-requests-deny');

    Route::prefix('exhibitor')->name('exhibitors.')->group(function () {
        Route::get('/', [ExhibitorController::class, 'index'])->name('index');
        Route::get('/list', [ExhibitorController::class, 'list'])->name('list');
        Route::post('/exhibitor-list', [ExhibitorController::class, 'getExhibitorList'])->name('getExhibitorList');
        Route::get('/details/{id?}', [ExhibitorController::class, 'showProfileForm'])->name('showProfileForm');
        Route::post('/update-exhibitor-status', [ExhibitorController::class, 'statusChange'])->name('exbStatusChange');
    });

    Route::prefix('creative-works')->name('creativeWorks.')->group(function () {
        Route::get('/', [CreativeWorkAdmin::class, 'index'])->name('index');
        Route::get('/list', [CreativeWorkAdmin::class, 'list'])->name('list');
        Route::get('/add', [CreativeWorkAdmin::class, 'showAddForm'])->name('add');
        Route::get('/edit/{slug?}', [CreativeWorkAdmin::class, 'showEditForm'])->name('edit');
    });


    Route::get('/messages', [MessageController::class, 'indexAdmin'])->name('messages');
});


Route::middleware('admin.bdu')->group(function () { //Accessible only to BDU Admins.

    //ROUTE GOES HERE

});


Route::middleware('admin.editor')->group(function () { //Accessible only to Editor Admins.

    //ROUTE GOES HERE

});
