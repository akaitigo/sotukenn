<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('header')

<script type="text/javascript">
    function myEnter() {
        myPassWord = prompt("パスワードを入力してください", "");
        if (myPassWord == "pass1") {
            location.href = "secret.htm";
        } else {
            alert("パスワードが違います!");
        }
    }
</script>

<label>🔍<label><input type="text" class="serch"><input type="button" class="serchButton">
        <a href="{{ route('employeesManagementPassView') }}" onclick="myEnter">パスワードの表示・変更</a>
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
                    <td>*****</td>
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
                    <td>*****</td>
                </tr>
                @endforeach
            </tbody>
        </table>