<!DOCTYPE html>
<html lang="ja">
    <head>
        <link rel="stylesheet" href="/css/submittedShiftEdit.css" type="text/css">
    </head>
    <body>
        @include('header')
        <div class="multiedit">
        @foreach ($stores as $stores)
            <a>{{ $stores->store_name}}</a>
        @endforeach
        <br>
            <a class="WorkText">勤務時間</a><br>
            <select name="WorkTimeStart" class="WorkTimeStart">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10" selected>10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
            </select><a class="Character"> 時</a>
            <a class="Character">～</a>
            <select name="WorkTimeEnd" class="WorkTimeEnd">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22" selected>22</option>
                <option value="23">23</option>
            </select><a class="Character"> 時</a><br><br>
            
            <a class="ShiftNote">シフトの提出は一ヶ月ごとになります</a><br>
            <br>
            <a class="ShiftText">シフト提出期限</a><br>
            <?php  
                (int)$NextDay = date('t',strtotime('+1 month'));
            ?>

            <select name="SubmissionLimit" class="SubmissionLimit">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20" selected>20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                @if($NextDay == 28)
                <option value="27">27</option>
                @elseif($NextDay == 29)
                <option value="28">28</option>
                <option value="29">29</option>
                @elseif($NextDay ==30)
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                @elseif($NextDay == 31)
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                @endif
            </select>
            <a class="Character">日迄</a><br><br><br>


            <!-- 投票機能 -->
            <a class="VoteSwitch_Text">投票機能</a><br><br>
            <div class="VoteSwitch_btn_cover">
                <div class="VoteSwitch_cover">
                    <div class="VoteSwitch_btn" id="VoteSwitch">
                        <input type='checkbox' class="VoteSwitch_checkbox" checked />
                        <div class="knobs">
                            <span>ON</span>
                        </div>            
                    </div>
                </div>
            </div>
            <br>
            <a href="{{ route('submittedShift') }}" >保存ボタン</a>
        </div>
    </body>
</html>