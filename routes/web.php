<?php

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
    return redirect()->route('apps.login');
});

Route::group(['prefix' => 'apps'], function () {
    // Auth
    Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('apps.login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'authenticate'])->name('apps.login.authenticate');
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('apps.logout');

    Route::group(['middleware' => ['auth']], function () {
        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\CMS\DashboardController::class, 'index'])->name('apps.dashboard');

        Route::group(['prefix' => 'peserta'], function () {
            Route::get('/', [\App\Http\Controllers\CMS\PesertaController::class, 'index'])->name('apps.peserta.index');
            Route::get('/list', [\App\Http\Controllers\CMS\PesertaController::class, 'list'])->name('apps.peserta.list');
            Route::get('/create', [\App\Http\Controllers\CMS\PesertaController::class, 'create'])->name('apps.peserta.create');
            Route::post('/store', [\App\Http\Controllers\CMS\PesertaController::class, 'store'])->name('apps.peserta.store');
            Route::post('/destroy', [\App\Http\Controllers\CMS\PesertaController::class, 'destroy'])->name('apps.peserta.destroy');
        });

        Route::group(['prefix' => 'pengajar'], function () {
            Route::get('/', [\App\Http\Controllers\CMS\PengajarController::class, 'index'])->name('apps.pengajar.index');
            Route::get('/list', [\App\Http\Controllers\CMS\PengajarController::class, 'list'])->name('apps.pengajar.list');
            Route::get('/create', [\App\Http\Controllers\CMS\PengajarController::class, 'create'])->name('apps.pengajar.create');
            Route::post('/store', [\App\Http\Controllers\CMS\PengajarController::class, 'store'])->name('apps.pengajar.store');
            Route::post('/destroy', [\App\Http\Controllers\CMS\PengajarController::class, 'destroy'])->name('apps.pengajar.destroy');
        });

        Route::group(['prefix' => 'data'], function () {
            Route::get('/kategori', [\App\Http\Controllers\CMS\DataController::class, 'kategori'])->name('data.kategori');
        });
    });
});
