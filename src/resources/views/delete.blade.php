<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>削除確認 | Contacts</title>

<style>
    body{
        margin:0;
        padding:40px;
        background:#fff9f6;
        color:#4b3f39;
        font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Noto Sans JP",sans-serif;
        line-height:1.6;
    }

    .box{
        max-width:600px;
        margin:0 auto;
        background:#fff;
        padding:30px;
        border-radius:12px;
        box-shadow:0 10px 20px rgba(0,0,0,.05);
    }

    h1{
        font-size:22px;
        margin-bottom:20px;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:20px;
    }

    th,td{
        padding:10px;
        border-bottom:1px solid #e6ddd7;
        text-align:left;
    }

    .actions{
        display:flex;
        justify-content:flex-end;
        gap:12px;
    }

    .btn{
        padding:10px 20px;
        border-radius:8px;
        cursor:pointer;
        font-size:15px;
        border:none;
        text-decoration:none;
    }

    .btn-cancel{
        background:#fff;
        border:1px solid #ccc;
        color:#4b3f39;
    }

    .btn-delete{
        background:#c34a36;
        color:#fff;
        border:none;
    }

</style>
</head>
<body>

<div class="box">

    <h1>このお問い合わせを削除しますか？</h1>

    <table>
        <tr>
            <th>ID</th>
            <td>{{ $contact->id }}</td>
        </tr>
        <tr>
            <th>名前</th>
            <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
        </tr>
        <tr>
            <th>メール</th>
            <td>{{ $contact->email }}</td>
        </tr>
        <tr>
            <th>カテゴリ</th>
            <td>{{ $category->content ?? '（なし）' }}</td>
        </tr>
        <tr>
            <th>内容</th>
            <td>{{ $contact->detail }}</td>
        </tr>
    </table>

    <div class="actions">

        {{-- キャンセル（一覧へ戻る） --}}
        <a class="btn btn-cancel"
            href="{{ route('admin.contacts.index') }}">
            キャンセル
        </a>

        {{-- 削除実行 --}}
        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="post">
            @csrf
            @method('DELETE')

            <button class="btn btn-delete" type="submit">
                削除する
            </button>
        </form>

    </div>

</div>

</body>
</html>