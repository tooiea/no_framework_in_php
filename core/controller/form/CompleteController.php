<?php
require_once(dirname(__FILE__).'/../../mail/SendMail.php');                 //SendMail.phpの読み込み
require_once(dirname(__FILE__).'/../../controller/form/Controller.php');    //Controllerの読み込み
require_once(dirname(__FILE__).'/../../const/data.php');                    //データ処理用定義ファイルの読み込み
require_once(dirname(__FILE__).'/../../const/sql.php');                    //sql用定義ファイルの読み込み
require_once(dirname(__FILE__).'/../../const/message.php');                 //メッセージ用定義ファイルの読み込み
require_once(dirname(__FILE__).'/../../database/WatanabeContactInfo.php');  //データベース登録用ファイルの読み込み


class CompleteController extends Controller{
 
    public function index() {

        $msg =array(); //テンプレート表示用変数
        $insertDB = ''; //DBアクセス用インスタンス変数
        $resultMail = true; //メール送信結果

        if (!empty($_SESSION)) { //セッションの中身が空かどうかチェック
            $keyCheckResult = $this->checkKeyOfSession($_SESSION); //セッション内のキーをチェックした結果
        } else {
            $keyCheckResult = false;
        }

        if ($keyCheckResult) { //セッション存在チェックの結果
            try {
                $values = $_SESSION; //表示用の値として代入
                $values['name'] = $this->concatenationName($values['name1'], $values['name2']);
                $values['kana'] = $this->concatenationName($values['kana1'], $values['kana2']);
                $values['zip'] = $this->concatenationZip($values['zip1'], $values['zip2']);
                $values['tel'] = $this->concatenationTelnum($values['tel1'], $values['tel2'], $values['tel3']);
                $values['address12'] = $this->concatenationAddress(PREFUCTURES_LIST[$values['address1']], $values['address2']);

                //MODE切り替え
                if (MODE === 'DEV') {   //メール本文のみログへ出力
                    $sendMail = new SendMail();
                    $file = '/Users/watanabe_touya/Documents/GitHub/php_exercise_t_watanabe/src/debuglog/mailLog.txt';
                    $current = file_get_contents($file);
                    $data = $sendMail->getBodymsg($values);
                    $current .= "\n\n". date("Y/m/d H:i:s") ."\n";
                    $current .=  '顧客用メール' . "\n" . $data[0] . "\n\n";
                    $current .=  'admin用メール' . "\n" . $data[1] . "\n";
                    file_put_contents($file,$current);

                } else if (MODE === 'PRODUCTION') { //メール送信
                    $senMail = new SendMail();
                    $resultMail = $senMail->sendingMail($values); //メール送信の結果を取得
                }

                if (!$resultMail) { //メール送信が失敗した場合、登録しないようにスローする
                    throw new Exception();
                }

                //DB登録
                $convertedValues = $this->convertValue($_SESSION, DB_CONTACT_INFO_ITEM);    //DB登録用として変換
                $insertDB = new WatanabeContactInfo(PDO_ACCESS_PHP_STUDY, USER_NAME, PASSWORD, array(PDO::ERRMODE_EXCEPTION,PDO::ERRMODE_WARNING));
                $insertDB->beginTransaction();          //トランザクション
                $insertDB->insert($convertedValues);    //インサート
                $insertDB->commit();                    //コミット

            } catch (PDOEXception $ex) {    //DB登録時のキャッチ
                $insertDB->rollBack();
                $msg = array(ERROR_MESSAGE, SERVER_ERROR_COMMENT);

            } catch (EXception $ex) { //メール送信時、他エクセプションのキャッチ
                $msg = array(ERROR_MESSAGE, SEND_MAIL_ERROR_COMMENT);
            }

            //コミット後
            $_SESSION = array();    //セッションクリア
            $msg = array(RECEPTION_COMPLETED, MESSAGE_AFTER_COMPLETED); //完了用メッセージを渡す

        } else { //セッション内に、存在しないキーが合った場合（セッションが存在しない場合）
            $_SESSION = array();
            header('Location: /form/');
            exit;
        }
        return $msg;
    }

    /**
     * DBアクセス用にセッション値を変換する
     * @param array $values セッションの値
     * @param array $list DB登録用のリスト
     * @return array DB登録に必要な配列を返す
     */
    public function convertValue($values, $list) {

        $convertValues = array(); //データベース用の配列

        foreach ($list as $key) {   //数値で保管するものをキャスト
            if ('tel' === $key) {    //tel1,tel2,tel3を結合
                $convertValues['tel'] = $values['tel1'] . $values['tel2'] . $values['tel3'];
            } else if ('category' === $key && !isset($values['category'])) {
                $convertValues['category'] = '';
            } else if ('category' === $key) { //カテゴリーの値が存在する場合
                $convertValues['category'] = implode(',', $values['category']);
            }  else { //文字列は、そのまま
                $convertValues[$key] = $values[$key];
            }
        }
        return $convertValues;
    }
}