<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\OutdoorController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    
});


Route::get('/dashboard', [MainController::class, 'branchIndex'])->name('index.branch');
    Route::get('/', [MainController::class, 'index'])->name('index.main');

    Route::get('add-branch', [MainController::class, 'branchIndex'])->name('index.branch');
    Route::post('add-branch', [MainController::class, 'branchStore'])->name('store.branch');
    Route::delete('delete-branch/{id}', [MainController::class, 'branchDelete'])->name('delete.branch');

    Route::get('add-type', [MainController::class, 'typeindex'])->name('index.type');
    Route::post('add-type', [MainController::class, 'typeStore'])->name('store.type');
    Route::delete('delete-type/{id}', [MainController::class, 'typeDelete'])->name('delete.type');

    Route::get('add-section', [MainController::class, 'sectionindex'])->name('index.section');
    Route::post('add-section', [MainController::class, 'sectionStore'])->name('store.section');
    Route::delete('delete-section/{id}', [MainController::class, 'sectionDelete'])->name('delete.section');

    Route::get('add-material', [MainController::class, 'materialIndex'])->name('index.material');
    Route::post('add-material', [MainController::class, 'materialStore'])->name('store.material');
    Route::delete('delete-material/{id}', [MainController::class, 'materialDelete'])->name('delete.material');

    Route::get('own-banner', [BannerController::class, 'index'])->name('index.own-banner');
    Route::get('own-banner/{id}', [BannerController::class, 'show'])->name('show.own-banner');
    Route::post('add-own-banner', [BannerController::class, 'store'])->name('store.own-banner');
    Route::put('update-own-banner/{id}', [BannerController::class, 'update'])->name('update.own-banner');
    Route::delete('delete-own-banner/{id}', [BannerController::class, 'delete'])->name('delete.own-banner');

    Route::post('add-payment/{id}', [BannerController::class, 'storePayments'])->name('store.payment');
    Route::put('update-payment/{id}', [BannerController::class, 'updatePayments'])->name('update.payment');
    Route::delete('delete-payment/{id}', [BannerController::class, 'deletePayments'])->name('delete.payment');

    Route::post('add-own-banner-record/{id}', [BannerController::class, 'storeOwnRecord'])->name('store.own-banner-record');
    Route::put('update-own-banner-record/{id}', [BannerController::class, 'updateOwnRecord'])->name('update.own-banner-record');
    Route::delete('delete-own-banner-record/{id}', [BannerController::class, 'deleteOwnRecord'])->name('delete.own-banner-record');

    Route::get('outdoor-banner', [OutdoorController::class, 'index'])->name('index.outdoor-banner');
    Route::get('outdoor-banner/{id}', [OutdoorController::class, 'show'])->name('show.outdoor-banner');
    Route::post('add-outdoor-banner', [OutdoorController::class, 'store'])->name('store.outdoor-banner');
    Route::put('update-outdoor-banner/{id}', [OutdoorController::class, 'update'])->name('update.outdoor-banner');
    Route::delete('delete-outdoor-banner/{id}', [OutdoorController::class, 'delete'])->name('delete.outdoor-banner');

    Route::post('add-outdoor-banner-record/{id}', [OutdoorController::class, 'storeOutdoorRecord'])->name('store.outdoor-banner-record');
    Route::put('update-outdoor-banner-record/{id}', [OutdoorController::class, 'updateOutdoorRecord'])->name('update.outdoor-banner-record');
    Route::delete('delete-outdoor-banner-record/{id}', [OutdoorController::class, 'deleteOutdoorRecord'])->name('delete.outdoor-banner-record');

    Route::get('party', [PartyController::class, 'index'])->name('index.party');
    Route::get('party/{id}', [PartyController::class, 'show'])->name('show.party');
    Route::post('add-party', [PartyController::class, 'store'])->name('store.party');
    Route::put('update-party/{id}', [PartyController::class, 'update'])->name('update.party');
    Route::delete('delete-party/{id}', [PartyController::class, 'delete'])->name('delete.party');

    Route::post('add-party-record/{id}', [PartyController::class, 'storePartyRecord'])->name('store.party-record');
    Route::put('update-party-record/{id}', [PartyController::class, 'updatePartyRecord'])->name('update.party-record');
    Route::delete('delete-party-record/{id}', [PartyController::class, 'deletePartyRecord'])->name('delete.party-record');

    Route::post('add-comment/{object_index}/{object_id}/{comment_id}', [CommentController::class, 'store'])->name('store.comment');
    Route::put('update-comment/{comment_id}', [CommentController::class, 'update'])->name('update.comment');
    Route::delete('delete-comment/{comment_id}', [CommentController::class, 'delete'])->name('delete.comment');

    Route::get('party-reports', [ReportController::class, 'partyIndex'])->name('report.party');
    Route::get('own-reports', [ReportController::class, 'ownIndex'])->name('report.own');
    Route::get('outdoor-reports', [ReportController::class, 'outdoorIndex'])->name('report.outdoor');