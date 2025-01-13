<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UpdatesController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\TideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('posts', PostController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/insert', [NewsController::class, 'insert']);
Route::get('/view', [NewsController::class, 'view']);
Route::put('/update/{id}', [NewsController::class, 'update']);
Route::delete('/delete/{id}', [NewsController::class, 'delete']);

Route::post('/insertupdate', [UpdatesController::class, 'insertupdate']);
Route::get('/viewupdate', [UpdatesController::class, 'viewupdate']);
Route::put('/updateupdate/{id}', [UpdatesController::class, 'updateupdate']);
Route::delete('/deleteupdate/{id}', [UpdatesController::class, 'deleteupdate']);

Route::post('/insertresident', [ResidenceController::class, 'insertresident']);
Route::get('/viewresident', [ResidenceController::class, 'viewresident']);
Route::put('/updateresident/{id}', [ResidenceController::class, 'updateresident']);
Route::delete('/deleteresident/{id}', [ResidenceController::class, 'deleteresident']);

Route::post('/inserttide', [TideController::class, 'inserttide']);
Route::get('/viewtide', [TideController::class, 'viewtide']);
Route::put('/updatetide/{id}', [TideController::class, 'updatetide']);
Route::delete('/deletetide/{id}', [TideController::class, 'deletetide']);
Route::post('/importdata', [TideController::class, 'importdata']);