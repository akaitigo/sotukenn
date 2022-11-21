<link rel="stylesheet" href="/css/setting.css" type="text/css">
<div class="overlay-navigation">
    <nav role="navigation">
        <ul class="navigation_ui">
            <!-- 勤務時間 -->
            <li class="navigation_li">
                <a class="WorkText">勤務時間</a><br>
                <div class="selectdiv">
                    <select name="WorkTimeStart" class="WorkTimeStart">
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
                    </select>
                </div>
            </li>
            <!-- シフト提出期限 -->
            <li class="navigation_li">
                <a class="WorkText">シフト提出期限</a><br>
                <div class="selectdiv">
                    <select name="SubmissionLimit" class="SubmissionLimit">
                        
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
                    <input data-index="0" id="cheap" type="checkbox" />
                    <label for="cheap">投票機能を使いますか？</label>
                </div>
            </li>
        </ul>
    </nav>
</div>

<section class="home">
    <div id="setting"  class="open-overlay">
        <img src="/img_submit/setting.png" width="100%">
    </div>
    <div id="setting2"  class="open-overlay2" style="display: none">
        <img src="/img_submit/setting.png" width="100%">
    </div>
</section>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/jquery.ui.min.js"></script>

<script type="text/javascript" src="/js/setting.js"></script>

