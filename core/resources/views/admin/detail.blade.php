@php
use App\Constants\FormConstant;
use Carbon\Carbon;

$category = explode(',', $user['category']);
@endphp

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="admin_detail_page">
    <h1>お問い合わせ内容</h1>

    <div class="contents">
        <h2>お問い合せ内容</h2>
        <hr>
        <div class="item conf">
            <div class="label">
                <p>お問い合わせNO</p>
            </div>
            <div class="inputs">
                <p>{{ $user->contact_no }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>お名前</p>
            </div>
            <div class="inputs">
                <p>{{ $user->name1 . '　' . $user->name2 }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>フリガナ</p>
            </div>
            <div class="inputs">
                <p>{{ $user->kana1 . '　' . $user->kana2 }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>性別</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::SEX_LIST[$user['sex']] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>年齢</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::AGE_LIST[$user['age']] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>血液型</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::BLOOD_LIST[$user['blood_type']] . '型' }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>職業</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::JOB_LIST[$user['job']] }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>郵便番号</p>
            </div>
            <div class="inputs">
                <p>{{ $user->zip1 . '-' . $user->zip2 }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>住所</p>
            </div>
            <div class="inputs">
                <p>{{ FormConstant::PREFUCTURES_LIST[$user->address1] }}@if (!empty($user->address2)){{ $user->address2 }}@endif</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>ビル・マンション名</p>
            </div>
            <div class="inputs">
                <p>
                    @if (!empty($user['address3'])) 
                        {{ $user->address3 }}
                    @endif
                </p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>電話番号</p>
            </div>
            <div class="inputs">
                <p>{{ $user->tel }}</p>
            </div>
        </div>

        <div class="item conf">
            <div class="label">
                <p>メールアドレス</p>
            </div>
            <div class="inputs">
                <p>{{ $user->mail }}</p>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>興味のあるカテゴリー</p>
            </div>
            <div class="inputs">
                @if (!empty($user->category))
                <p>
                @foreach ($category as $value)
                    {{ FormConstant::CATEGORY_LIST[$value] }} <br>
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
                <p>{!! nl2br(htmlspecialchars($user->info)) !!}</p>
            </div>
        </div>

        <div class="item">
            <div class="label">
                <p>お問い合わせ時期</p>
            </div>
            <div class="inputs">
                <p>
                {{ Carbon::parse($user->created)->format('Y年n月j日') }} <br>
                {{ Carbon::parse($user->created)->format('H時i分s秒') }}
                </p>
            </div>
        </div>

        <div class="btn_group">
            <form action="{{ route('admin.user_list', $query) }}" method="GET">
                @foreach ($query as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <button type="submit" class="return btn">戻る</button>
            </form>
        </div>
    </div>
    <footer class="footer">

    </footer>
</body>
</html>