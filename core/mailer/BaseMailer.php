<?php

//メール送信用のクラス
class BaseMailer {

    // 送信先メールアドレス
    private $mail;

    // メール件名
    private $subject;

    // メールヘッダー
    private $header;

    // 使用するテンプレート
    private $template;

    public function __construct($mail, $subject, $header, $template)
    {
        $this->mail = $mail;
        $this->subject = $subject;
        $this->header = $header;
        $this->template = $template;
    }

    /**
     * メールのテンプレートに使用する置換用のカラム
     *
     * @return array
     */
    public function setColumns()
    {
        return [];
    }

    /**
     * メール送信
     *
     * @param  array $values
     * @return bool
     */
    public function sendMail($values) {
        //メール本体の処理受取
        $msgBody = $this->getBodyMsg($values, $this->template);
        $this->header = $this->header . "\r\nMIME-Version: 1.0\r\n" . "Content-Transfer-Encoding: 8bit\r\n" . "Content-Type: text/plain; charset=UTF-8\r\n";

        //表示設定
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $sendTo = mb_send_mail(
                    $this->mail,
                    $this->subject,
                    $msgBody,
                    $this->header
                );

        return $sendTo;
    }

    /**
     * メール本文を取得する
     *
     * @param  array $values
     * @param  string $template
     * @return string
     */
    private function getBodyMsg($values, $template) {
        //メール本文置換(送信者用)
        $search = $this->setColumns();
        $msgBody = str_replace($search, $values, $template);

        return $msgBody;
    }
}