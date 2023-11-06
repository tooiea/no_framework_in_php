<?php
require_once(dirname(__FILE__).'/../../const/common_const.php');
require_once(dirname(__FILE__).'/../../controller/admin/DetailController.php');
$detailController = new DetailController();
$result = $detailController->index();

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="admin_detail_page">
    <h1>お問い合わせ内容</h1>

    <!-- 回答内容 -->
    <div class="contents">

        <h2>お問い合せ内容</h2>
        <hr>

        <?php if (empty($result['msg'])) :?>
        <div class="item conf">
            <div class="label">
                <p>お問い合わせNO</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['contact_no'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>お名前</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['first_name'] . '　' . $result['displayValues']['last_name'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['first_name_kana'] . '　' . $result['displayValues']['last_name_kana'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['sex_id'])) : ?>
                    <p><?php echo htmlspecialchars(SEX_LIST[$result['displayValues']['sex_id']], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['age_id'])) : ?>
                    <p><?php echo htmlspecialchars(AGE_LIST[$result['displayValues']['age_id']], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['blood_type_id'])) : ?>
                    <p><?php echo htmlspecialchars(BLOOD_LIST[$result['displayValues']['blood_type_id']], ENT_QUOTES, 'UTF-8') . '型' ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['job_id'])) : ?>
                    <p><?php echo htmlspecialchars(JOB_LIST[$result['displayValues']['job_id']], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>郵便番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['zip'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>住所</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['prefecture_id']) && isset($result['displayValues']['address2'])) : ?>
                    <p><?php echo htmlspecialchars(PREFUCTURES_LIST[(int)$result['displayValues']['prefecture_id']] . $result['displayValues']['address2'],ENT_QUOTES, 'UTF-8');  ?></p>
                <?php endif; ?>
            </div>
        </div>

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

        <div class="item conf">
            <div class="label">
                <p>電話番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['tel'],ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>メールアドレス</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($result['displayValues']['mail'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>興味のあるカテゴリー</p>
            </div>
            <div class="inputs">
                <?php if (isset($result['displayValues']['inquiry_content_ids'])) :?>
                <?php foreach ($result['displayValues']['inquiry_content_ids'] as $value):?>
                    <p><?php echo nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'))  ?></p>
                <?php endforeach;?>
                <?php endif; ?>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>お問い合わせ内容</p>
            </div>
            <div class="inputs">
                <p><?php echo nl2br(htmlspecialchars($result['displayValues']['inpuiry_detail'], ENT_QUOTES, 'UTF-8')) ?></p>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>お問い合わせ時期</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars(date('Y年n月j日', strtotime($result['displayValues']['created_date'])), ENT_QUOTES, 'UTF-8') . '<br>' .
                htmlspecialchars(date('H時i分s秒', strtotime($result['displayValues']['created_date'])), ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>

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