<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="complete_page">
    <h1><?php echo htmlspecialchars($msg['header']) ?></h1>
    <div class="contents complete">
        <p><?php echo nl2br(htmlspecialchars($msg['body'])) ?></p>
        <a href="/form">
            <p class="return_top">戻る</p>
        </a>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>