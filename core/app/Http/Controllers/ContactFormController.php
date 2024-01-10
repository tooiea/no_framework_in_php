<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Exceptions\MailerException;
use App\Http\Requests\ContactFormRequest;
use App\Mail\AdminMailable;
use App\Mail\CustomerMailable;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    /**
     * 入力画面
     *
     * @return void
     */
    public function index()
    {
        return view('form.index');
    }

    /**
     * 確認画面
     *
     * @param  ContactFormRequest $request
     * @return void
     */
    public function confirm(ContactFormRequest $request)
    {
        // 入力値のみセット(不要なキーまで入らないように)
        $values = $request->only(FormConstant::SESSION_KEY_LIST);

        // セッションに保存(別画面で取得するため)
        session(['contact_form' => $values]);
        return view('form.confirm', compact('values'));
    }

    /**
     * 完了画面
     *
     * @return void
     */
    public function complete(Request $request)
    {
        // セッションなし
        if (!$request->session()->has('contact_form')) {
            return redirect()->route('form.index');
        }

        // 入力値取得
        $values = $request->session()->pull('contact_form');
        
        // 不要なカラムを削除
        unset($values['mail2']);

        try {
            // DB登録
            DB::beginTransaction();
            $contactModel = new Contact();
            $contactModel->createContact($values);

            // メール送信
            $customerResult = Mail::to(config('mail.from.address'))->send(new CustomerMailable($values));
            $adminResult = Mail::to(config('mail.from.address'))->send(new AdminMailable($values));

            // メール送信結果確認
            if (is_null($customerResult) || is_null($adminResult)) {
                throw new MailerException;
            }
            DB::commit();

            // 成功用メッセージ
            $msgHeader = __('message.form.success.header');
            $msgBody = __('message.form.success.body');
        } catch (MailerException $th) {
            Log::error($th->getMessage());
            DB::rollBack();
            $msgHeader = __('message.form.error.mail.header');
            $msgBody = __('message.form.error.mail.body');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            $msgHeader = __('message.error.500.header');
            $msgBody = __('message.error.500.body');
        }

        // 表示用メッセージ
        $request->session()->flash('complete_header', $msgHeader);
        $request->session()->flash('complete_body', $msgBody);
        return view('form.complete');
    }
}
