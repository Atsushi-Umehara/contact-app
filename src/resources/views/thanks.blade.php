<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>お問い合わせ完了 | FashionablyLate</title>

    <!-- メタ情報（SEO・SNS用） -->
    <meta name="description" content="FashionablyLate お問い合わせ完了ページ">
    <meta property="og:title" content="お問い合わせありがとうございます">
    <meta property="og:type" content="website">

    <style>
        /* ===============================
        Base Style
        =============================== */
        html, body{
            height: 100%;
            margin: 0;
            padding: 0;
            background: #fff9f6;
            color: #4b3f39;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto,
                "Hiragino Kaku Gothic ProN", "Noto Sans JP", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header{
            width: 100%;
            text-align: center;
            padding: 40px 0 20px;
            font-size: 28px;
            letter-spacing: .08em;
        }

        /* ===============================
        Center Box
        =============================== */
        .box{
            background: #fff;
            width: 90%;
            max-width: 520px;
            padding: 40px 32px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,.05);
            text-align: center;
        }

        h1{
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            line-height: 1.5;
        }

        p{
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 32px;
        }

        /* ===============================
        Button
        =============================== */
        .btn{
            display: inline-block;
            padding: 12px 32px;
            background: #6a564c;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            letter-spacing: .05em;
            transition: .2s;
        }

        .btn:hover{
            filter: brightness(.95);
        }

        /* ===============================
        Responsive
        =============================== */
        @media (max-width: 640px){
            header{
                font-size: 24px;
                padding: 30px 0 16px;
            }
            .box{
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>
    <header>FashionablyLate</header>

    <div class="box">
        <h1>お問い合わせありがとうございました</h1>
        <p>
            内容を送信しました。<br>
            担当者より追ってご連絡させていただきます。
        </p>

        <a class="btn" href="{{ route('contacts.index') }}">トップへ戻る</a>
    </div>
</body>
</html>