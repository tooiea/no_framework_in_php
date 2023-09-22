<?php
require_once(dirname(__FILE__).'/Model.php');

class Administrator extends Model {

    /**
     * 管理者登録用のテーブルにあるユーザ、パスワード検索
     * @param  array $values 入力値（ログインID、パスワード）
     * @return array 検索リスト（パスワードのみ）
     */
    public function select($values)
    {
        //SELECT文のVALUESをプレースホルダーで準備
        $sql = SELECT_LOGIN_ID_PASSWORD;

        //空データで、sql実行前
        $stmt = $this->dbController->prepare($sql);
        $stmt->bindValue(':login_id', $values['login_id'], PDO::PARAM_STR);

        //実行
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * 検索後、ログインした日時を更新する
     * @param  array $value 入力値
     * @return void
     */
    public function update($values)
    {
        //UPDATE文のVALUESをプレースホルダーで準備
        $sql = UPDATE_LOGIN_DATE;

        //空データで、sql実行前
        $stmt = $this->dbController->prepare($sql);
        $stmt->bindValue(':login_id', $values['login_id'], PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * ログイン後、存在しているユーザかをチェック
     * @param  string $loginId セッションで渡されたログインID
     * @return array|bool 検索結果
     */
    public function checkUser(string $loginId)
    {
        //SELECT文のVALUESをプレースホルダーで準備
        $sql = SELECT_CHECK_USER;

        //空データで、sql実行前
        $stmt = $this->dbController->prepare($sql);
        $stmt->bindValue(':login_id', $loginId, PDO::PARAM_STR);

        //実行
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
}
