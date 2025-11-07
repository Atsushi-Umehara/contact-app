<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Confirm | FashionablyLate</title>
    <style>
        /* ===============================
        ■ Design Tokens（色/サイズ/影）
        =================================*/
        :root {
            --bg: #fff9f6;
            --ink: #4b3f39;
            --muted: #9b8a82;
            --line: #e3d9d3;

            --panel: #ffffff;
            --cell: #f4ece7;
            --accent: #6a564c;

            --radius: 12px;
            --shadow: 0 10px 20px rgba(0,0,0,.05);

            --w: 760px;

            --xs: 8px;
            --sm: 12px;
            --md: 16px;
            --lg: 24px;
            --xl: 32px;
        }

        /* ===============================
        ■ Base（全体共通）
        =================================*/
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto,
            "Hiragino Kaku Gothic ProN", "Noto Sans JP", sans-serif;
            line-height: 1.7;
        }

        header {
            padding: var(--lg) 0;
            text-align: center;
            font-size: 28px;
            letter-spacing: .08em;
        }

        main {
            max-width: var(--w);
            margin: 0 auto;
            padding: var(--xl) var(--md);
        }

        h1 {
            margin: 0 0 var(--lg);
            text-align: center;
            font-size: 26px;
        }

        /* ===============================
        ■ 表示カード（確認テーブル）
        =================================*/
        .card {
            background: var(--panel);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--line);
            vertical-align: top;
        }

        th {
            width: 30%;
            background: var(--cell);
            color: var(--ink);
        }

        tr:last-child th,
        tr:last-child td {
            border-bottom: none;
        }

        /* ===============================
        ■ ボタン
        =================================*/
        .actions {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-top: var(--lg);
            flex-wrap: wrap;
        }

        .btn {
            appearance: none;
            border: 0;
            padding: 12px 28px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-ghost {
            background: #fff;
            border: 1px solid var(--line);
            color: var(--ink);
        }

        /* ===============================
        ■ Responsive
        =================================*/
        @media (max-width: 640px) {
            main { padding: var(--lg) var(--md); }
            th { width: 38%; }
            th, td { padding: 12px 14px; }
        }
    </style>
</head>
<body>
    <header>FashionablyLate</header>
    <main aria-labelledby="ttl">
        <h1 id="ttl">Confirm</h1>

        @php
            $genderLabel = [
                '1' => '男性',
                '2' => '女性',
                '3' => 'その他',
            ][$inputs['gender'] ?? ''] ?? '';
        @endphp

        <div class="card" role="region" aria-label="入力内容の確認">
            <table>
                <caption class="sr-only">入力内容の一覧</caption>
                <tr>
                    <th scope="row">お名前</th>
                    <td>{{ $inputs['last_name'] }}　{{ $inputs['first_name'] }}</td>
                </tr>
                <tr>
                    <th scope="row">性別</th>
                    <td>{{ $genderLabel }}</td>
                </tr>
                <tr>
                    <th scope="row">メールアドレス</th>
                    <td>{{ $inputs['email'] }}</td>
                </tr>
                <tr>
                    <th scope="row">電話番号</th>
                    <td>{{ $inputs['tel'] }}</td>
                </tr>
                <tr>
                    <th scope="row">住所</th>
                    <td>{{ $inputs['address'] }}</td>
                </tr>
                <tr>
                    <th scope="row">建物名</th>
                    <td>{{ $inputs['building'] ?? '' }}</td>
                </tr>
                <tr>
                    <th scope="row">お問い合わせの種類</th>
                    <td>{{ $category->content ?? '' }}</td>
                </tr>
                <tr>
                    <th scope="row">お問い合わせ内容</th>
                    <td>{!! nl2br(e($inputs['detail'])) !!}</td>
                </tr>
            </table>
        </div>

        <div class="actions">
            {{-- 送信（DB登録） --}}
            <form action="{{ route('contacts.store') }}" method="post">
                @csrf
                @foreach($inputs as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ is_scalar($v) ? $v : '' }}">
                @endforeach
                <button class="btn btn-primary" type="submit">送信</button>
            </form>

            {{-- 修正（入力画面へ戻る：値保持） --}}
            <form action="{{ route('contacts.confirm') }}" method="post">
                @csrf
                @foreach($inputs as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ is_scalar($v) ? $v : '' }}">
                @endforeach
                <button class="btn btn-ghost" type="submit" name="back" value="1">修正</button>
            </form>
        </div>
    </main>
</body>
</html>