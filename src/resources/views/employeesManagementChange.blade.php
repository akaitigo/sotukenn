<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/deletepopup.js"></script>
@include('new_header')

<div id="scale">
    {{-- <button class="backButton" onclick="history.back()">戻　る</button> --}}
    @csrf
    <div id='container'>
        <div class='widget'>
            <div id='変更' class="tab-content" href="#tab1">

                <table class="group-table">
                    <caption>変更</caption>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>名前</th>
                            <th>メール</th>
                            <th>年齢</th>
                            <th>重み</th>
                            <th>ポジション</th>
                            <th>最大労働時間</th>
                            <th>最低労働時間</th>
                            <th>パスワード</th>
                            <th>更新</th>
                            <th>削除</th>

                        </tr>
                    </thead>


                    @if ($empChangeIden == true)
                    <tbody>
                        <form method="post" action="{{ route('employeesManegementUpdate') }}">
                            @csrf
                            @foreach ($employees as $emp)
                            <tr>
                                <td>{{ $emp->id }}</td>
                                <td><input class="newemp" type="text" name="newEmpName" placeholder="{{ $emp->name }}">
                                </td>
                                <td><input class="newemp" type="email" name="newEmpEmail" placeholder="{{ $emp->email }}">
                                </td>
                                <td><input class="newemp" type="text" name="newEmpAge" placeholder="{{ $emp->age }}">
                                </td>
                                <td><input class="newemp" type="text" name="newEmpWeight" placeholder="{{ $emp->weight }}">
                                </td>

                                <td class="emptext">
                                    @foreach ($allJob as $alljob)
                                    <input type="checkbox" class="check_job" name="{{ $loop->iteration }}" value="{{ $loop->iteration }}" {{ in_array($alljob->id, $jobcheck) ? 'checked' : '' }}>
                                    {{ $alljob->name }}
                                    <br>
                                    {{-- {{$loop->iteration}}で現在のループ回数 --}}
                                    @endforeach

                                </td>


                                <td> <label for=''>設定なし<input type="checkbox" value="-1" name='noMax' onclick="clickBtn1()"></label>
                                    <input type="number" max="500" min="1" id="b1" name="newMaxTime" placeholder="例）300">

                                    <script>
                                        function clickBtn1() {

                                            if (document.getElementById("b1").disabled === true) {
                                                // disabled属性を削除
                                                document.getElementById("b1").removeAttribute("disabled");
                                                document.getElementById("b1").style.color = "black";
                                            } else {
                                                // disabled属性を設定
                                                document.getElementById("b1").setAttribute("disabled", true);
                                                document.getElementById("b1").style.color = "White";
                                            }
                                        }
                                    </script>
                                </td>
                                <td> <label for=''>設定なし</label><input type="checkbox" value="-1" name='noMin' onclick="clickBtn2()">
                                    <input type="number" max="500" min="1" id="b2" name='newMinTime' placeholder="例）200">

                                    <script>
                                        function clickBtn2() {

                                            if (document.getElementById("b2").disabled === true) {
                                                // disabled属性を削除
                                                document.getElementById("b2").removeAttribute("disabled");
                                                document.getElementById("b2").style.color = "black";

                                            } else {
                                                // disabled属性を設定
                                                document.getElementById("b2").setAttribute("disabled", true);
                                                document.getElementById("b2").style.color = "White";

                                            }
                                        }
                                    </script>
                                </td>

                                <td><input class="newemp" type="text" name="newEmpPassword" placeholder="Password"></td>


                                <td class="empbtn"><button type="submit" name="upDateId" value="{{ $emp->id }}" class="updateButton newemp">更　新</button></td>
                        </form>
                        <form method="post" action="{{ route('employeesManagementDelete') }}" onsubmit="return DeleteCheck();">
                            @csrf
                            <td class="empbtn"><button type="submit" name="delete" value="{{ $emp->id }}" class="deleteButton">削　除</td>
                        </form>


                        </tr>
                        @endforeach
                    </tbody>
                    @elseif($partChangeIden == true)
                    <tbody>
                        <form method="post" action="{{ route('parttimersManegementUpdate') }}">
                            @foreach ($parttimers as $part)
                            <tr>
                                <td>{{ $part->id }}</td>
                                <td><input type="text" name="newPartName" placeholder="{{ $part->name }}">
                                </td>
                                <td><input type="email" name="newPartEmail" placeholder="{{ $part->email }}">
                                </td>
                                <td><input type="text" name="newPartAge" placeholder="{{ $part->age }}">
                                </td>
                                <td><input type="text" name="newPartWeight" placeholder="{{ $part->weight }}">
                                </td>

                                <td>

                                    @foreach ($allJob as $alljob)
                                    <input type="checkbox" class="check_job name="{{ $loop->iteration }}" value="{{ $loop->iteration }}" {{ in_array($alljob->id, $jobcheck) ? 'checked' : '' }}>
                                    {{ $alljob->name }}

                                    {{-- {{$loop->iteration}}で現在のループ回数 --}}
                                    @endforeach
                                </td>

   

                                <td> <label for=''>設定なし<input type="checkbox" value="-1" name='noMax' onclick="clickBtn1()"></label>
                                    <input type="number" max="500" min="1" id="b1" name="newMaxTime" placeholder="例）300">

                                    <script>
                                        function clickBtn1() {

                                            if (document.getElementById("b1").disabled === true) {
                                                // disabled属性を削除
                                                document.getElementById("b1").removeAttribute("disabled");
                                                document.getElementById("b1").style.color = "black";
                                            } else {
                                                // disabled属性を設定
                                                document.getElementById("b1").setAttribute("disabled", true);
                                                document.getElementById("b1").style.color = "White";
                                            }
                                        }
                                    </script>
                                </td>

                                    <td> <label for=''>設定なし</label><input type="checkbox" value="-1" name='noMin' onclick="clickBtn2()">
                                    <input type="number" max="500" min="1" id="b2" name='newMinTime' placeholder="例）200">

                                    <script>
                                        function clickBtn2() {

                                            if (document.getElementById("b2").disabled === true) {
                                                // disabled属性を削除
                                                document.getElementById("b2").removeAttribute("disabled");
                                                document.getElementById("b2").style.color = "black";

                                            } else {
                                                // disabled属性を設定
                                                document.getElementById("b2").setAttribute("disabled", true);
                                                document.getElementById("b2").style.color = "White";

                                            }
                                        }
                                    </script>
                                </td>



                                <td><input type="text" name="newPartPass" placeholder="password"></td>


                                @csrf
                                <td><button type="submit" name="upDateId" value="{{ $part->id }}" class="updateButton">更新</button></td>
                        </form>

                        <form method="post" action="{{ route('partManagementDelete') }}" onsubmit="return DeleteCheck();">
                            @csrf
                            <td><button type="submit" name="delete" value="{{ $part->id }}" class="deleteButton">削　除</td>
                        </form>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif

                </table>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/checkbox.js"></script>
