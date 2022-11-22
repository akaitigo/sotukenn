<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/employee.js"></script>
<button onclick="history.back()">戻る</button>

<h2>変更</h2>

<title>従業員管理</title>

<table class="table" border="2">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>weight</th>
            <th>position</th>
            <th>pass</th>
            <th>update</th>
            <th>delete</th>

        </tr>
    </thead>


    @if($empChangeIden==true)
    <tbody>
        @foreach ($employees as $emp)
        <tr>
            <td><input tpe="text" name="newEmpId" placeholder="{{ $emp->id }}"></td>
            <td><input tpe="text" name="newEmpName" placeholder="{{ $emp->name }}"></td>
            <td><input tpe="text" name="newEmpWeight" placeholder="{{ $emp->weight }}"></td>

            <td>

                @foreach($allJob as $alljob)
                <input type="checkbox" name="{{$loop->iteration}}" value="{{$loop->iteration}}">{{$alljob->name}}
                {{-- {{$loop->iteration}}で現在のループ回数--}}
                @endforeach
            </td>

            <td><input tpe="text" name="newEmpName" placeholder="{{$emp->password}}"></td>

            <form method="get" action="{{route('employeesManagementChange')}}">
                <td><button type="submit" name="{{$emp->id}}">更新</button></td>
            </form>

            <form method="post" action="{{route('employeesManagementDelete')}}">
                @csrf
                <td><button type="submit" name="delete" value="{{$emp->id}}" onclick="MoveCheck();">削除</td>
            </form>


        </tr>
        @endforeach
    </tbody>

@elseif($partChangeIden==true)
        <tbody>

        @foreach ($parttimers as $part)
        <tr>
            <td><input tpe="text" name="newPartId" placeholder="{{ $part->id }}"></td>
            <td><input tpe="text" name="newPartName" placeholder="{{ $part->name }}"></td>
            <td><input tpe="text" name="newPartWeight" placeholder="{{ $part->weight }}"></td>

            <td>

                @foreach($allJob as $alljob)
                <input type="checkbox" name="{{$loop->iteration}}" value="{{$loop->iteration}}">{{$alljob->name}}
                {{-- {{$loop->iteration}}で現在のループ回数--}}
                @endforeach
            </td>

            <td><input type="text" name="newPartPass" placeholder="{{$part->password}}"></td>

            <form method="get" action="{{route('employeesManagementChange')}}">
                <td><button type="submit" name="{{$part->id}}">更新</button></td>
            </form>

            <form method="post" action="{{route('partManagementDelete')}}">
                @csrf
                <td><button type="submit" name="delete" value="{{$part->id}}" onclick="MoveCheck();">削除</td>
            </form>
        </tr>
        @endforeach
    </tbody>
    @endif
</table>

