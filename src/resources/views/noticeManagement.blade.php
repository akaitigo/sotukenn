<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<title>通知管理</title>
@include('header')

@if(!($notices->isEmpty()))
    <h2 class="employeeH2">通知一覧</h2>
        <table class="table" border="2">
            <thead>
                <tr>
                    <th>通知内容</th>
                    <th>対象</th>
                    <th>メッセージ</th>
                    <th>通知日</th>
                    <th>編集</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($notices as $noti)
                <tr>
                    <td>{{ $noti->content}}</td>
                    <td>{{ $noti->target}}</td>
                    <td>{{ $noti->message}}</td>
                    <td>@if(($noti->noticeday) == 0)
                        <a>手動</a>
                        @else
                        {{ $noti->noticeday}}
                        @endif</td>
                    <form method="get" action="{{route('noticeEdit')}}">
                        @csrf
                        <td><button type="submit" name="notiChange" value="{{$noti->id}}">変　更</button></td>
                    </form>
                </tr>
                @endforeach
            </tbody>
        </table>
@endif
