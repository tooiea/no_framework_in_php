# フレームワーク使用なし
 
var_dump(password_hash('password', PASSWORD_BCRYPT));


# laravel構築手順

### コマンドによるインストール

- 実行するディレクトリ
    `/var/www/core` *アプリケーションのあるtinkerが実行できるディレクトリ

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
5. 言語ファイルのインストール
   `php artisan lang:publish`


    9  composer create-project laravel/laravel core
   10  ls
   11  php artisan key:generate
   12  ls
   13  cd core/
   14  php artisan key:generate
   15  php artisan make:controller ContactFormController
   16  php artisan migrate
   17  php artisan migrate
   18  composer require laravel/breeze --dev
   19  php artisan breeze:install
   20  hitsoty
   21  history
   22  php artisan tinker
   23  php artisan make:controller Admin/LoginController
   24  php artisan make:controller Admin/UserSearchController
   25  php artisan make:model Contact
   26  php artisan make:model Administrator
   27  php artisan tinker
   28  php artisan tinker
   29  php artisan lang:publish
   30  php artisan make:request ContactFormRequest
   31  php artisan make:request UserSearchRequest
   32  php artisan make:middleware AdminIpFilterMiddleware
   33  php artisan make:middleware AdminAuthenticateWithBasicAuth
   34  php artisan make:mail BaseMailable
   35  php artisan make:mail CustomerMailable
   36  php artisan make:mail AdminMailable