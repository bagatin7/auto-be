<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'records' => RecordController::class,
    'users' => UserController::class
]);
