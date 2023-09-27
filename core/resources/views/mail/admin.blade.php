{{ $values['time'] }} [{!! $values['name'] !!}] 様より以下のお問い合わせがありました。

---------------------------------
お問い合わせ内容
---------------------------------

■お名前                 {!! $values['name'] !!}

■フリガナ               {!! $values['kana'] !!}

■性別                   {{ $values['sex'] }}

■年齢                   {{ $values['age'] }}

■血液型                 {{ $values['blood_type'] }}

■職業                   {{ $values['job'] }}

■郵便番号               {{ $values['zip'] }}

■住所                   {!! $values['address12'] !!}

■ビル・マンション名     {{ $values['address3'] }}

■電話番号               {{ $values['tel'] }}

■メールアドレス         {{ $values['mail'] }}

■興味のあるカテゴリー   {{ $values['category'] }}

■お問合せ内容           {!! $values['info'] !!}