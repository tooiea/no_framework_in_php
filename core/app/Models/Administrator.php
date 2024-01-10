<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Administrator extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 新規作成、更新日時更新のカラム名をデフォルトから修正
     */
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    /**
     * ユニークなカラムを変更
     *
     * @return void
     */
    public function getAuthIdentifierName()
    {
        return 'login_id';
    }
}
