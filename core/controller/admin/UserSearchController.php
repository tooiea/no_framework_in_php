<?php

require_once(dirname(__FILE__) . '/../../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/../../controller/admin/BaseAdminController.php');
require_once(dirname(__FILE__) . '/../../model/Administrator.php');

class UserSearchController extends BaseAdminController {

    public function list()
    {
        $this->isLoggedin();

        // ログイン認証されていない
        if (!isset($_SESSION['login_id'])) {
            $_SESSION = [];
            header('Location: /admin/login');
            exit;
        }

        try {
            //管理者用テーブルへアクセス
            $administrators = new Administrator();
            $isUser = $administrators->existUser($_SESSION['login_id']);

            // 存在しているユーザかチェック
            if (!$isUser) {
                header('Location: /admin/login');
                exit;
            }

            // クエリパラメータを取得しセット
            parse_str(urldecode($_SERVER['QUERY_STRING']), $result['queryValues']);

            // 表示ページ取得
            $result['page'] = $this->checkPage($result['queryValues']);

            // 不要なキー削除とカナの変換
            $result['queryValues'] = $this->convertKana($this->removeKey($result['queryValues']));

            // contact_noのダブりを防ぐため一旦リセット
            if (isset($_GET['submit']) && CHECK_SUBMIT_CONFIRM_BACK === $_GET['submit'] && isset($result['queryValues']['contact_no'])) {
                unset($result['queryValues']['contact_no']);
            }

            // 検索件数取得
            $contact = new Contact();
            $result['countData'] = $contact->checkNumberOfData($result['queryValues']);

            // 検索した条件からデータなし
            if (empty($result['countData'])) {
                $result['msg'] = NOT_FOUND_DATA;
            } else {
                $result['displayData'] = $contact->select($result['page'], $result['queryValues']);
            }

        } catch (PDOEXception $pdo) {
            $result['msg'] = SERVER_ERROR_COMMENT;
        } catch (Exception $ex) { // PDO以外の例外処理
            $result['msg'] = SERVER_ERROR_COMMENT;
        }
        return $result;
    }

    /**
     * 検索時のSQL文のWHERE条件を選択
     *
     * @param  array $values 入力値
     * @return string 入力値から選択されたSQL文
     */
    public function checkSelectContents(array $values)
    {
        $sqlStr = '';
        foreach ($values as $key => $value) {
            if ('name' === $key && !empty($values['name'])) {   //nameに入力がある場合
                $sqlStr .= SELECT_CONTACT_LIST_NAME;
            }
            if ('kana' === $key && !empty($values['kana'])) {   //kanaに入力がある場合
                if (!empty($sqlStr)) {
                    $sqlStr .= ' AND';
                }
                $sqlStr .= SELECT_CONTACT_LIST_KANA;
            }
            if ('mail' === $key && !empty($values['mail'])) {   //mailに入力がある場合
                if (!empty($sqlStr)) {
                    $sqlStr .= ' AND';
                }
                $sqlStr .= SELECT_CONTACT_LIST_MAIL;
            }
        }
        return $sqlStr;
    }

    /**
     * 表示したいページ数に対して、SQL文のLIMIT,OFFSET条件を選択
     *
     * @param  integer $page
     * @return string LIMIT、OFFSETのSQL文を返す
     */
    private function checkOffsetSql(int $page)
    {
        $offset = array();
        $offset['offsetValue'] = ($page -1 ) * DISPLAY_IN_PAGE;

        if ($offset['offsetValue'] !== 0) {
            $offset['sql'] = IS_OFFSET;
        } else {
            $offset['sql'] = NO_OFFSET;
        }
        return $offset;
    }
}