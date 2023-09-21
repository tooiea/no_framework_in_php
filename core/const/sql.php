<?php

//DBアクセス用
const DB_NAME = 'assignment';
const TABLE_CONTACT = 'contacts ';
const TABLE_ADMIN = 'administrators';
const USER_NAME = 'root';
const PASSWORD = 'root';
const PDO_ACCESS_PHP_STUDY = 'mysql:dbname=assignment;host=assignment_db;charset=utf8';

//バインド用
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
define('COLUMN_ADMIN_VALUES',array('login_id' => ':login_id', 'password' => ':password', 'ccount_name' => ':account_name', 'last_login_date' => ':last_login_date',
        'created' => ':created', 'modified' => ':modified'));

//INSERT文
define('INSERT_FORM','INSERT INTO contacts (contact_no, name1, name2, kana1, kana2, sex, age, blood_type, job, zip1, zip2, address1, address2, 
address3, tel, mail, category, info, created, modified) 
VALUES (0, :name1, :name2, :kana1, :kana2, :sex, :age, :blood_type, :job, :zip1, :zip2, :address1, :address2, :address3, :tel, :mail, :category, :info, now(), now());');

//ログイン管理用SELECT
define('SELECT_LOGIN_ID_PASSWORD', 'SELECT password FROM administrators WHERE login_id = :login_id;');
define('SELECT_CHECK_USER', 'SELECT login_id FROM administrators WHERE login_id = :login_id;');

//SELECT文
define('SELECT_CONTACT_LIST_CHECK_NUMBER_OF_DATA', 'select COUNT(*) from  contacts;');
define('SELECT_CONTACT_LIST_INITIAL', 'select * from contacts LIMIT 5;');
define('SELECT_CONTACT_LIST_DETAIL', 'select * from contacts WHERE contact_no = :contact_no;');


//お問い合わせ検索用SELECT（パターンに応じて）
define('SELECT_CONTACT_LIST_NAME', ' CONCAT(name1,name2) LIKE :name');   //名前のみ
define('SELECT_CONTACT_LIST_KANA', ' CONCAT(kana1,kana2) LIKE :kana');   //カナのみ
define('SELECT_CONTACT_LIST_MAIL', ' mail LIKE :mail');    //メールのみ

//SELECTのOFFSET
define('NO_OFFSET', ' LIMIT 5;');
define('IS_OFFSET', ' LIMIT 5 OFFSET :offset;');

//DB登録用key
define('DB_CONTACT_INFO_ITEM', array(1 => 'name1', 2 => 'name2',3 => 'kana1', 4 => 'kana2', 5 => 'sex', 6 => 'age', 7 => 'blood_type', 8 => 'job',
     9 => 'zip1',10 => 'zip2', 11 => 'address1', 12 => 'address2', 13 => 'address3', 14 => 'tel',15 => 'mail', 16 => 'category', 17 => 'info'));

//管理画面UPDATE
define('UPDATE_LOGIN_DATE','UPDATE administrators SET last_login_date = DEFAULT WHERE login_id = :login_id;');

define('COLUMN_ADMIN',' (login_id, password, account_name, last_login_date, created, modified)');
