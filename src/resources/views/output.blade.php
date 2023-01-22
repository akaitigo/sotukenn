<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<title>シフトダウンロード</title>
@include('new_header')
<div id="scale">
    <h1>{{$year}}年{{$month}}月シフト</h1>
<a href="{{ url("/download/{$year}/csv/{$month}")}}">csvダウンロード</a><br>
<a href="{{ url("/download/{$year}/pdf/{$month}")}}">pdfダウンロード</a><br>
<a href="{{ url("/download/{$year}/image/{$month}")}}">imageダウンロード</a><br>
</div>