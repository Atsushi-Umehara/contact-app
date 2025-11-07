{{-- resources/views/search.blade.php --}}
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
  /* Colors */
    --bg:#fff9f6;
    --panel:#ffffff;
    --ghost:#f5efe9;
    --ink:#3e3835;
    --muted:#8b7e77;
    --line:#e6ddd7;
    --accent:#6a564c;
    --danger:#c34a36;

  /* Radius / Shadow */
    --radius:12px;
    --radius-sm:8px;
    --shadow:0 10px 20px rgba(0,0,0,.05);

  /* Layout width */
    --w:1100px;

  /* Spacing (scale) */
    --sp-2:8px;
    --sp-3:12px;
    --sp-4:16px;
    --sp-5:20px;
    --sp-6:24px;
    --sp-8:32px;

  /* Font sizes */
    --fs-sm:.9rem;
    --fs-base:1rem;
    --fs-lg:1.25rem;
}

/* =========================================================
Base / Reset
========================================================= */
*{ box-sizing:border-box; }
html,body{ height:100%; }

body{
    margin:0;
    background:var(--bg);
    color:var(--ink);
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Hiragino Kaku Gothic ProN","Noto Sans JP",sans-serif;
    font-size:var(--fs-base);
    line-height:1.65;
}

header{
    padding:var(--sp-6) 0;
    text-align:center;
    font-size:24px;
    letter-spacing:.06em;
}

main{
    max-width:var(--w);
    margin:0 auto;
    padding:var(--sp-8) var(--sp-4);
}

h1{
    margin:0 0 var(--sp-4);
    font-size:22px;
}

/* Better focus for keyboard users */
:focus-visible{
    outline:3px solid rgba(181,154,140,.35);
    outline-offset:2px;
}

/* Motion reduce */
@media (prefers-reduced-motion: reduce){
  *{ transition:none !important; animation:none !important; }
}

/* =========================================================
Utilities
========================================================= */
.u-muted{ color:var(--muted); }
.u-right{ margin-left:auto; }
.u-center{ text-align:center; }
.u-gap{ gap:var(--sp-3); }
.u-mt-4{ margin-top:var(--sp-4); }
.u-mt-6{ margin-top:var(--sp-6); }
.u-p-3{ padding:var(--sp-3); }
.u-pill{ border-radius:999px; }
.u-ghost{ background:#fff; border:1px solid var(--line); color:var(--ink); }

/* =========================================================
Components
========================================================= */

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
    transition:border-color .15s, box-shadow .15s, background .15s;
}

input:focus,
select:focus{
    background:#fff;
    border-color:#b59a8c;
    box-shadow:0 0 0 3px rgba(181,154,140,.16);
    outline:0; /* rely on focus-visible */
}

/* Buttons */
.c-btn{
    appearance:none;
    border:0;
    border-radius:10px;
    padding:10px 16px;
    cursor:pointer;
}
.c-btn.--primary{ background:var(--accent); color:#fff; }
.c-btn.--ghost{ background:#fff; border:1px solid var(--line); color:var(--ink); }
.c-btn:active{ transform:translateY(1px); }

/* Badge (sex) */
.c-badge{
    display:inline-block;
    padding:2px 8px;
    font-size:.82rem;
    border-radius:999px;
}
.c-badge.--m{ background:#dfe8ff; }
.c-badge.--f{ background:#ffdfe8; }
.c-badge.--o{ background:#ececec; }

/* Empty state */
.c-empty{
    padding:var(--sp-6);
    color:var(--muted);
    background:var(--ghost);
    border:1px dashed var(--line);
    border-radius:10px;
}

/* =========================================================
Filters (Search bar)
========================================================= */
.c-filters{
    display:grid;
    grid-template-columns:repeat(12, 1fr);
    align-items:end;
    gap:var(--sp-3);
    margin-bottom:var(--sp-4);
}

.c-filters__item{ grid-column:span 3; }
.c-filters__item.--wide{ grid-column:span 4; }
.c-filters__item.--narrow{ grid-column:span 2; }

.c-filters__actions{
    grid-column:span 12;
    display:flex;
    align-items:center;
    gap:var(--sp-3);
}

.c-label{
    display:block;
    margin:0 0 4px;
    color:var(--muted);
    font-size:var(--fs-sm);
}

/* =========================================================
Table (Desktop)
========================================================= */
.c-tableWrap{
    max-height:65vh;
    overflow:auto;
    border:1px solid var(--line);
    border-radius:10px;
}

table{
    width:100%;
    min-width:980px;
    border-collapse:separate;
    border-spacing:0;
}

th,td{
    padding:10px 12px;
    vertical-align:top;
    border-bottom:1px solid var(--line);
}

thead th{
    position:sticky;
    top:0;
    z-index:1;
    text-align:left;
    font-weight:600;
    background:linear-gradient(#f3ece6,#efe7e1);
}

/* Zebra & hover */
tbody tr:nth-child(odd){ background:#fff; }
tbody tr:nth-child(even){ background:#fcfaf8; }
tbody tr:hover{ background:#f7f2ee; }

/* Column widths */
th.w-id{ width:70px; }
th.w-date{ width:120px; }
th.w-sex{ width:90px; }
th.w-mail{ width:220px; }
th.w-tel{ width:140px; }
th.w-cat{ width:160px; }

/* Text handling */
.is-nowrap{ white-space:nowrap; }
.is-clip{
    max-width:420px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* =========================================================
Pagination (Laravel links)
========================================================= */
.pagination{
    display:flex;
    flex-wrap:wrap;
    gap:6px;
    margin-top:var(--sp-4);
}
.pagination a,
.pagination span{
    padding:6px 10px;
    background:#fff;
    color:var(--ink);
    border:1px solid var(--line);
    border-radius:8px;
    text-decoration:none;
}
.pagination .active{
    background:var(--accent);
    color:#fff;
    border-color:var(--accent);
}

/* =========================================================
Responsive
========================================================= */
@media (max-width:960px){
    .c-filters__item{ grid-column:span 4; }
    .c-filters__item.--wide{ grid-column:span 6; }
    .c-filters__item.--narrow{ grid-column:span 3; }
}

@media (max-width:720px){
    .c-filters{
        grid-template-columns:1fr;
        gap:var(--sp-3);
    }
    .c-filters__item,
    .c-filters__item.--wide,
    .c-filters__item.--narrow,
    .c-filters__actions{
        grid-column:1 / -1;
    }

  /* Table → Card list */
    .c-tableWrap, table{ display:none; }

    .c-list{
        display:grid;
        gap:var(--sp-3);
    }
    .c-listItem{
        padding:var(--sp-4);
        background:#fff;
        border:1px solid var(--line);
        border-radius:10px;
    }
    .c-listHead{
        display:flex;
        justify-content:space-between;
        gap:var(--sp-3);
        margin-bottom:6px;
    }
    .c-listName{ font-weight:600; }
    .c-listMeta{ color:var(--muted); font-size:.95rem; }
    .c-listBody{ display:grid; gap:4px; font-size:.98rem; }
}
</style>
</head>
<body>
    <header>FashionablyLate 検索</header>
    <main>
        <h1>お問い合わせ検索 <span class="u-muted" style="font-size:.95rem">/ 条件を指定して一覧を絞り込み</span></h1>

        <div class="c-card">
            {{-- フィルター（GET） --}}
            <form class="c-filters" method="get" action="{{ route('admin.contacts.search') }}">
                <div class="c-filters__item --wide">
                    <label for="q" class="c-label">キーワード</label>
                    <input id="q" type="text" name="q" value="{{ request('q') }}" placeholder="氏名・メール・本文・TELで検索">
                </div>

                <div class="c-filters__item">
                    <label for="category_id" class="c-label">カテゴリ</label>
                    <select id="category_id" name="category_id">
                        <option value="">すべて</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (string)request('category_id')===(string)$cat->id ? 'selected' : '' }}>
                                {{ $cat->content }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="c-filters__item">
                    <label for="gender" class="c-label">性別</label>
                    <select id="gender" name="gender">
                        <option value="">すべて</option>
                        <option value="1" {{ request('gender')==='1' ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender')==='2' ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender')==='3' ? 'selected' : '' }}>その他</option>
                    </select>
                </div>

                <div class="c-filters__item --narrow">
                    <label for="from" class="c-label">受付日（自）</label>
                    <input id="from" type="date" name="from" value="{{ request('from') }}">
                </div>

                <div class="c-filters__item --narrow">
                    <label for="to" class="c-label">受付日（至）</label>
                    <input id="to" type="date" name="to" value="{{ request('to') }}">
                </div>

                <div class="c-filters__item --narrow">
                    <label for="per" class="c-label">件数</label>
                    <select id="per" name="per">
                        @foreach([10,20,50] as $n)
                            <option value="{{ $n }}" {{ (int)request('per',10)===$n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="c-filters__actions">
                    <button class="c-btn --primary" type="submit">検索</button>
                    <a class="c-btn --ghost" href="{{ url()->current() }}">リセット</a>
                    <div class="u-right u-muted" style="font-size:.92rem">
                        条件数：<strong>
                            {{
                                collect([
                                    request('q'), request('category_id'), request('gender'),
                                    request('from'), request('to')
                                ])->filter(fn($v)=>filled($v))->count()
                            }}
                        </strong>
                    </div>
                </div>
            </form>

            {{-- 結果：テーブル（PC/タブレット） --}}
            @php $gLabel=[1=>'男性',2=>'女性',3=>'その他']; @endphp
            @if($contacts->count() === 0)
                <div class="c-empty u-center u-mt-4">該当するデータはありません。条件を変更して再検索してください。</div>
                @else
                <div class="c-tableWrap u-mt-4">
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
                            @foreach($contacts as $c)
                                @php
                                    $tel = $c->tel;
                                    if (preg_match('/^\d{10,11}$/', (string)$tel)) {
                                        $tel = preg_replace('/^(\d{2,4})(\d{2,4})(\d{3,4})$/', '$1-$2-$3', $tel);
                                    }
                                    $g = (int)$c->gender;
                                @endphp
                                <tr>
                                    <td class="is-nowrap">{{ $c->id }}</td>
                                    <td class="is-nowrap">{{ optional($c->created_at)->format('Y-m-d') }}</td>
                                    <td class="is-nowrap">{{ $c->last_name }} {{ $c->first_name }}</td>
                                    <td class="is-nowrap">
                                        <span class="c-badge {{ $g===1?'--m':($g===2?'--f':'--o') }}">{{ $gLabel[$g] ?? '-' }}</span>
                                    </td>
                                    <td class="is-clip" title="{{ $c->email }}">{{ $c->email }}</td>
                                    <td class="is-nowrap">{{ $tel }}</td>
                                    <td class="is-clip" title="{{ optional($c->category)->content }}">{{ optional($c->category)->content }}</td>
                                    <td class="is-clip" title="{{ $c->detail }}">{{ \Illuminate\Support\Str::limit($c->detail, 60) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- スマホ：カード表示 --}}
                <div class="c-list u-mt-4">
                    @foreach($contacts as $c)
                        @php
                            $tel = $c->tel;
                            if (preg_match('/^\d{10,11}$/', (string)$tel)) {
                                $tel = preg_replace('/^(\d{2,4})(\d{2,4})(\d{3,4})$/', '$1-$2-$3', $tel);
                            }
                            $g=(int)$c->gender; $gText = $gLabel[$g] ?? '-';
                        @endphp
                        <div class="c-listItem">
                            <div class="c-listHead">
                                <div class="c-listName">{{ $c->last_name }} {{ $c->first_name }}</div>
                                <div class="c-listMeta">#{{ $c->id }}・{{ optional($c->created_at)->format('Y-m-d') }}</div>
                            </div>
                            <div class="c-listBody">
                                <div><span class="c-badge {{ $g===1?'--m':($g===2?'--f':'--o') }}">{{ $gText }}</span> ／ {{ optional($c->category)->content }}</div>
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
            @endif
        </div>
    </main>
</body>
</html>