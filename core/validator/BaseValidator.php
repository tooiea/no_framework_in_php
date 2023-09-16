<?php

class BaseValidator {

    // 入力値
    private $data;
    private $errors;
    private $errorMsg;

    // 入力値セット
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [
            'required' => "{field}を入力してください。",
            'in' => "{field}を画面から選択してください。",
            'max' => "{field}を{maxLength}字以内で入力してください。",
            'regex' => "{field}を正しく入力してください。",
            'integer' => "{field}を正しく入力してください。",
        ];
    }

    public function attributes()
    {
        return [];
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function getErrorMsg($field, $value = null, $message)
    {
        return str_replace('{' . $field . '}', $value, $message);
    }

    private function required($field, $_)
    {
        if (!isset($this->data[$field]) || empty($this->data[$field]) || is_null($this->data[$field]) || "未選択" === $this->data[$field]) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['required']);
        }
    }

    private function max($field, $maxLength)
    {
        if (isset($this->data[$field]) && mb_strlen($this->data[$field]) > $maxLength) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->getErrorMsg('maxLength', $maxLength, $this->errorMsg['max']));
        }
    }

    private function regex($field, $pattern)
    {
        if (isset($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['regex']);
        }
    }

    private function in($field, $list)
    {

        // フィールド名に[]が付いている場合
        $dataKey = (substr($field, -2) == '[]') ? substr($field, 0, -2) : $field;
        if (isset($this->data[$dataKey])) {
             var_dump($this->data[$field]);
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


    private function integer($field, $_)
    {

        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
            $this->errors[$field] = $this->getErrorMsg('field', $this->attributes()[$field], $this->errorMsg['integer']);
        }
    }


    public function isValidated()
    {
        $this->errorMsg = $this->messages();
        foreach ($this->rules() as $field => $rules) {
            foreach ($rules as $ruleKey => $ruleValue) {
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