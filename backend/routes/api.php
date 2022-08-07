<?php

use App\Http\Controllers\Api\ProjectsController;

use App\Http\Controllers\Api\ServicesController;


use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

// projects routes
Route::get('projects', [ProjectsController::class, 'index']);
Route::get('projects/{project:slug}', [ProjectsController::class, 'show']);

// services routes
Route::get('services', [ServicessController::class, 'index']);
Route::get('services/{service:slug}', [ServicesController::class, 'show']);



Route::get('settings', [SettingsController::class, 'index']);
Route::post('contact-us', [ContactUsController::class, 'store']);
