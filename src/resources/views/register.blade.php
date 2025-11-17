<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>User Register</title>

<style>
body{
    margin:0;
    background:#fff9f6;
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Noto Sans JP",sans-serif;
    padding:40px 0;
    color:#4b3f39;
}
.wrapper{
    max-width:420px;
    margin:0 auto;
    background:#fff;
    padding:32px;
    border-radius:12px;
    box-shadow:0 10px 20px rgba(0,0,0,.08);
}
h1{
    font-size:22px;
    margin-bottom:24px;
    text-align:center;
}
label{
    display:block;
    font-size:14px;
    margin-bottom:6px;
    color:#8b7e77;
}
input{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #e4dcd5;
    background:#f8f5f3;
    margin-bottom:18px;
}
input:focus{
    background:#fff;
    border-color:#c4b1a6;
    outline:none;
    box-shadow:0 0 0 3px rgba(196,177,166,.25);
}
.btn{
    width:100%;
    padding:12px 0;
    background:#6a564c;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}
.btn:hover{
    opacity:.9;
}
.error{
    color:#c34a36;
    font-size:14px;
    margin-bottom:10px;
}
.status{
    color:#3a7f33;
    margin-bottom:10px;
    text-align:center;
}
a{
    display:block;
    margin-top:12px;
    color:#6a564c;
    text-align:center;
}
</style>
</head>

<body>
<div class="wrapper">
    <h1>ユーザー登録</h1>

    {{-- メッセージ --}}
    @if(session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    {{-- バリデーションエラー --}}
    @if($errors->any())
        @foreach($errors->all() as $e)
            <div class="error">・{{ $e }}</div>
        @endforeach
    @endif

    <form action="{{ route('register.store') }}" method="post">
        @csrf

        <label for="name">お名前</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}">

        <label for="email">メールアドレス</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}">

        <label for="password">パスワード</label>
        <input id="password" name="password" type="password">

        <label for="password_confirmation">パスワード（確認）</label>
        <input id="password_confirmation" name="password_confirmation" type="password">

        <button class="btn" type="submit">登録</button>
    </form>

    <a href="{{ route('login') }}">ログインはこちら</a>
</div>
</body>
</html>