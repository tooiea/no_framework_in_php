<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="confirm_page">
    <h1>お問合せ内容の確認</h1>

    <!-- 回答内容 -->
    <div class="contents">
        <div class="info">
            <p>以下の内容でよろしければ「送信する」ボタンを押してください。</p>
            <p>修正する場合は「戻る」ボタンを押して入力画面へお戻りください。</p>
        </div>

        <h2>お問い合せ内容</h2>
        <hr>
        <!-- 名前 -->
        <div class="item conf">
            <div class="label">
                <p>お名前</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($this->concatName($values['name1'],$values['name2']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <!-- フリガナ -->
        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($this->concatName($values['kana1'],$values['kana2']), ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>

        <!-- 性別 -->
        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['sex'])) : ?>
                    <p><?php echo htmlspecialchars(FormConstant::SEX_LIST[$values['sex']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 年齢 -->
        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['age'])) : ?>
                    <p><?php echo htmlspecialchars(FormConstant::AGE_LIST[$values['age']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>


        <!-- 血液型 -->
        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['blood_type'])) : ?>
                    <p><?php echo htmlspecialchars(FormConstant::BLOOD_TYPE_LIST[$values['blood_type']], ENT_QUOTES, "UTF-8") . '型' ?></p>
                <?php endif; ?>
            </div>
        </div>


        <!-- 職業 -->
        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['job'])) : ?>
                    <p><?php echo htmlspecialchars(FormConstant::JOB_LIST[$values['job']], ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>
            </div>
        </div>


        <!-- 郵便番号 -->
        <div class="item conf">
            <div class="label">
                <p>郵便番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($this->concatZipNum($values['zip1'],$values['zip2']),ENT_QUOTES, "UTF-8"); ?></p>
            </div>
        </div>


        <!-- 住所 -->
        <div class="item conf">
            <div class="label">
                <p>住所</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['address1']) && isset($values['address2'])) : ?>
                    <p><?php echo htmlspecialchars($this->concatString(FormConstant::PREFUCTURE_LIST[$values['address1']], $values['address2']),ENT_QUOTES, "UTF-8");  ?></p>
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
                    <?php if (isset($values['address3'])) {
                        echo htmlspecialchars($values['address3'], ENT_QUOTES, "UTF-8");
                    } else echo ""; ?>
                </p>
            </div>
        </div>

        <!-- 電話番号 -->
        <div class="item conf">
            <div class="label">
                <p>電話番号</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($this->concatTel($values['tel1'], $values['tel2'], $values['tel3']),ENT_QUOTES, "UTF-8") ?></p>
            </div>
        </div>

        <!-- メールアドレス -->
        <div class="item conf">
            <div class="label">
                <p>メールアドレス</p>
            </div>
            <div class="inputs">
                <p><?php echo htmlspecialchars($values['mail'], ENT_QUOTES, "UTF-8") ?></p>
            </div>
        </div>

        <!-- カテゴリー -->
        <div class="item">
            <div class="label">
                <p>興味のあるカテゴリー</p>
            </div>
            <div class="inputs">
                <?php if (isset($values['category'])) :?>
                <p>
                    <?php foreach ($values['category'] as $key => $vlist) : ?>
                        <?php echo htmlspecialchars(FormConstant::CATEGORY_LIST[$values['category'][$key]], ENT_QUOTES, "UTF-8")  ?>
                        <br>
                    <?php endforeach; ?>
                </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- お問い合わせ内容 -->
        <div class="item">
            <div class="label">
                <p>お問い合わせ内容</p>
            </div>
            <div class="inputs">
                <p><?php echo nl2br(htmlspecialchars($values['info'], ENT_QUOTES, "UTF-8")) ?></p>
            </div>
        </div>

        <!-- 戻るボタン -->
        <div class="btn_group">
            <form action="/form/" method="POST">
                <?php foreach ($values as $key => $value): ?>
                    <?php if ($key === 'category'): ?>
                        <?php foreach ($value as $category) :?>
                            <input type="hidden" name="<?php echo htmlspecialchars($key . '[]', ENT_QUOTES, "UTF-8")?>" value="<?php echo htmlspecialchars($category, ENT_QUOTES, "UTF-8")?>">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <input type="hidden" name="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8")?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES, "UTF-8")?>">
                    <?php endif;?>
                <?php endforeach; ?>
                <button type="submit" name="submit" class="return btn" value="<?php echo FormConstant::SUBMIT_CONFIRM_BACK; ?>">戻る</button>
            </form>

            <!-- 送信ボタン  -->
            <form action="/form/complete/" method="POST">
                <?php foreach ($values as $key => $value): ?>
                    <?php if ($key === 'category'): ?>
                        <?php foreach ($value as $category) :?>
                            <input type="hidden" name="<?php echo htmlspecialchars($key . '[]', ENT_QUOTES, "UTF-8")?>" value="<?php echo htmlspecialchars($category, ENT_QUOTES, "UTF-8")?>">
                        <?php endforeach; ?>
                    <?php else: ?>
                            <input type="hidden" name="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8")?>" value="<?php echo htmlspecialchars($value, ENT_QUOTES, "UTF-8")?>">
                    <?php endif;?>
                <?php endforeach; ?>
                <button type="submit" name="submit" class="next btn" value="<?php echo FormConstant::SUBMIT_COMPLETE; ?>">送信する</button>
            </form>
        </div>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>