<link rel="stylesheet" href="/css/test.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<form action="">
    <!--  General -->
    <div class="form-group">
        <h2 class="heading">記載タイトル</h2>
        <div class="controls">
            <input type="text" id="name" class="floatLabel" name="name">
            <label for="name">タイトル</label>
        </div>
    </div>
    <!--  Details -->
    <div class="form-group">
        <h2 class="heading">掲載期間</h2>
        <div class="grid">
            <div class="col-1-4 col-1-4-sm">
                <div class="controls">
                    <input type="date" id="arrive" class="floatLabel" name="arrive" value="<?php echo date('Y-m-d'); ?>">
                    <label for="arrive" class="label-date"><i class="fa fa-calendar"></i>&nbsp;&nbsp;期間</label>
                </div>
            </div>
        </div>



        <div class="grid">
            <br>
            <div class="controls">
                <textarea name="comments" class="floatLabel" id="comments"></textarea>
                <label for="comments">詳細</label>
            </div>
            <button type="submit" value="Submit" class="col-1-4">送信</button>
        </div>
    </div> <!-- /.form-group -->
</form>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
<script type="text/javascript" src="/js/test.js"></script>
