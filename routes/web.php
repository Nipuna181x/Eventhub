<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RsvpController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth','role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});



Route::middleware(['auth'])->group(function () {
    
    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('events', EventController::class)->except(['index', 'show']);
    });

    // Public Event Views (Users can see)
    Route::resource('events', EventController::class)->only(['index', 'show']);

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
});

Route::resource('events', EventController::class);



require __DIR__.'/auth.php'; 
