<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\LeadController;

// Web Routes
Route::get('/', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/properties/{property}/leads', [LeadController::class, 'store'])->name('leads.store');

// Internal API Routes (Web-accessible)
Route::get('/api/properties', [PropertyController::class, 'apiIndex'])->name('api.properties.index');
Route::get('/api/properties/{property}/weather', [PropertyController::class, 'apiWeather'])->name('api.properties.weather');
