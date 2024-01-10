<?php

namespace App\Constants;

/**
 * フォーム周りの定義
 */
class FormConstant {
    /**
     * 性別リスト
     */
    public const SEX_LIST = [
        1 => '男性',
        2 => '女性'
    ];

    /**
     * 年齢リスト
     */
    public const AGE_LIST = [
        1 => '10代',
        2 => '20代',
        3 => '30代',
        4 => '40代',
        5 => '50代',
        6 => '60代',
        7 => '65歳以上'
    ];

    /**
     * 職業リスト
     */
    public const JOB_LIST = [
        1 => '会社員',
        2 => '公務員',
        3 => '自営業',
        4 => 'フリーター',
        5 => '主婦',
        6 => '学生',
        7 => 'その他'
    ];

    /**
     * 血液型リスト
     */
    public const BLOOD_LIST = [
        1 => 'A',
        2 => 'B',
        3 => 'O',
        4 => 'AB'
    ];

    /**
     * 都道府県リスト
     */
    public const PREFUCTURES_LIST = [
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

    /**
     * カテゴリーリスト
     */
    public const CATEGORY_LIST = [
        1 => '音楽',
        2 => '読書',
        3 => '映画',
        4 => 'ファッション',
        5 => 'グルメ',
        6 => 'インテリア',
        7 => '旅行',
        8 => 'その他'
    ];

    /**
     * セッション内のキー存在チェック用(入力戻り含む)
     */
    public const SESSION_KEY_LIST = [
        'name1',
        'name2',
        'kana1',
        'kana2',
        'sex',
        'age',
        'blood_type',
        'job',
        'zip1',
        'zip2',
        'address1',
        'address2',
        'address3',
        'tel1',
        'tel2',
        'tel3',
        'mail',
        'mail2',
        'category',
        'info'
    ];

    /**
     * 正規表現ルール
     */
    public const REGEX_KANA = '/[ァ-ヴーa-zA-Zａ-ｚＡ-Ｚ]/u';
    public const REGEX_ZIP1 = '/^[0-9]{3,3}+$/';
    public const REGEX_ZIP2 = '/^[0-9]{4,4}+$/';
    public const REGEX_TEL1 = '/^[0-9]{1,5}+$/';
    public const REGEX_TEL23 = '/^[0-9]{1,4}+$/';

    /**
     * Contactモデルへインサートするカラム
     */
    public const CONTACT_INSERT_KEY_LIST = [
        'name1',
        'name2',
        'kana1',
        'kana2',
        'sex',
        'age',
        'blood_type',
        'job',
        'zip1',
        'zip2',
        'address1',
        'address2',
        'address3',
        'tel',
        'mail',
        'category',
        'info'
    ];
}