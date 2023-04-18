<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreviligesController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\RegusersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

Route::group(['prefix' => LaravelLocalization::setLocale() , 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ], function(){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/notauthorized', function () { return view('notauthorized'); })->name('notauthorized');
    Route::get('/login', function () { return view('login'); });
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::group(['prefix' => '', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::group(['middleware' => 'previliges:dashboard'], function(){
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        });

        // categories
        Route::group(['prefix' => 'categories', 'as' => 'categories.','middleware' => 'previliges:categories'], function(){
            Route::get('', [CategoriesController::class, 'index']);
            Route::post('save', [CategoriesController::class, 'save'])->name('save');
            Route::post('update', [CategoriesController::class, 'update'])->name('update');
            Route::post('delete', [CategoriesController::class, 'delete'])->name('delete');
        });

        // products
        Route::group(['prefix' => 'products', 'as' => 'products.','middleware' => 'previliges:products'], function(){
            Route::get('', [ProductsController::class, 'index']);
            Route::post('save', [ProductsController::class, 'save'])->name('save');
            Route::post('update', [ProductsController::class, 'update'])->name('update');
            Route::post('delete', [ProductsController::class, 'delete'])->name('delete');
        });

        // General Settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.', 'namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function () {
            
            Route::group(['prefix' => 'job', 'as' => 'job.', 'middleware' => 'previliges:previlige'], function(){
                Route::post('save', [JobsController::class, 'save'])->name('save');
                Route::post('update', [JobsController::class, 'update'])->name('update');
                Route::post('delete', [JobsController::class, 'delete'])->name('delete');
            });

            
            // Previliges Page
            Route::group(['prefix' => 'previliges', 'as' => 'previliges.', 'middleware' => 'previliges:previlige'], function(){
                Route::get('', [PreviligesController::class, 'index'])->name('index');
                Route::get('{id}', [PreviligesController::class, 'job'])->name('job');
                Route::post('update', [PreviligesController::class, 'update'])->name('update');
            });

            // reg Page
            Route::group(['prefix' => 'regusers', 'as' => 'regusers.', 'middleware' => 'previliges:regusers'], function(){
                Route::get('', [RegusersController::class, 'index']);
                Route::post('/save', [RegusersController::class, 'save'])->name('save');
                Route::post('/update', [RegusersController::class, 'update'])->name('update');
                Route::post('/delete', [RegusersController::class, 'delete'])->name('delete');
                Route::post('/update/updateCredits', [RegusersController::class, 'updateCredits'])->name('updateCredits');
                Route::post('/update/resetPass', [RegusersController::class, 'resetPass'])->name('resetPass');
            });
        });
        

    });
});

