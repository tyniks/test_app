<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::view('/private', 'private')->middleware('auth')->name('private');
Route::get('/login', function () {
    if(Auth::check()){
        return redirect(route('private'));
    }
    return view('login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

Route::get('/registration', function () {
    if(Auth::check()){
        return redirect(route('private'));
    }
    return view('registration');
})->name('registration');

Route::post('/registration', [\App\Http\Controllers\RegisterController::class, 'save']);
