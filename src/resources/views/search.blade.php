<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Search | Contacts</title>
<style>
/* =========================================================
Design Tokens
========================================================= */
:root{
  --bg:#fff9f6;
  --panel:#ffffff;
  --ghost:#f5efe9;
  --ink:#3e3835;
  --muted:#8b7e77;
  --line:#e6ddd7;
  --accent:#6a564c;
  --radius-sm:8px;
  --radius:12px;
  --shadow:0 10px 20px rgba(0,0,0,.05);
  --w:1100px;
  --sp-3:12px;
  --sp-4:16px;
  --sp-5:20px;
  --sp-6:24px;
  --sp-8:32px;
  --fs-sm:.9rem;
}

/* Base */
*{ box-sizing:border-box; }
html,body{ height:100%; }
body{
    margin:0;
    background:var(--bg);
    color:var(--ink);
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
    line-height:1.65;
}
header{
    padding:var(--sp-6) 0;
    text-align:center;
    font-size:24px;
}
main{
    max-width:var(--w);
    margin:0 auto;
    padding:var(--sp-8) var(--sp-4);
}
h1{ margin:0 0 var(--sp-4); }

/* Utilities */
.u-muted{ color:var(--muted); }
.u-mt-4{ margin-top:var(--sp-4); }
.u-mt-6{ margin-top:var(--sp-6); }
.u-center{ text-align:center; }

/* Card */
.c-card{
    background:var(--panel);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    padding:var(--sp-6);
}

/* Inputs */
input[type=text],
input[type=date],
select{
    width:100%;
    padding:10px 12px;
    background:#f8f5f3;
    border:1px solid var(--line);
    border-radius:var(--radius-sm);
}
input:focus,
select:focus{
    background:#fff;
    border-color:#b59a8c;
    box-shadow:0 0 0 3px rgba(181,154,140,.16);
}

/* Buttons */
.c-btn{
    padding:10px 16px;
    border-radius:10px;
    cursor:pointer;
}
.c-btn.--primary{ background:var(--accent); color:#fff; }
.c-btn.--ghost{ background:#fff; border:1px solid var(--line); }

/* Badge */
.c-badge{
    padding:2px 8px;
    font-size:.82rem;
    border-radius:999px;
}
.c-badge.--m{ background:#dfe8ff; }
.c-badge.--f{ background:#ffdfe8; }
.c-badge.--o{ background:#ececec; }

/* Filters */
.c-filters{
    display:grid;
    grid-template-columns:repeat(12, 1fr);
    gap:var(--sp-3);
    margin-bottom:var(--sp-4);
}
.c-filters__item{ grid-column:span 3; }
.c-filters__item.--wide{ grid-column:span 4; }
.c-filters__item.--narrow{ grid-column:span 2; }
.c-filters__actions{ grid-column:span 12; display:flex; gap:var(--sp-3); }

/* Table */
.c-tableWrap{
    max-height:65vh;
    overflow:auto;
    border:1px solid var(--line);
    border-radius:10px;
}
table{
    width:100%;
    min-width:960px;
    border-collapse:separate;
}
th,td{
    padding:10px 12px;
    border-bottom:1px solid var(--line);
}
thead th{
    position:sticky;
    top:0;
    background:#f3ece6;
}
tbody tr:nth-child(odd){ background:#fff; }
tbody tr:nth-child(even){ background:#fcfaf8; }

/* Text */
.is-nowrap{ white-space:nowrap; }
.is-clip{
    max-width:400px;
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}

/* Pagination */
.pagination{
    display:flex;
    gap:6px;
    margin-top:var(--sp-4);
}
.pagination a,
.pagination span{
    padding:6px 10px;
    border:1px solid var(--line);
    border-radius:8px;
    background:#fff;
    text-decoration:none;
}
.pagination .active{
    background:var(--accent);
    color:#fff;
}

/* Responsive */
@media (max-width:720px){
    .c-tableWrap, table{ display:none; }
    .c-list{ display:grid; gap:var(--sp-3); }
    .c-listItem{
        padding:var(--sp-4);
        background:#fff;
        border:1px solid var(--line);
        border-radius:10px;
    }
    .c-listHead{
        display:flex;
        justify-content:space-between;
    }
}
</style>
</head>

<body>
<header>FashionablyLate 検索</header>
<main>
    <h1>お問い合わせ検索 <span class="u-muted" style="font-size:.95rem">/ 条件を指定して絞り込み</span></h1>

    <div class="c-card">
        {{-- フィルターフォーム --}}
        <form class="c-filters" method="get" action="{{ route('admin.contacts.search') }}">
            <div class="c-filters__item --wide">
                <label class="c-label">キーワード</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="氏名・メール・TEL・本文">
            </div>

            <div class="c-filters__item">
                <label class="c-label">カテゴリ</label>
                <select name="category_id">
                    <option value="">すべて</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id ? 'selected':'' }}>
                            {{ $cat->content }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="c-filters__item">
                <label class="c-label">性別</label>
                <select name="gender">
                    <option value="">すべて</option>
                    <option value="1" {{ request('gender')==='1'?'selected':'' }}>男性</option>
                    <option value="2" {{ request('gender')==='2'?'selected':'' }}>女性</option>
                    <option value="3" {{ request('gender')==='3'?'selected':'' }}>その他</option>
                </select>
            </div>

            <div class="c-filters__item --narrow">
                <label class="c-label">受付日（自）</label>
                <input type="date" name="from" value="{{ request('from') }}">
            </div>

            <div class="c-filters__item --narrow">
                <label class="c-label">受付日（至）</label>
                <input type="date" name="to" value="{{ request('to') }}">
            </div>

            <div class="c-filters__item --narrow">
                <label class="c-label">件数</label>
                <select name="per">
                    @foreach([10,20,50] as $n)
                        <option value="{{ $n }}" {{ (int)request('per',10)===$n?'selected':'' }}>
                            {{ $n }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="c-filters__actions">
                <button class="c-btn --primary" type="submit">検索</button>
                <a class="c-btn --ghost" href="{{ url()->current() }}">リセット</a>
            </div>
        </form>

        {{-- 結果 --}}
        @php $gLabel=[1=>'男性',2=>'女性',3=>'その他']; @endphp

        @if($contacts->count()===0)
            <div class="c-empty u-center u-mt-4">該当データがありません。</div>

        @else

            {{-- PC 表示 --}}
            <div class="c-tableWrap u-mt-4">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $c)
                            @php
                                $tel = $c->tel1 . '-' . $c->tel2 . '-' . $c->tel3;
                            @endphp
                            <tr>
                                <td class="is-nowrap">{{ $c->id }}</td>
                                <td class="is-nowrap">{{ optional($c->created_at)->format('Y-m-d') }}</td>
                                <td class="is-nowrap">{{ $c->last_name }} {{ $c->first_name }}</td>
                                <td class="is-nowrap">
                                    <span class="c-badge {{ $c->gender==1?'--m':($c->gender==2?'--f':'--o') }}">
                                        {{ $gLabel[$c->gender] }}
                                    </span>
                                </td>
                                <td class="is-clip">{{ $c->email }}</td>
                                <td class="is-nowrap">{{ $tel }}</td>
                                <td>{{ optional($c->category)->content }}</td>
                                <td class="is-clip">{{ \Illuminate\Support\Str::limit($c->detail,60) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- スマホ表示 --}}
            <div class="c-list u-mt-4">
                @foreach($contacts as $c)
                    @php $tel = $c->tel1.'-'.$c->tel2.'-'.$c->tel3; @endphp
                    <div class="c-listItem">
                        <div class="c-listHead">
                            <div class="c-listName">{{ $c->last_name }} {{ $c->first_name }}</div>
                            <div class="c-listMeta">#{{ $c->id }}・{{ $c->created_at->format('Y-m-d') }}</div>
                        </div>
                        <div class="c-listBody">
                            <div>
                                <span class="c-badge {{ $c->gender==1?'--m':($c->gender==2?'--f':'--o') }}">
                                    {{ $gLabel[$c->gender] }}
                                </span>
                                ／ {{ optional($c->category)->content }}
                            </div>
                            <div>{{ $c->email }}</div>
                            <div>{{ $tel }}</div>
                            <div>{{ \Illuminate\Support\Str::limit($c->detail,80) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="pagination">
                {{ $contacts->appends(request()->query())->links() }}
            </div>

        @endif
    </div>
</main>
</body>
</html>