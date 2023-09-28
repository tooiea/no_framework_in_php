<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function userList(Request $request)
    {
        $query = $request->query();
        var_dump($request->query());

        $users = [];

        if (empty($query)) {
            $users = Contact::getUsers();
        }

        return view('admin.list', compact('users', 'query'));
    }

    public function userDetail()
    {
        return view('admin.detail');
    }
}
