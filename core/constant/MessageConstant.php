<?php

class MessageConstant {

    // 完了画面メール送信完了
    public const SUCCESS_SEND_MAIL_HEADER = '受付完了';
    public const SUCCESS_SEND_MAIL_BODY = "お問合せありがとうございます。\n担当者より後日連絡を差し上げます。";

    // メール送信失敗
    public const ERR_MSG_MAIL_HEADER = 'メール送信失敗';
    public const ERR_MSG_MAIL_BODY = "送信に失敗しました。\n下記より管理者へご連絡お願いします。";
}