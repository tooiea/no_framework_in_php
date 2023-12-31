<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/src/css/style.css">
</head>

<body class="admin_detail_page">
    <h1>お問い合わせ内容</h1>

    <!-- 回答内容 -->
    <div class="contents">

        <h2>お問い合せ内容</h2>
        <hr>

        <?php if (empty($result['msg'])) :?>
        <!-- お問い合わせNo -->
        <div class="item conf">
            <div class="label">
                <p>お問い合わせNO</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['contact_no'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <!-- 名前 -->
        <div class="item conf">
            <div class="label">
                <p>お名前</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['name1'] . '　' . $result['displayValues']['name2'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <!-- フリガナ -->
        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['kana1'] . '　' . $result['displayValues']['kana2'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <!-- 性別 -->
        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['sex'])) : ?>
                    <p><?php echo htmlspecialchars(SEX_LIST[$result['displayValues']['sex']], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 年齢 -->
        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['age'])) : ?>
                    <p><?php echo htmlspecialchars(AGE_LIST[$result['displayValues']['age']], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 血液型 -->
        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['blood_type'])) : ?>
                    <p><?php echo htmlspecialchars(BLOOD_LIST[$result['displayValues']['blood_type']], ENT_QUOTES, 'UTF-8') . '型' ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 職業 -->
        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['job'])) : ?>
                    <p><?php echo htmlspecialchars(JOB_LIST[$result['displayValues']['job']], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 郵便番号 -->
        <div class="item conf">
            <div class="label">
                <p>郵便番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['zip1'] . '-' . $result['displayValues']['zip2'],ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <!-- 住所 -->
        <div class="item conf">
            <div class="label">
                <p>住所</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['address1']) && isset($result['displayValues']['address2'])) : ?>
                    <p><?php echo htmlspecialchars(PREFUCTURES_LIST[(int)$result['displayValues']['address1']] . $result['displayValues']['address2'],ENT_QUOTES, 'UTF-8');  ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ビル・マンション名 -->
        <div class="item conf">
            <div class="label">
                <p>ビル・マンション名</p>
            </div>
            <div class="inputs">
                <p>
                    <?php if (isset($result['displayValues']['address3'])) {
                        echo htmlspecialchars($result['displayValues']['address3'], ENT_QUOTES, 'UTF-8');
                    } else echo ''; ?>
                </p>
            </div>
        </div>

        <!-- 電話番号 -->
        <div class="item conf">
            <div class="label">
                <p>電話番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['tel'],ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <!-- メールアドレス -->
        <div class="item conf">
            <div class="label">
                <p>メールアドレス</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['mail'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <!-- カテゴリー -->
        <div class="item">
            <div class="label">
                <p>興味のあるカテゴリー</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['category'])) :?>
                <?php foreach ($result['displayValues']['category'] as $value):?>
                    <p><?php echo nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'))  ?></p>
                <?php endforeach;?>
                <?php endif; ?>
            </div>
        </div>

        <!-- お問い合わせ内容 -->
        <div class="item">
            <div class="label">
                <p>お問い合わせ内容</p>
            </div>
            <div class="inputs">
                <p><?php echo nl2br(htmlspecialchars($result['displayValues']['info'], ENT_QUOTES, 'UTF-8')) ?></p>
            </div>
        </div>

        <!-- お問い合わせ時期 -->
        <div class="item">
            <div class="label">
                <p>お問い合わせ時期</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars(date('Y年n月j日', strtotime($result['displayValues']['created'])), ENT_QUOTES, 'UTF-8') . '<br>' .
                htmlspecialchars(date('H時i分s秒', strtotime($result['displayValues']['created'])), ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <!-- 戻るボタン -->
        <div class="btn_group">
            <form action='/admin/list' method="GET">
                <button type="submit" name="submit" class="return btn" value="<?php echo CHECK_SUBMIT_CONFIRM_BACK; ?>">戻る</button>
            <?php if (!empty($result['queryValues'])):?>
                <?php foreach ($result['queryValues'] as $key => $value):?>
                    <input type="hidden" name="<?php echo $key?>" value="<?php echo urlencode($value)?>">
                <?php endforeach;?>
            <?php endif;?>
            </form>
        </div>

        <!-- エラーメッセージがあった場合 -->
        <?php else:?>
            <p class="errorMsg"><?php echo htmlspecialchars($result['msg'], ENT_QUOTES, 'UTF-8');?></p>
            <div class="errorMsg submit">
                <a href="/admin/login">ログイン画面へ戻る</a>
            </div>
        <?php endif;?>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>