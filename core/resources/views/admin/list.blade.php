<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="/css/style.css">
</head>
    <body class="admin_list_page">

        <h1>■お問い合わせ一覧</h1>

        <form action="{{ route('admin.user_list') }}" method="get">

        <!-- お名前 -->
        <div class="item">
            <label for="name" class="label">お名前</label>
            <div class="inputs">
                <input type="text" name="name" id="name" value="{{ old('name') }}">
            </div>
        </div>

        <!-- カナ -->
        <div class="item">
            <label for="kana" class="label">カナ</label>
            <div class="inputs">
                <input type="text" name="kana" id="kana" value="{{ old('kana') }}">
            </div>
        </div>

        <!-- メールアドレス -->
        <div class="item">
            <label for="mail" class="label">メールアドレス</label>
            <div class="inputs">
                <input type="text" name="mail" id="mail" value="{{ old('mail') }}">
            </div>
        </div>

        <!-- 送信ボタン -->
        <div class="item submit">
            <button type="submit" name="submit">絞り込み</button>
        </div>
        </form>

        <!-- 検索データ表示 -->
        <div class="container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>お名前</th>
                    <th>カナ</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせ時間</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th><a href="{{ route('admin.user_detail' , $user->contact_no) }}">{{ $user->contact_no }}</a></th>
                    <td>{{ $user->name1 . $user->name2 }}</td>
                    <td>{{ $user->kana1 . $user->kana2 }}</td>
                    <td>{{ $user->mail }}</td>
                    <td>{{ $user->created }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
        </div>

        </div>
    </body>
</html>