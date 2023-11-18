<?php

require_once(dirname(__FILE__) . '/../../controller/admin/BaseAdminController.php');
require_once(dirname(__FILE__) . '/../../utility/TrimStrings.php');
require_once(dirname(__FILE__) . '/../../constant/MessageConstant.php');
require_once(dirname(__FILE__) . '/../../constant/AdminFormConstant.php');
require_once(dirname(__FILE__) . '/../../model/Administrator.php');
require_once(dirname(__FILE__) . '/../../validator/LoginValidator.php');

class LoginController extends BaseAdminController {

    public function login()
    {
        // ログイン認証済み
        $this->isLoggedin();

        if ("POST" === $_SERVER['REQUEST_METHOD']) {
            // ログイン処理
            $values = $_POST;
            try {
                $validator = new LoginValidator($values);

                if ($validator->isValidated()) {    //入力チェックがOKの場合
                    //管理用テーブルへアクセス
                    $administrator = new Adminstrator();
                    //トランザクション開始
                    $administrator->beginTransaction();

                    //select文実行
                    $data = $administrator->select($values);

                    // ユーザあり
                    if ($data) {
                        // パスワードをハッシュ化されたものと比較
                        if (password_verify($values['password'], $data['password'])) {
                            $administrator->updateLoginDate($values); //ログイン日時の更新
                            $administrator->commit();

                            // 各ページで認証チェックをするため、セッションにlogin_idをセット
                            $_SESSION['login_id'] = $values['login_id'];
                            header('Location: /admin/list/');
                            exit();
                        } else {
                            $errorMsg['password'] = MessageConstant::ERR_WRONG_LOGIN_ID_OR_PASSWORD;
                        }
                    } else {
                        $errorMsg['password'] = MessageConstant::ERR_WRONG_LOGIN_ID_OR_PASSWORD;
                    }
                }
                $errorMsg = $validator->getErrors();
            } catch (PDOEXception $pdo) {
                // ロールバック実行
                $administrator->rollback();
                $msg[0] = MessageConstant::ERR_HEADER;
                $msg[1]= MessageConstant::ERR_500;
            } catch (Exception $ex) {
                $msg[0] = MessageConstant::ERR_HEADER;
                $msg[1]= MessageConstant::ERR_500;
            }
        }

        include dirname(__FILE__) . '/../../view/admin/login.php';
    }
}