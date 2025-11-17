<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>検索条件リセット | Admin</title>

<style>
    body{
        margin:0;
        background:#fff9f6;
        color:#4b3f39;
        font-family:system-ui,-apple-system,"Segoe UI",Roboto,
            "Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
        text-align:center;
        padding-top:120px;
    }

    header{
        font-size:28px;
        margin-bottom:40px;
        letter-spacing:.06em;
    }

    .box{
        background:#fff;
        margin:0 auto;
        padding:40px;
        max-width:520px;
        border-radius:12px;
        box-shadow:0 10px 20px rgba(0,0,0,.05);
    }

    h1{
        font-size:22px;
        margin-bottom:16px;
    }

    p{
        font-size:15px;
        margin-bottom:28px;
    }

    .btn{
        display:inline-block;
        padding:12px 28px;
        border-radius:8px;
        font-size:15px;
        text-decoration:none;
        cursor:pointer;
        margin:0 10px;
    }

    .btn-primary{
        background:#6a564c;
        color:#fff;
    }

    .btn-ghost{
        background:#fff;
        border:1px solid #e6ddd7;
        color:#3e3835;
    }

    .btn:hover{ opacity:.92; }
</style>
</head>

<body>
<header>FashionablyLate 管理</header>

<div class="box">
    <h1>検索条件をリセットしますか？</h1>
    <p>現在の検索条件をすべて削除して<br>新しい一覧を表示します。</p>

    {{-- リセット実行（一覧に戻る） --}}
    <a class="btn btn-primary" href="{{ route('admin.contacts.index') }}">
        はい、リセットする
    </a>

    {{-- 元のページへ戻る --}}
    <a class="btn btn-ghost" href="{{ url()->previous() }}">
        いいえ、戻る
    </a>
</div>

</body>
</html>