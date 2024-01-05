<?php
require_once(dirname(__FILE__).'/../../controller/admin/ListController.php');
require_once(dirname(__FILE__).'/../../const/common_const.php');

$listController = new ListController(new Redirector());
$result = $listController->index(); //現在のページを渡す
$maxPage = (int)ceil($result['countData'] / DISPLAY_IN_PAGE);    //トータルページ数
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>
    <body class="admin_list_page">

        <h1>■お問い合わせ一覧</h1>

        <form action='/admin/list' method="get">

        <!-- お名前 -->
        <div class="item">
            <label for="name" class="label">お名前</label>
            <div class="inputs">
                <input type="text" name="name" id="name" value="<?php if (!empty($result['queryValues']['name'])) {
                                                                    echo htmlspecialchars($result['queryValues']['name'],ENT_QUOTES,"UTF-8");
                                                                }?>">
            </div>
        </div>

        <!-- カナ -->
        <div class="item">
            <label for="kana" class="label">カナ</label>
            <div class="inputs">
                <input type="text" name="kana" id="kana" value="<?php if (!empty($result['queryValues']['kana'])) {
                                                                    echo htmlspecialchars($result['queryValues']['kana'],ENT_QUOTES,"UTF-8");
                                                                }?>">
            </div>
        </div>

        <!-- メールアドレス -->
        <div class="item">
            <label for="mail" class="label">メールアドレス</label>
            <div class="inputs">
                <input type="text" name="mail" id="mail" value="<?php if (!empty($result['queryValues']['mail'])) {
                                                                    echo htmlspecialchars($result['queryValues']['mail'],ENT_QUOTES,"UTF-8");
                                                                }?>">
            </div>
        </div>

        <!-- 送信ボタン -->
        <div class="item submit">
            <button type="submit" name="submit" value="<?php echo SEARCH_CONTACT_LIST; ?>">絞り込み</button>
        </div>
        </form>

        <?php if (empty($result['msg'])):?>
        <!-- 検索データ表示 -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>お名前</th>
                    <th>カナ</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせ時間</th>
                </tr>
            </thead>
            <?php foreach($result['displayData'] as $key => $value):?>
            <tbody>
                <tr>
                    <th><?php echo '<a href="/admin/detail?contact_no=' . $value['contact_no']  . '&' . http_build_query($result['queryValues'], $encoding_type = PHP_QUERY_RFC1738) .'">'. htmlspecialchars($value['contact_no'],ENT_QUOTES,"UTF-8") . '</a> '; ?></th>
                    <td><?php echo htmlspecialchars($value['name1']. ' ' . $value['name2'], ENT_QUOTES,"UTF-8") ?></td>
                    <td><?php echo htmlspecialchars($value['kana1']. ' ' . $value['kana2'], ENT_QUOTES,"UTF-8") ?></td>
                    <td><?php echo '<a href="mailto:' . $value['mail'] . '">' . htmlspecialchars($value['mail'], ENT_QUOTES,"UTF-8") . '</a>'; ?></td>
                    <td><?php echo htmlspecialchars($value['created'], ENT_QUOTES,"UTF-8")?></td>
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>

        <!-- ページ数表示 -->
        <div class="page">
        <?php
            for ($i = 1; $i <= $maxPage; $i++) {
                if (1 === $maxPage) {
                    echo htmlspecialchars($result['page'],ENT_QUOTES,"UTF-8");
                } else {
                    if ($i === $result['page']) { //表示ページ
                        if ($result['page'] === $maxPage) {
                            echo htmlspecialchars($result['page'],ENT_QUOTES,"UTF-8");
                        } else {
                            echo htmlspecialchars($result['page'],ENT_QUOTES,"UTF-8") . ' | ';
                        }
                    } elseif ($i === $maxPage) {   //最後のページ
                        if (isset($_GET) || !empty($$result['queryValues'])) {
                            if (isset($result['queryValues']['page_id'])) {  //page_idがある場合、ページを更新
                                $result['queryValues']['page_id'] = $i;
                                echo '<a href="/admin/list?'. http_build_query($result['queryValues'], $encoding_type = PHP_QUERY_RFC1738) .'">'. htmlspecialchars($i, ENT_QUOTES, "UTF-8") . '</a> ';
                            } else {
                                echo '<a href="/admin/list?page_id='. $i . '&' . http_build_query($result['queryValues'], $encoding_type = PHP_QUERY_RFC1738) . '">' . htmlspecialchars($i,ENT_QUOTES,"UTF-8") . '</a> ';
                            }
                        }

                    } else {    //その他
                        if (isset($_GET) || !empty($result['queryValues']) || count(array_filter($result['queryValues'])) !== 0) {
                            if (isset($result['queryValues']['page_id'])) {  //page_idがある場合、ページを更新
                                $result['queryValues']['page_id'] = $i;
                                echo '<a href="/admin/list?'. http_build_query($result['queryValues'],$encoding_type = PHP_QUERY_RFC1738) .'">'. htmlspecialchars($i, ENT_QUOTES, "UTF-8") . '</a> '. ' | ';
                            } else {
                                echo '<a href="/admin/list?page_id='. $i . '&' . http_build_query($result['queryValues'],$encoding_type = PHP_QUERY_RFC1738) . '">' . htmlspecialchars($i, ENT_QUOTES, "UTF-8") . '</a> '. ' | ';
                            }
                        }
                    }
                }
            }
        ?>
        <?php else:?>
            <p><?php echo htmlspecialchars($result['msg'],ENT_QUOTES,"UTF-8");?></p>
        <?php endif;?>
        </div>
    </body>
</html>