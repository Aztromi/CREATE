<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users\BookmarkController;
use App\Http\Controllers\GenController;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Users\RegistrationController as UserRegistration;
use App\Http\Controllers\Users\ProfileController as UserProfile;
use App\Http\Controllers\Users\CreativeWorkController as CreativeWork;
use App\Http\Controllers\Shared\ConnectCreativeController;
use App\Http\Controllers\Shared\MessageController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|
*/

Route::name('user.')->group(function () { //Accessible only to All Registered Users.

    // ALL Auth
    Route::get('/',[DashboardController::class, 'showDashboard'])->name('index');
    Route::get('/announcements', function () { return view('dashboard.content.announcements'); })->name('announcement');
    Route::get('/inbox', function () { return view('dashboard.content.inbox'); })->name('inbox');
    Route::get('/messages', [MessageController::class, 'index'])->middleware('messaging.all')->name('messages');
    Route::get('/bookmarks', function () { return view('dashboard.content.bookmarks'); })->name('bookmarks');

    Route::get('/account', [UserProfile::class, 'viewProfile'])->name('account');
    Route::get('/edit-account/{id?}', [UserProfile::class, 'editProfile'])->name('edit-account');
    // Route::post('/get-account-data', [UserProfile::class, 'getProfileData'])->name('get-account-data');
    // Route::post('/edit-account/process', [UserProfile::class, 'updateProfile'])->name('edit-account.process');

    Route::get('/engagements', function () { return view('dashboard.content.engagements'); })->name('engagements');

    Route::post('/get-user-stats', [DashboardController::class, 'getUserStats'])->name('getUserStats');

    Route::get('/change-password', [DashboardController::class, 'changePassword'])->name('changePassword');
    Route::post('/submit-password', [DashboardController::class, 'passwordvalidateAndSave'])->name('passwordvalidateAndSave');

    Route::middleware('user.member')->group(function () {

        Route::get('register/register-type',  [UserRegistration::class, 'showStepEventForm'])->name('register.type');

        Route::prefix('register/step-2')->name('register.')->group(function () {
            Route::get('/{type?}', [UserRegistration::class, 'showStep2Form'])->name('step-two');
            Route::post('/submit', [UserRegistration::class, 'step2Validate'])->name('step-two.validate');
        });
    
        Route::prefix('register/step-3')->name('register.')->group(function () {
            Route::get('/{type?}', [UserRegistration::class, 'showStep3Form'])->name('step-three');
            Route::post('/get-step3-data', [UserRegistration::class, 'getStep3Data'])->name('step-three.data');
            Route::post('/submit', [UserRegistration::class, 'step3Validate'])->name('step-three.validate');
        });
    
        Route::prefix('register/step-4')->name('register.')->group(function () {
            Route::get('/{type?}', [UserRegistration::class, 'showStep4Form'])->name('step-four');
            Route::post('/get-step4-data', [UserRegistration::class, 'getStep4Data'])->name('step-four.data');
            Route::post('/submit', [UserRegistration::class, 'step4Validate'])->name('step-four.validate');
        });
    
        Route::prefix('register')->name('register.')->group(function () {
            // Route::get('/upload-type',  [UserRegistration::class, 'showUploadTypeForm'])->name('upload-type');
            // Route::get('/upload-alt/{type}',  [UserRegistration::class, 'showUploadAltForm'])->name('upload-alt');
            // Route::get('/upload-link',  [UserRegistration::class, 'showUploadLinkForm'])->name('upload-link');
            // Route::post('/upload-link-process',  [UserRegistration::class, 'processUploadLinkForm'])->name('upload-link-process');
            Route::get('/submission-confirmed',  function(){ return view('messages.submissionConfirmed'); })->name('submission-confirmed');
            Route::get('/submission-exhibitor-confirmed',  function(){ return view('messages.submissionExhibitorConfirmed'); })->name('submission-exhibitor-confirmed');
            // Route::get('/upload-requirements', function () { return view('register.upload-requirements'); })->name('upload-requirements');
            // Route::get('/upload-basic',  [UserRegistration::class, 'showBasicUploadForm'])->name('upload-basic');
            // Route::post('/upload-basic-verify',  [UserRegistration::class, 'processBasicUploadForm'])->name('upload-basic-verify');
            Route::get('/upload-requirements/{type?}',  [UserRegistration::class, 'showVerifiedUploadForm'])->name('upload-verified');
            Route::post('/upload-requirements-verify',  [UserRegistration::class, 'processVerifiedUploadForm'])->name('upload-verified-verify');
            Route::post('/uploaded',  [UserRegistration::class, 'showUploaded'])->name('uploaded');

            Route::get('/registration-summary/{type?}', [UserRegistration::class, 'showSummary'])->name('registrationSummary');
            Route::post('/registration-submission', [UserRegistration::class, 'processSubmission'])->name('registrationSubmission');
        });
    
        
    
        
    
        Route::prefix('member')->name('member.')->group(function () {
            Route::get('/welcome', [UserRegistration::class, 'showMemberWelcome'])->name('message.memberWelcome');
            Route::get('/directory-setup', [UserRegistration::class, 'showAccountUpdate'])->name('message.accountUpdate');
        });
    
    });


    // Route::prefix('upload')->name('upload.')->group(function () {
    //     Route::post('/photo-process',  [GenController::class, 'uploadProfileImage']);
    // });
    
    
    Route::middleware('user.unverified')->group(function () {
    
        Route::prefix('???')->name('???.')->group(function () {
            
        });
    
    });
    
    Route::middleware('user.verified')->group(function () {
    
        Route::prefix('???')->name('???.')->group(function () {
            
        });
    
    });


    Route::middleware('user.verifiedunverified')->group(function () {
        Route::prefix('creative-works')->name('creativeWorks.')->group(function () {
            Route::get('/', [CreativeWork::class, 'index'])->name('index');
            Route::get('/list', [CreativeWork::class, 'list'])->name('list');
            Route::get('/add', [CreativeWork::class, 'showAddForm'])->name('add');
            Route::get('/edit/{slug?}', [CreativeWork::class, 'showEditForm'])->name('edit');
        });
    });

    Route::prefix('bookmarks')->name('bookmarks.')->group(function(){
        Route::post('/article', [BookmarkController::class, 'bookmarkArticle'])->name('article');
        Route::post('/profile', [BookmarkController::class, 'bookmarkProfile'])->name('profile');
        Route::post('/work', [BookmarkController::class, 'bookmarkStory'])->name('story');

        Route::get('/', [BookmarkController::class, 'index'])->name('index');
        Route::post('/get-bookmarks', [BookmarkController::class, 'getBookmarksData'])->name('getBookmarksData');
    });

    route::prefix('connect-with-creatives')->name('connect-creative.')->group(function(){
        Route::get('/request', [ConnectCreativeController::class, 'addFormMember'])->name('memberAdd');
    });

});
