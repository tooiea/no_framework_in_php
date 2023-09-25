<?php //検索コントローラ
require_once(dirname(__FILE__).'/../../model/Administrator.php');
require_once(dirname(__FILE__).'/../../validation/AdminFormValidator.php');
require_once(dirname(__FILE__).'/../../const/sql.php');
require_once(dirname(__FILE__).'/../../const/message.php');

class LoginController {

    // 表示用エラー時メッセージ
    private $msg;

    // 表示用バリデーションエラーメッセージ
    private $errorMsg;

    /**
     * ログインチェック
     *
     * @return void
     */
    public function index()
    {
        $this->msg = [];         //画面切り替え時のメッセージ
        $administrators = '';     //DBアクセス用インスタンス変数

        // ログイン認証済み
        if (isset($_SESSION['login_id'])) {
            header('Location: /admin/list');
            exit;
        }

        if ("POST" === $_SERVER['REQUEST_METHOD']) {
            // ログイン処理
            if (isset($_POST['submit']) && CHECK_ADMIN_LOGIN == $_POST['submit']) {
                $values = $_POST;
                try {
                    unset($values['submit']); //入力チェックする前に、submitの削除
                    $validator = new AdminFormValidator();
                    $validator->checkUserPassword($values); //入力チェック
                    $this->errorMsg = $validator->getErrorMsgs();

                    if (empty($this->errorMsg)) {    //入力チェックがOKの場合
                        //管理用テーブルへアクセス
                        $administrators = new Administrator(
                            DB_ACCESS_INFO,
                            USER_NAME,
                            PASSWORD,
                            [PDO::ERRMODE_EXCEPTION,PDO::ERRMODE_WARNING]
                        );
                        //トランザクション開始
                        $administrators->beginTransaction();

                        //select文実行
                        $data = $administrators->select($values);

                        // ユーザあり
                        if ($data) {
                            // パスワードをハッシュ化されたものと比較
                            if (password_verify($values['password'], $data['password'])) {
                                $administrators->update($values); //ログイン日時の更新
                                $administrators->commit();

                                // 各ページで認証チェックをするため、セッションにlogin_idをセット
                                $_SESSION['login_id'] = $values['login_id'];
                            } else {
                                $this->errorMsg['password'] = WRONG_LOGIN_ID_OR_PASSWORD;
                            }
                        } else {
                            $this->errorMsg['password'] = WRONG_LOGIN_ID_OR_PASSWORD;
                        }
                    }
                } catch (PDOEXception $pdo) {
                    // ロールバック実行
                    $administrators->rollback();
                    $this->msg[0] = ERROR_MESSAGE;
                    $this->msg[1]= SERVER_ERROR_COMMENT;
                } catch (Exception $ex) {
                    $this->msg[0] = ERROR_MESSAGE;
                    $this->msg[1]= SERVER_ERROR_COMMENT;
                }

                //入力内容とDBでの検索結果、問題なければログイン
                if (empty($this->errorMsg) && empty($this->msg)) {
                    header('Location: /admin/list');
                    exit;
                }
            }
        }
    }

    /**
     * テンプレート表示用入力値を取得
     *
     * @return array
     */
    public function getMessage()
    {
        return $this->msg;
    }

    /**
     * エラーメッセージ取得
     *
     * @return array
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}