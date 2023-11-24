<?php

require_once(dirname(__FILE__) . '/Model.php');

class Administrator extends Model {

    private const SELECT_LOGIN_ID_PASSWORD = 'SELECT login_id, password FROM administrators WHERE login_id = :login_id';
    private const UPDATE_LOGIN_DATE = 'UPDATE administrators set last_login_date = :last_login_date';
    private const SELECT_CHECK_USER = 'SELECT login_id FROM administrators WHERE login_id = :login_id';

    /**
     * 管理者登録用のテーブルにあるユーザ、パスワード検索
     * 
     * @param  array $values 入力値（ログインID、パスワード）
     * @return array 検索リスト（パスワードのみ）
     */
    public function select($values)
    {
        // SELECT文のVALUESをプレースホルダーで準備
        $sql = self::SELECT_LOGIN_ID_PASSWORD;

        // 空データで、sql実行前
        $stmt = $this->dbInstance->prepare($sql);
        $stmt->bindValue(':login_id', $values['login_id'], PDO::PARAM_STR);

        // 実行
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * 検索後、ログインした日時を更新する
     * 
     * @param  array $value 入力値
     * @return void
     */
    public function updateLoginDate($values)
    {
        // UPDATE文のVALUESをプレースホルダーで準備
        $sql = self::UPDATE_LOGIN_DATE;
        $now = date("Y-m-d H:i:s");

        // 空データで、sql実行前
        $stmt = $this->dbInstance->prepare($sql);
        $stmt->bindValue(':last_login_date', $now, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * ログイン後、存在しているユーザかをチェック
     * 
     * @param  string $loginId セッションで渡されたログインID
     * @return array|bool 検索結果
     */
    public function existUser(string $loginId)
    {
        // SELECT文のVALUESをプレースホルダーで準備
        $sql = self::SELECT_CHECK_USER;

        // 空データで、sql実行前
        $stmt = $this->dbInstance->prepare($sql);
        $stmt->bindValue(':login_id', $loginId, PDO::PARAM_STR);

        // 実行
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
}