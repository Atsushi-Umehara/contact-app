<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ユーザー登録フォーム表示
    public function create()
    {
        return view('register');
    }

    // ユーザー登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // ← パスワードは暗号化
        ]);

        return redirect('/admin/contacts')->with('message', 'ユーザーを登録しました');
    }
}