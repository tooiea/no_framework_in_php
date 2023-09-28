<?php

namespace App\Models;

use App\Constants\FormConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = FormConstant::CONTACT_INSERT_KEY_LIST;

    public function createContact($values)
    {
        // 登録用に配列をセット
        $insertValues = $this->convertValue($values);
        $this->create($insertValues);
    }

    /**
     * 送信用の配列に加工
     *
     * @param  array $values
     * @return array
     */
    private function convertValue($values)
    {
        $insertValues = [];
        foreach (FormConstant::CONTACT_INSERT_KEY_LIST as $key) {
            // カテゴリーの入力があれば、配列から文字列に変換
            if ('category' === $key) {
                $insertValues[$key] = '';
                if (isset($values[$key])) {
                    $insertValues[$key] = implode(',', $values[$key]);
                }
            } elseif ('tel' === $key) {
                $insertValues['tel'] = $values['tel1'] . $values['tel2'] . $values['tel3'];
            } else {
                $insertValues[$key] = $values[$key];
            }
        }
        return $insertValues;
    }

    public static function getUsers()
    {
        return Contact::paginate(10);
    }
}
