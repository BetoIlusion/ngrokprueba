<?php

use App\Http\Controllers\Controller;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('users')->group(function () {
        Route::get('/', [Controller::class, 'index'])->name('users.index');
        Route::get('/create', [Controller::class, 'create'])->name('users.create');
        Route::post('/', [Controller::class, 'store'])->name('users.store');
        Route::get('/{relationship}', [Controller::class, 'show'])->name('users.show');
        Route::get('/{relationship}/edit', [Controller::class, 'edit'])->name('users.edit');
        Route::put('/{relationship}', [Controller::class, 'update'])->name('users.update');
        Route::delete('/{relationship}', [Controller::class, 'destroy'])->name('users.destroy');
    });

    Route::get('/components-demo', function () {
        return Inertia::render('ComponentsDemo');
    })->name('components-demo');
    
    Route::prefix('categories')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Categories/Index');
        })->name('categories.index');
        Route::get('/create', function () {
            return Inertia::render('Categories/Create');
        })->name('categories.create');
        Route::post('/', function () {
            // Store category logic
        })->name('categories.store');
        Route::get('/{id}/edit', function () {
            return Inertia::render('Categories/Edit');
        })->name('categories.edit');
        Route::put('/{id}', function () {
            // Update category logic
        })->name('categories.update');
        Route::delete('/{id}', function () {
            // Delete category logic
        })->name('categories.destroy');
    });


   
});
