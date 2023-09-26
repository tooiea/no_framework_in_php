<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once(dirname(__FILE__).'/../model/Model.php');    //データベースアクセスクラス
require_once(dirname(__FILE__).'/../const/sql.php');           //定義用php

class Contact extends Model {

    /**
     * テーブルにデータを登録する
     *
     * @param  array $values 登録する値
     * @return object|bool アクセス、登録までできた場合object,失敗時はbool
     */
    public function insert(array $values)
    {
        // SQL実行後の判定
        $result = false;

        // プレースホルダを用いたinsert文を準備
        // 直接SQLに値をセットしてクエリを発行しない
        $sql = INSERT_FORM;
        $stmt = $this->dbController->prepare($sql);

        // 入力値を型に合わせてプレースホルダで値をセットしていく(バインド)
        foreach ($values as $key => $value) {
            $checkResult[] = array_key_exists($key, COLUMN_INFO_VALUES);
            if (array_key_exists($key, COLUMN_INFO_VALUES)) {
                if ('sex' === $key || 'age' === $key || 'blood_type' === $key || 'job' === $key || 'address1' === $key) {
                    // 整数型
                    $stmt->bindValue(COLUMN_INFO_VALUES[$key], (int)$value, PDO::PARAM_INT);
                } else {
                    // 文字列
                    $stmt->bindValue(COLUMN_INFO_VALUES[$key], $value, PDO::PARAM_STR);
                }
            }
        }

        // DBへ登録
        $result = $stmt->execute();
        return $result;
    }

    /**
     * テーブル内のデータ件数を取得する
     *
     * @return int データ件数
     */
    public function checkNumberOfDataInitial()
    {
        $sql = SELECT_CONTACT_LIST_CHECK_NUMBER_OF_DATA;
        $stmt = $this->dbController->query($sql);
        $countData = $stmt->fetchColumn();
        return $countData;
    }

    /**
     * 検索する対象のデータ件数を取得
     *
     * @param  array $values 入力値
     * @return integer データ件数
     */
    public function checkNumberOfData(array $values)
    {
        //SQL文のWHERE条件を選択
        $sqlWhereCondition = $this->checkSelectContents($values);

        //SELECT文のVALUESをプレースホルダーで準備
        if (empty($sqlWhereCondition)) {
            $sql = SELECT_CONTACT_LIST_CHECK_NUMBER_OF_DATA;
        } else {
            $sql = "SELECT COUNT(*) FROM contacts WHERE $sqlWhereCondition;";
        }

        //空データで、sql実行前
        $stmt = $this->dbController->prepare($sql);

        //セッションのデータをバインド
        $convertedData = $this->convertData($values);
        if (!empty($convertedData['name'])) {
            $stmt->bindValue(':name', '%' . $convertedData['name'] . '%', PDO::PARAM_STR);
        }
        if (!empty($convertedData['kana'])) {
            $stmt->bindValue(':kana', '%' . $convertedData['kana'] . '%', PDO::PARAM_STR);
        }
        if (!empty($convertedData['mail'])) {
            $stmt->bindValue(':mail', '%' . $convertedData['mail'] . '%', PDO::PARAM_STR);
        }

        //件数取得
        $stmt->execute();
        $countData = $stmt->fetchColumn();
        return $countData;
    }

    /**
     * SELECTで検索
     *
     * @param  integer $page
     * @param  array $values 入力値
     * @return mixed 検索データ、検索数
     */
    public function select(int $page, array $values = [])
    {
        //SQL文のLIMIT,OFFSET条件を選択
        $offset = $this->checkOffsetSql($page);

        //検索値の入力がある場合
        if (!empty($values['name']) || !empty($values['kana']) || !empty($values['mail'])) {
            $sqlWhereCondition = $this->checkSelectContents($values);
            $sql = 'SELECT contact_no,name1,name2,kana1,kana2,mail,created FROM contacts WHERE' . $sqlWhereCondition. $offset['sql'];
        } else {
            $sql = 'SELECT contact_no,name1,name2,kana1,kana2,mail,created FROM contacts' . $offset['sql'];
        }

        //空データで、sql実行前
        $stmt = $this->dbController->prepare($sql);

        //セッションのデータをバインド
        $convertedData = $this->convertData($values);
        if (!empty($convertedData['name'])) {
            $stmt->bindValue(':name', '%' . $convertedData['name'] . '%', PDO::PARAM_STR);
        }
        if (!empty($convertedData['kana'])) {
            $stmt->bindValue(':kana', '%' . $convertedData['kana'] . '%', PDO::PARAM_STR);
        }
        if (!empty($convertedData['mail'])) {
            $stmt->bindValue(':mail', '%' . $convertedData['mail'] . '%', PDO::PARAM_STR);
        }
        if ($offset['offsetValue'] !== 0) {    //オフセット量
            $stmt->bindValue(':offset', $offset['offsetValue'], PDO::PARAM_INT);
        }

        //検索実行
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * 詳細ページでの検索
     *
     * @param  integer $contact_no
     * @return mixed
     */
    public function selectDetailContents(int $contact_no)
    {
        //SELECT文のVALUESをプレースホルダーで準備
        $sql = SELECT_CONTACT_LIST_DETAIL;

        //空データで、sql実行前
        $stmt = $this->dbController->prepare($sql);
        $stmt->bindValue(':contact_no', $contact_no, PDO::PARAM_STR);

        //DBへインサート実行
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * 検索用ワードに分割
     *
     * @param  array $values 入力値
     * @return array bind用値に変換
     */
    private function convertData(array $values)
    {
        // 初期値を空とする
        $convertedValue = [
            'name' => '',
            'kana' => '',
            'mail' => ''
        ];

        foreach ($values as $key => $value) {   //空白があった場合、空白を取り除き、1つの検索文字列とする
            if ($key !== 'mail') {
                if (!empty($value)) {
                    $value = str_replace('　', ' ', $value); //全角の空白を変換する
                    $separate[$key] = explode(' ', $value); //姓名で分けて入力した場合、姓と名を分けて配列に入れる

                    if (!empty($separate[$key][1])) {   //姓名を空白ありで入力した場合
                        $convertedValue[$key] = $separate[$key][0] . $separate[$key][1];
                    } else { //姓名の間に空白がない場合 or 姓のみの入力（カナも）
                        $convertedValue[$key] = $separate[$key][0];
                    }
                }
            } elseif (!empty($values['mail'])) {   //メールの入力があった場合
                $convertedValue['mail'] = $values['mail'];
            }
        }
        return $convertedValue;
    }

    /**
     * 検索時のSQL文のWHERE条件を選択
     *
     * @param  array $values 入力値
     * @return string 入力値から選択されたSQL文
     */
    public function checkSelectContents(array $values)
    {
        $sqlStr = '';
        foreach ($values as $key => $value) {
            if ('name' === $key && !empty($values['name'])) {   //nameに入力がある場合
                $sqlStr .= SELECT_CONTACT_LIST_NAME;
            }
            if ('kana' === $key && !empty($values['kana'])) {   //kanaに入力がある場合
                if (!empty($sqlStr)) {
                    $sqlStr .= ' AND';
                }
                $sqlStr .= SELECT_CONTACT_LIST_KANA;
            }
            if ('mail' === $key && !empty($values['mail'])) {   //mailに入力がある場合
                if (!empty($sqlStr)) {
                    $sqlStr .= ' AND';
                }
                $sqlStr .= SELECT_CONTACT_LIST_MAIL;
            }
        }
        return $sqlStr;
    }

    /**
     * 表示したいページ数に対して、SQL文のLIMIT,OFFSET条件を選択
     *
     * @param  integer $page
     * @return string LIMIT、OFFSETのSQL文を返す
     */
    private function checkOffsetSql(int $page)
    {
        $offset = array();
        $offset['offsetValue'] = ($page -1 ) * DISPLAY_IN_PAGE;

        if ($offset['offsetValue'] !== 0) {
            $offset['sql'] = IS_OFFSET;
        } else {
            $offset['sql'] = NO_OFFSET;
        }
        return $offset;
    }
}