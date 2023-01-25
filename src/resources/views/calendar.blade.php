<?php
$event = [];
$day = [];
$count = 0;
$not_count = 1;
for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++) {
    if ($calendarData[$i]['memberCount'] != 0) {
        $event[$count] = $calendarData[$i]['memberCount'] . '人';
        $day[$count] = $i;
        $count += 1;
    } else {
        $not_count += 1;
    }
}
$last_data = $calendarData[0]['lastDay'] - $not_count;
for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++) {
    if ($calendarData[$i]['holiday'] != '-') {
        $event[$count] = $calendarData[$i]['holiday'];
        $day[$count] = $i;
        $count += 1;
    }
}

$all_data = array_merge($event, $day);
$json_data = json_encode($all_data);
?>
@include('new_header')
<link rel="stylesheet" href="/css/calendar.css" type="text/css">
<link rel="stylesheet" href="/css/scale.css" type="text/css">
<title>カレンダー</title>
{{-- @include('new_header') --}}

<body onload="data_set({{ $json_data }},{{ $last_data }})">
    {{-- <body> --}}
    <div id="scale">
        <div id="calendar"></div>
    </div>
</body>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.js"></script>
{{-- <script async src="https://js.cybozu.com/momentjs/2.27.0/moment.min.js"></script> --}}
{{-- <script async src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script> --}}
<script type="text/javascript" src="/js/calendar.js"></script>