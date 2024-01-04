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
    'mail2' => 't-watanabe@un-t.com',
    // 'category' => [],
    'info' => 'info'
];