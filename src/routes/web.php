<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| お問い合わせ（ユーザー側）
|--------------------------------------------------------------------------
*/

Route::get('/', [ContactController::class, 'index'])
    ->name('contacts.index');

Route::post('/contacts/confirm', [ContactController::class, 'confirm'])
    ->name('contacts.confirm');

Route::post('/contacts/store', [ContactController::class, 'store'])
    ->name('contacts.store');

Route::get('/contacts/thanks', [ContactController::class, 'thanks'])
    ->name('contacts.thanks');


/*
|--------------------------------------------------------------------------
| 管理画面（ログイン必須）
|--------------------------------------------------------------------------
|
| ※ 未ログインの場合 → /login に自動リダイレクトされる
| ※ URL は /admin/contacts/〜
| ※ ルート名は admin.contacts.〜
|
*/

Route::middleware('auth')
    ->prefix('admin/contacts')
    ->name('admin.contacts.')
    ->group(function () {

        // 一覧
        Route::get('/', [AdminContactController::class, 'index'])
            ->name('index');

        // 検索（スマホ用画面にも対応）
        Route::get('/search', [AdminContactController::class, 'search'])
            ->name('search');

        // リセット画面
        Route::get('/reset', function () {
            return view('reset');
        })->name('reset');

        // 削除確認
        Route::get('{contact}/delete', [AdminContactController::class, 'delete'])
            ->whereNumber('contact')
            ->name('delete');

        // 削除実行
        Route::delete('{contact}', [AdminContactController::class, 'destroy'])
            ->whereNumber('contact')
            ->name('destroy');

        // CSVエクスポート（bladeは不要）
        Route::get('/export', [AdminContactController::class, 'export'])
            ->name('export');
    });


/*
|--------------------------------------------------------------------------
| ユーザー登録・ログイン（未ログイン時のみ）
|--------------------------------------------------------------------------
|
| ※ ログイン中はこのグループ全体に入れない → / にリダイレクト
|
*/

Route::middleware('guest')->group(function () {

    // 新規登録フォーム
    Route::get('/register', [UserController::class, 'showRegisterForm'])
        ->name('register.form');

    // 新規登録処理
    Route::post('/register', [UserController::class, 'register'])
        ->name('register.store');

    // ログインフォーム
    Route::get('/login', [UserController::class, 'showLoginForm'])
        ->name('login');

    // ログイン実行
    Route::post('/login', [UserController::class, 'login'])
        ->name('login.attempt');
});


/*
|--------------------------------------------------------------------------
| ログアウト（ログイン中のみ）
|--------------------------------------------------------------------------
*/

Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ログイン済みユーザーが /home に飛ばされたとき用
Route::get('/home', function () {
    return redirect()->route('admin.contacts.index');
})->name('home');