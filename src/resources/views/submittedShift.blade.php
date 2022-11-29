<!DOCTYPE html>
<html lang="ja">
    <head>
    <link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
    </head>
    <body>
    @include('header')
            <a href="{{ route('submittedShiftDetail') }}" >提出済み従業員それぞれのシフト確認ボタン</a>
            <a href="{{ route('submittedShiftEdit') }}" >設定ボタン</a>
    </body>
</html>
