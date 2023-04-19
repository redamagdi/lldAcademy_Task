<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PreviligesController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\RegusersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\OrdersController;

Route::group(['prefix' => LaravelLocalization::setLocale().'/admin' , 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ], function(){
    Route::get('/', function () {
        return view('Admin.welcome');
    });
    Route::get('/notauthorized', function () { return view('notauthorized'); })->name('notauthorized');
    Route::get('/login', function () { return view('Admin.login'); });
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

        // front users
        Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'previliges:users'], function(){
            Route::get('', [UsersController::class, 'index']);
            Route::post('/save', [UsersController::class, 'save'])->name('save');
            Route::post('/update', [UsersController::class, 'update'])->name('update');
            Route::post('/delete', [UsersController::class, 'delete'])->name('delete');
            Route::post('/update/resetPass', [UsersController::class, 'resetPass'])->name('resetPass');
        });

        // orders
        Route::group(['prefix' => 'orders', 'as' => 'orders.','middleware' => 'previliges:orders'], function(){
            Route::get('', [OrdersController::class, 'index']);
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

            // Admin Page
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

