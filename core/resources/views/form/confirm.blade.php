<?php
use App\Constants\FormConstant;

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="confirm_page">
    <h1>お問合せ内容の確認</h1>
    <div class="contents">
        <div class="info">
            <p>以下の内容でよろしければ「送信する」ボタンを押してください。</p>
            <p>修正する場合は「戻る」ボタンを押して入力画面へお戻りください。</p>
        </div>

        <h2>お問い合せ内容</h2>
        <hr>

        <div class="item conf">
            <div class="label">
                <p>お名前</p>
            </div>
            <div class="inputs">
                <p>{{ $values['name1'] . '　' .$values['name2'] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p>{{ $values['kana1'] . '　' .$values['kana2'] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::SEX_LIST[$values['sex']] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::AGE_LIST[$values['age']] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::BLOOD_LIST[$values['blood_type']] . '型' }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::JOB_LIST[$values['job']] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>郵便番号</p>
            </div>
            <div class="inputs">
                <p>{{ $values['zip1'] . '-' . $values['zip2'] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>住所</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::PREFUCTURES_LIST[$values['address1']] . $values['address2'] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>ビル・マンション名</p>
            </div>
            <div class="inputs">
                <p>@if (!empty($values['address3'])){{ $values['address3'] }}@endif</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>電話番号</p>
            </div>
            <div class="inputs">
                <p>{{ $values['tel1'] . '-' . $values['tel2'] . '-' . $values['tel3'] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>メールアドレス</p>
            </div>
            <div class="inputs">
                <p>{{ $values['mail'] }}</p>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>興味のあるカテゴリー</p>
            </div>
            <div class="inputs">
                @if (isset($values['category']))
                <p>
                @foreach ($values['category'] as $cval)
                    {{ FormConstant::CATEGORY_LIST[$cval] }}
                    <br>
                @endforeach
                </p>
                @endif
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>お問い合わせ内容</p>
            </div>
            <div class="inputs">
                <p>{!! nl2br(e($values['info'])) !!}</p>
            </div>
        </div>

        <div class="btn_group">
            <form action="{{ route('form.back') }}" method="POST">
                @csrf
                <button type="submit" name="submit" class="return btn">戻る</button>
            </form>

            <form action="{{ route('form.complete') }}" method="POST">
                @csrf
                <button type="submit" name="submit" class="next btn">送信する</button>
            </form>
        </div>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>