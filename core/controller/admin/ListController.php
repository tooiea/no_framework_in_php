<?php //登録用
require_once(dirname(__FILE__).'/../../const/sql.php');
require_once(dirname(__FILE__).'/../../const/message.php');
require_once(dirname(__FILE__).'/../../database/Contact.php');
require_once(dirname(__FILE__).'/../../database/Administrator.php');
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');

class ListController extends Controller {

    public function index()
    {
        $result = array();  //テンプレートへ返す配列変数
        $query = urldecode($_SERVER['QUERY_STRING']);   //URLのエンコード
        parse_str($query, $result['queryValues']);      //クエリパラメータ（戻す用）
        $result['page'] = $this->checkPage($result['queryValues']);   //表示ページ取得
        $result['queryValues'] = $this->convertKana($this->removeKey($result['queryValues']));  //不要なキー削除とカナの変換

        //contact_noのダブりを防ぐため削除
        if (isset($_GET['submit']) && 'confirm_back' === $_GET['submit'] && isset($result['queryValues']['contact_no'])) {
            unset($result['queryValues']['contact_no']);
        } 

        if (isset($_SESSION['login_id'])) {    //セッション存在チェック
            try {
                //管理者用テーブルへアクセス
                $administrators = new Administrator(PDO_ACCESS_PHP_STUDY, USER_NAME, PASSWORD, [PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING]);
                $isUser = $administrators->checkUser($_SESSION['login_id']);

                if (!$isUser) { //存在しているユーザかチェック
                    header('Location: /admin/login');
                    exit;
                } else {
                    $contactInfo = new Contact(PDO_ACCESS_PHP_STUDY, USER_NAME, PASSWORD, [PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING]);
                    $result['countData'] = $contactInfo->checkNumberOfData($result['queryValues']); //検索件数

                    if (empty($result['countData'])) {
                        //検索結果が0の場合
                        $result['msg'] = NOT_FOUND_DATA;
                    } else {
                        $result['displayData'] = $contactInfo->select($result['page'], $result['queryValues']); //検索データ
                    }
                }
            } catch (PDOEXception $pdo) {
                $result['msg'] = SERVER_ERROR_COMMENT;
            } catch (Exception $ex) { // PDO以外の例外処理
                $result['msg'] = SERVER_ERROR_COMMENT;
            }
        } else {
            header('Location: /admin/login');
            exit;
        }
        return $result;
    }

    /**
     * 入力されたカナを変換（カナを入力された時のみ）
     * @param $values 入力値
     * @return array
     */
    public function convertKana($values)
    {
        if (!empty($values['kana'])) {
            $values['kana'] = mb_convert_kana($values['kana'], 'KC');
        }
        return $values;
    }

    /**
     * テンプレートで表示するページの取得
     * @param array $values クエリパラメータ
     * @return int ページ数
     */
    public function checkPage($values)
    {
        $page = 1;
        if (isset($values['page_id'])) {
            if (is_numeric($values['page_id'])) {  //クエリの値が数値かどうかをチェック
                $page = (int)$values['page_id'];
            } else { //数字以外の入力であった場合
                $page = 1;
            }
        } else {
            $page = 1;
        }
        return $page;
    }
}