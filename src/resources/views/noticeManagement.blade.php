<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/search.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<title>通知管理</title>
@include('new_header')
<div id="scale">
    @if (!$notices->isEmpty())
        <div id='container'>
            <div class='widget'>
                <div class="tab-content" href="#tab1">
                    <table class="group-table">
                        <caption>通知一覧</caption>
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
                                    <td>{{ $noti->content }}</td>
                                    <td>{{ $noti->target }}</td>
                                    <td>{{ $noti->message }}</td>
                                    <td>
                                        @if ($noti->noticeday == 0)
                                            <a>手動</a>
                                        @else
                                            {{ $noti->noticeday }}
                                        @endif
                                    </td>
                                    <form method="get" action="{{ route('noticeEdit') }}">
                                        @csrf
                                        <td><button type="submit" name="notiChange"
                                                value="{{ $noti->id }}">変　更</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="center">
                <a href="{{ route('noticeAdd') }}" id="sbtn_a" style="display:inline-block;">追加</a>
            </div>
        </div>
    @endif
</div>

