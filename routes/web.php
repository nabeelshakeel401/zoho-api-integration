<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZohoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */

// Route::inertia('/', 'CreateDealAccount')->name('create-deal-account-form');
Route::get('/', function () {
    return Inertia::render('Zoho/DealForm', [
        //
    ]);
});

//ZOHO Redirect
//http://localhost:8000/zohoRedirect

Route::get('/getZohoTokens', [ZohoController::class, 'getFirstTimeTokens']);
// Route::get('/createAccountTest', [ZohoController::class, 'createAccountTest']); //for testing
// Route::get('/createDealAndAccount', [ZohoController::class, 'createDealAndAccount']); //for testing
Route::post('/createDealAndAccount', [ZohoController::class, 'createDealAndAccount']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
