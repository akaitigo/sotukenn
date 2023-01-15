<link rel="stylesheet" href="/css/emp_box.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/js/registerpopup.js"></script>
@include('emp_header')
<div class="emp_box">
    <title>業務情報共有掲示板</title>
    <div id='container'>
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
    <link rel="stylesheet" href="/css/emp_info.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
    <script type="text/javascript" src="/js/emp_info.js"></script>
</div>
