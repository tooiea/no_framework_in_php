<?php

namespace App\Models;

use App\Constants\FormConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = FormConstant::CONTACT_INSERT_KEY_LIST;

    /**
     * フォームから新規登録
     *
     * @param  array $values
     * @return void
     */
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

    /**
     * 一覧取得(全件)
     *
     * @return Concatct
     */
    public static function getUsers()
    {
        return DB::table('list_view')->paginate(5);
    }

    public static function getUserByQuery($query)
    {
        var_dump($query);
        return DB::table('list_view')->where($query)->paginate(5);
    }
}
