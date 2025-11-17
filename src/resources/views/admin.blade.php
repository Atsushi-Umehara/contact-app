{{-- resources/views/admin.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>管理画面 | FashionablyLate</title>

<style>
/* ===== Design Tokens ===== */
:root {
    --bg: #fff9f6;
    --ink: #3e3835;
    --muted: #8b7e77;
    --line: #e6ddd7;
    --panel: #ffffff;
    --accent: #6a564c;
    --accent-ghost: #f4ece7;
    --radius: 12px;
    --radius-sm: 8px;
    --shadow: 0 10px 20px rgba(0,0,0,.05);
    --width-content: 1100px;
    --space-xs: 6px;
    --space-sm: 10px;
    --space-md: 14px;
    --space-lg: 20px;
    --space-xl: 28px;
}

/* ===== Base ===== */
*{ box-sizing:border-box; }
html,body{ height:100%; }

body{
    margin:0;
    background:var(--bg);
    color:var(--ink);
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
}

header{
    padding:var(--space-lg) 0;
    font-size:24px;
    text-align:center;
    letter-spacing:.06em;
}

main{
    max-width:var(--width-content);
    margin:0 auto;
    padding:var(--space-xl) var(--space-md);
}

h1{
    margin-bottom:var(--space-md);
    font-size:22px;
}

/* ===== Card ===== */
.card{
    background:var(--panel);
    padding:var(--space-lg);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
}

/* ===== Search Form ===== */
.filters{
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1fr auto;
    gap:var(--space-sm);
    align-items:flex-end;
    margin-bottom:var(--space-md);
}

label{
    display:block;
    margin-bottom:4px;
    font-size:.88rem;
    color:var(--muted);
}

input[type=text],
select{
    width:100%;
    padding:10px;
    background:#f8f5f3;
    border:1px solid var(--line);
    border-radius:var(--radius-sm);
}

button,
.btn{
    padding:10px 16px;
    border:none;
    border-radius:10px;
    background:var(--accent);
    color:#fff;
    cursor:pointer;
}

.btn-ghost{
    background:#fff;
    border:1px solid var(--line);
    color:var(--ink);
}

.btn-sm{
    padding:6px 12px;
    font-size:.88rem;
}

/* ===== Links ===== */
.link-delete{
    color:#c34a36;
    text-decoration:none;
    font-size:.9rem;
}
.link-delete:hover{
    text-decoration:underline;
}

/* ===== Table ===== */
.table-wrap{
    max-height:65vh;
    overflow:auto;
    border:1px solid var(--line);
    border-radius:10px;
}

table{
    width:100%;
    min-width:960px;
    border-collapse:separate;
    border-spacing:0;
}

th,td{
    padding:10px 12px;
    border-bottom:1px solid var(--line);
    vertical-align:top;
}

thead th{
    background:var(--accent-ghost);
    position:sticky;
    top:0;
    font-weight:600;
}

tbody tr:nth-child(odd){ background:#fff; }
tbody tr:nth-child(even){ background:#fcfaf8; }
tbody tr:hover{ background:#f7f2ee; }

.clip{
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ===== Mobile ===== */
@media(max-width:720px){
    .filters{ grid-template-columns:1fr 1fr; }
    .table-wrap, table{ display:none; }

    .card-list{ display:grid; gap:var(--space-sm); }
    .card-item{
        padding:var(--space-md);
        border-radius:10px;
        border:1px solid var(--line);
        background:#fff;
    }
    .ci-head{
        display:flex;
        justify-content:space-between;
        margin-bottom:6px;
    }
    .ci-name{ font-weight:600; }
    .ci-meta{ color:var(--muted); font-size:.9rem; }
    .ci-body{
        display:grid;
        gap:4px;
        font-size:.95rem;
    }
    .ci-actions{
        margin-top:8px;
        text-align:right;
    }
}
</style>

</head>

<body>
<header>FashionablyLate 管理</header>

<main>

<h1>お問い合わせ一覧</h1>

{{-- 成功メッセージ --}}
@if(session('message'))
    <div class="card" style="padding:10px;margin-bottom:10px">
        {{ session('message') }}
    </div>
@endif

<div class="card">

    {{-- === フィルター === --}}
    <form class="filters" method="get" action="{{ url()->current() }}">
        <div>
            <label>キーワード</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="氏名・メール・TEL・本文など">
        </div>

        <div>
            <label>カテゴリ</label>
            <select name="category_id">
                <option value="">すべて</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        @selected((string)request('category_id') === (string)$cat->id)>
                        {{ $cat->content }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>性別</label>
            <select name="gender">
                <option value="">すべて</option>
                <option value="1" @selected(request('gender')==='1')>男性</option>
                <option value="2" @selected(request('gender')==='2')>女性</option>
                <option value="3" @selected(request('gender')==='3')>その他</option>
            </select>
        </div>

        <div>
            <label>件数</label>
            <select name="per">
                @foreach([10,20,50] as $n)
                    <option value="{{ $n }}"
                        @selected((int)request('per',10) === $n)>
                        {{ $n }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit">検索</button>
            <a class="btn btn-ghost" href="{{ url()->current() }}">リセット</a>
        </div>
    </form>

    {{-- CSVエクスポートボタン（現在の検索条件付き） --}}
    <div style="text-align:right; margin-bottom:10px;">
        <a
            href="{{ route('admin.contacts.export', request()->query()) }}"
            class="btn btn-sm btn-ghost"
        >
            CSVエクスポート
        </a>
    </div>

    @php
        $genderLabel = [1 => '男性', 2 => '女性', 3 => 'その他'];
    @endphp

    {{-- === PCテーブル === --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>受付日</th>
                    <th>氏名</th>
                    <th>性別</th>
                    <th>メール</th>
                    <th>TEL</th>
                    <th>カテゴリ</th>
                    <th>内容</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $c)
                    @php
                        // tel1,2,3 を単純に結合（null / 空文字は除外）
                        $tel = implode('-', array_filter(
                            [$c->tel1, $c->tel2, $c->tel3],
                            fn($v) => $v !== null && $v !== ''
                        ));
                    @endphp
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ optional($c->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $c->last_name }} {{ $c->first_name }}</td>
                        <td>{{ $genderLabel[(int)$c->gender] ?? '-' }}</td>
                        <td class="clip">{{ $c->email }}</td>
                        <td>{{ $tel }}</td>
                        <td>{{ optional($c->category)->content }}</td>
                        <td class="clip">{{ \Illuminate\Support\Str::limit($c->detail, 60) }}</td>
                        <td>
                            <a
                                href="{{ route('admin.contacts.delete', $c->id) }}"
                                class="link-delete"
                            >
                                削除
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">該当するデータはありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- === スマホ用カードリスト === --}}
    <div class="card-list" style="margin-top:16px;">
        @foreach($contacts as $c)
            @php
                $tel = implode('-', array_filter(
                    [$c->tel1, $c->tel2, $c->tel3],
                    fn($v) => $v !== null && $v !== ''
                ));
                $gText = $genderLabel[(int)$c->gender] ?? '-';
            @endphp
            <div class="card-item">
                <div class="ci-head">
                    <div class="ci-name">{{ $c->last_name }} {{ $c->first_name }}</div>
                    <div class="ci-meta">
                        #{{ $c->id }} ／ {{ optional($c->created_at)->format('Y-m-d') }}
                    </div>
                </div>
                <div class="ci-body">
                    <div>{{ $gText }} ／ {{ optional($c->category)->content }}</div>
                    <div>{{ $c->email }}</div>
                    <div>{{ $tel }}</div>
                    <div>{{ \Illuminate\Support\Str::limit($c->detail, 80) }}</div>
                </div>
                <div class="ci-actions">
                    <a
                        href="{{ route('admin.contacts.delete', $c->id) }}"
                        class="link-delete"
                    >
                        削除
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ページネーション --}}
    <div style="margin-top:14px">
        {{ $contacts->appends(request()->query())->links() }}
    </div>

</div>

{{-- === ログアウト === --}}
<form method="post" action="{{ route('logout') }}" style="text-align:right;margin-top:20px;">
    @csrf
    <button type="submit" class="btn">ログアウト</button>
</form>

</main>
</body>
</html>