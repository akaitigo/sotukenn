<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_box.css" type="text/css">
<link rel="stylesheet" href="/css/emp_search.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<link rel='stylesheet' href='/css/chat.css' type='text/css' />

<script type="text/javascript" src="/js/deletepopup.js"></script>

@include('emp_header')

<body>
    <div class="emp_box">
        <title>業務情報共有掲示板</title>
        {{-- <div id="search1">
            <form action="informationShare" method="GET">
                @csrf
                <input id="sbox5" type="text" name="search_name" placeholder="キーワードを入力" />
                <input id="sbtn5" type="submit" value="検索" />
                <a href="{{ route('emp_informationShare-register') }}" class="registerButton">通知登録</a>
            </form>
        </div> --}}
        <?php
        if (isset($_POST['search_name'])) {
            $search_name = $_POST['search_name']; //検索内容取得
        } elseif (isset($_GET['search_name'])) {
            $search_name = $_GET['search_name']; //検索内容取得
        } else {
            $search_name = null;
        }
        ?>
        {{-- <div id='container'>
            <div class='widget'>
                <div id='正社員' class="tab-content" href="?tab1">
                    <table class="group-table">

                        <caption>掲示一覧</caption>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>登録日</th>
                                <th>提示名</th>
                                <th>掲示内容</th>
                                <th>掲示登録者</th>
                                <th>掲示期間</th>
                                <th>削除</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($information as $info)
                                @if ($search_name != null)
                                    @if (preg_match("/$search_name/", $info->registrationDate) == 0 && preg_match("/$search_name/", $info->shareContent) == 0 && preg_match("/$search_name/", $info->registerUser) == 0 && preg_match("/$search_name/", $info->shareText) == 0)
                                        <?php continue; ?>
                                    @endif
                                @endif
                                <tr>
                                    <td>{{ $info->shareId }}</td>
                                    <td>{{ $info->registrationDate }}</td>
                                    <td>{{ $info->shareContent }}</td>
                                    <td>{{ $info->shareText }}</td>
                                    <td>{{ $info->registerUser }}</td>
                                    <td>{{ $info->daysRemaining }}</td>

                                    <form method="post" action="{{ route('informationDelete') }}"
                                        onsubmit="return DeleteCheck();">
                                        @csrf
                                        <td class="empbtn"><button type="submit" name="delete"
                                                value="{{ $info->shareId }}" class="deleteButton">削　除</td>
                                    </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}

        <div class="line__container">
            <!-- タイトル -->
            <div class="line__title">
                掲示板
                <a href="{{ route('emp_informationShare-register') }}" class="puls" ><img src="/img_submit/puls.png" width="40"
                    height="40"></a>
            </div>

            <!-- ▼会話エリア scrollを外すと高さ固定解除 -->
            <div class="line__contents scroll">
                @foreach ($information as $info)
                    <!-- 吹き出し -->
                    <div class="line__left">
                        <div class="line__left-text">
                            <div class="text">
                                <div class="chat_div" style="font-weight: bold;">
                                    <div class="chat_title">

                                        <font color="red">
                                            {{ $info->shareContent }}
                                        </font>

                                    </div>
                                    <div class="chat_name">
                                        &nbsp; &nbsp;&nbsp; &nbsp;
                                        {{ $info->registrationDate }}&nbsp; &nbsp;掲示登録者：{{ $info->registerUser }}
                                    </div>
                                    &nbsp; &nbsp;&nbsp; &nbsp;
                                    @if ($userEmail == $info->email)
                                        <form class="chat-right" method="post"
                                            action="{{ route('informationDelete') }}" onsubmit="return DeleteCheck();">
                                            @csrf
                                            <font color="#CCCCCC">
                                                <button type="submit" name="delete"
                                                    value="{{ $info->shareId }}">削　除</button>
                                            </font>
                                        </form>
                                    @endif
                                </div>
                                <br>
                                {{ $info->shareText }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--　▲会話エリアここまで -->
        </div>
        
    </div>
</body>
