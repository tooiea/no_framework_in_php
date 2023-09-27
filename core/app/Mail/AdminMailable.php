<?php

namespace App\Mail;

use App\Constants\FormConstant;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminMailable extends BaseMailable
{
    use Queueable, SerializesModels;

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.display_name.admin')),
            subject: config('mail.subject.admin'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'mail.admin',
            with: [
                'values' => $this->getFormatedValues(),
            ],
        );
    }

    /**
     * 本文用の変数に加工
     *
     * @return array
     */
    protected function getFormatedValues()
    {
        $formated = [
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'name' => $this->concatStrings('　', $this->values['name1'], $this->values['name2']),
            'kana' => $this->concatStrings('　', $this->values['kana1'], $this->values['kana2']),
            'sex' => FormConstant::SEX_LIST[$this->values['sex']],
            'age' => FormConstant::AGE_LIST[$this->values['age']],
            'blood_type' => FormConstant::BLOOD_LIST[$this->values['blood_type']] . '型',
            'job' => FormConstant::JOB_LIST[$this->values['job']],
            'zip' => $this->concatStrings('-', $this->values['zip1'], $this->values['zip2']),
            'address12' => $this->concatStrings('', FormConstant::PREFUCTURES_LIST[$this->values['address1']], $this->values['address2']),
            'address3' => $this->values['address3'],
            'tel' => $this->concatStrings('-', $this->values['tel1'], $this->values['tel2'], $this->values['tel3']),
            'mail' => $this->values['mail'],
            'category' => isset($this->values['category']) ? implode("\n", $this->getConvertToLabel($this->values['category'])) : '',
            'info' => $this->values['info'],
        ];
        return $formated;
    }
}
