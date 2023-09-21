<?php

//開発or本番モードの切り替え用フラグ
const MODE = 'PRODUCTION';

// 性別リスト
const SEX_LIST = [
    1 => '男性',
    2 => '女性'
];

// 年齢リスト
const AGE_LIST = [
    1 => '10代',
    2 => '20代',
    3 => '30代',
    4 => '40代',
    5 => '50代',
    6 => '60代',
    7 => '65歳以上'
];

// 職業リスト
const JOB_LIST = [
    1 => '会社員',
    2 => '公務員',
    3 => '自営業',
    4 => 'フリーター',
    5 => '主婦',
    6 => '学生',
    7 => 'その他'
];

// 血液型リスト
const BLOOD_LIST = [
    1 => 'A',
    2 => 'B',
    3 => 'O',
    4 => 'AB'
];

// 都道府県リスト
const PREFUCTURES_LIST = [
    1 => '北海道',
    2 => '青森県',
    3 => '岩手県',
    4 => '宮城県',
    5 => '秋田県',
    6 => '山形県',
    7 => '福島県',
    8 => '茨城県',
    9 => '栃木県',
    10 => '群馬県',
    11 => '埼玉県',
    12 => '千葉県',
    13 => '東京都',
    14 => '神奈川県',
    15 => '新潟県',
    16 => '富山県',
    17 => '石川県',
    18 => '福井県',
    19 => '山梨県',
    20 => '長野県',
    21 => '岐阜県',
    22 => '静岡県',
    23 => '愛知県',
    24 => '三重県',
    25 => '滋賀県',
    26 => '京都府',
    27 => '大阪府',
    28 => '兵庫県',
    29 => '奈良県',
    30 => '和歌山県',
    31 => '鳥取県',
    32 => '島根県',
    33 => '岡山県',
    34 => '広島県',
    35 => '山口県',
    36 => '徳島県',
    37 => '香川県',
    38 => '愛媛県',
    39 => '高知県',
    40 => '福岡県',
    41 => '佐賀県',
    42 => '長崎県',
    43 => '熊本県',
    44 => '大分県',
    45 => '宮崎県',
    46 => '鹿児島県',
    47 => '沖縄県'
];

// カテゴリーリスト
const CATEGORY_LIST = [
    1 => '音楽',
    2 => '読書',
    3 => '映画',
    4 => 'ファッション',
    5 => 'グルメ',
    6 => 'インテリア',
    7 => '旅行',
    8 => 'その他'
];

//バリデーション用（桁数チェック）
const CHECK_NUMBER_DIGIT_3 = 3;
const CHECK_NUMBER_DIGIT_4 = 4;
const CHECK_NUMBER_DIGIT_5 = 5;
const CHECK_NUMBER_DIGIT_255 = 255;

//返信メールフォーマット用
const SUBJECT_TO_CUSTOMER = '[un-T system]お問い合わせありがとうございました。';
const SUBJECT_TO_ADMINISTRATOR = '[un-T system]お問い合わせがありました。';
const ADDRESS_TO_ADMINISTRATOR = 't-watanabe@un-t.com';
const ADDRESS_MAIL_HEADER = 'From: t-watanabe@un-t.com';

//submitチェック用
const CHECK_SUBMIT_FORM = 'form_submit';
const CHECK_SUBMIT_CONFIRM_BACK = 'confirm_back';
const CHECK_SUBMIT_CONFIRM_NEXT = 'confirm_next';
const CHECK_ADMIN_LOGIN = 'login_admin';
const SEARCH_CONTACT_LIST = 'serch_list';

//セッション内のキー存在チェック用
const KEY_LIST = [
    1 => 'name1',
    2 => 'name2',
    3 => 'kana1',
    4 => 'kana2',
    5 => 'sex',
    6 => 'age',
    7 => 'blood_type',
    8 => 'job',
    9 => 'zip1',
    10 => 'zip2',
    11 => 'address1',
    12 => 'address2',
    13 => 'address3',
    14 => 'tel1',
    15 => 'tel2',
    16 => 'tel3',
    17 => 'mail',
    18 => 'mail2',
    19 => 'category',
    20 => 'info'
];

//ページャーページ表示数
define('DISPLAY_IN_PAGE', '5');
