<link rel="stylesheet" href="/css/#.css" type="text/css">
<title>通知管理</title>
@include('header')

<button class="backButton" onclick="history.back()">戻　る</button>
@csrf
<h2>変更</h2>

<table class="table" border="2">
    <thead>
        <tr>
            <th>通知内容</th>
            <th>対象</th>
            <th>メッセージ</th>
            <th>通知日</th>
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
                <td><input type="text" name="newNotiMessage" placeholder="{{$noti->message}}"></td>
                <td><select id="slc" name="newNotiDay" class="newNotiDay">
                        <option selected hidden>{{($noti->noticeday)}}</option>
                        <option value="0">手動</option>
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
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select></td>

                <td><button type="submit" name="updateId" value="{{$noti->id}}" class="updateButton">更　新</button></td>
                </form>

                <form method="post" action="{{route('noticeDelete')}}">
                    @csrf
                    <td><button type="submit" name="delete" value="{{$noti->id}}" onclick="MoveCheck();" class="deleteButton">削　除</td>
                </form>
            </tr>
        @endforeach
    </tbody>

