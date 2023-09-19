<?php

class BaseValidator {

    // 入力値
    private $data;
    private $errors = [];
    private $errorMsg = [];

    // 入力値セット
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 継承先でカラムごとにルールをセット
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 各バリデーションルールの基本メッセージをセット
     *
     * @return void
     */
    public function messages()
    {
        return [
            'required' => "{field}を入力してください。",
            'in' => "{field}を画面から選択してください。",
            'max' => "{field}を{maxLength}字以内で入力してください。",
            'regex' => "{field}を正しく入力してください。",
            'integer' => "{field}を正しく入力してください。",
            'email' => "{field}を正しく入力してください。",
            'same' => "{field}が不一致です。",
        ];
    }

    /**
     * 表示用として変換する配列をセット
     *
     * @return void
     */
    public function attributes()
    {
        return [];
    }

    /**
     * バリデーション後のエラー取得
     *
     * @return void
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * 各種カラムでのエラーメッセージを取得
     *
     * @param  string $field
     * @param  string $value
     * @param  string $message
     * @return string
     */
    private function getErrorMsg($field, $value = null, $message)
    {
        return str_replace('{' . $field . '}', $value, $message);
    }

    /**
     * バリデーション:必須入力
     *
     * @param  string $field
     * @param  void $_
     * @return void
     */
    private function required($field, $_)
    {
        if (!isset($this->data[$field]) || empty($this->data[$field]) || is_null($this->data[$field]) || "未選択" === $this->data[$field]) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['required']);
        }
    }

    /**
     * バリデーション:最大文字数
     *
     * @param  string $field
     * @param  int $maxLength
     * @return void
     */
    private function max($field, $maxLength)
    {
        if (isset($this->data[$field]) && mb_strlen($this->data[$field]) > $maxLength) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->getErrorMsg('maxLength', $maxLength, $this->errorMsg['max']));
        }
    }

    /**
     * バリデーション:正規表現
     *
     * @param  string $field
     * @param  string $pattern
     * @return void
     */
    private function regex($field, $pattern)
    {
        if (isset($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['regex']);
        }
    }

    /**
     * バリデーション:リスト
     *
     * @param  string $field
     * @param  array $list
     * @return void
     */
    private function in($field, $list)
    {

        // フィールド名に[]が付いている場合
        $dataKey = (substr($field, -2) == '[]') ? substr($field, 0, -2) : $field;
        if (isset($this->data[$dataKey])) {
            // チェックボックスの場合（配列としての入力）
            if (is_array($this->data[$dataKey])) {
                foreach ($this->data[$dataKey] as $value) {
                    if (!array_key_exists($value, $list)) {
                        $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['in']);
                    }
                }
            } else {
                if (!array_key_exists($this->data[$field], $list)) {
                    $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['in']);
                }
            }
        }
    }

    /**
     * バリデーション:整数
     *
     * @param  string $field
     * @param  void $_
     * @return void
     */
    private function integer($field, $_)
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['integer']);
        }
    }

    /**
     * バリデーション:メールアドレス形式
     *
     * @param  string $field
     * @param  string $_
     * @return void
     */
    private function email($field, $_)
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['mail']);
        }
    }

    /**
     * バリデーション:比較(他キーと同一)
     *
     * @param  string $field
     * @param  string $field2
     * @return void
     */
    private function same($field, $field2)
    {
        if (isset($this->data[$field]) && $this->data[$field] !== $this->data[$field2]) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['same']);
        }
    }

    /**
     * バリデーション実行
     *
     * @return boolean
     */
    public function isValidated()
    {
        $this->errorMsg = $this->messages();
        foreach ($this->rules() as $field => $rules) {
            foreach ($rules as $ruleKey => $ruleValue) {
                // 同一カラム名ですでにエラーとなった場合は、スキップ
                if (isset($this->errors[$field])) {
                    break;
                }

                 if (is_numeric($ruleKey)) {
                    $ruleMethod = $ruleValue;
                    $value = true;
                } else { // ルールがキーとして定義されている場合
                    $ruleMethod = $ruleKey;
                    $value = $ruleValue;
                }

                // ババリデーションルールが存在する場合
                if (method_exists($this, $ruleMethod)) {
                    $this->$ruleMethod($field, $value);
                } else {
                    throw new Exception("Unknown validation rule: $ruleMethod");
                }
            }
        }

        return count($this->errors) === 0;
    }
}