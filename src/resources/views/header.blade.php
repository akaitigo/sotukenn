<link rel="stylesheet" href="/css/header.css" type="text/css">
<header>
  <div class="blandWrapper">
    <a class="brand">M&emsp;A&emsp;R&emsp;U&emsp;O&emsp;K&emsp;U&emsp;N</a>
  </div>
  <div class="menuhyde">
    <div class="menuHeaderWrap">
      <ul class="menuclass" id="menu">
        <li>
          <a href="#">カレンダー</a>
          <ul>
            <li>
              <a href="{{ route('calendar') }}" >カレンダー</a>
              
            </li>
            <li>
              <a href="{{ route('employeesManagement') }}" >従業員管理</a>
              
            </li>
            <li>
              <a href="{{ route('noticeManagement') }}" >通知管理</a>
              <ul>
                <li>
                  <a href="#" >編集</a>
                </li>
                
              </ul>
            </li>
            <li>
              <a href="{{ route('submittedShift') }}" >提出シフト管理</a>
              <ul>
                <li>
                  <a href="#" >設定</a>
                </li>
                
              </ul>
            </li>
            <li>
              <a href="{{ route('ShiftView') }}" >シフト閲覧</a>
              
            </li>
            <li>
              <a href="{{ route('ShiftCreateMenu') }}" >シフト作成</a>
              <ul>
                <li>
                  <a href="#" >自動シフト作成</a>
                </li>
                <li>
                  <a href="#" >候補シフト表示画面</a>
                </li>
                
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">従業員管理</a>
          <ul>
            <li>
              <a href="#">編集</a>
            </li>
            <li>
              <a href="#">閲覧</a>
            </li>
            <li>
              <a href="#">(仮)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">通知管理</a>
          <ul>
            <li>
              <a href="#">編集</a>
            </li>
            <li>
              <a href="#">閲覧</a>
            </li>
            <li>
              <a href="#">(仮)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">提出シフト管理</a>
          <ul>
            <li>
              <a href="#">編集</a>
            </li>
            <li>
              <a href="#">閲覧</a>
            </li>
            <li>
              <a href="#">(仮)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">シフト閲覧</a>
          <ul>
            <li>
              <a href="#">編集</a>
            </li>
            <li>
              <a href="#">閲覧</a>
            </li>
            <li>
              <a href="#">(仮)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#">シフト作成</a>
          <ul>
            <li>
              <a href="#">編集</a>
            </li>
            <li>
              <a href="#">閲覧</a>
            </li>
            <li>
              <a href="#">(仮)</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>

</header>