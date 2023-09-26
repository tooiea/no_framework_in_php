<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function index()
    {
        return view('form.index');
    }

    public function confirm(ContactFormRequest $request)
    {
        return view('form.confirm');
    }

    public function complete()
    {
        return view('form.complete');
    }
}
