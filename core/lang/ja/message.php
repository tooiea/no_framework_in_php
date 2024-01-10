<?php

return [
    'form' => [
        'success' => [
            'header' =>'受付完了',
            'body' => "お問合せありがとうございます。\n担当者より後日連絡を差し上げます。"
        ],
        'error' => [
            'mail' => [
                'header' =>'エラーが発生しました',
                'body' => "メール送信ができませんでした。\n時間をおいて再度ご入力お願い致します。"
            ]
        ],
    ],
    'admin' => [
        'no_data' => 'データが存在しません。'
    ],
    'error' => [
        '404' => [
            'header' =>'404 ERROR',
            'body' => 'ページが存在しません。'
        ],
        '405' => [
            'header' =>'405 ERROR',
            'body' => 'サーバーに異常が発生しました。'
        ],
        '500' => [
            'header' =>'500 ERROR',
            'body' => 'サーバーに異常が発生しました。'
        ]
    ]
];