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

        Route::group(['prefix' => 'activity'], function () {
            Route::group(['prefix' => 'attendance'], function () {
                Route::get('/', [\App\Http\Controllers\CMS\ActivityController::class, 'index'])->name('apps.attendance.index');
                Route::get('/list', [\App\Http\Controllers\CMS\ActivityController::class, 'list'])->name('apps.attendance.list');
                Route::get('/create', [\App\Http\Controllers\CMS\ActivityController::class, 'create'])->name('apps.attendance.create');
                Route::post('/store', [\App\Http\Controllers\CMS\ActivityController::class, 'store'])->name('apps.attendance.store');
                Route::post('/destroy', [\App\Http\Controllers\CMS\ActivityController::class, 'destroy'])->name('apps.attendance.destroy');
            });
        });

        Route::group(['prefix' => 'finance'], function () {
            Route::group(['prefix' => 'qurban'], function () {
                Route::get('/', [\App\Http\Controllers\CMS\QurbanController::class, 'index'])->name('apps.qurban.index');
                Route::get('/list', [\App\Http\Controllers\CMS\QurbanController::class, 'list'])->name('apps.qurban.list');
                Route::get('/{uuid}/detail', [\App\Http\Controllers\CMS\QurbanController::class, 'detail'])->name('apps.qurban.detail');
                Route::get('/detail-list', [\App\Http\Controllers\CMS\QurbanController::class, 'detailList'])->name('apps.qurban.detail_list');
                Route::get('/create', [\App\Http\Controllers\CMS\QurbanController::class, 'create'])->name('apps.qurban.create');
                Route::post('/store', [\App\Http\Controllers\CMS\QurbanController::class, 'store'])->name('apps.qurban.store');
                Route::get('/edit/{uuid}', [\App\Http\Controllers\CMS\QurbanController::class, 'edit'])->name('apps.qurban.edit');
                Route::post('/update-amount', [\App\Http\Controllers\CMS\QurbanController::class, 'updateAmount'])->name('apps.qurban.update_amount');
                Route::post('/destroy', [\App\Http\Controllers\CMS\QurbanController::class, 'destroy'])->name('apps.qurban.destroy');
            });

            // Route::group(['prefix' => 'kas'], function () {
            // Route::get('/', [\App\Http\Controllers\CMS\FinanceController::class, 'indexks'])->name('apps.kas.index');
            // Route::get('/list', [\App\Http\Controllers\CMS\FinanceController::class, 'listks'])->name('apps.kas.list');
            // Route::get('/create', [\App\Http\Controllers\CMS\FinanceController::class, 'createks'])->name('apps.kas.create');
            // Route::post('/store', [\App\Http\Controllers\CMS\FinanceController::class, 'storeks'])->name('apps.kas.store');
            // Route::post('/destroy', [\App\Http\Controllers\CMS\FinanceController::class, 'destroyks'])->name('apps.kas.destroy');
            // });
        });

        Route::group(['prefix' => 'data'], function () {
            Route::get('/categories', [\App\Http\Controllers\CMS\DataController::class, 'categories'])->name('data.categories');
            Route::get('/participants', [\App\Http\Controllers\CMS\DataController::class, 'participants'])->name('data.participants');
        });
    });
});
