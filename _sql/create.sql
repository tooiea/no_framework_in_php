#お問合わせテーブル作成
CREATE TABLE contacts (
    contact_no INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name1 VARCHAR(255) NOT NULL,
    name2 VARCHAR(255) NOT NULL,
    kana1 VARCHAR(255) NOT NULL,
    kana2 VARCHAR(255) NOT NULL,
    sex INT NOT NULL,
    age INT NOT NULL,
    blood_type INT NOT NULL,
    job INT NOT NULL,
    zip1 VARCHAR(3) NOT NULL,
    zip2 VARCHAR(4) NOT NULL,
    address1 INT NOT NULL,
    address2 VARCHAR(255) NOT NULL,
    address3 VARCHAR(255),
    tel VARCHAR(50) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    info TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

#管理者情報テーブル作成
CREATE TABLE administrators (
    login_id VARCHAR(255) NOT NULL PRIMARY KEY,
    password TEXT NOT NULL,
    account_name VARCHAR(255) NOT NULL,
    last_login_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

#リスト画面表示用ビュー作成
CREATE VIEW list_view (
contact_no,
name,
kana,
mail,
created) AS
SELECT contact_no,
CONCAT(name1,' ',name2),
CONCAT(kana1,' ',kana2),
mail,
created from contacts;