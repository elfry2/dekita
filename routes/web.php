<?php

use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('home.index');
})->name('home.index');

Route::get('/dashboard', function () {
    return view('dashboard');
    // return redirect(route('tasks.index'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/preference', [PreferenceController::class, 'store'])->name('preference.store');

Route::middleware('auth')->group(function () {
    Route::resource('folders', FolderController::class);
    Route::resource('tasks', TaskController::class);
});