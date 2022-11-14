<link rel="stylesheet" href="/css/header.css" type="text/css">
<header>
    <div class="blandWrapper">
        <a class="brand">M&emsp;A&emsp;R&emsp;U&emsp;O&emsp;K&emsp;U&emsp;N</a>
    </div>
    <div class="menuhyde">
        <div class="menuHeaderWrap">
            <ul class="menuclass" id="menu">
                <!-- カレンダー -->
                <li>
                    <a>カレンダー</a>
                    <ul>
                        <li>
                            <a href="{{ route('calendar') }}">カレンダー(仮)</a>
                        </li>
                    </ul>
                </li>
                <!-- 従業員管理 -->
                <li>
                    <a>従業員管理</a>
                    <ul>
                        <li>
                            <a href="{{ route('employeesManagement') }}">従業員管理(仮)</a>
                        </li>
                    </ul>
                </li>
                <!-- 通知管理 -->
                <li>
                    <a>通知管理</a>
                    <ul>
                        <li>
                            <a href="{{ route('noticeManagement') }}">通知管理(仮)</a>
                        </li>
                        <li>
                            <a href="{{ route('noticeEdit') }}">編集</a>
                        </li>
                    </ul>
                </li>
                <!-- 提出シフト管理 -->
                <li>
                    <a>提出シフト管理</a>
                    <ul>
                        <li>
                            <a href="{{ route('submittedShift') }}">提出シフト管理(仮)</a>
                        </li>
                        <li>
                            <a href="{{ route('submittedShiftEdit') }}">設定</a>
                        </li>
                    </ul>
                </li>
                <!-- シフト作成 -->
                <li>
                    <a>シフト作成</a>
                    <ul>
                        <li>
                            <a href="{{ route('shiftCreateMenu') }}">シフト作成(仮)</a>
                        </li>
                        <li>
                            <a href="{{ route('shiftCreate') }}">自動シフト作成</a>
                        </li>
                        <li>
                            <a href="{{ route('candidacyView') }}">候補シフト表示</a>
                        </li>
                    </ul>
                </li>
                <!-- シフト閲覧 -->
                <li>
                    <a>シフト閲覧</a>
                    <ul>
                        <li>
                            <a href="{{ route('shiftView') }}">シフト閲覧(仮)</a>
                        </li>
                        <li>
                            <a href="{{ route('shiftEdit') }}">シフト編集</a>
                        </li>

                    </ul>
                </li>
                
            </ul>
        </div>
</header>
