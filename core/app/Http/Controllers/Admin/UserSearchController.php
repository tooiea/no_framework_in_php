<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailRequest;
use App\Http\Requests\UserSearchRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    /**
     * ユーザ一覧表示
     *
     * @param  Request $request
     * @return void
     */
    public function userList(UserSearchRequest $request)
    {
        $query = $request->query();
        unset($query['submit']); // ボタン削除
        $users = [];

        // 全件取得
        if (empty($query)) {
            $users = Contact::getUsers();
        } else {
            // 検索値入力あり
            $users = Contact::getUserByQuery($query);
            $users->appends($query);
        }

        return view('admin.list', compact('users', 'query'));
    }

    /**
     * ユーザ情報詳細
     *
     * @param  UserDetailRequest $request
     * @param  int $id
     * @return void
     */
    public function userDetail(UserDetailRequest $request, $id)
    {
        // 対象のユーザ情報を取得
        $query = $request->only(['name', 'kana', 'mail']);
        $user = Contact::query()->where('contact_no', $id)->first();
        return view('admin.detail', compact('user', 'query'));
    }
}
