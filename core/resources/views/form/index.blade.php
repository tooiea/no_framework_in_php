<?php
use App\Constants\FormConstant;
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="form_page">
    <div class="contents">
        <h1>お問合せフォーム</h1>

        <form action='{{ route('form.confirm') }}' method="POST">
            @csrf
            <div class="item">
                <label for="name1" class="label">お名前：姓<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="name1" id="name1" value="{{ old('name1') }}">
                    @error('name1')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="name2" class="label">お名前：名<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="name2" id="name2" value="{{ old('name2') }}">
                    @error('name2')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="kana1" class="label">フリガナ：セイ<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="kana1" id="kana1" value="{{ old('kana1') }}">
                    @error('kana1')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="kana2" class="label">フリガナ：メイ<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="kana2" id="kana2" value="{{ old('kana2') }}">
                    @error('kana2')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="sex" class="label">性別<span>*</span></label>
                <div class="inputs">
                    @foreach (FormConstant::SEX_LIST as $key => $value)
                    <label>
                        <input type="radio" name="sex" id="sex" value="{{ $key }}" @if (!empty(old('sex'))) {{ $key === (int)old('sex') ? 'checked' : '' }} @endif><?php echo $value ?>
                    </label>
                    @endforeach
                    @error('sex')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="age" class="label">年齢<span>*</span></label>
                <div class="inputs">
                    <select name="age" id="age" >
                        <option hidden value="">未選択</option>
                        {{old('age')}}
                        @foreach (FormConstant::AGE_LIST as $key => $value)
                        <option value="{{ $key }}" @if (!empty(old('age'))) {{ $key === (int)old('age') ? 'selected' : '' }} @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('age')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="blood_type" class="label">血液型<span>*</span></label>
                <div class="inputs">
                    @foreach (FormConstant::BLOOD_LIST as $key => $value)
                        <label><input type="radio" name="blood_type" id="blood_type" value="{{ $key }}" @if (!empty(old('blood_type'))) {{ $key === (int)old('blood_type') ? 'checked' : '' }} @endif>{{ $value }}</label>
                    @endforeach
                    @error('blood_type')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="job" class="label">職業<span>*</span></label>
                <div class="inputs">
                    <select name="job" id="job">
                        <option hidden value="">未選択</option>
                        @foreach (FormConstant::JOB_LIST as $key => $value)
                        <option value="{{ $key }}" @if (!empty(old('job'))) {{ $key === (int)old('job') ? 'selected' : '' }}  @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('job')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="zip1" class="label">郵便番号（上）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="zip1" id="zip1" value="{{ old('zip1') }}">
                    @error('zip1')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="zip2" class="label">郵便番号（下）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="zip2" id="zip2" value="{{ old('zip2') }}">
                    @error('zip2')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="address1" class="label">都道府県<span>*</span></label>
                <div class="inputs">
                    <select name="address1" id="address1">
                        <option hidden value="">未選択</option>
                        @foreach (FormConstant::PREFUCTURES_LIST as $key => $value)
                            <option value="{{ $key }}"@if(!empty(old('address1'))) {{ $key === (int)old('address1') ? 'selected' : '' }} @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('address1')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div class="item">

            <div class="item">
                <label for="address2" class="label">住所<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="address2" id="address2" value="{{ old('address2') }}">
                    @error('address2')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="address3" class="label">ビル・マンション名</label>
                <div class="inputs">
                    <input type="text" name="address3" id="address3" value="{{ old('address3') }}">
                    @error('address3')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="tel1" class="label">電話番号<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="tel1" id="tel1" value="{{ old('tel1') }}">
                    <input type="text" name="tel2" id="tel2" value="{{ old('tel2') }}">
                    <input type="text" name="tel3" id="tel3" value="{{ old('tel3') }}">
                    @if (!empty($errors->get('tel1')))
                    <p class="error_msg">{{ $errors->get('tel1')[0] }}</p>
                    @elseif (!empty($errors->get('tel2')))
                    <p class="error_msg">{{ $errors->get('tel2')[0] }}</p>
                    @elseif (!empty($errors->get('tel3')))
                    <p class="error_msg">{{ $errors->get('tel3')[0] }}</p>
                    @endif
                </div>
            </div>

            <div class="item">
                <label for="mail" class="label">メールアドレス<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="mail" id="mail" value="{{ old('mail') }}">
                    @error('mail')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="mail2" class="label">メールアドレス<br>（確認用）<span>*</span></label>
                <div class="inputs">
                    <input type="text" name="mail2" id="mail2" value="{{ old('mail2') }}">
                    @error('mail2')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="category" class="label">興味のあるカテゴリー<br>（複数選択可）</label>
                <div class="inputs category">
                    @foreach (FormConstant::CATEGORY_LIST as $key => $value)
                        <label><input type="checkbox" name="category[]" id="category" value="{{ $key }}" @if (!empty(old('category'))) {{ in_array($key, old('category')) ? 'checked' : '' }} @endif>{{ $value }}</label>
                    @endforeach
                    @error('category.*')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item">
                <label for="info" class="label">お問合せ内容<span>*</span></label>
                <div class="inputs">
                    <textarea name="info" id="info" cols="50" rows="10">{{ old('info') }}</textarea>
                    </p>
                    @error('info')<p class="error_msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="item submit">
                <button type="submit" name="submit">入力内容を確認する</button>
            </div>
        </form>
    </div>
</body>

</html>