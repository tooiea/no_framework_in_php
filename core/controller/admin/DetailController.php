<?php

require_once dirname(__FILE__) . '/../../const/sql.php';
require_once dirname(__FILE__) . '/../../const/message.php';
require_once dirname(__FILE__) . '/../../model/Contact.php';
require_once dirname(__FILE__) . '/../../model/Administrator.php';
require_once dirname(__FILE__) . '/../../controller/form/Controller.php';
require_once dirname(__FILE__) . '/../../service/ServiceModelContainer.php';

/**
 * 詳細画面お問い合わせ内容表示
 * 一覧画面より特定のリンクより遷移される
 */
class DetailController extends Controller
{
    private $administratorContainer;
    private $contactContainer;

    /**
     * インスタンス注入
     *
     * @param Redirector            $redirector             リダイレクター
     * @param ServiceModelContainer $administratorContainer サービスコンテナ
     * @param ServiceModelContainer $contactContainer       サービスコンテナ
     */
    public function __construct(Redirector $redirector, ServiceModelContainer $administratorContainer, ServiceModelContainer $contactContainer)
    {
        $this->redirector = $redirector;
        $this->administratorContainer = $administratorContainer;
        $this->contactContainer = $contactContainer;
    }

    /**
     * GETで渡されたクエリパラメータを取得する
     *
     * @return array 表示用データを渡す
     */
    public function index()
    {
        //テンプレートへ返す配列変数
        $result = [];

        // ログイン認証されていない
        if (!isset($_SESSION['login_id'])) {
            $this->redirector->getRedirectTo('/admin/login');
        }

        try {
            //クエリパラメータ(戻す用でセット)
            parse_str(urldecode($_SERVER['QUERY_STRING']), $result['queryValues']);

            //contact_noが存在しない or 数値でない場合
            if (!isset($result['queryValues']['contact_no']) || !is_numeric($result['queryValues']['contact_no'])) {
                $result['msg'] = NOT_FOUND_CONTACT_NO;
            } else {
                $administrators = $this->getInstance('administrator', 'Administrator', $this->administratorContainer);
                $isUser = $administrators->checkUser($_SESSION['login_id']);

                //存在しているユーザかチェック
                if (!$isUser) {
                    $this->redirector->getRedirectTo('/admin/login');
                }

                //不要なキー削除
                $result['queryValues'] = $this->removeKey($result['queryValues']);

                // 詳細データ取得
                $contactInfo = $this->getInstance('contact', 'Contact', $this->contactContainer);
                $data = $contactInfo->selectDetailContents($result['queryValues']['contact_no']);

                if (!$data) {
                    //検索後、データがない場合
                    $result['msg'] = NOT_FOUND_CONTACT_NO;
                } else {
                    //表示用に変換
                    $result['displayValues'] = $this->convertCategory($data);
                }
            }
        } catch (PDOEXception $pdo) {
            $result['msg'] = SERVER_ERROR_COMMENT;
        } catch (Exception $ex) {
            $result['msg'] = SERVER_ERROR_COMMENT;
        }

        return $result;
    }

    /**
     * DBに登録されているカテゴリーの文字列を配列に変換
     *
     * @param array $values 入力値
     * 
     * @return array
     */
    public function convertCategory(array $values)
    {
        $data = explode(',', $values['category']);
        $values['category'] = $this->getArrayInList($data, CATEGORY_LIST);
        return $values;
    }

    /**
     * 興味のあるカテゴリー(配列)の値取り出し
     *
     * @param array $values 入力されたキーの配列
     * @param array $list   取り出し対象とする配列
     * 
     * @return array
     */
    public function getArrayInList(array $values, array $list)
    {
        $data = [];
        foreach ($values as $key) {
            if (array_key_exists($key, $list)) {
                $data[] = CATEGORY_LIST[$key];
            }
        }
        return $data;
    }
}
