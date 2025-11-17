<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザー登録フォーム表示
     * GET /register → route('register.form')
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * ユーザー登録処理
     * POST /register → route('register.store')
     */
    public function register(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:30'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // ユーザー作成
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // パスワードは必ずハッシュ化
        ]);

        // 登録後ログイン画面へ
        return redirect()
            ->route('login') // web.php の GET /login （name: login） と一致
            ->with('status', 'ユーザー登録が完了しました。ログインしてください。');
    }

    /**
     * ログインフォーム表示
     * GET /login → route('login')
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * ログイン処理
     * POST /login → route('login.attempt')
     */
    public function login(Request $request)
    {
        // バリデーション
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 認証試行
        if (Auth::attempt($credentials)) {

            // セッション固定攻撃対策
            $request->session()->regenerate();

            return redirect()
                ->route('admin.contacts.index')
                ->with('status', 'ログインしました。');
        }

        // 失敗：メールだけ保持しエラー表示
        return back()
            ->withInput($request->only('email'))
            ->with('login_error', 'メールアドレスまたはパスワードが正しくありません。');
    }

    /**
     * ログアウト処理
     * POST /logout → route('logout')
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // セッション無効化
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'ログアウトしました。');
    }
}