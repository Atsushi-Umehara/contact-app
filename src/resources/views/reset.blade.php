{{-- resources/views/reset.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>検索条件リセット | Contacts</title>

<style>
/* =========================================================
Design Tokens
========================================================= */
:root{
  /* Colors */
    --bg:#fff9f6;
    --panel:#ffffff;
    --ghost:#f5efe9;
    --ink:#3e3835;
    --muted:#8b7e77;
    --line:#e6ddd7;
    --accent:#6a564c;

  /* Radius / Shadow */
    --radius:14px;
    --shadow:0 10px 24px rgba(0,0,0,.08);

  /* Spacing */
    --sp-3:12px;
    --sp-4:16px;
    --sp-6:24px;
    --sp-8:32px;

  /* Font */
    --fs-base:1rem;
    --fs-lg:1.25rem;
}

/* =========================================================
Base
========================================================= */
*{ box-sizing:border-box; }

html,body{ height:100%; }

body{
    margin:0;
    min-height:100vh;
    padding:var(--sp-8) var(--sp-4);
    color:var(--ink);
    background:var(--bg);
    font-size:var(--fs-base);
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
    display:flex;
    align-items:center;
    justify-content:center;
    line-height:1.7;
}

/* =========================================================
Dialog
========================================================= */
.c-dialog{
    width:100%;
    max-width:520px;
    padding:var(--sp-8) var(--sp-6);
    background:var(--panel);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    text-align:center;
    animation:fadeIn .3s ease;
}

@keyframes fadeIn{
    from{ opacity:0; transform:translateY(8px); }
    to  { opacity:1; transform:translateY(0); }
}

/* =========================================================
Typography
========================================================= */
h1{
    margin:0 0 var(--sp-4);
    font-size:var(--fs-lg);
    font-weight:600;
}

p{
    margin:0 0 var(--sp-6);
    color:var(--muted);
    line-height:1.7;
}

/* =========================================================
Actions / Buttons
========================================================= */
.c-actions{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:var(--sp-4);
}

.c-btn{
    display:inline-block;
    padding:10px 20px;
    font-size:var(--fs-base);
    text-decoration:none;
    border-radius:10px;
    cursor:pointer;
    transition:transform .15s ease, opacity .15s ease;
}

.c-btn:active{ transform:translateY(1px); }

.c-btn.--primary{
    color:#fff;
    background:var(--accent);
}

.c-btn.--ghost{
    color:var(--ink);
    background:#fff;
    border:1px solid var(--line);
}

/* =========================================================
A11y / Motion
========================================================= */
:focus-visible{
    outline:3px solid rgba(181,154,140,.35);
    outline-offset:2px;
}

@media (prefers-reduced-motion: reduce){
  *{ animation:none !important; transition:none !important; }
}
</style>
</head>

<body>
    <div class="c-dialog" role="dialog" aria-labelledby="ttl" aria-describedby="desc">
        <h1 id="ttl">検索条件をリセットしますか？</h1>
        <p id="desc">現在入力している検索条件はすべてクリアされます。<br>よろしければ「はい」を選択してください。</p>

        <div class="c-actions">
            {{-- ✅ 完全リセット --}}
            <a href="{{ route('admin.contacts.index') }}" class="c-btn --primary">はい、リセットする</a>

            {{-- ↩️ 検索ページに戻る --}}
            <a href="javascript:history.back()" class="c-btn --ghost">戻る</a>
        </div>
    </div>
</body>
</html>