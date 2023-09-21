<?php
require_once(dirname(__FILE__).'/../../controller/form/CompleteController.php');    //CompleteControllerの読み込み

//インスタンス化し、メール送信処理を実行
$completeController = new CompleteController();
$msg = $completeController->index();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="complete_page">
    <h1><?php echo htmlspecialchars($msg[0]) ?></h1>
    <div class="contents complete">
        <p><?php echo htmlspecialchars(nl2br($msg[1])) ?></p>
        <a href="/form">
            <p class="return_top">戻る</p>
        </a>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>