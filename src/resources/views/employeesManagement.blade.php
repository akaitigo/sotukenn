@include('header')


<h2>従業員一覧</h2>

<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>pass</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
        <tr>
            <td>{{ $employee->employee_id}}</td>
            <td>{{ $employee->employee_name }}</td>
            <td>{{ $employee->employee_pass }}</td>

        </tr>
        @endforeach
    </tbody>
</table>