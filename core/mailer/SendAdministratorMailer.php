<?php

require_once(dirname(__FILE__) . '/BaseMailer.php');

class SendAdministratorMailer extends BaseMailer {

    /**
     * メールのテンプレートに使用する置換用のカラム
     *
     * @return array
     */
    public function setColumns()
    {
        return [
            '{{time}}',
            '{{name}}',
            '{{kana}}',
            '{{sex}}',
            '{{age}}',
            '{{blood_type}}',
            '{{job}}',
            '{{zip}}',
            '{{address12}}',
            '{{address3}}',
            '{{tel}}',
            '{{mail}}',
            '{{category}}',
            '{{info}}'
        ];
    }
}