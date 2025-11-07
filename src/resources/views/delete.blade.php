{{-- resources/views/delete.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>お問い合わせ削除 | Contacts</title>
<style>
/* =========================================
Design Tokens
========================================= */
:root{
    --bg:#fff9f6;
    --panel:#ffffff;
    --ghost:#f5efe9;
    --ink:#3e3835;
    --muted:#8b7e77;
    --line:#e6ddd7;
    --accent:#6a564c;
    --danger:#c34a36;

    --radius:14px;
    --shadow:0 10px 24px rgba(0,0,0,.08);

    --sp-3:12px;
    --sp-4:16px;
    --sp-6:24px;
    --sp-8:32px;

    --fs-base:1rem;
    --fs-lg:1.25rem;
}

/* =========================================
Base
========================================= */
*{ box-sizing:border-box; }
html,body{ height:100%; margin:0; }

body{
    min-height:100vh;
    padding:var(--sp-8) var(--sp-4);
    background:var(--bg);
    color:var(--ink);
    font: var(--fs-base)/1.7 system-ui, -apple-system, "Segoe UI", Roboto, "Hiragino Kaku Gothic ProN","Noto Sans JP", sans-serif;
    display:flex; justify-content:center; align-items:center;
}

/* =========================================
Dialog Container
========================================= */
.c-dialog{
    width:100%;
    max-width:720px;
    padding:var(--sp-8) var(--sp-6);
    background:var(--panel);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    text-align:center;
    animation:fadeIn .25s ease both;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(6px);}
    to{opacity:1; transform:translateY(0);}
}

/* =========================================
Text
========================================= */
h1{
    margin:0 0 var(--sp-4);
    font-size:var(--fs-lg);
    font-weight:600;
}

.p{
    margin:0 0 var(--sp-6);
    color:var(--muted);
}

/* =========================================
Detail Table
========================================= */
.table{
    width:100%;
    border:1px solid var(--line);
    border-radius:12px;
    border-collapse:separate;
    border-spacing:0;
    overflow:hidden;
}

.table th,
.table td{
    padding:10px 12px;
    border-bottom:1px solid var(--line);
    vertical-align:top;
}

.table th{
    width:28%;
    background:var(--ghost);
    font-weight:600;
    text-align:left;
}

.table tr:last-child th,
.table tr:last-child td{
    border-bottom:none;
}

/* =========================================
Actions
========================================= */
.actions{
    margin-top:var(--sp-6);
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:var(--sp-3);
}

.btn{
    display:inline-block;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
    text-decoration:none;
    transition:.15s;
}

.btn:active{
    transform:translateY(1px);
}

.btn-danger{
    background:var(--danger);
    color:#fff;
}

.btn-ghost{
    background:#fff;
    color:var(--ink);
    border:1px solid var(--line);
}

/* =========================================
A11y
========================================= */
:focus-visible{
    outline:3px solid rgba(195,74,54,.25);
    outline-offset:3px;
}
</style>
</head>
<body>
    <div class="c-dialog" role="dialog" aria-labelledby="ttl" aria-describedby="desc">
        <h1 id="ttl">このお問い合わせを削除しますか？</h1>
        <p id="desc" class="p">
        削除すると元に戻せません（※ゴミ箱/論理削除を使っていない場合）。内容を確認のうえ実行してください。
        </p>

        {{-- $contact と $category をコントローラから受け取る想定 --}}
        @php
            $tel = $contact->tel;
            if (preg_match('/^\d{10,11}$/', (string)$tel)) {
                $tel = preg_replace('/^(\d{2,4})(\d{2,4})(\d{3,4})$/', '$1-$2-$3', $tel);
            }
            $gLabel = [1=>'男性',2=>'女性',3=>'その他'];
            $gender = $gLabel[(int)$contact->gender] ?? '-';
        @endphp

        <table class="table" aria-label="削除対象の詳細">
            <tr><th>ID</th><td>#{{ $contact->id }}</td></tr>
            <tr><th>受付日</th><td>{{ optional($contact->created_at)->format('Y-m-d H:i') }}</td></tr>
            <tr><th>氏名</th><td>{{ $contact->last_name }} {{ $contact->first_name }}</td></tr>
            <tr><th>性別</th><td>{{ $gender }}</td></tr>
            <tr><th>メール</th><td>{{ $contact->email }}</td></tr>
            <tr><th>TEL</th><td>{{ $tel }}</td></tr>
            <tr><th>カテゴリ</th><td>{{ optional($category)->content }}</td></tr>
            <tr><th>内容</th><td>{!! nl2br(e($contact->detail)) !!}</td></tr>
        </table>

        <div class="actions">
            {{-- 削除実行 --}}
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="post" onsubmit="return confirm('本当に削除しますか？この操作は元に戻せません。');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">削除する</button>
            </form>

            {{-- 戻る（一覧 or 直前ページ） --}}
            @php
                $backUrl = url()->previous() && url()->previous() !== url()->current()
                ? url()->previous()
                : route('admin.contacts.index');
            @endphp
            <a href="{{ $backUrl }}" class="btn btn-ghost">戻る</a>
        </div>
    </div>
</body>
</html>