<ul class="navigation_ui">
    <!-- 勤務時間 -->
    <li class="navigation_li">
        <a class="WorkText">勤務時間</a><br>
        <div class="selectdiv">
            <select name="workstarttime" v-model="WorkTimeStart" >
                <option selected hidden></option>
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
            <select name="workendtime" v-model="WorkTimeEnd">

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
            </select>
        </div>
    </li>
    <!-- シフト提出期限 -->
    <li class="navigation_li">
        <a class="WorkText">シフト提出期限</a><br>
        <div class="selectdiv">
            <select name="submissionlimit" v-model="SubmissionLimit">

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
    </li>
    <!-- 投票機能 -->
    <li class="navigation_li">
        <a class="WorkText">投票機能</a>
        <div class="block">
            <input name="vote" value="vote" id="cheap" type="checkbox" v-model="vote"/>
            <label for="cheap">投票機能を使いますか？</label>
        </div>
    </li>
</ul>
<button type="submit" id="test">
    {{ __('次へ') }}
</button>
<script type="text/javascript" src="/js/test.js"></script>
