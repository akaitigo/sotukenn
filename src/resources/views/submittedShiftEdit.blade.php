<link rel="stylesheet" href="/css/submittedShiftEdit.css" type="text/css">
<script type="text/javascript" src="/js/firstsetting.js"></script>
<div class="overlay-navigation">
    <form method="post" action="{{ route('firstsetting') }}" >
        @csrf
        <ul class="navigation_ui">
            <!-- 勤務時間 -->
            <li class="navigation_li1">
                <div class = "nav_work1">
                <a class="WorkText">勤務時間</a><br><br><br><br>
                <div class="selectdiv">
                    <select id="slc" name="workstarttime" class="workstarttime">
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
                    <select id="slce" name="workendtime" class="workendtime">
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
            <script>
                var slc_elm = document.querySelector("#slc");
                slc_elm.addEventListener("focus",function(elm){
                    if(elm.currentTarget.options.length >=11){
                        elm.currentTarget.size = "10";
                    }
                }, false)

                slc_elm.addEventListener("blur",function(elm){
                    elm.currentTarget.size = "1";
                }, false)

                slc_elm.addEventListener("change",function(elm){
                    elm.currentTarget.blur();
                }, false)

                var slce_elm = document.querySelector("#slce");
                slce_elm.addEventListener("focus",function(elm){
                    if(elm.currentTarget.options.length >=11){
                        elm.currentTarget.size = "10";
                    }
                }, false)

                slce_elm.addEventListener("blur",function(elm){
                    elm.currentTarget.size = "1";
                }, false)

                slce_elm.addEventListener("change",function(elm){
                    elm.currentTarget.blur();
                }, false)

            </script>
            <!-- シフト提出期限 -->
            <li class="navigation_li2">
            <div class = "nav_work2">
                <a class="WorkText">シフト提出期限</a><br><br><br><br>
                <div class="selectdiv">
                    <select name="submissionlimit" class="submissionlimit" required>
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
                    <input name="vote" class="vote" value="vote" id="cheap" type="checkbox" checked />
                    @else
                    <input name="vote" class="vote" value="vote" id="cheap" type="checkbox" />
                    @endif
                    <label for="cheap">投票機能を使いますか？</label>
                </div>
            </div>
            <input type="hidden" name="WorkTimeStart">
            <label>
                <input type="submit" class="hide_vote">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
</svg>            </label>
            </li>
        </ul>
    </form>
</div>

