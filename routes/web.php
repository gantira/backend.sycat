<?php

use App\Http\Controllers\Admin\{CategoryController, PostController, TagController, TeamController};
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

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('', [TagController::class, 'index'])->name('index');
        Route::post('', [TagController::class, 'store'])->name('store');
        Route::get('create', [TagController::class, 'create'])->name('create');
        Route::get('{tag}', [TagController::class, 'edit'])->name('edit');
        Route::put('{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('{tag}', [TagController::class, 'destroy'])->name('delete');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::post('', [CategoryController::class, 'store'])->name('store');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::get('{category}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('{category}', [CategoryController::class, 'destroy'])->name('delete');
    });

    Route::prefix('teams')->name('teams.')->group(function () {
        Route::get('', [TeamController::class, 'index'])->name('index');
        Route::post('', [TeamController::class, 'store'])->name('store');
        Route::get('create', [TeamController::class, 'create'])->name('create');
        Route::get('{team}', [TeamController::class, 'edit'])->name('edit');
        Route::put('{team}', [TeamController::class, 'update'])->name('update');
        Route::delete('{team}', [TeamController::class, 'destroy'])->name('delete');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('', [PostController::class, 'index'])->name('index');
        Route::post('', [PostController::class, 'store'])->name('store');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::get('{post}', [PostController::class, 'edit'])->name('edit');
        Route::put('{post}', [PostController::class, 'update'])->name('update');
        Route::delete('{post}', [PostController::class, 'destroy'])->name('delete');
    });
});
