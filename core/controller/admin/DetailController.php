<?php //登録用
require_once(dirname(__FILE__).'/../../const/sql.php');
require_once(dirname(__FILE__).'/../../const/message.php');
require_once(dirname(__FILE__).'/../../model/Contact.php');
require_once(dirname(__FILE__).'/../../model/Administrator.php');
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');

class DetailController extends Controller {

    /**
     * GETで渡されたクエリパラメータを取得する
     * @param string $url URL
     * @return array 表示用データを渡す
     */
    public function index()
    {
        //テンプレートへ返す配列変数
        $result = [];
        $query = urldecode($_SERVER['QUERY_STRING']); //URLのエンコード
        parse_str($query, $result['queryValues']); //クエリパラメータ抽出値
        $result['queryValues'] = $this->removeKey($result['queryValues']); //不要なインデックスの削除

        if (isset($_SESSION['login_id'])) {
            //セッションあり
            try {
                if (!isset($result['queryValues']['contact_no']) || !is_numeric($result['queryValues']['contact_no'])) {
                    //contact_noが存在しない or 数値でない場合
                    $result['msg'] = NOT_FOUND_CONTACT_NO;
                } else {
                    $administrators = new Administrator(PDO_ACCESS_PHP_STUDY, USER_NAME, PASSWORD, [PDO::ERRMODE_EXCEPTION,PDO::ERRMODE_WARNING]);
                    $isUser = $administrators->checkUser($_SESSION['login_id']);

                    if (!$isUser) {
                        //存在しているユーザかチェック
                        header('Location: /admin/login');
                        exit;
                    } else {
                        $contactInfo = new Contact(PDO_ACCESS_PHP_STUDY, USER_NAME, PASSWORD, [PDO::ERRMODE_EXCEPTION,PDO::ERRMODE_WARNING]);
                        $data = $contactInfo->selectDetailContents($result['queryValues']['contact_no']);
                        
                        if (!$data) {
                            //検索後、データがない場合
                            $result['msg'] = NOT_FOUND_CONTACT_NO;
                        } else {
                            //表示用に変換
                            $result['displayValues'] = $this->convertCategory($data);
                        }
                    }
                } 
            } catch (PDOEXception $pdo) {
                $result['msg'] = SERVER_ERROR_COMMENT;
            } catch (Exception $ex) {
                $result['msg'] = SERVER_ERROR_COMMENT;
            }
        } else {
            header('Location: /admin/login');
            exit;
        }
        return $result;
    }

    /**
     * DBに登録されているカテゴリーの文字列を配列に変換
     * @param array $values クエリパラメータの配列
     * @return array カテゴリーの値を変換した後の配列
     */
    public function convertCategory($values)
    {
        $data = explode(',', $values['category']);
        $values['category'] = $this->getArrayInList($data, CATEGORY_LIST);
        return $values;
    }

    /**
    * 興味のあるカテゴリー(配列)の値取り出し
    * @param array $value 入力されたキーの配列
    * @param array $list 取り出し対象とする配列
    * @return array リストから取り出した値の配列
    */
    public function getArrayInList($value,$list)
    {
        $data = array();
        foreach ($value as $key) {
            if (array_key_exists($key, $list)) {
                $data[] = CATEGORY_LIST[$key];
            }
        }
        return $data;
    }
}