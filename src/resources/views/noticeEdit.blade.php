<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/notice.js"></script>
<title>通知管理</title>
@include('header')

<button class="backButton" onclick="history.back()">戻　る</button>
@csrf
<h2>通知変更</h2>

<table class="table" border="2">
    <thead>
        <tr>
            <th>通知内容</th>
            <th>対象</th>
            <th class="noticeManagementmessage">メッセージ</th>
            <th>&nbsp;通知日&nbsp;</th>
            <th>更新</th>
            <th>削除</th>
        </tr>
    </thead>

    <tbody>
        <form method="post" action="{{route('noticeUpdate')}}">
        @csrf
        @foreach ($notices as $noti)
            <tr>
                <td><input type="text" name="newNotiContent" placeholder="{{ $noti->content}}"></td>
                <td><input type="text" name="newNotiTarget" placeholder="{{$noti->target}}"></td>
                <td><input type="text" name="newNotiMessage" placeholder="{{$noti->message}}" class="noticeManagementmessage"></td>
                <td><select id="slc" name="newNotiDay" class="notiday">
                        <option selected hidden>
                            @if(($noti->noticeday) == 0)
                                手動
                            @else
                                {{($noti->noticeday)}}
                            @endif
                        </option>
                        <option value="0">手動</option>
                        <option value="1">1日</option>
                        <option value="2">2日</option>
                        <option value="3">3日</option>
                        <option value="4">4日</option>
                        <option value="5">5日</option>
                        <option value="6">6日</option>
                        <option value="7">7日</option>
                        <option value="8">8日</option>
                        <option value="9">9日</option>
                        <option value="10">10日</option>
                        <option value="11">11日</option>
                        <option value="12">12日</option>
                        <option value="13">13日</option>
                        <option value="14">14日</option>
                        <option value="15">15日</option>
                        <option value="16">16日</option>
                        <option value="17">17日</option>
                        <option value="18">18日</option>
                        <option value="19">19日</option>
                        <option value="20">20日</option>
                        <option value="21">21日</option>
                        <option value="22">22日</option>
                        <option value="23">23日</option>
                        <option value="24">24日</option>
                        <option value="25">25日</option>
                        <option value="26">26日</option>
                        <option value="27">27日</option>
                        <option value="28">28日</option>
                        <option value="29">29日</option>
                        <option value="30">30日</option>
                        <option value="31">31日</option>
                    </select></td>
                    <script>
                var slc_elm = document.querySelector("#slc");
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
                </script>
                <td><button type="submit" name="updateId" value="{{$noti->id}}" class="updateButton">更　新</button></td>
                </form>

                <form method="post"  action="{{route('noticeManagementDelete')}}" onSubmit="return DeleteCheck()">
                    @csrf
                    <td><button id="deleteid" type="submit" name="deleteid" value="{{$noti->id}}" class="deleteButton">削　除</td>
                </form>
            </tr>
        @endforeach
    </tbody>

