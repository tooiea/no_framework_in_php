<?php

require_once(dirname(__FILE__) . '/Model.php');

class Contact extends Model {

    protected $table = 'contacts';

    protected $columns = [
        'name1',
        'name2',
        'kana1',
        'kana2',
        'sex',
        'age',
        'blood_type',
        'job',
        'zip1',
        'zip2',
        'address1',
        'address2',
        'address3',
        'tel1',
        'tel2',
        'tel3',
        'mail',
        'category',
        'info'
    ];

    protected $bindList = [
        'contact_no' => 0,
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

    private $intList = [
        'sex',
        'age',
        'blood_type',
        'job',
        'address1'
    ];

    /**
     * テーブルにデータを登録する
     * @param array $values 登録する値
     * @return bool|object アクセス、登録までできた場合object,失敗時はbool
     */
    public function insert(array $values) {
        //INSERT文のVALUESをステークホルダーで準備INSERT_FORM
        $sql = $this->getInsertLine();
        var_dump($sql);

        //空データで、sql実行前
        $stmt = $this->prepare($sql);

        // 入力値をバインドし
        foreach ($values as $key => $value) {
            if (array_key_exists($key, $this->bindList)) {
                if (in_array($key, $this->intList)) {
                    $stmt->bindValue($this->bindList[$key], (int)$value, PDO::PARAM_INT); //int型にキャスト
                } else {
                    $stmt->bindValue($this->bindList[$key], $value, PDO::PARAM_STR);
                }
            }
        }

        //DBへインサート実行
        // $result = $stmt->execute();

        return $result;
    }

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
}