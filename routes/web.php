<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebSettingController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Roles
    Route::resource('roles', RoleController::class);

    // Users
    Route::resource('users', UserController::class);

    // Web Settings
    Route::get('/web/settings', [WebSettingController::class, 'index'])->name('websettings.index');
    Route::post('/web/update-contact', [WebSettingController::class, 'updateContact'])->name('websettings.updateContact');
    Route::post('/web/update-social', [WebSettingController::class, 'updateSocial'])->name('websettings.updateSocial');
    Route::post('/web/logo-favicon', [WebSettingController::class, 'logoFavicon'])->name('websettings.updateLogoFavicon');

    // FAQs
    Route::resource('/faqs', FaqController::class);
});
