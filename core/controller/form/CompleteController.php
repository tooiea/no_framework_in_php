<?php

require_once dirname(__FILE__) . '/../../mail/SendMail.php';
require_once dirname(__FILE__) . '/../../controller/form/Controller.php';
require_once dirname(__FILE__) . '/../../const/common_const.php';
require_once dirname(__FILE__) . '/../../const/sql.php';
require_once dirname(__FILE__) . '/../../const/message.php';
require_once dirname(__FILE__) . '/../../model/Contact.php';
require_once dirname(__FILE__) . '/../../util/AppModeController.php';
require_once dirname(__FILE__) . '/../../service/ServiceModelContainer.php';

/**
 * 確認画面から遷移後の処理(完了画面表示まで)
 */
class CompleteController extends Controller
{

    private $contactContainer;

    /**
     * リダイレクター、Administrator操作用のインスタンス
     *
     * @param Redirector            $redirector             リダイレクター
     * @param ServiceModelContainer $administratorContainer Administrator操作コンテナ
     */

    /**
     * リダイレクター、Administrator操作用のインスタンス
     *
     * @param Redirector            $redirector       リダイレクター
     * @param ServiceModelContainer $contactContainer Contact操作コンテナ
     * @param string|null           $mode             処理モード切り替え
     */
    public function __construct(Redirector $redirector, ServiceModelContainer $contactContainer, string $mode = null)
    {
        parent::__construct(new Redirector);
        $this->redirector = $redirector;
        $this->contactContainer = $contactContainer;

        // 開発モード指定
        $appMode = new AppModeController($mode);
        $this->appMode = $appMode->getAppMode();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function index()
    {
        $msg = []; //テンプレート表示用変数

        // セッションの中身が空か指定のキーが入っているかチェック
        if (empty($_SESSION) || "POST" !== $_SERVER['REQUEST_METHOD'] || $this->isInListValue($_SESSION)) {
            // セッション配列のクリーンアップ
            $_SESSION = [];
            $this->redirector->getRedirectTo('/form/');
        }

        try {
            // DB登録
            $convertedValues = $this->convertValue($_SESSION, DB_CONTACT_INFO_ITEM);
            $contact = $this->getInstance('contact', 'Contact', $this->contactContainer);;

            // トランザクション開始
            $contact->beginTransaction();
            $contact->insert($convertedValues);

            // メール表示用
            $values = $_SESSION;
            $values['name'] = $this->concatenationName($values['name1'], $values['name2']);
            $values['kana'] = $this->concatenationName($values['kana1'], $values['kana2']);
            $values['zip'] = $this->concatenationZip($values['zip1'], $values['zip2']);
            $values['tel'] = $this->concatenationTelnum($values['tel1'], $values['tel2'], $values['tel3']);
            $values['address12'] = $this->concatenationAddress(PREFUCTURES_LIST[$values['address1']], $values['address2']);

            // MODEによって処理を切り替える
            if ('DEV' === $this->appMode) {
                //メール本文のみログへ出力
                $sendMail = new SendMail();
                $file = dirname(__FILE__) . '/../../logs/log.txt';
                $current = file_get_contents($file);
                $current .= "\n\n" . date("Y/m/d H:i:s") . "\n";
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

            $_SESSION = [];

            $msg['header'] = RECEPTION_COMPLETED; //完了用メッセージを渡す
            $msg['body'] = MESSAGE_AFTER_COMPLETED;
        } catch (PDOEXception $ex) {
            $contact->rollBack();
            $msg['header'] = ERROR_MESSAGE;
            $msg['body'] = SERVER_ERROR_COMMENT;
        } catch (EXception $ex) { //メール送信・他例外
            $contact->rollBack();
            $msg['header'] = ERROR_MESSAGE;
            $msg['body'] = SERVER_ERROR_COMMENT;
        }
        return $msg;
    }

    /**
     * DBアクセス用にセッション値を変換する
     *
     * @param array $values セッションの値
     * @param array $list   DB登録用のリスト
     * 
     * @return array DB登録に必要な配列を返す
     */
    public function convertValue(array $values, array $list)
    {
        $convertValues = []; //データベース用の配列

        foreach ($list as $key) {
            if ('tel' === $key) {
                $convertValues['tel'] = $values['tel1'] . $values['tel2'] . $values['tel3'];
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
