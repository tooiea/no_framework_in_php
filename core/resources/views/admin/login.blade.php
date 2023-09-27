<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>
    <body class="admin_login_page">
        <form action='{{ route('admin.index') }}' method="post">
            @csrf
            <div class="item">
                <label for="login_id" class="label">ログインID</label>
                <div class="inputs">
                    <input type="text" name="login_id" id="login_id">
                    @error ('login_id')
                    <p class="error_msg"{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="item pass">
                <label for="password" class="label">パスワード</label>
                <div class="inputs">
                    <input type="password" name="password" id="password">
                    @error ('password')
                    <p class="error_msg"{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 送信ボタン -->
            <div class="item submit">
                <button type="submit" name="submit">ログイン</button>
            </div>
        </form>

        <!-- エラー発生時 -->
        <div class="item">
            <label for="login_id" class="label">{{ session('admin_error.header') }}</label>
            <div class="inputs">
                <p class="error_msg">{{ session('admin_error.body') }}</p>
            </div>
        </div>
    </body>
</html>