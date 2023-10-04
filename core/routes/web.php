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

// お問い合わせフォーム
Route::prefix('form')->group(function () {
    Route::get('/', [ContactFormController::class, 'index'])->name('form.index');
    Route::post('back', function (Request $request) {

        // セッションなし
        if (!$request->session()->has('contact_form')) {
            return redirect()->route('form.index');
        }

        // セッションから取得
        $values = $request->session()->pull('contact_form');
        return redirect()->route('form.index')->withInput($values);
    })->name('form.back');
    Route::post('confirm', [ContactFormController::class, 'confirm'])->name('form.confirm');
    Route::post('complete', [ContactFormController::class, 'complete'])->name('form.complete');

    // フォーム直アクセス
    Route::get('confirm', function () {
        return redirect()->route('form.index');
    });
    Route::get('complete', function () {
        return redirect()->route('form.index');
    });
});

// 管理画面
Route::prefix('admin')->group(function () {
    // 認証なし
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('admin.index');
        Route::post('login', [LoginController::class, 'store'])->name('admin.store');
    });

    // 認証必要
    Route::middleware('auth:admin')->group(function () {
        Route::get('list', [UserSearchController::class, 'userList'])->name('admin.user_list');
        Route::get('detail/{id}', [UserSearchController::class, 'userDetail'])->name('admin.user_detail');
        Route::get('logout', [LoginController::class, 'destroy'])->name('logout');
    });
});