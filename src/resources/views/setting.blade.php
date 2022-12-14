<?php $data = file_get_contents('php://input');
$stores = json_decode($data);
?>
<link rel="stylesheet" href="/css/setting.css" type="text/css">
<form  method="post" >
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="overlay-navigation">
        <nav role="navigation">
            <ul class="navigation_ui">
                <!-- 勤務時間 -->
                <li class="navigation_li">
                    <a class="WorkText">勤務時間</a><br><br><br><br>
                    <div class="selectdiv">
                        <select id="WorkTimeStart" name="WorkTimeStart" class="WorkTimeStart">
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
                        <a>～</a>
                        <select id="WorkTimeEnd" name="WorkTimeEnd" class="WorkTimeEnd">
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
                </li>
                <script>
                var slc_elm = document.querySelector("#WorkTimeStart");
                slc_elm.addEventListener("focus",function(elm){
                    if(elm.currentTarget.options.length >=8){
                        elm.currentTarget.size = "7";
                    }
                }, false)

                slc_elm.addEventListener("blur",function(elm){
                    elm.currentTarget.size = "1";
                }, false)

                slc_elm.addEventListener("change",function(elm){
                    elm.currentTarget.blur();
                }, false)

                var slce_elm = document.querySelector("#WorkTimeEnd");
                slce_elm.addEventListener("focus",function(elm){
                    if(elm.currentTarget.options.length >=8){
                        elm.currentTarget.size = "7";
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
                <li class="navigation_li">
                    <a class="WorkText">シフト提出期限</a><br><br><br><br>
                    <div class="selectdiv">
                        <select id="SubmissionLimit" name="SubmissionLimit" class="SubmissionLimit">
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
                    <a class="WorkText">投票機能</a><br><br><br><br>
                    <div class="block">
                        <input value="vote" class="votecheck" id="cheap" type="checkbox"/>
                        <label for="cheap" class="vote">投票機能を使いますか？</label>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <section class="home">
        <div id="setting" class="open-overlay">
            <img type=submit name="add" src="/img_submit/setting2.png" width="110%">
        </div>
    </section>
</form>


<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/jquery.ui.min.js"></script>

<script type="text/javascript" src="/js/setting.js"></script>
