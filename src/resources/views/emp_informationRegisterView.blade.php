<link rel="stylesheet" href="/css/emp_box.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/js/registerpopup.js"></script>
@include('emp_header')
<div class="emp_box">
    <title>業務情報共有掲示板</title>
    <div id='container'>
        {{-- <div class='widget'>
            <h2 class="sharetitle">掲示内容登録</h2>
            <h3>こちらで掲示板に掲載する内容を登録することができます。下記注意事項をお読みになってご利用ください。</h3><br />
            <h3 class="attention">掲示板に登録される期間は最大で15日となっております。<br />
                登録と同時にMARUOKUN公式ラインに登録している対象者に通知されます。通知は一度のみ行われます<br />
                掲示内容はすべて管理者が閲覧することができます。人が不愉快になる内容は書き込まないでください。
            </h3>




            <form method="post" action="{{ route('emp_informationRegisterInput') }}"
                onsubmit="return registerCheck();">
                @csrf
                <h2 class="label-title">掲示内容登録</p>
                    <div class="inforForm">
                        <p class="form-label">掲示期間</p>
                        <input type="text" class="form-input" name="days" required placeholder="例）10(最大15日まで)">
                    </div>
                    <div class="inforForm">
                        <p class="form-label">掲示名</p>
                        <input type="text" class="form-input-name" name="sharename" required maxlength="30"
                            placeholder="(最大30文字まで)">
                    </div>
                    <div class="inforForm">
                        <p class="form-label">掲示内容</p>
                        <textarea class="inputText" name="massage" maxlength="250" rows="10" placeholder="(最大250文字まで)"
                            style="font-family:Yu Gothic"></textarea>
                    </div>

                    <button type="submit" name="registerUser"
                        value="{{ $user->email }}"class="updateButton">登録</button>


            </form>
        </div> --}}
        <form method="post" action="{{ route('emp_informationRegisterInput') }}" onsubmit="return registerCheck();">
            <!--  General -->
            @csrf
            <div class="form-group">
                <h2 class="heading">記載タイトル</h2>
                <div class="controls">
                    <input type="text" id="name" class="floatLabel" name="sharename" placeholder="タイトル">
                    
                </div>
            </div>
            <!--  Details -->
            <div class="form-group">
                <h2 class="heading">掲載期間</h2>
                <div class="grid">
                    <div class="col-1-4 col-1-4-sm">
                        <div class="controls">
                            <input type="date" id="arrive" class="floatLabel" name="days"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>



                <div class="grid">
                    <br>
                    <div class="controls">
                        <textarea name="massage" class="floatLabel" id="comments" maxlength="250" rows="10" placeholder="(最大250文字まで)"></textarea>
                    </div>
                    <button type="submit" name="registerUser" value="{{ $user->email }}" class="col-1-4">送信</button>
                </div>
            </div> <!-- /.form-group -->
        </form>
    </div>
    <link rel="stylesheet" href="/css/test.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
    <script type="text/javascript" src="/js/test.js"></script>
</div>
