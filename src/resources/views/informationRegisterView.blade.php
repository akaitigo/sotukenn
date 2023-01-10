<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/search.css" type="text/css">
<link rel="stylesheet" href="/css/pagenation.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('new_header')

<div id="scale">
    <button class="backButton" onclick="history.back()">戻　る</button>
    <title>業務情報共有掲示板</title>
    <div id='container'>
        <div class='widget'>
            <h2>掲示内容登録</h2>
            <h3>こちらで掲示板に掲載する内容を登録することができます。下記注意事項をお読みになってご利用ください。</h3><br />
            <h3 class="attention">掲示板に登録される期間は最大で15日となっております。<br />
                登録と同時にMARUOKUN公式ラインに登録している対象者に通知されます。通知は一度のみ行われます<br />
                掲示内容はすべて管理者が閲覧することができます。人が不愉快になる内容は書き込まないでください。
            </h3>




            <form method="post" action="{{ route('informationRegisterInput') }}">
            <h2 class="label-title">掲示内容登録</p>
                <div class="inforForm">
                    <p class="form-label">氏名</p>
                    <input type="text" class="form-input" name="username" required placeholder="例）鈴木一郎">
                </div>
                <div class="inforForm">
                    <p class="form-label">掲示期間</p>
                    <input type="text" class="form-input" name="deys" required placeholder="例）10(最大15日まで)">
                </div>
                <div class="inforForm">
                    <p class="form-label">掲示名</p>
                    <input type="text" class="form-input-name" name="sharename" required maxlength="30"
                        placeholder="(最大30文字まで)">
                </div>
                <div class="inforForm">
                    <p class="form-label">掲示内容</p>
                    <textarea class="inputText" name="message" name="sharetext" maxlength="250" rows="10" placeholder="(最大250文字まで)"
                        style="font-family:Yu Gothic"></textarea>
                </div>

                <button type="submit" name="registerUser" value="{{$user->email}}" class="updateButton">登録</button>


                </form>
