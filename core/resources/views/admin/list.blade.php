<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="/css/style.css">
</head>
    <body class="admin_list_page">

        <h1>■お問い合わせ一覧</h1>

        <form action="{{ route('admin.user_list') }}" method="get">

            <div class="item">
                <label for="name" class="label">お名前</label>
                <div class="inputs">
                    <input type="text" name="name" id="name" value="@if (!empty(old('name'))){{ old('name') }}@elseif(!empty($query['name'])){{ $query['name'] }}@endif">
                    @error('name')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="kana" class="label">カナ</label>
                <div class="inputs">
                    <input type="text" name="kana" id="kana" value="@if (!empty(old('kana'))){{ old('kana') }}@elseif(!empty($query['kana'])){{ $query['kana'] }}@endif">
                    @error('kana')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- メールアドレス -->
            <div class="item">
                <label for="mail" class="label">メールアドレス</label>
                <div class="inputs">
                    <input type="text" name="mail" id="mail" value="@if (!empty(old('mail'))){{ old('mail') }}@elseif(!empty($query['mail'])){{ $query['mail'] }}@endif">
                    @error('mail')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- 送信ボタン -->
            <div class="item submit">
                <button type="submit" name="submit">絞り込み</button>
            </div>
        </form>

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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->kana }}</td>
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