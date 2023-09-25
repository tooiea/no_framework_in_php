<?php

// DBアクセス用
const DB_NAME = 'assignment';
const HOST_NAME = 'assignment_db';
const USER_NAME = 'root';
const PASSWORD = 'root';
const DB_ACCESS_INFO = 'mysql:dbname=' . DB_NAME . ';host=' . HOST_NAME . ';charset=utf8';

// フォーム:バインドリスト
const COLUMN_INFO_VALUES = [
    'name1' => ':name1',
    'name2' => ':name2',
    'kana1' => ':kana1',
    'kana2' => ':kana2',
    'sex' => ':sex',
    'age' => ':age',
    'blood_type' => ':blood_type',
    'job' => ':job',
    'zip1' => ':zip1',
    'zip2' => ':zip2',
    'address1' => ':address1',
    'address2' => ':address2',
    'address3' => ':address3',
    'tel' => ':tel',
    'mail' => ':mail',
    'category' => ':category',
    'info' => ':info'
];

// INSERT文
const INSERT_FORM = 'INSERT INTO contacts (name1, name2, kana1, kana2, sex, age, blood_type, job, zip1, zip2, address1, address2, address3, tel, mail, category, info, created, modified)
VALUES (:name1, :name2, :kana1, :kana2, :sex, :age, :blood_type, :job, :zip1, :zip2, :address1, :address2, :address3, :tel, :mail, :category, :info, now(), now());';


// ログイン管理用SELECT
const SELECT_LOGIN_ID_PASSWORD = 'SELECT password FROM administrators WHERE login_id = :login_id;';
const SELECT_CHECK_USER = 'SELECT login_id FROM administrators WHERE login_id = :login_id;';

// SELECT文
const SELECT_CONTACT_LIST_CHECK_NUMBER_OF_DATA = 'select COUNT(*) from  contacts;';
const SELECT_CONTACT_LIST_INITIAL = 'select * from contacts LIMIT 5;';
const SELECT_CONTACT_LIST_DETAIL = 'select * from contacts WHERE contact_no = :contact_no;';


// お問い合わせ検索用SELECT（パターンに応じて）
const SELECT_CONTACT_LIST_NAME = ' CONCAT(name1,name2) LIKE :name';   //名前のみ
const SELECT_CONTACT_LIST_KANA = ' CONCAT(kana1,kana2) LIKE :kana';   //カナのみ
const SELECT_CONTACT_LIST_MAIL = ' mail LIKE :mail';    //メールのみ

// SELECTのOFFSET
const NO_OFFSET = ' LIMIT 5;';
const IS_OFFSET = ' LIMIT 5 OFFSET :offset;';

// DB登録用key
const DB_CONTACT_INFO_ITEM = [
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
    14 => 'tel',
    15 => 'mail',
    16 => 'category',
    17 => 'info'
];

// 管理画面UPDATE
const UPDATE_LOGIN_DATE = 'UPDATE administrators SET last_login_date = DEFAULT WHERE login_id = :login_id;';
const COLUMN_ADMIN = ' (login_id, password, account_name, last_login_date, created, modified)';
