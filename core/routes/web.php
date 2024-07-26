<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::resource('/draft/propose', 'DraftProposeController');
    Route::resource('/draft', 'DraftController');
    Route::resource('/persetujuan', 'PersetujuanController');
    Route::resource('/overview', 'OverviewController');
    Route::resource('/email', 'EmailSendController');
    Route::get('/monitor', 'ViewController@monitor');
    Route::get('/sendsap', 'ViewController@sendsap');
    Route::get('/cancelsap', 'ViewController@cancelsap');
    Route::get('/home', 'ViewController@home');
    Route::get('/qr_check',[ViewController::class, 'print_view']);
});
Route::get('/', 'ViewController@plain');
Route::get('/maintenance', 'ViewController@maintenance');
