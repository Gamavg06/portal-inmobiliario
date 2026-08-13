<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;

// Public Web Routes
Route::get('/', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/properties/{property}/leads', [LeadController::class, 'store'])->name('leads.store');

// Internal API Routes (Web-accessible)
Route::get('/api/properties', [PropertyController::class, 'apiIndex'])->name('api.properties.index');
Route::get('/api/properties/{property}/weather', [PropertyController::class, 'apiWeather'])->name('api.properties.weather');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin & Agent Routes
Route::middleware([RoleMiddleware::class . ':admin,agent'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/properties/create', [AdminController::class, 'createProperty'])->name('properties.create');
    Route::post('/properties', [AdminController::class, 'storeProperty'])->name('properties.store');
    Route::delete('/properties/{property}', [AdminController::class, 'deleteProperty'])->name('properties.destroy');
});
