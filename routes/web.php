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

        Route::group(['prefix' => 'participants'], function () {
            Route::get('/', [\App\Http\Controllers\CMS\ParticipantController::class, 'index'])->name('apps.participant.index');
            Route::get('/list', [\App\Http\Controllers\CMS\ParticipantController::class, 'list'])->name('apps.participant.list');
            Route::get('/create', [\App\Http\Controllers\CMS\ParticipantController::class, 'create'])->name('apps.participant.create');
            Route::post('/store', [\App\Http\Controllers\CMS\ParticipantController::class, 'store'])->name('apps.participant.store');
            Route::get('/edit/{uuid}', [\App\Http\Controllers\CMS\ParticipantController::class, 'edit'])->name('apps.participant.edit');
            Route::post('/update', [\App\Http\Controllers\CMS\ParticipantController::class, 'update'])->name('apps.participant.update');
            Route::post('/destroy', [\App\Http\Controllers\CMS\ParticipantController::class, 'destroy'])->name('apps.participant.destroy');
        });

        Route::group(['prefix' => 'mentors'], function () {
            Route::get('/', [\App\Http\Controllers\CMS\MentorController::class, 'index'])->name('apps.mentor.index');
            Route::get('/list', [\App\Http\Controllers\CMS\MentorController::class, 'list'])->name('apps.mentor.list');
            Route::get('/create', [\App\Http\Controllers\CMS\MentorController::class, 'create'])->name('apps.mentor.create');
            Route::post('/store', [\App\Http\Controllers\CMS\MentorController::class, 'store'])->name('apps.mentor.store');
            Route::get('/edit/{uuid}', [\App\Http\Controllers\CMS\MentorController::class, 'edit'])->name('apps.mentor.edit');
            Route::post('/update', [\App\Http\Controllers\CMS\MentorController::class, 'update'])->name('apps.mentor.update');
            Route::post('/destroy', [\App\Http\Controllers\CMS\MentorController::class, 'destroy'])->name('apps.mentor.destroy');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [\App\Http\Controllers\CMS\CategoryController::class, 'index'])->name('apps.category.index');
            Route::get('/list', [\App\Http\Controllers\CMS\CategoryController::class, 'list'])->name('apps.category.list');
            Route::get('/create', [\App\Http\Controllers\CMS\CategoryController::class, 'create'])->name('apps.category.create');
            Route::post('/store', [\App\Http\Controllers\CMS\CategoryController::class, 'store'])->name('apps.category.store');
            Route::get('/edit/{id}', [\App\Http\Controllers\CMS\CategoryController::class, 'edit'])->name('apps.category.edit');
            Route::post('/update', [\App\Http\Controllers\CMS\CategoryController::class, 'update'])->name('apps.category.update');
            Route::post('/destroy', [\App\Http\Controllers\CMS\CategoryController::class, 'destroy'])->name('apps.category.destroy');
        });
        
        Route::group(['prefix' => 'kegiatan'], function () {
            Route::get('/', [\App\Http\Controllers\CMS\ActivityController::class, 'index'])->name('apps.kegiatan.index');
            Route::get('/list', [\App\Http\Controllers\CMS\ActivityController::class, 'list'])->name('apps.kegiatan.list');
            Route::get('/create', [\App\Http\Controllers\CMS\ActivityController::class, 'create'])->name('apps.kegiatan.create');
            Route::post('/store', [\App\Http\Controllers\CMS\ActivityController::class, 'store'])->name('apps.kegiatan.store');
            Route::post('/destroy', [\App\Http\Controllers\CMS\ActivityController::class, 'destroy'])->name('apps.kegiatan.destroy');
        });

        Route::group(['prefix' => 'keuangan'], function () {
            Route::group(['prefix' => 'kurban'], function () {
                Route::get('/', [\App\Http\Controllers\CMS\FinanceController::class, 'indexKurban'])->name('apps.kurban.index');
                Route::get('/list', [\App\Http\Controllers\CMS\FinanceController::class, 'listKurban'])->name('apps.kurban.list');
                Route::get('/{uuid}/detail', [\App\Http\Controllers\CMS\FinanceController::class, 'detailKurban'])->name('apps.kurban.detail');
                Route::get('/detail-list', [\App\Http\Controllers\CMS\FinanceController::class, 'detailListKurban'])->name('apps.kurban.detail_list');
                Route::post('/update-nominal' , [\App\Http\Controllers\CMS\FinanceController::class, 'updateNominalKurban'])->name('apps.kurban.update_nominal');
                Route::get('/create', [\App\Http\Controllers\CMS\FinanceController::class, 'createKurban'])->name('apps.kurban.create');
                Route::post('/store', [\App\Http\Controllers\CMS\FinanceController::class, 'storeKurban'])->name('apps.kurban.store');
                Route::post('/destroy', [\App\Http\Controllers\CMS\FinanceController::class, 'destroyKurban'])->name('apps.kurban.destroy');
            });

            Route::group(['prefix' => 'kas'], function () {
                Route::get('/', [\App\Http\Controllers\CMS\FinanceController::class, 'indexks'])->name('apps.kas.index');
                Route::get('/list', [\App\Http\Controllers\CMS\FinanceController::class, 'listks'])->name('apps.kas.list');
                Route::get('/create', [\App\Http\Controllers\CMS\FinanceController::class, 'createks'])->name('apps.kas.create');
                Route::post('/store', [\App\Http\Controllers\CMS\FinanceController::class, 'storeks'])->name('apps.kas.store');
                Route::post('/destroy', [\App\Http\Controllers\CMS\FinanceController::class, 'destroyks'])->name('apps.kas.destroy');
            });
        });

        Route::group(['prefix' => 'data'], function () {
            Route::get('/categories', [\App\Http\Controllers\CMS\DataController::class, 'categories'])->name('data.categories');
            Route::get('/participants', [\App\Http\Controllers\CMS\DataController::class, 'participants'])->name('data.participants');
        });
    });
});
