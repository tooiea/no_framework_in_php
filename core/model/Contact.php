<?php

require_once(dirname(__FILE__) . '/Model.php');

class Contact extends Model {

    protected $table = 'contacts';

    /**
     * バインドリスト
     *
     * @var array
     */
    protected $bindList = [
        'name1' => ':name1',
        'name2' => ':name2',
        'kana1' => ':kana1',
        'kana2' => ':kana2',
        'sex' => ':sex',
        'age' => ':age',
        'blood_type' => ':blood_type',
        'job' => ':job',
        'zip1' => ':zip1',
        'zip2' => ':zip2',
        'address1' => ':address1',
        'address2' => ':address2',
        'address3' => ':address3',
        'tel' => ':tel',
        'mail' => ':mail',
        'category' => ':category',
        'info' => ':info',
        'created' => ':created',
        'modified' => ':modified'
    ];

    /**
     * 整数として扱うリスト
     *
     * @var array
     */
    private $intList = [
        'sex',
        'age',
        'blood_type',
        'job',
        'zip1',
        'zip2',
        'address1'
    ];

    /**
     * 登録
     * @param  array $values 登録する値
     * @return bool|object アクセス、登録までできた場合object,失敗時はbool
     */
    public function insert(array $values) {
        // INSERT文のVALUESをステークホルダーで置換するSQLを取得
        $stmt = $this->prepare($this->getInsertLine());

        // 入力値を整数値、文字列で型を指定しバインド
        foreach ($values as $key => $value) {
            if (array_key_exists($key, $this->bindList)) {
                if (in_array($key, $this->intList)) {
                    $stmt->bindValue($this->bindList[$key], (int)$value, PDO::PARAM_INT); // int型にキャスト
                } else {
                    $stmt->bindValue($this->bindList[$key], $value, PDO::PARAM_STR);
                }
            }
        }

        // インサート実行
        $result = $stmt->execute();

        // インサート失敗
        if (!$result) {
            return new throwable();
        }

        return $result;
    }

    /**
     * インサート文を加工
     * ステークホルダーをインサート文内に組み立てる
     *
     * @return string
     */
    private function getInsertLine()
    {
        $insertFirst = 'INSERT INTO ' . $this->table . ' (';
        $insertValue = 'VALUES (';

        foreach ($this->bindList as $key => $bindValue) {
            $lastKey = array_key_last($this->bindList);

            if ($key == $lastKey) {
                $insertFirst .= $key . ') ';
                $insertValue .= $bindValue . '); ';
            } else {
                $insertFirst .= $key . ', ';
                $insertValue .= $bindValue . ', ';
            }
        }

        return $insertFirst . $insertValue;
    }

    public function getContacts()
    {
        
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