<?php

use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TaskController;
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
    // return view('dashboard');
    return redirect(route('tasks.index'));
})->middleware(['auth', 'verified', 'notSuspended'])->name('dashboard');

Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);

require __DIR__.'/auth.php';

Route::post('/preference', [PreferenceController::class, 'store'])->name('preference.store');

Route::get('/account-suspended', function () {
    return view('account-suspended.index', [
        'backURL' => route('home.index')
    ]);
})->middleware('auth')->name('account-suspended');

Route::middleware(['auth', 'notSuspended'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('folders/{folder}/delete', [FolderController::class, 'delete'])->name('folders.delete');
    Route::get('folders/preferences', [FolderController::class, 'preferences'])->name('folders.preferences');
    Route::post('folders/preferences', [FolderController::class, 'applyPreferences'])->name('folders.applyPreferences');
    Route::resource('folders', FolderController::class)->except(['index', 'show']);

    Route::get('tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
    Route::get('tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::get('tasks/preferences', [TaskController::class, 'preferences'])->name('tasks.preferences');
    Route::post('tasks/preferences', [TaskController::class, 'applyPreferences'])->name('tasks.applyPreferences');
    Route::resource('tasks', TaskController::class);

    Route::middleware('admin')->group(function() {

        Route::get('users/{user}/deleteAvatar', [RegisteredUserController::class, 'deleteAvatar'])->name('users.deleteAvatar');
        Route::post('users/{user}/destroyAvatar', [RegisteredUserController::class, 'destroyAvatar'])->name('users.destroyAvatar');
        Route::get('users/{user}/delete', [RegisteredUserController::class, 'delete'])->name('users.delete');
        Route::get('users/search', [RegisteredUserController::class, 'search'])->name('users.search');
        Route::get('users/preferences', [RegisteredUserController::class, 'preferences'])->name('users.preferences');
        Route::post('users/preferences', [RegisteredUserController::class, 'applyPreferences'])->name('users.applyPreferences');
        Route::resource('users', RegisteredUserController::class)->except('show');
    });
});

require __DIR__ . "/../helpers/url_update_query_string.php";

Route::get('test', function() {

    $newUrl = url_update_query_string("http://localhost:8000?a=b&c=d#e", [
        'a' => 999,
        'q' => 'agus',
    ]);

    dd($newUrl); // Outputs "http://localhost:8000?a=999&c=d&q=agus#e"
});
