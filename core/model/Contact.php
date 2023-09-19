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
}