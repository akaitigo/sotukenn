<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/employee.js"></script>

<button class="backButton" onclick="history.back()">戻　る</button>

<h2>変更</h2>

<title>従業員管理</title>

<table class="table" border="2">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>weight</th>
            <th>position</th>
            <th>pass</th>
            <th>update</th>
            <th>delete</th>

        </tr>
    </thead>


    @if($empChangeIden==true)
    <tbody>
        <form method="post" action="{{route('employeesManegementUpdate')}}">
            @csrf
        @foreach ($employees as $emp)
        <tr>
            <td>{{ $emp->id }}</td>
            <td><input type="text" name="newEmpName" placeholder="{{ $emp->name }}"></td>
            <td><input type="email" name="newEmpEmail" placeholder="{{$emp->email}}"></td>
            <td><input type="text" name="newEmpWeight" placeholder="{{ $emp->weight }}"></td>

            <td>
                @foreach($allJob as $alljob)

                <input type="checkbox" name="{{$loop->iteration}}" value="{{$loop->iteration}}" {{in_array($alljob->id, $jobcheck)? 'checked' : '' }}>
                {{$alljob->name}}
                {{-- {{$loop->iteration}}で現在のループ回数--}}
                @endforeach

            </td>

            <td><input type="text" name="newEmpPassword" placeholder="Password"></td>


                <td><button type="submit" name="upDateId" value="{{$emp->id}}" class="updateButton">更　新</button></td>
            </form>

            <form method="post" action="{{route('employeesManagementDelete')}}">
                @csrf
                <td><button type="submit" name="delete" value="{{$emp->id}}" onclick="MoveCheck();" class="deleteButton">削　除</td>
            </form>


        </tr>
        @endforeach
    </tbody>

@elseif($partChangeIden==true)
        <tbody>

        @foreach ($parttimers as $part)
        <tr>
            <td>{{ $part->id }}</td>
            <td><input type="text" name="newPartName" placeholder="{{ $part->name }}"></td>
            <td><input type="email" name="newPartEmail" placeholder="{{$part->email}}"></td>

            <td><input type="text" name="newPartWeight" placeholder="{{ $part->weight }}"></td>

            <td>

                @foreach($allJob as $alljob)
                <input type="checkbox" name="{{$loop->iteration}}" value="{{$loop->iteration}}">{{$alljob->name}}
                {{-- {{$loop->iteration}}で現在のループ回数--}}
                @endforeach
            </td>

            <td><input type="text" name="newPartPass" placeholder="passwors"></td>

            <form method="post" action="{{route('parttimersManegementUpdate')}}">
                <td><button type="submit" name="{{$part->id}}" class="updateButton">更新</button></td>
            </form>

            <form method="post" action="{{route('partManagementDelete')}}">
                @csrf
                <td><button type="submit" name="delete" value="{{$part->id}}" onclick="MoveCheck();" class="deleteButton">削除aa  </td>
            </form>
        </tr>
        @endforeach
    </tbody>
    @endif
</table>

