<?php //登録用
require_once(dirname(__FILE__).'/../../const/sql.php');
require_once(dirname(__FILE__).'/../../const/message.php');
require_once(dirname(__FILE__).'/../../model/Contact.php');
require_once(dirname(__FILE__).'/../../model/Administrator.php');
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');

class ListController extends Controller {

    /**
     * ユーザ一覧取得、検索クエリが入力されたら条件にあったユーザを取得
     *
     * @return void
     */
    public function index()
    {
        $result = [];  //テンプレートへ返す配列変数

        //セッション存在チェック
        if (!isset($_SESSION['login_id'])) {
            $_SESSION = [];
            header('Location: /admin/login');
            exit;
        }

        try {
            //管理者用テーブルへアクセス
            $administrators = new Administrator(DB_ACCESS_INFO, USER_NAME, PASSWORD, [PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING]);
            $isUser = $administrators->checkUser($_SESSION['login_id']);

            //存在しているユーザかチェック
            if (!$isUser) {
                header('Location: /admin/login');
                exit;
            } else {
                //クエリパラメータを取得しセット
                parse_str(urldecode($_SERVER['QUERY_STRING']), $result['queryValues']);

                //表示ページ取得
                $result['page'] = $this->checkPage($result['queryValues']);

                //不要なキー削除とカナの変換
                $result['queryValues'] = $this->convertKana($this->removeKey($result['queryValues']));

                //contact_noのダブりを防ぐため一旦クリア
                if (isset($_GET['submit']) && CHECK_SUBMIT_CONFIRM_BACK === $_GET['submit'] && isset($result['queryValues']['contact_no'])) {
                    unset($result['queryValues']['contact_no']);
                }

                 // 検索件数取得
                $contactInfo = new Contact(DB_ACCESS_INFO, USER_NAME, PASSWORD, [PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING]);
                $result['countData'] = $contactInfo->checkNumberOfData($result['queryValues']);

                // 検索結果が0の場合
                if (empty($result['countData'])) {
                    $result['msg'] = NOT_FOUND_DATA;
                } else {
                    // データ取得
                    $result['displayData'] = $contactInfo->select($result['page'], $result['queryValues']);
                }
            }
        } catch (PDOEXception $pdo) {
            $result['msg'] = SERVER_ERROR_COMMENT;
        } catch (Exception $ex) { // PDO以外の例外処理
            $result['msg'] = SERVER_ERROR_COMMENT;
        }
        return $result;
    }

    /**
     * 入力されたカナを変換（カナを入力された時のみ）
     * @param  array $values 入力値
     * @return array
     */
    private function convertKana(array $values)
    {
        if (!empty($values['kana'])) {
            $values['kana'] = mb_convert_kana($values['kana'], 'KC');
        }
        return $values;
    }

    /**
     * テンプレートで表示するページの取得
     * @param  array $values クエリパラメータ
     * @return int ページ数
     */
    private function checkPage(array $values)
    {
        // 初期値
        $page = 1;
        if (isset($values['page_id']) && is_numeric($values['page_id'])) {
            $page = (int)$values['page_id'];
        }
        return $page;
    }
}