# no_framework_in_php
 
var_dump(password_hash('password', PASSWORD_BCRYPT));


# laravel構築手順

1. Laravel本体のインストール
    `composer create-project laravel/laravel`
2. アプリケーションキーの生成
    `php artisan key:generate`
3. データベースの準備
    `データベース、使用するテーブル作成のSQLを実行`
4. breezeインストール
   1. composer require laravel/breeze --dev
   2.   ┌ Which Breeze stack would you like to install? ───────────────┐
        │ Blade with Alpine                                            │
        └──────────────────────────────────────────────────────────────┘

        ┌ Would you like dark mode support? ───────────────────────────┐
        │ Yes                                                          │
        └──────────────────────────────────────────────────────────────┘

        ┌ Which testing framework do you prefer? ──────────────────────┐
        │ PHPUnit   