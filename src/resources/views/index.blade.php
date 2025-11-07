<!-- resources/views/index.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Contact | FashionablyLate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
    /* ===============================
    Design Tokens
    =================================*/
    :root{
        --bg:        #fff9f6;
        --ink:       #4b3f39;
        --muted:     #9b8a82;
        --line:      #e3d9d3;
        --accent:    #6a564c;
        --accent-2:  #b59a8c;
        --danger:    #c34a36;

        --radius:    12px;
        --radius-sm: 8px;
        --shadow:    0 10px 20px rgba(0,0,0,.05);

        --space-xs:  8px;
        --space-sm:  12px;
        --space-md:  16px;
        --space-lg:  24px;
        --space-xl:  32px;
        --content-w: 760px;
    }

    /* ===============================
    Base
    =================================*/
    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body{
        margin: 0;
        color: var(--ink);
        background: var(--bg);
        font-family: system-ui, -apple-system, "Segoe UI", Roboto,
        "Hiragino Kaku Gothic ProN", "Noto Sans JP", sans-serif;
        line-height: 1.6;
    }

    header{
        padding: var(--space-lg) 0;
        text-align: center;
        font-size: 28px;
        letter-spacing: .08em;
    }

    main{
        max-width: var(--content-w);
        margin: 0 auto;
        padding: var(--space-xl) var(--space-md);
    }

    h1{
        margin: 0 0 var(--space-lg);
        text-align: center;
        font-size: 26px;
    }

    /* ===============================
    Form Shell
    =================================*/
    form{
        background: #fff;
        box-shadow: var(--shadow);
        border-radius: var(--radius);
        padding: var(--space-xl);
    }

    /* ラベル + 入力の2カラム行 */
    .row{
        display: grid;
        grid-template-columns: 180px 1fr;
        align-items: center;
        gap: var(--space-sm) var(--space-md);
        margin-bottom: var(--space-sm);
    }

    label .req{ color: var(--danger); margin-left: .4em; font-size: .9em; }

    /* ===============================
    Inputs
    =================================*/
    input[type="text"],
    input[type="email"],
    select,
    textarea{
        width: 100%;
        padding: var(--space-sm) var(--space-md);
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        background: #f8f5f3;
        outline: none;
        transition: border-color .15s, background .15s, box-shadow .15s;
    }
    input:focus,
    select:focus,
    textarea:focus{
        border-color: var(--accent-2);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(181,154,140,.15);
    }

    /* 名前フィールドの2分割 */
    .name-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-sm);
    }

    /* ラジオボタン横並び */
    .radios{ display: flex; gap: var(--space-lg); }

    /* エラーメッセージを入力の真下に揃える */
    .error{
        grid-column: 2 / 3;
        color: var(--danger);
        font-size: .9rem;
        margin: -4px 0 var(--space-sm);
    }

    /* 送信ボタン */
    .actions{ margin-top: var(--space-md); text-align: center; }
    button{
        appearance: none;
        border: 0;
        border-radius: 10px;
        background: var(--accent);
        color: #fff;
        padding: 12px 28px;
        font-size: 16px;
        cursor: pointer;
        transition: transform .02s ease, filter .15s ease;
    }
    button:hover{ filter: brightness(.96); }
    button:active{ transform: translateY(1px); }

    /* 薄い補助テキスト（未使用なら削除OK） */
    small.placeholder{ color: var(--muted); }

    /* ===============================
    Responsive
    =================================*/
    @media (max-width: 640px){
        .row{ grid-template-columns: 1fr; gap: var(--space-xs); }
        .error{ grid-column: 1 / -1; }
        .name-grid{ grid-template-columns: 1fr; }
        form{ padding: var(--space-lg); }
        header{ font-size: 24px; padding: var(--space-md) 0; }
    }

    .tel-grid{
        display:flex; align-items:center; gap:8px;
    }
    .tel-grid input[type="text"]{
        width: 120px;
        text-align: center;
    }
    .tel-dash{ color: var(--muted); user-select:none; }
    @media (max-width:640px){
        .tel-grid{ gap:6px; }
        .tel-grid input[type="text"]{ width: 100%; max-width: 110px; }
    }
    </style>
</head>
<body>
    <header>FashionablyLate</header>
    <main>
        <h1>Contact</h1>
        <form action="{{ route('contacts.confirm') }}" method="post">
            @csrf

            {{-- お名前 --}}
            <div class="row">
                <label for="last_name">お名前 <span class="req">※</span></label>
                <div class="name-grid">
                    <input id="last_name" type="text" name="last_name"  value="{{ old('last_name') }}" placeholder="例）山田" required maxlength="8">
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例）太郎" required maxlength="8">
                </div>
            </div>
            @error('last_name')
                <div class="row"><div></div><div class="error">{{ $message }}</div></div>
            @enderror
            @error('first_name')
                <div class="row"><div></div><div class="error">{{ $message }}</div></div>
            @enderror

            {{-- 性別 --}}
            <div class="row">
                <label for="gender">性別 <span class="req">※</span></label>
                <div class="radios">
                    @php($g = old('gender','1'))
                    <label for="gender_m">
                        <input id="gender_m" type="radio" name="gender" value="1" {{ $g == '1' ? 'checked' : '' }} required>
                        男性
                    </label>
                    <label for="gender_f">
                        <input id="gender_f" type="radio" name="gender" value="2" {{ $g == '2' ? 'checked' : '' }}>
                        女性
                    </label>
                    <label for="gender_o">
                        <input id="gender_o" type="radio" name="gender" value="3" {{ $g == '3' ? 'checked' : '' }}>
                        その他
                    </label>
                </div>
            </div>
            @error('gender')
                <div class="row">
                    <div></div>
                    <div class="error">{{ $message }}</div>
                </div>
            @enderror

            {{-- メールアドレス --}}
            <div class="row">
                <label for="email">メールアドレス <span class="req">※</span></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="例）test@example.com" required>
            </div>
            @error('email')
                <div class="row">
                    <div></div>
                    <div class="error">{{ $message }}</div>
                </div>
            @enderror

            {{-- 電話番号 --}}
            <div class="row">
                <label for="tel1">電話番号 <span class="req">※</span></label>

                <div class="tel-grid">
                    <input id="tel1" type="text" name="tel1"
                        value="{{ old('tel1') }}"
                        inputmode="numeric" pattern="\d{2,4}" maxlength="4"
                        placeholder="例）090" required>

                    <span class="tel-dash">-</span>

                    <input id="tel2" type="text" name="tel2"
                        value="{{ old('tel2') }}"
                        inputmode="numeric" pattern="\d{1,4}" maxlength="4"
                        placeholder="例）1234" required>

                    <span class="tel-dash">-</span>

                    <input id="tel3" type="text" name="tel3"
                        value="{{ old('tel3') }}"
                        inputmode="numeric" pattern="\d{1,4}" maxlength="4"
                        placeholder="例）5678" required>
                </div>
            </div>

            @error('tel')   {{-- 結合後の最終チェックのエラーを1か所に出す --}}
                <div class="row"><div></div><div class="error">{{ $message }}</div></div>
            @enderror
            @error('tel1') <div class="row"><div></div><div class="error">{{ $message }}</div></div> @enderror
            @error('tel2') <div class="row"><div></div><div class="error">{{ $message }}</div></div> @enderror
            @error('tel3') <div class="row"><div></div><div class="error">{{ $message }}</div></div> @enderror

            {{-- 住所 --}}
            <div class="row">
                <label for="address">住所 <span class="req">※</span></label>
                <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="例）東京都港区芝公園4-2-8" required maxlength="255">
            </div>
            @error('address')
                <div class="row">
                    <div></div>
                    <div class="error">{{ $message }}</div>
                </div>
            @enderror

            {{-- 建物名 --}}
            <div class="row">
                <label for="building">建物名</label>
                <input id="building" type="text" name="building" value="{{ old('building') }}" placeholder="例）サンプルマンション101" maxlength="255">
            </div>
            @error('building')
                <div class="row">
                    <div></div>
                    <div class="error">{{ $message }}</div>
                </div>
            @enderror

            {{-- お問い合わせの種類（カテゴリ） --}}
            <div class="row">
                <label for="category_id">お問い合わせの種類 <span class="req">※</span></label>
                <select id="category_id" name="category_id" required>
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string)old('category_id') === (string)$category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                <div class="row">
                    <div></div>
                    <div class="error">{{ $message }}</div>
                </div>
            @enderror

            {{-- お問い合わせ内容 --}}
            <div class="row">
                <label for="detail">お問い合わせ内容 <span class="req">※</span></label>
                <textarea id="detail" name="detail" rows="6" placeholder="お問い合わせ内容をご記載ください" required>{{ old('detail') }}</textarea>
            </div>
            @error('detail')
                <div class="row">
                    <div></div>
                    <div class="error">{{ $message }}</div>
                </div>
            @enderror

            <div class="actions">
                <button type="submit">確認画面</button>
            </div>
        </form>
    </main>
</body>
</html>