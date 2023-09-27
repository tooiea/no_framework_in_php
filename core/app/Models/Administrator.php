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
     * ユニークなカラムを変更
     *
     * @return void
     */
    public function getAuthIdentifierName()
    {
        return 'login_id';
    }
}
