<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserSearchController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
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

// お問い合わせ
Route::get('form', [ContactFormController::class, 'index'])->name('form.index');
Route::post('form/back', function (Request $request) {

    // セッションなし
    if (!$request->session()->has('contact_form')) {
        return redirect()->route('form.index');
    }

    // セッションから取得
    $values = $request->session()->pull('contact_form');
    return redirect()->route('form.index')->withInput($values);
})->name('form.back');
Route::post('form/confirm', [ContactFormController::class, 'confirm'])->name('form.confirm');
Route::post('form/complete', [ContactFormController::class, 'complete'])->name('form.complete');

// 管理画面
Route::middleware('guest')->group(function () {
    Route::get('admin/login', [LoginController::class, 'create'])->name('admin.index');
    Route::post('admin/login', [LoginController::class, 'store'])->name('admin.store');
});

Route::middleware('auth')->group(function () {
    Route::get('admin/list', [UserSearchController::class, 'userList'])->name('admin.user_list');
    Route::get('admin/detail/{id}', [UserSearchController::class, 'userDetail'])->name('admin.user_detail');

    // ボタンがないため一旦保留
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});
