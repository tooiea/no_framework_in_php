<?php
require_once(dirname(__FILE__).'/../../controller/form/ConfirmController.php'); //Confirmcontrollerの読み込み

$confirmController = new ConfirmController();
$values = $confirmController->index();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="confirm_page">
    <h1>お問合せ内容の確認</h1>
    <div class="contents">
        <div class="inpuiry_detail">
            <p>以下の内容でよろしければ「送信する」ボタンを押してください。</p>
            <p>修正する場合は「戻る」ボタンを押して入力画面へお戻りください。</p>
        </div>

        <h2>お問い合せ内容</h2>
        <hr>

        <div class="item conf">
            <div class="label">
                <p>お名前</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($confirmController->concatenationName($values['first_name'],$values['last_name']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($confirmController->concatenationName($values['first_name_kana'],$values['last_name_kana']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['sex_id'])) : ?>
                    <p><?php echo htmlspecialchars(SEX_LIST[$values['sex_id']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['age_id'])) : ?>
                    <p><?php echo htmlspecialchars(AGE_LIST[$values['age_id']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['blood_type_id'])) : ?>
                    <p><?php echo htmlspecialchars(BLOOD_LIST[$values['blood_type_id']], ENT_QUOTES, "UTF-8") . '型' ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['job_id'])) : ?>
                    <p><?php echo htmlspecialchars(JOB_LIST[$values['job_id']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>郵便番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($confirmController->concatenationZip($values['zip1'], $values['zip2']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>住所</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['prefecture_id']) && isset($values['address1'])) : ?>
                    <p><?php echo htmlspecialchars($confirmController->concatenationAddress(PREFUCTURES_LIST[$values['prefecture_id']], $values['address1']), ENT_QUOTES, "UTF-8");  ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>ビル・マンション名</p>
            </div>
            <div class="inputs">
                <p>
                    <?php if (isset($values['address2'])) {
                        echo htmlspecialchars($values['address2'], ENT_QUOTES, "UTF-8");
                    } else echo ""; ?>
                </p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>電話番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($confirmController->concatenationTelnum($values['tel1'],$values['tel2'],$values['tel3']), ENT_QUOTES, "UTF-8") ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>メールアドレス</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($values['mail'], ENT_QUOTES, "UTF-8") ?></p>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>興味のあるカテゴリー</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['inquiry_content_ids'])) :?>
                <?php foreach ($values['inquiry_content_ids'] as $key => $vlist) : ?>
                    <p><?php echo htmlspecialchars(CATEGORY_LIST[$values['inquiry_content_ids'][$key]], ENT_QUOTES, "UTF-8")  ?></p>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>お問い合わせ内容</p>
            </div>
            <div class="inputs">
                <p><?php echo nl2br(htmlspecialchars($values['inpuiry_detail'], ENT_QUOTES, "UTF-8")) ?></p>
            </div>
        </div>

        <div class="btn_group">
            <form action="/form/" method="POST">
                <button type="submit" name="submit" class="return btn" value="<?php echo CHECK_SUBMIT_CONFIRM_BACK; ?>">戻る</button>
            </form>

            <form action="/form/complete/" method="POST">
                <button type="submit" name="submit" class="next btn" value="<?php echo CHECK_SUBMIT_CONFIRM_NEXT; ?>">送信する</button>
            </form>
        </div>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>