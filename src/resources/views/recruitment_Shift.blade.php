<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<link rel="stylesheet" href="/css/shift_recruiment.css" type="text/css">
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
    <div id='container'>
    <?php $shift_divi_count = 1; ?>

    <form method="post" onsubmit="return update()" action="{{ route('shiftupdate') }}">
    @csrf
        <div class='widget'>
                <table class="recruitment_table">
                    <caption>募集シフト</caption>
                </table>
                <table class="recruitment_table" id="recruitment_table">
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
                            $main = 1;
                            $sub1 = 2;
                            $sub2 = 3;
                        ?>
                        <tr>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_main}}" value="{{ $next_divi->main }}" id="{{$input_text_main}}" readonly="readonly"/>
                                <input class="starttimepull" oninput="addshift({{$next_divi->id}},{{$main}})" type="number" id="{{$start_main}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" oninput="addshift({{$next_divi->id}},{{$main}})" type="number" id="{{$end_main}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" onclick="nullshift({{$next_divi->id}},{{$main}})" type="button" id="{{$main_btn}}">×</button>
                            </td>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_sub1}}" value="{{ $next_divi->sub1 }}" id="{{$input_text_sub1}}" readonly="readonly"/>
                                <input class="starttimepull" oninput="addshift({{$next_divi->id}},{{$sub1}})" type="number" id="{{$start_sub1}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" oninput="addshift({{$next_divi->id}},{{$sub1}})" type="number" id="{{$end_sub1}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" onclick="nullshift({{$next_divi->id}},{{$sub1}})" type="button" id="{{$sub1_btn}}">×</button>
                            </td>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_sub2}}" value="{{ $next_divi->sub2 }}" id="{{$input_text_sub2}}" readonly="readonly"/>
                                <input class="starttimepull" oninput="addshift({{$next_divi->id}},{{$sub2}})" type="number" id="{{$start_sub2}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" oninput="addshift({{$next_divi->id}},{{$sub2}})" type="number" id="{{$end_sub2}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" onclick="nullshift({{$next_divi->id}},{{$sub2}})" type="button" id="{{$sub2_btn}}">×</button>
                            </td>
                        </tr>
                        <?php $shift_divi_count++; ?>
                        @endforeach
                    </tbody>
                </table>
        </div>
        <button type="submit" name="updateId" class="updateButton">更新</button>
    </form>
    <button type="button"onclick="addcolumn({{$shift_divi_count}},{{$workstarttime}},{{$workendtime}})" name="add_column" class="updateButton">＋</button>
    </div>
</div>

<script type="text/javascript" src="/js/shift_recruitment.js"></script>
