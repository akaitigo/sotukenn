<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<link rel="stylesheet" href="/css/shift_recruiment.css" type="text/css">
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
    <div id='container'>

        <div class='widget'>
                <table class="recruitment_table">
                    <caption>募集シフト</caption>
                </table>
                <table class="recruitment_table">
                    <thead class="thead">
                        <th class="rec_main">メイン</th>
                        <th class="sub1">サブ１</th>
                        <th class="sub2">サブ２</th>
                    </thead>
                    <tbody>
                        @foreach ($nextdivider as $next_divi)
                        <?php
                            $input_text_main = $next_divi->id . 'text_main';
                            $start_main = $next_divi->id . 'start_main';
                            $end_main = $next_divi->id . 'end_main';
                            $main_btn = $next_divi->id . 'btn_main';
                            $input_text_sub1 = $next_divi->id . 'text_sub1';
                            $start_sub1 = $next_divi->id . 'start_sub1';
                            $end_sub1 = $next_divi->id . 'end_sub1';
                            $sub1_btn = $next_divi->id . 'btn_sub1';
                            $input_text_sub2 = $next_divi->id . 'text_sub2';
                            $start_sub2 = $next_divi->id . 'start_sub2';
                            $end_sub2 = $next_divi->id . 'end_sub2';
                            $sub2_btn = $next_divi->id . 'btn_sub2';
                        ?>
                        <tr>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_main}}" value="{{ $next_divi->main }}" id="{{$input_text_main}}" readonly="readonly"/>
                                <input class="starttimepull" type="number" id="{{$start_main}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" type="number" id="{{$end_main}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" type="button" id="{{$main_btn}}">×</button>
                            </td>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_sub1}}" value="{{ $next_divi->sub1 }}" id="{{$input_text_sub1}}" readonly="readonly"/>
                                <input class="starttimepull" type="number" id="{{$start_sub1}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" type="number" id="{{$end_sub1}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" type="button" id="{{$sub1_btn}}">×</button>
                            </td>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_sub2}}" value="{{ $next_divi->sub2 }}" id="{{$input_text_sub2}}" readonly="readonly"/>
                                <input class="starttimepull" type="number" id="{{$start_sub2}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" type="number" id="{{$end_sub2}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" type="button" id="{{$sub2_btn}}">×</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>

    </div>
</div>
