<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Confirm | FashionablyLate</title>
    <style>
        body {
            background:#fff9f6; font-family:sans-serif;
            padding:30px;
        }

        .card {
            background:#fff;
            padding:20px;
            border-radius:8px;
            max-width:700px;
            margin:auto;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
        }

        table {
            width:100%;
            border-collapse:collapse;
        }

        th,td {
            padding:10px;
            border-bottom:1px solid #eee;
        }

        th {
            background:#f8f4f2;
            width:30%;
        }

        .actions {
            margin-top:20px;
            display:flex;
            gap:10px;
            justify-content:center;
        }

        button {
            padding:10px 20px;
            border:none;
            border-radius:6px;
            cursor:pointer;
        }

        .primary {
            background:#6a564c;
            color:#fff;
        }

        .ghost {
            background:#fff;
            border:1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>入力内容の確認</h2>

    @php
        $genderLabel = [
            '1' => '男性',
            '2' => '女性',
            '3' => 'その他'
        ][$inputs['gender'] ?? ''] ?? '';

        // 電話番号（結合）
        $tel = ($inputs['tel1'] ?? '') . '-' . ($inputs['tel2'] ?? '') . '-' . ($inputs['tel3'] ?? '');

        // 本文(detail)
        $body = $inputs['detail'] ?? '';
    @endphp

    <table>
        <tr>
            <th>お名前</th>
            <td>{{ $inputs['last_name'] ?? '' }} {{ $inputs['first_name'] ?? '' }}</td>
        </tr>

        <tr>
            <th>性別</th>
            <td>{{ $genderLabel }}</td>
        </tr>

        <tr>
            <th>メールアドレス</th>
            <td>{{ $inputs['email'] ?? '' }}</td>
        </tr>

        <tr>
            <th>電話番号</th>
            <td>{{ $tel }}</td>
        </tr>

        <tr>
            <th>住所</th>
            <td>{{ $inputs['address'] ?? '' }}</td>
        </tr>

        <tr>
            <th>建物名</th>
            <td>{{ $inputs['building'] ?? '' }}</td>
        </tr>

        <tr>
            <th>お問い合わせの種類</th>
            <td>{{ $category?->content ?? '' }}</td>
        </tr>

        <tr>
            <th>お問い合わせ内容</th>
            <td>{!! nl2br(e($body)) !!}</td>
        </tr>
    </table>

    <div class="actions">

        {{-- 送信 --}}
        <form action="{{ route('contacts.store') }}" method="post">
            @csrf
            @foreach($inputs as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <button type="submit" class="primary">送信</button>
        </form>

        {{-- 戻る --}}
        <form action="{{ route('contacts.confirm') }}" method="post">
            @csrf
            @foreach($inputs as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <button type="submit" name="back" value="1" class="ghost">修正</button>
        </form>

    </div>

</div>

</body>
</html>