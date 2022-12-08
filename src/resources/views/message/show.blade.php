<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/employee.js"></script>
@include('header')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>通知管理</title>
    </head>

    <body>
    @if(!(is_null($empPick)))
        @foreach($empPick as $emp)
            <h2>ユーザー名:{{"$emp->name"}}</h2>
        @endforeach
    @endif

    @if(!(is_null($partPick)))
        @foreach($partPick as $part)
            <h2>ユーザー名:{{"$part->name"}}</h2>
        @endforeach
    @endif



<table class="table" border="2">
    <thead>
        <tr>
            <th>message</th>
            <th>通　知</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($notice as $no)
        <tr>
            <td>{{ $no->message}}</td>
            <td>
                <form method="post"  action="{{ route('message.create', ['lineUserId' => $lineId]) }}">
                @csrf
                <button name="noticeId" value="{{$no->id}}" onclick="NoticeAlart();" class="noticeButton">通知</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



    </body>
</html>
