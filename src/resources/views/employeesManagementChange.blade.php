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
            <div id='正社員' class="tab-content" href="#tab1">

                <table class="group-table">
                    <caption>変更</caption>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>age</th>
                            <th>weight</th>
                            <th>position</th>
                            <th>pass</th>
                            <th>update</th>
                            <th>delete</th>

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

                                        <td>
                                            @foreach ($allJob as $alljob)
                                                <input type="checkbox" name="{{ $loop->iteration }}"
                                                    value="{{ $loop->iteration }}"
                                                    {{ in_array($alljob->id, $jobcheck) ? 'checked' : '' }}>
                                                {{ $alljob->name }}
                                                {{-- {{$loop->iteration}}で現在のループ回数 --}}
                                            @endforeach

                                        </td>

                                        <td><input class="newemp" type="text" name="newEmpPassword" placeholder="Password"></td>


                                        <td><button type="submit" name="upDateId" value="{{ $emp->id }}"
                                                class="updateButton">更　新</button></td>
                            </form>
                            <form method="post" action="{{ route('employeesManagementDelete') }}"
                                onsubmit="return DeleteCheck();">
                                @csrf
                                <td><button type="submit" name="delete" value="{{ $emp->id }}"
                                        class="deleteButton">削　除</td>
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
                                            <input type="checkbox" name="{{ $loop->iteration }}"
                                                value="{{ $loop->iteration }}"
                                                {{ in_array($alljob->id, $jobcheck) ? 'checked' : '' }}>
                                            {{ $alljob->name }}

                                            {{-- {{$loop->iteration}}で現在のループ回数 --}}
                                        @endforeach
                                    </td>

                                    <td><input type="text" name="newPartPass" placeholder="password"></td>


                                    @csrf
                                    <td><button type="submit" name="upDateId" value="{{ $part->id }}"
                                            class="updateButton">更新</button></td>
                        </form>

                        <form method="post" action="{{ route('partManagementDelete') }}"
                            onsubmit="return DeleteCheck();">
                            @csrf
                            <td><button type="submit" name="delete" value="{{ $emp->id }}"
                                    class="deleteButton">削　除</td>
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


