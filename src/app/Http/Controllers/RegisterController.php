<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// もし自動ログインさせたいなら↓を使います
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Rules\Password; // 強めのポリシーにするなら

class RegisterController extends Controller
{
    /**
     * 登録フォーム表示
     */
    public function create()
    {
        return view('register');
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        // バリデーション（統一して min:8 に）
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:50'],
            'email'    => ['required', 'email', 'unique:users,email'],
            // より厳しくするなら Password ルールを使う
            // 'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()]
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => '名前を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
        ]);

        // ユーザー作成
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // ハッシュ必須
        ]);

        // 自動ログインさせたい場合はコメントアウト解除
        // Auth::login($user);

        // リダイレクト先はどちらかに統一（ここでは管理画面トップに）
        return redirect()
            ->route('admin.contacts.index')
            ->with('message', 'ユーザー登録が完了しました');
    }
}