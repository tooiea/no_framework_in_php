<?php
require_once(dirname(__FILE__) . '/../../controller/form/InputController.php');

$inputController = new InputController();
$inputController->index();
$values = $inputController->getValues();
$errorMsg = $inputController->getErrorMsg();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="form_page">
    <div class="contents">
        <h1>お問合せフォーム</h1>

        <form action='/form/' method="POST">
            <div class="item">
                <label for="name1" class="label">お名前：姓<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="name1" id="name1" value="<?php if (isset($values['name1'])) {
                                                                        echo htmlspecialchars($values['name1'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['name1']) && "" != $errorMsg['name1']):?>
                        <p class="error_msg"><?php echo $errorMsg['name1'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="item">
                <label for="name2" class="label">お名前：名<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="name2" id="name2" value="<?php if (isset($values['name2'])) {
                                                                        echo htmlspecialchars($values['name2'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['name2']) && "" != $errorMsg['name2']):?>
                        <p class="error_msg"><?php echo $errorMsg['name2'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="item">
                <label for="kana1" class="label">フリガナ：セイ<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="kana1" id="kana1" value="<?php if (isset($values['kana1'])) {
                                                                        echo htmlspecialchars($values['kana1'], ENT_QUOTES, "UTF-8") ;
                                                                    } ?>">
                    <?php if (isset($errorMsg['kana1']) && "" != $errorMsg['kana1']):?>
                        <p class="error_msg"><?php echo $errorMsg['kana1'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="kana2" class="label">フリガナ：メイ<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="kana2" id="kana2" value="<?php if (isset($values['kana2'])) {
                                                                        echo htmlspecialchars($values['kana2'], ENT_QUOTES, "UTF-8") ;
                                                                    } ?>">
                    <?php if (isset($errorMsg['kana2']) && "" != $errorMsg['kana2']):?>
                        <p class="error_msg"><?php echo $errorMsg['kana2'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="sex" class="label">性別<span>*</span></label>
                <div class="inputs">
                    <?php foreach (SEX_LIST as $key => $value) : ?>
                        <label><input type="radio" name="sex" id="sex" value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>"<?php if (isset($values['sex']) && $key == $values['sex']) echo 'checked' ?>><?php echo $value ?>
                    <?php endforeach ?>
                        </label>
                    <?php if (isset($errorMsg['sex']) && "" != $errorMsg['sex']) :?>
                        <p class="error_msg"><?php echo $errorMsg['sex'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="age" class="label">年齢<span>*</span></label>
                <div class="inputs">
                    <select name="age" id="age" >
                        <option hidden>未選択</option>
                        <?php foreach (AGE_LIST as $key => $value) : ?>
                            <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>" <?php if (isset($values['age']) && $key == $values['age']) echo 'selected' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errorMsg['age']) && "" != $errorMsg['age']) :?>
                        <p class="error_msg"><?php echo $errorMsg['age'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="blood_type" class="label">血液型<span>*</span></label>
                <div class="inputs">
                    <?php foreach (BLOOD_LIST as $key => $value) : ?>
                        <label><input type="radio" name="blood_type" id="blood_type" value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>" <?php if (isset($values['blood_type']) && $key == $values['blood_type']) echo 'checked' ?>><?php echo htmlspecialchars($value, ENT_QUOTES, "UTF-8") ?></label>
                    <?php endforeach ?>
                    <?php if (isset($errorMsg['blood_type']) && "" != $errorMsg['blood_type']): ?>
                        <p class="error_msg"><?php echo $errorMsg['blood_type'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="job" class="label">職業<span>*</span></label>
                <div class="inputs">
                    <select name="job" id="job">
                        <option hidden>未選択</option>
                        <?php foreach (JOB_LIST as $key => $value) : ?>
                            <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>"<?php if (isset($values['job']) && $key == $values['job']) echo 'selected' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errorMsg['job']) && "" != $errorMsg['job']) :?>
                        <p class="error_msg"><?php echo $errorMsg['job'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="zip1" class="label">郵便番号（上）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="zip1" id="zip1" value="<?php if (isset($values['zip1'])) {
                                                                                echo htmlspecialchars($values['zip1'],ENT_QUOTES,"UTF-8");
                                                                            } ?>">
                    <?php if (isset($errorMsg['zip1']) && "" != $errorMsg['zip1']):?>
                        <p class="error_msg"><?php echo $errorMsg['zip1'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="zip2" class="label">郵便番号（下）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="zip2" id="zip2" value="<?php if (isset($values['zip2'])) {
                                                                                echo htmlspecialchars($values['zip2'],ENT_QUOTES,"UTF-8");
                                                                            } ?>">
                    <?php if (isset($errorMsg['zip2']) && "" != $errorMsg['zip2']):?>
                        <p class="error_msg"><?php echo $errorMsg['zip2'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="address1" class="label">都道府県<span>*</span></label>
                <div class="inputs">
                    <select name="address1" id="address1">
                        <option hidden>未選択</option>
                        <?php foreach (PREFUCTURES_LIST as $key => $value) : ?>
                            <option value="<?php echo htmlspecialchars($key,ENT_QUOTES,"UTF-8") ?>" <?php if (isset($values['address1']) && $key == $values['address1']) echo 'selected' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errorMsg['address1']) && "" != $errorMsg['address1']):?>
                        <p class="error_msg"><?php echo $errorMsg['address1'] ?></p>
                    <?php endif;?>
                </div>
            </div class="item">

            <div class="item">
                <label for="address2" class="label">住所<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="address2" id="address2" value="<?php if (isset($values['address2'])) {
                                                                                echo htmlspecialchars($values['address2'],ENT_QUOTES,"UTF-8");
                                                                            } ?>">
                    <?php if (isset($errorMsg['address2']) && "" != $errorMsg['address2']) :?>
                        <p class="error_msg"><?php echo $errorMsg['address2'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="address3" class="label">ビル・マンション名</label>
                <div class="inputs">
                    <input type="text" name="address3" id="address3" value="<?php if (isset($values['address3'])) {
                                                                        echo htmlspecialchars($values['address3'],ENT_QUOTES,"UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['address3']) && "" != $errorMsg['address3']) :?>
                        <p class="error_msg"><?php echo $errorMsg['address3'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="tel1" class="label">電話番号<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="tel1" id="tel1" value="<?php if (isset($values['tel1'])) {
                                                                        echo htmlspecialchars($values['tel1'],ENT_QUOTES,"UTF-8");
                                                                    } ?>">
                    <input type="text" name="tel2" id="tel2" value="<?php if (isset($values['tel2'])) {
                                                                        echo htmlspecialchars($values['tel2'],ENT_QUOTES,"UTF-8");
                                                                    } ?>">
                    <input type="text" name="tel3" id="tel3" value="<?php if (!empty($values['tel3'])) {
                                                                        echo htmlspecialchars($values['tel3'],ENT_QUOTES,"UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['tel1']) && "" != $errorMsg['tel1']) :?>
                        <p class="error_msg"><?php echo $errorMsg['tel1'] . "<br>"?></p>
                    <?php endif;?>
                    <?php if (isset($errorMsg['tel2']) && "" != $errorMsg['tel2']) :?>
                        <p class="error_msg"><?php echo $errorMsg['tel2'] . "<br>"?></p>
                    <?php endif;?>
                    <?php if (isset($errorMsg['tel3']) && "" != $errorMsg['tel3']) :?>
                        <p class="error_msg"><?php echo $errorMsg['tel3'] . "<br>"?></p>
                    <?php endif;?>

                </div>
            </div>

            <div class="item">
                <label for="mail" class="label">メールアドレス<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="mail" id="mail" value="<?php if (isset($values['mail'])) {
                                                                        echo htmlspecialchars($values['mail'],ENT_QUOTES,"UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['mail']) && "" != $errorMsg['mail']):?>
                        <p class="error_msg"><?php echo $errorMsg['mail']; ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="mail2" class="label">メールアドレス<br>（確認用）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="mail2" id="mail2" value="<?php if (isset($values['mail2'])) {
                                                                            echo htmlspecialchars($values['mail2'],ENT_QUOTES,"UTF-8");
                                                                        } ?>">
                    <?php if (isset($errorMsg['mail2']) && "" != $errorMsg['mail2']):?>
                        <p class="error_msg"><?php echo $errorMsg['mail2']; ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="category" class="label">興味のあるカテゴリー<br>(複数選択可）</label>
                <div class="inputs category">
                    <?php foreach (CATEGORY_LIST as $key => $value) : ?>
                        <label><input type="checkbox" name="category[]" id="category" value="<?php echo htmlspecialchars($key,ENT_QUOTES,"UTF-8") ?>" <?php if (isset($values['category']) && is_int(array_search($key, $values['category']))) echo 'checked'; ?>><?php echo $value ?></label>
                    <?php endforeach ?>
                    <?php if (isset($errorMsg['category']) && "" != $errorMsg['category']):?>
                        <p class="error_msg"><?php echo $errorMsg['category']; ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="info" class="label">お問合せ内容<span>*</span></label>
                <div class="inputs">
                    <textarea name="info" id="info" cols="50" rows="10"><?php if (isset($values['info'])) {
                                                                                    echo htmlspecialchars($values['info'],ENT_QUOTES,"UTF-8");
                                                                                } ?></textarea>
                    </p>
                    <?php if (isset($errorMsg['info']) && "" != $errorMsg['info']):?>
                        <p class="error_msg"><?php echo $errorMsg['info']; ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item submit">
                <button type="submit" name="submit" value="<?php echo CHECK_SUBMIT_FORM; ?>">入力内容を確認する</button>
            </div>
        </form>
    </div>
</body>

</html>