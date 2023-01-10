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
                    <caption>追加</caption>
                    <thead>
                        <tr>
                            <th>employee</th>
                            <th>name</th>
                            <th>email</th>
                            <th>age</th>
                            <th>weight</th>
                            <th>position</th>
                            <th>pass</th>
                            <th>add</th>
                        </tr>
                    </thead>
                        <tbody>
                            <form method="post" action="{{ route('employeesManegementdbAdd') }}">
                                @csrf
                                    <tr>
                                        <td><select id="slc" name="newemp" class="emp">
                                                <option value="1">従業員</option>
                                                <option value="2">アルバイト</option>
                                            </select>
                                        </td>
                                        <td><input class="newemp" type="text" name="newEmpName" placeholder="name" required>
                                        </td>
                                        <td><input class="newemp" type="email" name="newEmpEmail" placeholder="email" required>
                                        </td>
                                        <td><input class="newemp" type="text" name="newEmpAge" placeholder="age" required>
                                        </td>
                                        <td><select id="slc" name="newweight" class="weight">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </td>

                                        <td class="emptext">
                                            @foreach ($allJob as $alljob)
                                                <input  type="checkbox" name="{{ $loop->iteration }}"
                                                    value="{{ $loop->iteration }}" required>
                                                {{ $alljob->name }}
                                                <br>
                                                {{-- {{$loop->iteration}}で現在のループ回数 --}}
                                            @endforeach
                                        </td>

                                        <td><input class="newemp" type="text" name="newEmpPassword" placeholder="Password" required></td>
                                        <td class="empbtn"><button  type="submit" name="upDateId"
                                                class="updateButton newemp">追 加</button></td>
                               </form>
                          </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


+