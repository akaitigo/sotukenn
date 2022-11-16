@include('header')


<h2>従業員一覧</h2>

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
            <td>{{ $parttimer->password }}
            </td>
            <td><input type="checkbox"></td>
        </tr>
        @endforeach
    </tbody>
</table>