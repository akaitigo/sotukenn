<link rel="stylesheet" href="/css/submittedShiftEdit.css" type="text/css">
<div class="overlay-navigation">
    <form method="post" action="{{ route('firstsetting') }}" >
        @csrf
        <ul class="navigation_ui">
            <!-- 勤務時間 -->
            <li class="navigation_li1">
                <div class = "nav_work1">
                <a class="WorkText">勤務時間</a><br><br><br><br>
                <div class="selectdiv">
                    <select name="workstarttime" class="WorkTimeStart">
                        <option selected hidden>{{($stores->workstarttime)}}</option>
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
                        <option value="22">22</option>
                        <option value="23">23</option>
                    </select>
                    <a class="Character">～</a>
                    <select name="workendtime" class="WorkTimeEnd">
                        <option selected hidden>{{($stores->workendtime)}}</option>
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
                        <option value="22">22</option>
                        <option value="23">23</option>
                    </select>
                </div>
                </div>
            </li>
            <!-- シフト提出期限 -->
            <li class="navigation_li2">
            <div class = "nav_work2">
                <a class="WorkText">シフト提出期限</a><br><br><br><br>
                <div class="selectdiv">
                    <select name="submissionlimit" class="SubmissionLimit">
                        <option selected hidden>{{($stores->submissionlimit)}}</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <a class="Character">日前まで</a>
                </div>
            </div>
            </li>

            <li class="navigation_li3">
            <div class = "nav_work3">
                <a class="WorkText">投票機能</a><br><br><br><br>
                <div class="block">
                    @if(($stores->vote) == 1)
                    <input name="vote" value="vote" id="cheap" type="checkbox" checked />
                    @else
                    <input name="vote" value="vote" id="cheap" type="checkbox" />
                    @endif
                    <label for="cheap">投票機能を使いますか？</label>
                </div>
            </div>
            <input type="hidden" name="WorkTimeStart">
                <button type="submit" class="btn btn--orange btn--cubic bt--shadow">保存</button>
            </li>
        </ul>
    </form>
</div>

