<?php

require_once dirname(__FILE__) . '/../../controller/form/Controller.php';    //controllerの読み込み
require_once dirname(__FILE__) . '/../../const/common_const.php';                  //定義用php

/**
 * 確認画面処理
 */
class ConfirmController extends Controller
{
    /**
     * Undocumented function
     *
     * @return array
     */
    public function index()
    {
        $values = [];

        // セッションの中身が空か指定のキーが入っているかチェック
        if (empty($_SESSION) || "POST" !== $_SERVER['REQUEST_METHOD'] || $this->isInListValue($_SESSION)) {
            // セッション配列のクリーンアップ
            $_SESSION = [];
            $this->redirector->getRedirectTo('/form/');
        }

        //セッションに保存されている値を表示用の値として代入
        $values = $_SESSION;

        return $values;
    }
}
