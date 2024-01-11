<?php

require_once dirname(__FILE__) . '/../../controller/admin/LoginController.php';

$loginController = new LoginController(new Redirector(), new ServiceModelContainer);
$loginController->index();
$errorMsg = $loginController->getErrorMsg();
$msg = $loginController->getMessage();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="admin_login_page">
    <?php if (empty($msg)) : ?>
        <form action='/admin/login' method="post">
            <!-- ログインID -->
            <div class="item">
                <label for="login_id" class="label">ログインID</label>
                <div class="inputs">
                    <input type="text" name="login_id" id="login_id">
                    <?php if (isset($errorMsg['login_id']) && '' != $errorMsg['login_id']) : ?>
                        <p class="error_msg"><?php echo $errorMsg['login_id'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- パスワード -->
            <div class="item pass">
                <label for="password" class="label">パスワード</label>
                <div class="inputs">
                    <input type="password" name="password" id="password">
                    <?php if (isset($errorMsg['password']) && '' != $errorMsg['password']) : ?>
                        <p class="error_msg"><?php echo $errorMsg['password'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 送信ボタン -->
            <div class="item submit">
                <button type="submit" name="submit" value="<?php echo CHECK_ADMIN_LOGIN; ?>">ログイン</button>
            </div>
        </form>

        <!-- エラー発生時 -->
    <?php else : ?>
        <div class="item">
            <label for="login_id" class="label"><?php echo htmlspecialchars($msg[0]) ?></label>
            <div class="inputs">
                <p class="error_msg"><?php echo htmlspecialchars($msg[1]) ?></p>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>