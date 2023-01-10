<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/search.css" type="text/css">
<link rel="stylesheet" href="/css/pagenation.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/deletepopup.js"></script>

@include('new_header')

<div id="scale">
    <title>業務情報共有掲示板</title>
    <div id='container'>
        <div class='widget'>
            <div id='正社員' class="tab-content" href="?tab1">
                <a href="{{ route('informationShare-register') }}" class="registerButton">通知登録</a>
                <table class="group-table">

                    <caption>掲示一覧</caption>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>登録日</th>
                            <th>提示名</th>
                            <th>掲示内容</th>
                            <th>掲示登録者</th>
                            <th>掲示期間</th>
                            <th>削除</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($information as $info)
                            <tr>
                                <td>{{ $info->shareId }}</td>
                                <td>{{ $info->registrationDate }}</td>
                                <td>{{ $info->shareContent }}</td>
                                <td>{{ $info->shareText }}</td>
                                <td>{{ $info->registerUser }}</td>
                                <td>{{ $info->daysRemaining }}</td>

                                <form method="post" action="{{ route('informationDelete') }}"
                                    onsubmit="return DeleteCheck();">
                                    @csrf
                                    <td class="empbtn"><button type="submit" name="delete"
                                            value="{{ $info->shareId }}" class="deleteButton">削　除</td>
                                </form>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
