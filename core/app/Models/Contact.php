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

    /**
     * 入力値から検索
     *
     * @param  array $queryParam
     * @return object
     */
    public static function getUserByQuery($queryParam)
    {
        // 検索対象のキー
        $searchKeys = [
            'name',
            'kana',
            'mail'
        ];
        $queryContact = DB::table('list_view');

        // クエリにwhere句をセット
        foreach ($queryParam as $key => $value) {
            if (in_array($key, $searchKeys) && !empty($queryParam[$key])) {
                $queryContact->where($key, 'like', "%$queryParam[$key]%");
            }
        }

        return $queryContact->paginate(5);
    }
}
