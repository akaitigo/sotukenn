<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('new_header')

<div id="scale">
    {{-- <div>
        <button class="backButton" onclick="history.back()">戻　る</button>
        <a href="{{ route('employeesManagementPassNotView') }}" class="passViewButton">メール非表示</a>
    </div> --}}
    <title>従業員管理</title>
    <div id='container'>
        <div class='widget'>
            <div id='正社員' class="tab-content" href="#tab1">

                @if (!$employees->isEmpty())

                    <table class="group-table">
                        <caption>正社員一覧</caption>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>email</th>
                                <th>name</th>
                                <th>age</th>
                                <th>weight</th>
                                <th>position</th>
                                <th>notice</th>
                                <th>change</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($employees as $emp)
                                <tr>
                                    <td>{{ $emp->id }}</td>
                                    <td>{{ $emp->email }}</td>
                                    <td>{{ $emp->name }}</td>
                                    <td>{{ $emp->age }}</td>
                                    <td>{{ $emp->weight }}</td>
                                    <td>
                                        @foreach ($emp->Jobs as $job)
                                            {{ $job->name }}
                                        @endforeach
                                    </td>

                                    @if (!is_null($emp->lineUserId))
                                        <form method="get" action="{{ route('messagessent') }}">
                                            @csrf
                                            <td><button type="submit" name="noticeId" value="{{ $emp->id }}"
                                                    class="noticeButton">通知</button></td>
                                        </form>
                                    @endif
                                    @if (is_null($emp->lineUserId))
                                        <td>
                                            <p>未登録</p>
                                        </td>
                                    @endif


                                    <form method="get" action="{{ route('employeesManagementChange') }}">
                                        @csrf
                                        <td><button type="submit" name="empChange"
                                                value="{{ $emp->id }}">変　更</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class='widget'>
            <div id='アルバイト' class="tab-content">

                @if (!$parttimers->isEmpty())

                    <table class="group-table">
                        <caption>アルバイト一覧</caption>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>email</th>
                                <th>name</th>
                                <th>age</th>
                                <th>weight</th>
                                <th>position</th>
                                <th>notice</th>
                                <th>change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parttimers as $part)
                                <tr>
                                    <td>{{ $part->id }}</td>
                                    <td>{{ $part->email }}</td>
                                    <td>{{ $part->name }}</td>
                                    <td>{{ $part->age }}</td>
                                    <td>{{ $part->weight }}</td>

                                    <td>
                                        @foreach ($part->Jobs as $job)
                                            {{ $job->name }}
                                        @endforeach
                                    </td>

                                    @if (!is_null($part->lineUserId))
                                        <form method="get" action="{{ route('partMessagessent') }}">
                                            @csrf
                                            <td><button type="submit" name="noticeId" value="{{ $part->id }}"
                                                    class="noticeButton">通知</button></td>
                                        </form>
                                    @endif
                                    @if (is_null($part->lineUserId))
                                        <td>
                                            <p>未登録</p>
                                        </td>
                                    @endif
                                    <form method="get" action="{{ route('partManagementChange') }}">
                                        @csrf
                                        <td class="underTd"><button type="submit" name="partChange"
                                                value="{{ $part->id }}">変　更</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>


<script type="text/javascript" src="/js/tab.js"></script>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
