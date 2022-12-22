<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/search.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('new_header')

<div id="scale">
    {{-- <div>
        <button class="backButton" onclick="history.back()">戻　る</button>
        <a href="{{ route('employeesManagementPassNotView') }}" class="passViewButton">メール非表示</a>
    </div> --}}
    <div id="search1">
        <form action="employeesManagementPassView" method="GET">
            <input id="sbox5" type="text" name="search_name1" placeholder="キーワードを入力" />
            <input id="sbtn5" type="submit" value="検索" />
        </form>
    </div>
    <div id="search2">
        <form action="employeesManagementPassView" method="GET">
            <input id="sbox5" type="text" name="search_name2" placeholder="キーワードを入力" value="" />
            <input id="sbtn5" type="submit" value="検索" />
        </form>
    </div>

    <title>従業員管理</title>
    <div id='container'>
        <div class='widget'>
            <div id='正社員' class="tab-content" href="?tab1">

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
                        <?php $count = 0; ?>
                        @foreach ($employees as $emp)
                            <?php $count = $count + 1; ?>
                        @endforeach
                        <?php
                        $pagination1 = ceil($count / 4);
                        if (isset($_GET['page1'])) {
                            $page1 = (int) $_GET['page1']; //ページの取得
                        } else {
                            $page1 = 1; //始めのページ
                        }
                        if (isset($_GET['search_name1'])) {
                            $search_name1 = $_GET['search_name1']; //検索名前取得
                        }else{
                            $search_name1 = null;
                        }
                        
                        // スタートのポジションを計算する
                        if ($page1 > 1) {
                            // 例：２ページ目の場合は、(2 × 4) - 4 = 4
                            $start = $page1 * 4 - 4;
                        } else {
                            $start = 0;
                        }
                        $start_loop = $start + 1; //1ページの表示の始め　例8件目からとか
                        $count_loop = 1; //現在の表示件数
                        $end_loop = 4 * $page1; //1ページあたりの表示の終わり
                        
                        ?>

                        <tbody>
                            @foreach ($employees as $emp)
                                {{-- 表示件数の処理 --}}
                                @if ($start_loop > $count_loop)
                                    <?php
                                    $count_loop = $count_loop + 1;
                                    continue; ?>
                                @endif
                                @if ($end_loop < $count_loop)
                                    <?php
                                    $count_loop = $count_loop + 1;
                                    continue; ?>
                                @endif
                                @if ($search_name1 != $emp->name && $search_name1 != null)
                                    <?php continue; ?>
                                @endif
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
                                <?php
                                $count_loop = $count_loop + 1;
                                ?>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <?php for ($x=1; $x <= $pagination1 ; $x++) { ?>
                <a class='pagetab' href="?page1=<?php echo $x; ?>"><?php echo $x; ?></a>
                <?php } ?>
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
                        <?php $count = 0; ?>
                        @foreach ($parttimers as $part)
                            <?php $count = $count + 1; ?>
                        @endforeach
                        <?php
                        $pagination2 = ceil($count / 4);
                        $count_loop = 1; //現在の表示件数
                        ?>
                        <?php
                        $pagination = ceil($count / 4);
                        if (isset($_GET['page2'])) {
                            $page2 = (int) $_GET['page2']; //ページの取得
                        } else {
                            $page2 = 1; //始めのページ
                        }
                        if (isset($_GET['search_name2'])) {
                            $search_name2 = $_GET['search_name2']; //検索名前取得
                        }else{
                            $search_name2 = null;
                        }
                        
                        // スタートのポジションを計算する
                        if ($page2 > 1) {
                            // 例：２ページ目の場合は、(2 × 4) - 4 = 4
                            $start = $page2 * 4 - 4;
                        } else {
                            $start = 0;
                        }
                        $start_loop = $start + 1; //1ページの表示の始め　例8件目からとか
                        $count_loop = 1; //現在の表示件数
                        $end_loop = 4 * $page2; //1ページあたりの表示の終わり
                        
                        ?>
                        <tbody>
                            @foreach ($parttimers as $part)
                                {{-- 表示件数の処理 --}}
                                @if ($start_loop > $count_loop)
                                    <?php
                                    $count_loop = $count_loop + 1;
                                    continue; ?>
                                @endif
                                @if ($end_loop < $count_loop)
                                    <?php
                                    $count_loop = $count_loop + 1;
                                    continue; ?>
                                @endif
                                @if ($search_name2 != $emp->name && $search_name2 != null)
                                    <?php continue; ?>
                                @endif
                                <tr id="<?php echo $count_loop; ?>">
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
                                            <td id="<?php echo $count_loop; ?>"><button type="submit" name="noticeId"
                                                    value="{{ $part->id }}" class="noticeButton">通知</button></td>
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
                                <?php
                                $count_loop = $count_loop + 1;
                                ?>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <?php for ($x=1; $x <= $pagination2 ; $x++) { ?>
                <a class='pagetab2_<?php echo $x; ?>'
                    href="?tab=2&page2=<?php echo $x; ?>"><?php echo $x; ?></a>
                <?php } ?>
            </div>

        </div>
        {{-- なぜかこれが無いとアルバイトが最初にでない --}}
        <div class='widget3'>
            <div id='アルバイト' class="tab-content">
            </div>
        </div>

    </div>
</div>


<script type="text/javascript" src="/js/tab.js"></script>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
