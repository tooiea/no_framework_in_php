<?php

require_once dirname(__FILE__) . '/../../controller/form/CompleteController.php';

//インスタンス化し、メール送信処理を実行
$completeController = new CompleteController(new Redirector(), new ServiceModelContainer());
$msg = $completeController->index();
?>

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
