<?php

use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::apiResource('records', RecordController::class);
