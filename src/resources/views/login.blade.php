<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ログイン | FashionablyLate</title>

<style>
body{
    margin:0;
    background:#fff9f6;
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
    color:#3e3835;
}

.box{
    background:#fff;
    padding:40px 32px;
    width:100%;
    max-width:420px;
    border-radius:12px;
    box-shadow:0 10px 20px rgba(0,0,0,.08);
}

h1{
    margin:0 0 24px;
    font-size:24px;
    text-align:center;
}

input{
    width:100%;
    padding:12px;
    margin-top:6px;
    margin-bottom:18px;
    border-radius:8px;
    border:1px solid #e6ddd7;
    background:#faf7f4;
}

button{
    width:100%;
    padding:12px;
    background:#6a564c;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
}

.error{
    background:#ffebe8;
    color:#b04a4a;
    padding:12px;
    border-radius:6px;
    font-size:14px;
    margin-bottom:16px;
}

.status{
    background:#e7f6ef;
    color:#2f7d57;
    padding:12px;
    border-radius:6px;
    font-size:14px;
    margin-bottom:16px;
}
</style>
</head>

<body>
<div class="box">

    <h1>ログイン</h1>

    {{-- 登録直後・ログアウト直後のメッセージ --}}
    @if(session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    {{-- 認証失敗 --}}
    @if(session('login_error'))
        <div class="error">{{ session('login_error') }}</div>
    @endif

    <form method="post" action="{{ route('login.attempt') }}">
        @csrf

        <label>メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}">

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>パスワード</label>
        <input type="password" name="password">

        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">ログイン</button>
    </form>

    <p style="margin-top:18px; text-align:center; font-size:14px;">
        <a href="{{ route('register.form') }}">新規登録はこちら</a>
    </p>
</div>
</body>
</html>