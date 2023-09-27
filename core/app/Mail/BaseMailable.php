<?php

namespace App\Mail;

use App\Constants\FormConstant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BaseMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * 入力値
     *
     * @var array
     */
    protected $values;

    /**
     * Create a new message instance.
     */
    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Base Mailable',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * 本文加工用変数
     *
     * @return void
     */
    protected function getFormatedValues()
    {
        return [];
    }

    /**
     * 文字列結合
     *
     * @param  string $separater
     * @param  string $value
     * @param  string $value2
     * @param  string $value3
     * @return string
     */
    protected function concatStrings($separater, $value, $value2, $value3 = null)
    {
        $concatedString = '';
        if (is_null($value3)) {
            $concatedString = $value . $separater . $value2;
        } else {
            $concatedString = $value . $separater . $value2 . $separater . $value3;
        }
        return $concatedString;
    }

    /**
     * カテゴリーをラベルに変換
     *
     * @param  array $values
     * @return array
     */
    protected function getConvertToLabel($values)
    {
        $category = [];
        foreach ($values as $key) {
            $category[] = FormConstant::CATEGORY_LIST[$key];
        }
        return $category;
    }
}
