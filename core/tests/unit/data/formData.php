<?php

const REQUEST_METHOD_GET = "GET";

const REQUEST_METHOD_POST = "POST";

/**
 * フォーム入力値(pass)1
 */
const PASS_FORM_DATA = [
    'name1' => '渡邊',
    'name2' => '透也',
    'kana1' => 'わたなべ',
    'kana2' => 'とうや',
    'sex' => 1,
    'age' => 2,
    'blood_type' => 1,
    'job' => 1,
    'zip1' => 111,
    'zip2' => 222,
    'address1' => 45,
    'address2' => 'address2',
    'address3' => 'address3',
    'tel1' => 111,
    'tel2' => 111,
    'tel3' => 111,
    'mail' => 't-watanabe@un-t.com',
    'mail2' => 't-watanabe@un-t.com',
    // 'category' => [],
    'info' => 'info',
    'submit' => CHECK_SUBMIT_FORM,
];

/**
 * フォーム入力値(pass)
 */
const PASS_FORM_DATA2 = [
    'name1' => '渡邊',
    'name2' => '透也',
    'kana1' => 'わたなべ',
    'kana2' => 'とうや',
    'sex' => 1,
    'age' => 2,
    'blood_type' => 1,
    'job' => 1,
    'zip1' => 111,
    'zip2' => 222,
    'address1' => 45,
    'address2' => 'address2',
    'address3' => 'address3',
    'tel1' => 111,
    'tel2' => 111,
    'tel3' => 111,
    'mail' => 't-watanabe@un-t.com',
    'mail2' => 't-watanabe@un-t.com',
    'category' => [1,2],
    'info' => 'info',
    'submit' => CHECK_SUBMIT_FORM,
];

/**
 * フォーム入力値(fail)
 */
const FAIL_FORM_DATA = [
    'name1' => '',
    'name2' => '透也',
    'kana1' => 'わたなべ',
    'kana2' => 'とうや',
    'sex' => 1,
    'age' => 2,
    'blood_type' => 1,
    'job' => 1,
    'zip1' => 111,
    'zip2' => 222,
    'address1' => 45,
    'address2' => 'address2',
    'address3' => 'address3',
    'tel1' => 111,
    'tel2' => 111,
    'tel3' => 111,
    'mail' => 't-watanabe@un-t.com',
    'mail2' => 't-watanabe@un-t.com',
    'category' => [],
    'info' => 'info',
    'submit' => CHECK_SUBMIT_FORM,
];

/**
 * フォーム入力値(戻り時)
 */
const BACK_FORM_DATA = [
    'name1' => '渡邊',
    'name2' => '透也',
    'kana1' => 'わたなべ',
    'kana2' => 'とうや',
    'sex' => 1,
    'age' => 2,
    'blood_type' => 1,
    'job' => 1,
    'zip1' => 111,
    'zip2' => 222,
    'address1' => 45,
    'address2' => 'address2',
    'address3' => 'address3',
    'tel1' => 111,
    'tel2' => 111,
    'tel3' => 111,
    'mail' => 't-watanabe@un-t.com',
    'mail2' => 't-watanabe@un-t.com',
    // 'category' => [],
    'info' => 'info',
    'submit' => CHECK_SUBMIT_CONFIRM_BACK
];

/**
 * セッション用データ
 */
const SESSION_FORM_DATA = [
    'name1' => '渡邊',
    'name2' => '透也',
    'kana1' => 'わたなべ',
    'kana2' => 'とうや',
    'sex' => 1,
    'age' => 2,
    'blood_type' => 1,
    'job' => 1,
    'zip1' => 111,
    'zip2' => 222,
    'address1' => 45,
    'address2' => 'address2',
    'address3' => 'address3',
    'tel1' => 111,
    'tel2' => 111,
    'tel3' => 111,
    'mail' => 't-watanabe@un-t.com',
    // 'category' => [],
    'info' => 'info'
];

/**
 * フォーム登録用入力値
 */
const INSERT_DATA = [
    
    'name1' => '渡邊',
    'name2' => '透也',
    'kana1' => 'わたなべ',
    'kana2' => 'とうや',
    'sex' => 1,
    'age' => 2,
    'blood_type' => 1,
    'job' => 1,
    'zip1' => "111",
    'zip2' => "2222",
    'address1' => 45,
    'address2' => 'address2',
    'address3' => 'address3',
    'tel' => "111111111",
    'mail' => 't-watanabe@un-t.com',
    'category' => "",
    'info' => 'info',

];

/**
 * 管理画面用検索クエリ
 */
const ADMIN_FORM_QUERY_VALUES = [
    'name' => '渡邊 透也',
    'kana' => 'ワタナベトウヤ',
    'mail' => 'tooiea1113@gmail.com'
];

/**
 * 管理画面ログインID
 */
const ADMIN_LOGIN_ID = 't-watanabe@un-t.com';

/**
 * 管理画面ユーザ情報
 */
const ADMIN_USER_PASSWORD = [
    'login_id' => 't-watanabe@un-t.com',
    'password' => 'Touya1008'
];

/**
 * 管理画面ユーザ情報
 */
const ADMIN_LOG_IN_INFO_PASS = [
    'login_id' => 't-watanabe@un-t.com',
    'password' => 'Touya1008',
    'submit' => CHECK_ADMIN_LOGIN
];

/**
 * 管理画面ユーザ情報:パスワード違い
 */
const ADMIN_LOG_IN_INFO_FAIL = [
    'login_id' => 't-watanabe@un-t.com',
    'password' => 'passW0rd',
    'submit' => CHECK_ADMIN_LOGIN
];

/**
 * 管理画面ユーザ情報:ユーザなし
 */
const ADMIN_LOG_IN_INFO_FAIL2 = [
    'login_id' => 't-watanabe@un-t.come',
    'password' => 'passW0rd',
    'submit' => CHECK_ADMIN_LOGIN
];

/**
 * 管理画面ログインID
 */
const ADMIN_SESSION_LOGIN_ID = [
    'login_id' => 't-watanabe@un-t.com'
];