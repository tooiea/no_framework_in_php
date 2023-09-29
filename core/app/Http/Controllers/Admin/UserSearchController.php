<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function userDetail()
    {
        return view('admin.detail');
    }
}
