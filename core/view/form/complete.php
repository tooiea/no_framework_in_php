<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="complete_page">
    <h1><?php echo htmlspecialchars($msgHeader) ?></h1>
    <div class="contents complete">
        <p><?php echo nl2br(htmlspecialchars($msgBody)) ?></p>

        <a href="/form">
            <p class="return_top">戻る</p>
        </a>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>