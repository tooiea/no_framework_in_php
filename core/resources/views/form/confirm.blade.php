<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="confirm_page">
    <h1>お問合せ内容の確認</h1>
    <div class="contents">
        <div class="info">
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
                <p><?php echo htmlspecialchars($confirmController->concatenationName($values['name1'],$values['name2']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($confirmController->concatenationName($values['kana1'],$values['kana2']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['sex'])) : ?>
                    <p><?php echo htmlspecialchars(SEX_LIST[$values['sex']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['age'])) : ?>
                    <p><?php echo htmlspecialchars(AGE_LIST[$values['age']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['blood_type'])) : ?>
                    <p><?php echo htmlspecialchars(BLOOD_LIST[$values['blood_type']], ENT_QUOTES, "UTF-8") . '型' ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['job'])) : ?>
                    <p><?php echo htmlspecialchars(JOB_LIST[$values['job']], ENT_QUOTES, "UTF-8") ?></p>
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
                <?php if (isset($values['address1']) && isset($values['address2'])) : ?>
                    <p><?php echo htmlspecialchars($confirmController->concatenationAddress(PREFUCTURES_LIST[$values['address1']], $values['address2']), ENT_QUOTES, "UTF-8");  ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>ビル・マンション名</p>
            </div>
            <div class="inputs">
                <p>
                    <?php if (isset($values['address3'])) {
                        echo htmlspecialchars($values['address3'], ENT_QUOTES, "UTF-8");
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
                <?php if (isset($values['category'])) :?>
                <?php foreach ($values['category'] as $key => $vlist) : ?>
                    <p><?php echo htmlspecialchars(CATEGORY_LIST[$values['category'][$key]], ENT_QUOTES, "UTF-8")  ?></p>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>お問い合わせ内容</p>
            </div>
            <div class="inputs">
                <p><?php echo nl2br(htmlspecialchars($values['info'], ENT_QUOTES, "UTF-8")) ?></p>
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