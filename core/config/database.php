<?php

const ACCESS_INFO = [
    // 開発環境
    'local' => [
        'db_name' => 'assignment',
        'host_name' => 'assignment_db',
        'user_name' => 'root',
        'password' => 'root',
    ],
    // 本番環境用
    'production' => [
        'db_name' => 'assignment',
        'host_name' => 'assignment_db',
        'user_name' => 'root',
        'password' => 'root',
    ],
    // テスト時のPDD例外発生用
    'test' => [
        'db_name' => 'assignments',
        'host_name' => 'assignment_db',
        'user_name' => 'root',
        'password' => 'root',
    ]
];
