<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

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