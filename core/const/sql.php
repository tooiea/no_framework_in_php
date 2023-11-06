<?php

// DBアクセス用
// const DB_NAME = 'assignment';
const DB_NAME = 'y_assignment';
const HOST_NAME = 'assignment_db';
const USER_NAME = 'root';
const PASSWORD = 'root';
const DB_ACCESS_INFO = 'mysql:dbname=' . DB_NAME . ';host=' . HOST_NAME . ';charset=utf8';

// フォーム:バインドリスト
const COLUMN_INFO_VALUES = [
    'first_name' => ':first_name',
    'last_name' => ':last_name',
    'first_name_kana' => ':first_name_kana',
    'last_name_kana' => ':last_name_kana',
    'sex_id' => ':sex_id',
    'age_id' => ':age_id',
    'blood_type_id' => ':blood_type_id',
    'job_id' => ':job_id',
    'zip' => ':zip',
    'prefecture_id' => ':prefecture_id',
    'address1' => ':address1',
    'address2' => ':address2',
    'tel' => ':tel',
    'mail' => ':mail',
    'inquiry_content_ids' => ':inquiry_content_ids',
    'inpuiry_detail' => ':inpuiry_detail'
];

// INSERT文
const INSERT_FORM = 'INSERT INTO inquiry_contents (first_name, last_name, first_name_kana, last_name_kana, sex_id, age_id, blood_type_id, job_id, zip, prefecture_id, address1, address2, tel, mail, inquiry_content_ids, inpuiry_detail, created_date, updated_date)
VALUES (:first_name, :last_name, :first_name_kana, :last_name_kana, :sex_id, :age_id, :blood_type_id, :job_id, :zip, :prefecture_id, :address1, :address2, :tel, :mail, :inquiry_content_ids, :inpuiry_detail, now(), now());';


// ログイン管理用SELECT
const SELECT_LOGIN_ID_PASSWORD = 'SELECT password FROM administrators WHERE login_id = :login_id;';
const SELECT_CHECK_USER = 'SELECT login_id FROM administrators WHERE login_id = :login_id;';

// SELECT文
const SELECT_CONTACT_LIST_CHECK_NUMBER_OF_DATA = 'select COUNT(*) from  inquiry_contents;';
const SELECT_CONTACT_LIST_INITIAL = 'select * from inquiry_contents LIMIT 5;';
const SELECT_CONTACT_LIST_DETAIL = 'select * from inquiry_contents WHERE contact_no = :contact_no;';


// お問い合わせ検索用SELECT（パターンに応じて）
const SELECT_CONTACT_LIST_NAME = ' CONCAT(first_name,last_name) LIKE :name';   //名前のみ
const SELECT_CONTACT_LIST_KANA = ' CONCAT(first_name_kana,last_name_kana) LIKE :kana';   //カナのみ
const SELECT_CONTACT_LIST_MAIL = ' mail LIKE :mail';    //メールのみ

// SELECTのOFFSET
const NO_OFFSET = ' LIMIT 5;';
const IS_OFFSET = ' LIMIT 5 OFFSET :offset;';

// DB登録用key
const DB_CONTACT_INFO_ITEM = [
    1 => 'first_name',
    2 => 'last_name',
    3 => 'first_name_kana',
    4 => 'last_name_kana',
    5 => 'sex_id',
    6 => 'age_id',
    7 => 'blood_type_id',
    8 => 'job_id',
    9 => 'zip',
    10 => 'prefecture_id',
    11 => 'address1',
    12 => 'address2',
    13 => 'tel',
    14 => 'mail',
    15 => 'inquiry_content_ids',
    16 => 'inpuiry_detail'
];

// 管理画面UPDATE
const UPDATE_LOGIN_DATE = 'UPDATE administrators SET last_login_date = DEFAULT WHERE login_id = :login_id;';
const COLUMN_ADMIN = ' (login_id, password, account_name, last_login_date, created_date, updated_date)';
