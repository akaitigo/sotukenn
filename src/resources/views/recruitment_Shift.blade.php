<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<link rel="stylesheet" href="/css/shift_recruiment.css" type="text/css">
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
    <div id='container'>
    <?php $gouid = 0; ?>
        <div class='widget'>
                <table class="recruitment_table">
                    <caption>募集シフト</caption>
                </table>
                <form method="post" action="{{ route('recruitment_Shift_update') }}">
                @csrf
                <table class="recruitment_table" id="recruitment_table">
                    <thead class="thead">
                        <th class="rec_main">メイン</th>
                        <th class="sub1">サブ１</th>
                        <th class="sub2">サブ２</th>
                    </thead>
                    <tbody>
                        @for($i = 0;$i < $shift_divicount; $i++)
                        <?php
                            $id = $i + 1;
                            $input_text_main = $id . 'text_main';
                            $start_main = $id . 'start_main';
                            $end_main = $id . 'end_main';
                            $main_btn = $id . 'btn_main';
                            $input_text_sub1 = $id . 'text_sub1';
                            $start_sub1 = $id . 'start_sub1';
                            $end_sub1 = $id . 'end_sub1';
                            $sub1_btn = $id . 'btn_sub1';
                            $input_text_sub2 = $id . 'text_sub2';
                            $start_sub2 = $id . 'start_sub2';
                            $end_sub2 = $id . 'end_sub2';
                            $sub2_btn = $id . 'btn_sub2';
                            $main = 1;
                            $sub1 = 2;
                            $sub2 = 3;
                        ?>
                        <tr>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_main}}" value="{{ $shift_divi_array[$i][0] }}" id="{{$input_text_main}}" readonly="readonly"/>
                                <input class="starttimepull" oninput="addshift({{$id}},{{$main}},{{$workendtime}})" type="number" id="{{$start_main}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" oninput="addshift({{$id}},{{$main}},{{$workendtime}})" type="number" id="{{$end_main}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" onclick="nullshift({{$id}},{{$main}})" type="button" id="{{$main_btn}}">×</button>
                            </td>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_sub1}}" value="{{ $shift_divi_array[$i][1] }}" id="{{$input_text_sub1}}" readonly="readonly"/>
                                <input class="starttimepull" oninput="addshift({{$id}},{{$sub1}},{{$workendtime}})" type="number" id="{{$start_sub1}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" oninput="addshift({{$id}},{{$sub1}},{{$workendtime}})" type="number" id="{{$end_sub1}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" onclick="nullshift({{$id}},{{$sub1}})" type="button" id="{{$sub1_btn}}">×</button>
                            </td>
                            <td class="">
                                <input class="shifttext" type="text" name="{{$input_text_sub2}}" value="{{ $shift_divi_array[$i][2] }}" id="{{$input_text_sub2}}" readonly="readonly"/>
                                <input class="starttimepull" oninput="addshift({{$id}},{{$sub2}},{{$workendtime}})" type="number" id="{{$start_sub2}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                <p class="hihunp">-</p>
                                <input class="endtimepull" oninput="addshift({{$id}},{{$sub2}},{{$workendtime}})" type="number" id="{{$end_sub2}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                <button class="batsubtn" onclick="nullshift({{$id}},{{$sub2}})" type="button" id="{{$sub2_btn}}">×</button>
                            </td>
                        </tr>
                        <?php $gouid++; ?>
                        @endfor
                    </tbody>
                </table>
        </div>
        <button type="submit" onclick="return update({{$gouid}})" name="updateId" class="updateButton">更新</button>
    </form>
    <button type="button"onclick="addcolumn({{$gouid}},{{$workstarttime}},{{$workendtime}})" name="add_column" class="updateButton">＋</button>
    </div>
</div>

<script type="text/javascript" src="/js/shift_recruitment.js"></script>
