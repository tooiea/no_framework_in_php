#お問合わせテーブル作成
CREATE TABLE inquiry_contents (
    contact_no INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    first_name_kana VARCHAR(255) NOT NULL,
    last_name_kana VARCHAR(255) NOT NULL,
    sex_id INT NOT NULL,
    age_id INT NOT NULL,
    blood_type_id INT NOT NULL,
    job_id INT NOT NULL,
    zip1 VARCHAR(3) NOT NULL,
    zip2 VARCHAR(4) NOT NULL,
    prefecture_id INT NOT NULL,
    address2 VARCHAR(255) NOT NULL,
    address3 VARCHAR(255),
    tel VARCHAR(50) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    inquiry_content_ids VARCHAR(255) NOT NULL,
    inpuiry_detail TEXT NOT NULL,
    created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

#管理者情報テーブル作成
CREATE TABLE administrators (
    login_id VARCHAR(255) NOT NULL PRIMARY KEY,
    password TEXT NOT NULL,
    account_name VARCHAR(255) NOT NULL,
    last_login_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

#リスト画面表示用ビュー作成
CREATE VIEW list_view (
contact_no,
name,
kana,
mail,
created_date) AS
SELECT contact_no,
CONCAT(first_name,' ',last_name),
CONCAT(first_name_kana,' ',last_name_kana),
mail,
created_date from inquiry_contents;