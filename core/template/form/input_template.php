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
                <label for="first_name" class="label">お名前：姓<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="first_name" id="first_name" value="<?php if (isset($values['first_name'])) {
                                                                        echo htmlspecialchars($values['first_name'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['first_name']) && "" != $errorMsg['first_name']):?>
                        <p class="error_msg"><?php echo $errorMsg['first_name'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="item">
                <label for="last_name" class="label">お名前：名<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="last_name" id="last_name" value="<?php if (isset($values['last_name'])) {
                                                                        echo htmlspecialchars($values['last_name'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['last_name']) && "" != $errorMsg['last_name']):?>
                        <p class="error_msg"><?php echo $errorMsg['last_name'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="item">
                <label for="first_name_kana" class="label">フリガナ：セイ<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="first_name_kana" id="first_name_kana" value="<?php if (isset($values['first_name_kana'])) {
                                                                        echo htmlspecialchars($values['first_name_kana'], ENT_QUOTES, "UTF-8") ;
                                                                    } ?>">
                    <?php if (isset($errorMsg['first_name_kana']) && "" != $errorMsg['first_name_kana']):?>
                        <p class="error_msg"><?php echo $errorMsg['first_name_kana'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="last_name_kana" class="label">フリガナ：メイ<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="last_name_kana" id="last_name_kana" value="<?php if (isset($values['last_name_kana'])) {
                                                                        echo htmlspecialchars($values['last_name_kana'], ENT_QUOTES, "UTF-8") ;
                                                                    } ?>">
                    <?php if (isset($errorMsg['last_name_kana']) && "" != $errorMsg['last_name_kana']):?>
                        <p class="error_msg"><?php echo $errorMsg['last_name_kana'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="sex_id" class="label">性別<span>*</span></label>
                <div class="inputs">
                    <label>
                    <?php foreach (SEX_LIST as $key => $value) : ?>
                        <input type="radio" name="sex_id" id="sex_id" value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>"<?php if (isset($values['sex_id']) && $key == $values['sex_id']) echo 'checked' ?>><?php echo $value ?>
                    <?php endforeach ?>
                    </label>
                        <?php if (isset($errorMsg['sex_id']) && "" != $errorMsg['sex_id']) :?>
                            <p class="error_msg"><?php echo $errorMsg['sex_id'] ?></p>
                        <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="age_id" class="label">年齢<span>*</span></label>
                <div class="inputs">
                    <select name="age_id" id="age_id" >
                        <option hidden>未選択</option>
                        <?php foreach (AGE_LIST as $key => $value) : ?>
                            <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>" <?php if (isset($values['age_id']) && $key == $values['age_id']) echo 'selected' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errorMsg['age_id']) && "" != $errorMsg['age_id']) :?>
                        <p class="error_msg"><?php echo $errorMsg['age_id'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="blood_type_id" class="label">血液型<span>*</span></label>
                <div class="inputs">
                    <?php foreach (BLOOD_LIST as $key => $value) : ?>
                        <label><input type="radio" name="blood_type_id" id="blood_type_id" value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>" <?php if (isset($values['blood_type_id']) && $key == $values['blood_type_id']) echo 'checked' ?>><?php echo $value ?></label>
                    <?php endforeach ?>
                    <?php if (isset($errorMsg['blood_type_id']) && "" != $errorMsg['blood_type_id']):?>
                        <p class="error_msg"><?php echo $errorMsg['blood_type_id'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="job_id" class="label">職業<span>*</span></label>
                <div class="inputs">
                    <select name="job_id" id="job_id">
                        <option hidden>未選択</option>
                        <?php foreach (JOB_LIST as $key => $value) : ?>
                            <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>"<?php if (isset($values['job_id']) && $key == $values['job_id']) echo 'selected' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errorMsg['job_id']) && "" != $errorMsg['job_id']) :?>
                        <p class="error_msg"><?php echo $errorMsg['job_id'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="zip1" class="label">郵便番号（上）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="zip1" id="zip1" value="<?php if (isset($values['zip1'])) {
                                                                                echo htmlspecialchars($values['zip1'], ENT_QUOTES, "UTF-8");
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
                                                                                echo htmlspecialchars($values['zip2'], ENT_QUOTES, "UTF-8");
                                                                            } ?>">
                    <?php if (isset($errorMsg['zip2']) && "" != $errorMsg['zip2']):?>
                        <p class="error_msg"><?php echo $errorMsg['zip2'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="prefecture_id" class="label">都道府県<span>*</span></label>
                <div class="inputs">
                    <select name="prefecture_id" id="prefecture_id">
                        <option hidden>未選択</option>
                        <?php foreach (PREFUCTURES_LIST as $key => $value) : ?>
                            <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>" <?php if (isset($values['prefecture_id']) && $key == $values['prefecture_id']) echo 'selected' ?>><?php echo $value ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errorMsg['prefecture_id']) && "" != $errorMsg['prefecture_id']):?>
                        <p class="error_msg"><?php echo $errorMsg['prefecture_id'] ?></p>
                    <?php endif;?>
                </div>
            </div class="item">

            <div class="item">
                <label for="address1" class="label">住所<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="address1" id="address1" value="<?php if (isset($values['address1'])) {
                                                                                echo htmlspecialchars($values['address1'], ENT_QUOTES, "UTF-8");
                                                                            } ?>">
                    <?php if (isset($errorMsg['address1']) && "" != $errorMsg['address1']) :?>
                        <p class="error_msg"><?php echo $errorMsg['address1'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="address2" class="label">ビル・マンション名</label>
                <div class="inputs">
                    <input type="text" name="address2" id="address2" value="<?php if (isset($values['address2'])) {
                                                                        echo htmlspecialchars($values['address2'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <?php if (isset($errorMsg['address2']) && "" != $errorMsg['address2']) :?>
                        <p class="error_msg"><?php echo $errorMsg['address2'] ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="tel1" class="label">電話番号<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="tel1" id="tel1" value="<?php if (isset($values['tel1'])) {
                                                                        echo htmlspecialchars($values['tel1'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <input type="text" name="tel2" id="tel2" value="<?php if (isset($values['tel2'])) {
                                                                        echo htmlspecialchars($values['tel2'], ENT_QUOTES, "UTF-8");
                                                                    } ?>">
                    <input type="text" name="tel3" id="tel3" value="<?php if (!empty($values['tel3'])) {
                                                                        echo htmlspecialchars($values['tel3'], ENT_QUOTES, "UTF-8");
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
                                                                        echo htmlspecialchars($values['mail'], ENT_QUOTES, "UTF-8");
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
                                                                            echo htmlspecialchars($values['mail2'], ENT_QUOTES, "UTF-8");
                                                                        } ?>">
                    <?php if (isset($errorMsg['mail2']) && "" != $errorMsg['mail2']):?>
                        <p class="error_msg"><?php echo $errorMsg['mail2']; ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="inquiry_content_ids" class="label">興味のあるカテゴリー<br>(複数選択可）</label>
                <div class="inputs inquiry_content_ids">
                    <?php foreach (CATEGORY_LIST as $key => $value) : ?>
                        <label><input type="checkbox" name="inquiry_content_ids[]" id="inquiry_content_ids" value="<?php echo htmlspecialchars($key, ENT_QUOTES, "UTF-8") ?>" <?php if (isset($values['inquiry_content_ids']) && is_int(array_search($key, $values['inquiry_content_ids']))) echo 'checked'; ?>><?php echo $value ?></label>
                    <?php endforeach ?>
                    <?php if (isset($errorMsg['inquiry_content_ids']) && "" != $errorMsg['inquiry_content_ids']):?>
                        <p class="error_msg"><?php echo $errorMsg['inquiry_content_ids']; ?></p>
                    <?php endif;?>
                </div>
            </div>

            <div class="item">
                <label for="inpuiry_detail" class="label">お問合せ内容<span>*</span></label>
                <div class="inputs">
                    <textarea name="inpuiry_detail" id="inpuiry_detail" cols="50" rows="10"><?php if (isset($values['inpuiry_detail'])) {
                                                                                    echo htmlspecialchars($values['inpuiry_detail'], ENT_QUOTES, "UTF-8");
                                                                                } ?></textarea>
                    <?php if (isset($errorMsg['inpuiry_detail']) && "" != $errorMsg['inpuiry_detail']):?>
                        <p class="error_msg"><?php echo $errorMsg['inpuiry_detail']; ?></p>
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