<?php

// Imports a class to handle profile-related routes and imports the facade route to provide methods to define routes
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Create a GET request on the homepage/root URL and returns the "welcome" view. AKA the default landing page in Laravel
Route::get('/', function () {
    return view('welcome');
});

// Define GET request for and to the dashboard. Protected by 2 middleware which ensures the user is authenticated and the email is verified. Also assigns the name "dashboard" to the route so it can be easily referred back too.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group routes requiring authentication. Also defines a GET, PATCH and DELETE requests to edit, update and delete the profile respectively. Uses the respective methods from "ProfileController" to do this.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
  ->only(['index', 'store', 'edit', 'update', 'destroy'])
  ->middleware(['auth', 'verified']);

// Include additional routes from auth.php (login, registration, password reset, etc). Provided by Laravel Breeze.
require __DIR__.'/auth.php';
