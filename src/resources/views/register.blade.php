<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>ユーザー登録 | Admin</title>

<style>
:root{
  /* ===== Colors ===== */
  --bg:#fff9f6;
  --panel:#ffffff;
  --ink:#3e3835;
  --muted:#8b7e77;
  --line:#e6ddd7;
  --accent:#6a564c;
  --danger:#c34a36;
  --success:#2f9e44;

  /* ===== Effects & Layout ===== */
  --radius:14px;
  --shadow:0 10px 24px rgba(0,0,0,.08);
  --sp-3:12px;
  --sp-4:16px;
  --sp-6:24px;
  --sp-8:32px;
  --fs-base:1rem;
  --fs-lg:1.25rem;
}

*{
  box-sizing:border-box;
}

html,body{
  height:100%;
}

body{
  margin:0;
  min-height:100vh;
  padding:var(--sp-8) var(--sp-4);
  background:var(--bg);
  color:var(--ink);
  font:var(--fs-base)/1.7 system-ui,-apple-system,"Segoe UI",Roboto,"Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
  display:flex;
  justify-content:center;
  align-items:center;
}

:focus-visible{
  outline:3px solid rgba(181,154,140,.35); outline-offset:3px;
}

@media (prefers-reduced-motion: reduce){ *{ animation:none !important; transition:none !important; } }

.c-card{
  width:100%;
  max-width:520px;
  background:var(--panel);
  padding:var(--sp-8) var(--sp-6);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  animation:fadeIn .25s ease both;
}
@keyframes fadeIn{ from{opacity:0; transform:translateY(6px);} to{opacity:1; transform:translateY(0);} }

h1{
  margin:0 0 var(--sp-6);
  font-size:var(--fs-lg);
  text-align:center;
  font-weight:600; 
}

.c-field{
  margin-bottom:var(--sp-4);
}

label{
  display:block;
  margin:0 0 6px;
  color:var(--muted);
  font-size:.92rem;
}

input{
  width:100%;
  padding:12px;
  border:1px solid var(--line);
  border-radius:10px;
  background:#f9f6f4;
  transition:border-color .15s, box-shadow .15s, background .15s;
}

input::placeholder{
  color:#b4a9a3;
}

input:focus{
  outline:none;
  border-color:#b59a8c;
  box-shadow:0 0 0 3px rgba(181,154,140,.16); background:#fff;
}

.is-invalid{
  border-color:var(--danger) !important;
  box-shadow:0 0 0 3px rgba(195,74,54,.12) !important;
}

.field-error{
  margin-top:6px;
  font-size:.88rem;
  color:#9a2a25;
}

.error-msg{
  background:#ffeaea;
  color:#9a2a25;
  padding:8px 12px;
  border-radius:8px;
  font-size:.9rem;
  margin:0 0 var(--sp-4);
}

button{
  width:100%;
  padding:12px;
  border:none;
  cursor:pointer;
  font-size:var(--fs-base);
  border-radius:10px;
  background:var(--accent);
  color:#fff;
  transition:opacity .2s, transform .05s;
}

button:hover{
  opacity:.92;
}

button:active{
  transform:translateY(1px);
}

.u-center{
  text-align:center;
  margin-top:var(--sp-4);
}

.u-center a{
  color:var(--accent);
  text-decoration:none;
}

.u-center a:hover{
  text-decoration:underline;
}

@media (max-width:420px){ .c-card{ padding:var(--sp-6) var(--sp-4); } }
</style>

</head>
<body>
  <div class="c-card">
    <h1>ユーザー登録</h1>

    {{-- フラッシュ（成功メッセージなど）任意 --}}
    @if (session('status'))
      <div class="error-msg" style="background:#eef9f0; color:#216e39;">
        {{ session('status') }}
      </div>
    @endif

    {{-- 全体エラー（任意：要約） --}}
    @if ($errors->any())
      <div class="error-msg">
        入力内容をご確認ください。
      </div>
    @endif

    <form action="{{ route('register.store') }}" method="post" novalidate>
      @csrf

      <div class="c-field">
        <label for="name">名前</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="50"
        autocomplete="name"
        @error('name') class="is-invalid" aria-invalid="true" aria-describedby="err-name" @enderror>
        @error('name')
          <div id="err-name" class="field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="c-field">
        <label for="email">メールアドレス</label>
        <input id="email" type="email" name="email"
        value="{{ old('email') }}" required maxlength="255"
        autocomplete="email"
        @error('email') class="is-invalid" aria-invalid="true" aria-describedby="err-email" @enderror>
        @error('email')
          <div id="err-email" class="field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="c-field">
        <label for="password">パスワード</label>
        <input id="password" type="password" name="password"
        required minlength="8" autocomplete="new-password"
        @error('password') class="is-invalid" aria-invalid="true" aria-describedby="err-password" @enderror>
        @error('password')
          <div id="err-password" class="field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="c-field">
        <label for="password_confirmation">パスワード（確認）</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
        required minlength="8" autocomplete="new-password">
      </div>

      <button type="submit">登録する</button>
    </form>

    <p class="u-center"><a href="{{ route('admin.contacts.index') }}">← 管理画面に戻る</a></p>
  </div>
</body>
</html>