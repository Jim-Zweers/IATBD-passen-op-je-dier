<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $role = Auth::user()->role->value;

    switch ($role) {
        case 'Admin':
            return redirect(route('requests.index', 'Alle'));
            break;
        case 'Owner':
            return redirect(route('animals.index'));
            break;
        case 'Sitter':
            return redirect(route('sitter.edit'));
            break;
    }
})->middleware('auth');


// Owner routes
Route::middleware('auth')->group(function () {
    Route::get('/dieren', [PetController::class, 'index'])->name('animals.index');
    Route::post('/dieren',[PetController::class, 'store'])->name('animals.store');
    Route::get('/dieren/bewerk/{dier}', [PetController::class, 'edit'])->name('animal.edit');
    Route::put('/dieren/bewerk/{dier}', [PetController::class, 'update'])->name('animal.update');
    Route::delete('/dieren/verwijder/{dier}', [PetController::class, 'destroy'])->name('animal.destroy');

    Route::get('/mijn-aanvragen', [RequestController::class, 'owner_index'])->name('owner.requests.index');
    Route::post('/mijn-aanvragen',[RequestController::class, 'store'])->name('requests.store');
    Route::delete('/aanvragen/{aanvraag}',[RequestController::class, 'destroy'])->name('requests.destroy');

    Route::get('/mijn-inbox',[RequestController::class, 'inbox'])->name('requests.inbox');
    Route::get('/mijn-inbox/{oppas}', [UserController::class, 'show'])->name('sitter.show');
    Route::put('/aanvraag/accepteren/{aanvraag}', [RequestController::class, 'accept'])->name('requests.accept');
    Route::put('/aanvraag/reject/{aanvraag}', [RequestController::class, 'reject'])->name('requests.reject');
    Route::post('/aanvraag/review', [ReviewController::class, 'store'])->name('requests.review');
});

// Sitter routes
Route::middleware('auth')->group(function () {
    Route::get('/mijn-info', [UserController::class, 'edit'])->name('sitter.edit');
    Route::post('/mijn-info', [UserController::class, 'update'])->name('sitter.update');

    Route::get('/aanvragen/{filter}', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/aanvraag/{aanvraag}', [RequestController::class, 'show'])->name('requests.show');
    Route::put('/aanvraag/sign-up/{aanvraag}', [RequestController::class, 'sign_up'])->name('requests.sign-up');

    Route::get('/inbox/aanvragen', [RequestController::class, 'sitter_index'])->name('sitter.requests.index');
});

// Admin routes
Route::middleware('auth')->group(function () {
    Route::delete('/aanvraag/verwijderen/{aanvraag}', [RequestController::class, 'destroy'])->name('requests.destroy');

    Route::get('/gebruikers', [UserController::class, 'index'])->name('users.index');
    Route::put('/blokkeer/{gebruiker}', [UserController::class, 'blockUser'])->name('user.block');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/uitloggen', [UserController::class, 'logout'])->name('user.logout');

require __DIR__.'/auth.php';
