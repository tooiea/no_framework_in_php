<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="complete_page">
    <h1>{{ session('complete_header') }}</h1>
    <div class="contents complete">
        <p>{!! session('complete_body') !!}</p>
        <a href="/form">
            <p class="return_top">戻る</p>
        </a>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>