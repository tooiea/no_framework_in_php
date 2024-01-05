# no_framework_in_php

// ハッシュ化パスワードの更新時
var_dump(password_hash('password', PASSWORD_BCRYPT));

# phpunitパッケージインストールまで

- phpunitを配置するディレクトリへ移動
- composer.jsonを追加
- phpunitのバージョンを追記
- composer.jsonを配置したディレクトリで`composer install`を実行

## テストコマンド(暫定)

`composer make_report`
・/var/www/coreのディレクトリで上記コマンドを実行するとHTML形式で出力される

`composer test`
・/var/www/coreのディレクトリで上記コマンドを実行するとテストだけを完了させる