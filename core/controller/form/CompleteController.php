<?php
require_once(dirname(__FILE__).'/../../mail/SendMail.php');                 //SendMail.phpの読み込み
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //Controllerの読み込み
require_once(dirname(__FILE__).'/../../const/common_const.php');                    //データ処理用定義ファイルの読み込み
require_once(dirname(__FILE__).'/../../const/sql.php');                    //sql用定義ファイルの読み込み
require_once(dirname(__FILE__).'/../../const/message.php');                 //メッセージ用定義ファイルの読み込み
require_once(dirname(__FILE__).'/../../model/Contact.php');  //データベース登録用ファイルの読み込み


class CompleteController extends Controller {

    public function index()
    {
        $msg = []; //テンプレート表示用変数

        // セッションの中身が空か指定のキーが入っているかチェック
        if (empty($_SESSION) || "POST" !== $_SERVER['REQUEST_METHOD'] || $this->isInListValue($_SESSION)) {
            session_destroy();
            header('Location: /form/');
            exit;
        }

        try {
            // DB登録
            $convertedValues = $this->convertValue($_SESSION, DB_CONTACT_INFO_ITEM);
            $contact = new Contact(
                DB_ACCESS_INFO,
                USER_NAME, PASSWORD,
                [PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING]
            );

            // トランザクション開始
            $contact->beginTransaction();
            $contact->insert($convertedValues);

            // メール表示用
            $values = $_SESSION;
            $values['name'] = $this->concatenationName($values['first_name'], $values['last_name']);
            $values['kana'] = $this->concatenationName($values['first_name_kana'], $values['last_name_kana']);
            $values['zip'] = $this->concatenationZip($values['zip1'], $values['zip2']);
            $values['tel'] = $this->concatenationTelnum($values['tel1'], $values['tel2'], $values['tel3']);
            $values['address'] = $this->concatenationAddress(PREFUCTURES_LIST[$values['prefecture_id']], $values['address1']);

            //MODE切り替え
            if ('DEV' === MODE) {
                //メール本文のみログへ出力
                $sendMail = new SendMail();
                $file = dirname(__FILE__) . '/../../logs/log.txt';
                $current = file_get_contents($file);
                $current .= "\n\n". date("Y/m/d H:i:s") ."\n";
                $current .=  '顧客向け' . "\n" . $sendMail->getBodymsgForCustomer($values) . "\n\n";
                $current .=  '管理者向け' . "\n" . $sendMail->getBodymsgForCustomer($values) . "\n";
                file_put_contents($file, $current);
            } else {
                //メール送信
                $sendMail = new SendMail();
                $resultMail = $sendMail->sendingMail($values); //メール送信の結果を取得

                //メール送信が失敗した場合、DB登録しないようにスローする
                if (!$resultMail) {
                    throw new Exception();
                }
            }

            // メール送信完了後にコミット
            $contact->commit();

            //コミット後
            session_destroy();;    //セッションクリア
            $msg['header'] = RECEPTION_COMPLETED; //完了用メッセージを渡す
            $msg['body'] = MESSAGE_AFTER_COMPLETED;
        } catch (PDOEXception $ex) {
            $contact->rollBack();
            $msg['header'] = ERROR_MESSAGE;
            $msg['body'] = SERVER_ERROR_COMMENT;
        } catch (EXception $ex) { //メール送信・他例外
            $msg['header'] = ERROR_MESSAGE;
            $msg['body'] = SERVER_ERROR_COMMENT;
        }
        return $msg;
    }

    /**
     * DBアクセス用にセッション値を変換する
     *
     * @param  array $values セッションの値
     * @param  array $list DB登録用のリスト
     * @return array DB登録に必要な配列を返す
     */
    public function convertValue(array $values, array $list)
    {
        $convertValues = []; //データベース用の配列

        foreach ($list as $key) {
            if ('tel' === $key) {
                $convertValues['tel'] = $values['tel1'] . $values['tel2'] . $values['tel3'];
            } elseif ('zip' === $key) {
                $convertValues['zip'] = $values['zip1'] . $values['zip2'];
            } elseif ('category' === $key) {
                $convertValues['category'] = '';
                if (isset($values['category'])) {
                    $convertValues['category'] = implode(',', $values['category']);
                }
            } else {
                $convertValues[$key] = $values[$key];
            }
        }
        return $convertValues;
    }
}