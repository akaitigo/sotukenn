<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('header')

<form action="{{route('employeesManagementPassView')}}" method="get"><label>🔍<label><input type="serch" class="serch"><input type="submit" class="serchButton">
            <a href="{{ route('employeesManagementPassNotView') }}">パスワード非表示</a></form>
<h2>正社員一覧</h2>

<title>従業員管理</title>
<table class="table" border="2">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>weight</th>
            <th>position</th>
            <th>pass</th>
            <th>delete</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($employees as $emp)
        <tr>
            <td>{{ $emp->id}}</td>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->weight}}</td>

            <td> @foreach($emp-> Jobs as $job)

                {{$job->name}}

                @endforeach
            </td>
            <td><input type="password" placeholder="{{ $emp->password }}"></td>
            <td><input type="checkbox"></td>
        </tr>
        @endforeach
    </tbody>
</table>




<h2>アルバイト一覧</h2>

<table class="table" border="2">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>weight</th>
            <th>position</th>
            <th>pass</th>
            <th>delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($parttimers as $parttimer)
        <tr>
            <td>{{ $parttimer->id}}</td>
            <td>{{ $parttimer->name }}</td>
            <td>{{ $parttimer->weight}}</td>

            <td> @foreach($parttimer-> Jobs as $job)

                {{$job->name}}

                @endforeach
            </td>

            <td><input type="password" placeholder="{{ $parttimer->password }}"></td>

            <td><input type="checkbox" class="delete"></td>
        </tr>
        @endforeach
    </tbody>
</table>