<link rel="stylesheet" href="/css/employeesheader.css" type="text/css">
<header >
      <div class="blandWrapper">
        <a class="brand">M&emsp;A&emsp;R&emsp;U&emsp;O&emsp;K&emsp;U&emsp;N</a>
      </div>
      <div class="tabs">
        <input id="all" type="radio" name="tab_item" checked>
        <label class="tab_item" for="all">シフト提出</label>
        <input id="inspection" type="radio" name="tab_item">
        <label class="tab_item" for="inspection">シフト閲覧</label>
        
        <div class="tab_content" id="all_content">
          テストテストテスト
        </div>
        <div class="tab_content" id="inspection_content">
          @include('calendar')
        </div>
      </div>
    
        
        
</header>