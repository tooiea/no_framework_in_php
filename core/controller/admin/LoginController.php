<?php //検索コントローラ
require_once(dirname(__FILE__).'/../../database/Administrator.php');   //WatanabeAdministratosクラス
require_once(dirname(__FILE__).'/../../validation/validation.php');             //バリデーション用ファイルの読み込み
require_once(dirname(__FILE__).'/../../const/sql.php');                         //sql処理用ファイル
require_once(dirname(__FILE__).'/../../const/message.php');                     //メッセージ取得用ファイル

class LoginController {
    public function index() {

        $values = [];      //入力チェック用配列
        $errorMsg = [];    //入力チェック後のエラーメッセージ
        $msg = [];         //画面切り替え時のメッセージ
        $administrators = '';     //DBアクセス用インスタンス変数

        if ("POST" === $_SERVER['REQUEST_METHOD']) {    //postリクエストか
            if (isset($_POST['submit']) && 'login_admin' == $_POST['submit']) { //submitのリクエストか
                $values = $_POST;
                try {
                    unset($values['submit']); //入力チェックする前に、submitの削除
                    $errorMsg = $this->checkIDPASS($values); //入力チェック

                    if (empty($errorMsg)) {    //入力チェックがOKの場合
                        //管理用テーブルへアクセス
                        $administrators = new Administrator(
                            PDO_ACCESS_PHP_STUDY,
                            USER_NAME,
                            PASSWORD,
                            [PDO::ERRMODE_EXCEPTION,PDO::ERRMODE_WARNING]
                        );
                        //トランザクション開始
                        $administrators->beginTransaction();

                        //select文実行
                        $data = $administrators->select($values);

                        if ($data) {    //検索ヒット
                            if (!password_verify($values['password'], $data['password'])) { //入力値のハッシュ化された値をDB内のハッシュ化された値と比較する
                                $errorMsg['password'] = WRONG_LOGIN_ID_OR_PASSWORD;
                            } else {    //パスワードが一致
                                $administrators->update($values); //ログイン日時の更新
                                $administrators->commit();
                                $_SESSION['login_id'] = $values['login_id'];
                            }
                        } else {    //検索ヒットなし
                            $errorMsg['password'] = WRONG_LOGIN_ID_OR_PASSWORD;
                        }
                    }
                } catch (PDOEXception $pdo) {   //PDOエクセプションのキャッチ
                    $administrators->rollback();
                    $msg = array(ERROR_MESSAGE, SERVER_ERROR_COMMENT);
                } catch (Exception $ex) {       //PDO以外エクセプションのキャッチ
                    $msg = array(ERROR_MESSAGE, SERVER_ERROR_COMMENT);
                }

                //入力内容とDBでの検索結果、問題なければログイン
                if (empty($errorMsg) && empty($msg)) {
                    header('Location: /admin/list');
                    exit;
                }
            }
        }
        //画面側に表示を返す（何らかのエラーがある場合）
        return [$errorMsg, $msg];
    }

    /**
     * チェック後の値で、DBで検索する
     * @param array $values
     * @return array エラーメッセージ
     */
    public function checkIDPASS(array $values)
    {
        $errorMsg = [];
        $errorMsg = $this->nullCheck($values);
        if (empty($errorMsg)) { //nullチェック
            $errorMsg = $this->checkDigit($values);
        }
        return $errorMsg;
    }

    /**
     * 桁数チェック
     * @param array $values 入力値
     * @return array エラーメッセージ
     */
    public function checkDigit(array $values)
    {
        $errorMsg = [];
        foreach ($values as $value) {
            if (checkDigitStr($value, CHECK_NUMBER_DIGIT_255)) {
                $errorMsg['password'] = WRONG_LOGIN_ID_OR_PASSWORD;
                continue;
            }
        }
        return $errorMsg;
    }

    /**
     * ログインIDとパスワードが未入力でないかをチェック
     * @param array $values 入力データ
     * @return array エラーメッセージ
     */
    public function nullCheck(array $values)
    {
        $errorMsg = [];
        foreach ($values as $key => $value) {
            if (isEmpty($value)) {
                if ('login_id' === $key) {
                    $errorMsg[$key] = NOT_INPUT_LOGINID;
                } else {
                    $errorMsg[$key] = NOT_INPUT_PASSWORD;
                }
            }
        }
        return $errorMsg;
    }
}