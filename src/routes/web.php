<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\UserController;

// ------------------------------
// Public (問い合わせフォーム)
// ------------------------------
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
Route::post('/contacts/store',   [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/thanks',   [ContactController::class, 'thanks'])->name('contacts.thanks');

// ------------------------------
// Admin（一覧/検索/削除）
// ※ 必要なら ->middleware('auth') を付ける
// ------------------------------
Route::prefix('admin/contacts')->name('admin.contacts.')->group(function () {
    Route::get('/',           [AdminContactController::class, 'index'])->name('index');
    Route::get('/search',     [AdminContactController::class, 'search'])->name('search');

    // 確認ダイアログ（ビュー直返し）
    Route::get('/reset', function () {
        return view('reset');
    })->name('reset');

    // 削除確認ページ & 実行
    Route::get('{contact}/delete', [AdminContactController::class, 'delete'])
        ->whereNumber('contact')
        ->name('delete');

    Route::delete('{contact}',     [AdminContactController::class, 'destroy'])
        ->whereNumber('contact')
        ->name('destroy');
});

// ------------------------------
// User Register（自作の登録ページを使う場合）
// ------------------------------
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register.store');

Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');