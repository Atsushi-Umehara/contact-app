{{-- resources/views/admin.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin | Contacts</title>
<style>
/* ------------------------------------
Design Tokens (色・サイズなどの基準値)
------------------------------------ */
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

/* ------------------------------------
Base Style（共通）
------------------------------------ */
* { box-sizing: border-box; }
html, body { height: 100%; }

body {
    margin: 0;
    background: var(--bg);
    color: var(--ink);
    font-family: system-ui, sans-serif;
    line-height: 1.6;
}

header {
    padding: var(--space-lg) 0;
    font-size: 24px;
    text-align: center;
    letter-spacing: .06em;
}

main {
    max-width: var(--width-content);
    margin: 0 auto;
    padding: var(--space-xl) var(--space-md);
}

h1 {
    margin-bottom: var(--space-md);
    font-size: 22px;
}

/* ------------------------------------
Card / Panel
------------------------------------ */
.card {
    background: var(--panel);
    padding: var(--space-lg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

/* ------------------------------------
Filter Form
------------------------------------ */
.filters {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr auto;
    align-items: end;
    gap: var(--space-sm);
    margin-bottom: var(--space-md);
}

label {
    display: block;
    font-size: .88rem;
    color: var(--muted);
    margin-bottom: 4px;
}

input[type=text],
select {
    width: 100%;
    padding: 10px;
    background: #f8f5f3;
    border: 1px solid var(--line);
    border-radius: var(--radius-sm);
}

button,
.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 10px;
    background: var(--accent);
    color: #fff;
    cursor: pointer;
}

.btn-ghost {
    background: #fff;
    border: 1px solid var(--line);
    color: var(--ink);
}

/* ------------------------------------
Table Layout (PC表示)
------------------------------------ */
.table-wrap {
    max-height: 65vh;
    overflow: auto;
    border: 1px solid var(--line);
    border-radius: 10px;
}

table {
    width: 100%;
    min-width: 960px;
    border-collapse: separate;
    border-spacing: 0;
}

th, td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--line);
    vertical-align: top;
}

thead th {
    position: sticky;
    top: 0;
    background: var(--accent-ghost);
    font-weight: 600;
    text-align: left;
}

/* 交互背景 + ホバー */
tbody tr:nth-child(odd) { background: #fff; }
tbody tr:nth-child(even){ background: #fcfaf8; }
tbody tr:hover { background: #f7f2ee; }

/* 固定幅列 */
th.w-id   { width: 70px; }
th.w-date { width: 110px; }
th.w-sex  { width: 90px; }
th.w-mail { width: 200px; }
th.w-tel  { width: 140px; }
th.w-cat  { width: 140px; }

/* テキスト省略 */
.nowrap { white-space: nowrap; }
.clip {
    max-width: 380px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* 性別バッジ */
.badge {
    display: inline-block;
    padding: 2px 8px;
    font-size: .8rem;
    border-radius: 999px;
}
.badge-m { background: #dfe8ff; }
.badge-f { background: #ffdfe8; }
.badge-o { background: #ececec; }

/* ------------------------------------
Pagination (Laravel links)
------------------------------------ */
.pagination {
    display: flex;
    gap: 6px;
    margin-top: var(--space-md);
    flex-wrap: wrap;
}
.pagination a,
.pagination span {
    padding: 6px 10px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 8px;
    text-decoration: none;
    color: var(--ink);
}
.pagination .active {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

/* ------------------------------------
Responsive (スマホ → カード)
------------------------------------ */
@media (max-width: 720px) {

.filters {
    grid-template-columns: 1fr 1fr;
}

.table-wrap, table { display: none; }

.card-list {
    display: grid;
    gap: var(--space-sm);
}

.card-item {
    padding: var(--space-md);
    border-radius: 10px;
    border: 1px solid var(--line);
    background: #fff;
}

.ci-head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
}

.ci-name { font-weight: 600; }
.ci-meta { font-size: .9rem; color: var(--muted); }

.ci-body {
    display: grid;
    gap: 4px;
    font-size: .95rem;
}
}
</style>
</head>
<body>
    <header>FashionablyLate 管理</header>
    <main>
        <h1>お問い合わせ一覧</h1>

        @if(session('message'))
            <div class="card" style="padding:10px;margin-bottom:10px">{{ session('message') }}</div>
        @endif

        <div class="card">
            {{-- フィルター（GET） --}}
            <form class="filters" method="get" action="{{ url()->current() }}">
                <div>
                    <label for="q">キーワード</label>
                    <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="氏名・メール・本文・TELで検索">
                </div>
                <div>
                    <label for="category_id">カテゴリ</label>
                    <select id="category_id" name="category_id">
                        <option value="">すべて</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (string)request('category_id')===(string)$cat->id?'selected':'' }}>
                            {{ $cat->content }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="gender">性別</label>
                    <select id="gender" name="gender">
                        <option value="">すべて</option>
                        <option value="1" {{ request('gender')==='1'?'selected':'' }}>男性</option>
                        <option value="2" {{ request('gender')==='2'?'selected':'' }}>女性</option>
                        <option value="3" {{ request('gender')==='3'?'selected':'' }}>その他</option>
                    </select>
                </div>
                <div>
                    <label for="per">表示件数</label>
                    <select id="per" name="per">
                        @foreach([10,20,50] as $n)
                            <option value="{{ $n }}" {{ (int)request('per',10)===$n?'selected':'' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit">検索</button>
                    <a class="btn btn-ghost" href="{{ url()->current() }}" style="margin-left:6px;">リセット</a>
                </div>
            </form>

            {{-- PC/タブレット：テーブル表示 --}}
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="w-id">ID</th>
                            <th class="w-date">受付日</th>
                            <th>氏名</th>
                            <th class="w-sex">性別</th>
                            <th class="w-mail">メール</th>
                            <th class="w-tel">TEL</th>
                            <th class="w-cat">カテゴリ</th>
                            <th>内容</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $gLabel=[1=>'男性',2=>'女性',3=>'その他']; @endphp
                        @forelse($contacts as $c)
                            @php
                                $tel = $c->tel;
                                if (preg_match('/^\d{10,11}$/', (string)$tel)) {
                                $tel = preg_replace('/^(\d{2,4})(\d{2,4})(\d{3,4})$/', '$1-$2-$3', $tel);
                                }
                            @endphp
                            <tr>
                                <td class="nowrap">{{ $c->id }}</td>
                                <td class="nowrap">{{ optional($c->created_at)->format      ('Y-m-d') }}</td>
                                <td class="nowrap">{{ $c->last_name }} {{ $c->first_name }}</td>
                                <td class="nowrap">
                                    @php $g=(int)$c->gender; @endphp
                                    <span class="badge {{ $g===1?'badge-m':($g===2?'badge-f':'badge-o') }}">{{ $gLabel[$g] ?? '-' }}</span>
                                </td>
                                <td class="clip" title="{{ $c->email }}">{{ $c->email }}</td>
                                <td class="nowrap">{{ $tel }}</td>
                                <td class="clip" title="{{ optional($c->category)->content }}">{{ optional($c->category)->content }}</td>
                                <td class="clip" title="{{ $c->detail }}">{{ \Illuminate\Support\Str::limit($c->detail, 60) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="8">該当するデータはありません。</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- スマホ：カード表示 --}}
            <div class="card-list">
                @foreach($contacts as $c)
                    @php
                        $tel = $c->tel;
                        if (preg_match('/^\d{10,11}$/', (string)$tel)) {
                            $tel = preg_replace('/^(\d{2,4})(\d{2,4})(\d{3,4})$/', '$1-$2-$3', $tel);
                        }
                        $g=(int)$c->gender; $gLabel=[1=>'男性',2=>'女性',3=>'その他'][$g]??'-';
                    @endphp
                    <div class="card-item">
                        <div class="ci-head">
                            <div class="ci-name">{{ $c->last_name }} {{ $c->first_name }}</div>
                            <div class="ci-meta">#{{ $c->id }}・{{ optional($c->created_at)->format('Y-m-d') }}</div>
                        </div>
                        <div class="ci-body">
                            <div><span class="badge {{ $g===1?'badge-m':($g===2?'badge-f':'badge-o') }}">{{ $gLabel }}</span> ／ {{ optional($c->category)->content }}</div>
                            <div>{{ $c->email }}</div>
                            <div>{{ $tel }}</div>
                            <div>{{ \Illuminate\Support\Str::limit($c->detail, 80) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            @if(method_exists($contacts,'links'))
                <div class="pagination">
                    {{ $contacts->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>