<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\UserController; 

// --- お問い合わせ ---
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

// 入力 → 確認
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');

// 確認 → 保存
Route::post('/contacts/store',   [ContactController::class, 'store'])->name('contacts.store');

// 完了画面
Route::get('/contacts/thanks',   [ContactController::class, 'thanks'])->name('contacts.thanks');

// --- 管理画面 ---
Route::prefix('admin/contacts')->name('admin.contacts.')->group(function () {
    Route::get('/',       [AdminContactController::class, 'index'])->name('index');
    Route::get('/search', [AdminContactController::class, 'search'])->name('search');

    Route::get('/reset', function () {
        return view('reset');
    })->name('reset');

    Route::get('{contact}/delete', [AdminContactController::class, 'delete'])
        ->whereNumber('contact')->name('delete');

    Route::delete('{contact}', [AdminContactController::class, 'destroy'])
        ->whereNumber('contact')->name('destroy');
});

// --- ユーザー登録 ---
Route::get('/register',  [UserController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register.store');