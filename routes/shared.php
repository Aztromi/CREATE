<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Shared\CategoryController as Category;
use App\Http\Controllers\Shared\TagController as Tag;
use App\Http\Controllers\Shared\AddressController as Address;
use App\Http\Controllers\Shared\ProfileController as UserProfile;
use App\Http\Controllers\Shared\WorksController as Work;
use App\Http\Controllers\Shared\TinyMCEController;
use App\Http\Controllers\Shared\MessageController;


/*
|--------------------------------------------------------------------------
| Shared Routes
|--------------------------------------------------------------------------
| 
|
*/


Route::name('shd.')->prefix('shd')->group(function(){

    Route::prefix('svc')->name('svc.')->group(function () { //Routes shared by Admins and Users
        Route::post('/get-address-detail', [Address::class, 'getAddressDetail'])->name('address-detail');
        Route::post('/get-countries', [Address::class, 'getCountries'])->name('countries');
        Route::post('/get-categories', [Category::class, 'getCategories'])->name('categories');

        Route::post('/get-tags-selection', [Tag::class, 'getTagsSelection'])->name('tags');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::post('/get-account-data', [UserProfile::class, 'getProfileData'])->name('get-account-data');
        Route::post('/edit-account/process', [UserProfile::class, 'updateProfile'])->name('edit-account.process');
    });

    Route::prefix('creative-works')->name('creativeWorks.')->group(function () {
        // Route::post('/process', [Work::class, 'processForm'])->name('process');
        Route::post('/get-works', [Work::class, 'getWorks'])->name('get-works');
        Route::post('/process-add', [Work::class, 'processAdd'])->name('process-add');
        Route::post('/process-edit', [Work::class, 'processEdit'])->name('process-edit');
        Route::post('/get-story-data', [Work::class, 'getStoryData'])->name('get-story-data');
        route::post('/tmce-img-upload', [TinyMCEController::class, 'worksTinyMCEUpload'])->name('tmceImgUpload');
    });

    Route::prefix('messages')->name('messages.')->group(function () {
        Route::middleware('messaging.all')->group(function(){
            Route::get('/start-message/{recipient}', [MessageController::class, 'findOrCreateMessageGroup'])->name('startMessage');
            Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('sendMessage');
            Route::post('/get-message-list', [MessageController::class, 'getMessageList'])->name('getMessageList');
            Route::post('/get-message-Entries', [MessageController::class, 'getMessageEntries'])->name('getMessageEntries');
        });
        Route::middleware('messaging.creatives')->group(function(){
            
        });
        
        
    });


    

});



