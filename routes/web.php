<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::prefix('admin')->middleware('auth')->group(function(){

    Route::get('/profile-details',[App\Http\Controllers\Admin\SettingController::class,'index'])->name('profile-details');
    Route::post('/profile-save',[App\Http\Controllers\Admin\SettingController::class,'store'])->name('profile-save');
    Route::post('/profile_image_remove',[App\Http\Controllers\Admin\SettingController::class,'profileImageDelete'])->name('profile_image_remove');
    Route::get('/setting',[App\Http\Controllers\Admin\SettingController::class,'settingPage'])->name('setting');

    Route::prefix('category')->group(function(){
        Route::get('/',[App\Http\Controllers\Admin\CategoryController::class,'index'])->name('category');
        Route::get('/addOrEdit/{id?}',[App\Http\Controllers\Admin\CategoryController::class,'addOrEdit'])->name('category.addEdit');
        Route::post('/save',[App\Http\Controllers\Admin\CategoryController::class,'store'])->name('category.add');
        Route::post('/delete',[App\Http\Controllers\Admin\CategoryController::class,'delete'])->name('category.delete');
        Route::post('/status',[App\Http\Controllers\Admin\CategoryController::class,'status'])->name('category.status');
    });
    Route::prefix('product')->group(function(){
        Route::get('/',[App\Http\Controllers\Admin\ProductController::class,'index'])->name('product');
        Route::get('/addOrEdit',[App\Http\Controllers\Admin\ProductController::class,'addEdit'])->name('category.addEdit');
    });

});

    


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

