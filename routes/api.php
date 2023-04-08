<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping',
    [ApiController::class, 'ping'])
    ->name('ping');

Route::get('/users/{userid}/token',
    [ApiController::class, 'create_token'])
    ->name('create_token');

Route::post('/users/by-token',
    [ApiController::class, 'get_user'])
    ->name('get_user');

Route::post('/action_upload_file',
    [ApiController::class, 'action_upload_file'])
    ->name('action_upload_file');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/action_login',
    [ApiController::class, 'action_login'])
    ->name('action_login');



