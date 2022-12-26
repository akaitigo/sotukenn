   {{-- <link rel="stylesheet" href="/css/submittedShift.css" type="text/css"> --}}
   <link rel="stylesheet" href="/css/scale.css" type="text/css">
   <link rel="stylesheet" href="/css/tab.css" type="text/css">
   <link rel="stylesheet" href="/css/search.css" type="text/css">
   <link rel="stylesheet" href="/css/pagenation.css" type="text/css">
   <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">

   @include('new_header')
   <div id="scale">
       <div id="search1">
           <form action="submittedShift" method="GET">
               <input type="text" name="refinement1" value="1" style="display: none;" />
               <input id="sbtn5" type="submit" value="提出済" />
           </form>
           <form action="submittedShift" method="GET">
               <input type="text" name="refinement1" value="2" style="display: none;" />
               <input id="sbtn5" type="submit" value="未提出" />
           </form>
       </div>
       <div id="search2">
           <form action="submittedShift" method="GET">
               <input type="text" name="tab" value="2" style="display: none;" />
               <input type="text" name="refinement2" value="1" style="display: none;" />
               <input id="sbtn5" type="submit" value="提出済" />
           </form>
           <form action="submittedShift" method="GET">
               <input type="text" name="tab" value="2" style="display: none;" />
               <input type="text" name="refinement2" value="2" style="display: none;" />
               <input id="sbtn5" type="submit" value="未提出" />
           </form>
       </div>
       <div id='container'>
           <div class='widget'>
               <div id='正社員' class="tab-content" href="?tab1">
                   @if (!$employees->isEmpty())
                       <table class="group-table">
                           <caption>正社員一覧</caption>
                           <thead>
                               <tr>
                                   <th>id</th>
                                   <th>name</th>
                                   <th>提出状況</th>
                                   <th>view</th>
                               </tr>
                           </thead>
                           <?php $count = 0; ?>
                           {{-- データ件数の取得 --}}
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
                               $search_name1 = $_GET['search_name1']; //検索内容取得
                           } else {
                               $search_name1 = null;
                           }
                           if (isset($_GET['refinement1'])) {
                               $refinement = $_GET['refinement1']; //検索内容取得
                           } else {
                               $refinement = null;
                           }
                           
                           // 表示するデータのスタートのポジションを計算する
                           if ($page1 > 1) {
                               // 例：２ページ目の場合は、(2 × 4) - 4 = 4
                               $start = $page1 * 4 - 4;
                           } else {
                               $start = 0; //1ページ目
                           }
                           $start_loop = $start + 1; //1ページの表示の始め　例8件目からとか
                           $count_loop = 1; //現在の表示件数
                           $end_loop = 4 * $page1; //1ページあたりの表示の終わり
                           
                           ?>

                           <tbody>
                               @foreach ($employees as $emp)
                                   {{-- 提出済みを押している＋提出した人が存在しない場合 --}}
                                   @if ($refinement == 1)
                                       @if (in_array($emp->id, $submitcompempid) == false)
                                           <?php continue; ?>
                                       @endif
                                   @elseif($refinement == 2)
                                       @if (in_array($emp->id, $submitcompempid))
                                           <?php continue; ?>
                                       @endif
                                   @endif
                                   {{-- 表示件数の処理 --}}
                                   {{-- 2ページ以降は（4×ページ数 - 1）件スキップする --}}
                                   @if ($start_loop > $count_loop)
                                       <?php
                                       $count_loop = $count_loop + 1;
                                       continue; ?>
                                   @endif
                                   {{-- (4×ページ数)件以上はスキップ --}}
                                   @if ($end_loop < $count_loop)
                                       <?php
                                       $count_loop = $count_loop + 1;
                                       continue; ?>
                                   @endif
                                   {{-- 検索内容と一致しなかったらスキップする --}}
                                   @if ($search_name1 != null)
                                       @if (preg_match("/$search_name1/", $emp->name) == 0 && preg_match("/$search_name1/", $emp->id) == 0)
                                           <?php continue; ?>
                                       @endif
                                   @endif
                                   <tr id="<?php echo $count_loop; ?>">
                                       <td class="subcompempname">{{ $emp->id }}</td>
                                       <td class="subcompempname">{{ $emp->name }}</td>
                                       {{-- 提出済IDの配列に存在するかどうか --}}
                                       @if (in_array($emp->id, $submitcompempid))
                                           <td style="background-color:#55f;">済</td>
                                           <td class="subcompempname_btn"><button
                                                   style="background-color:#55f;">確認</button></td>
                                       @else
                                           <td style="background-color:#f55;">未</td>
                                           <td class="subcompempname_btn"><button
                                                   style="background-color:#f55;">通知</button>
                                           </td>
                                       @endif
                                   </tr>
                                   <?php
                                   $count_loop = $count_loop + 1;
                                   ?>
                               @endforeach
                           </tbody>
                       </table>
                   @endif
                   {{-- 件数に対するページ数計算 --}}
                   <?php
                   $pagination1 = ceil($count_loop / 4);
                   ?>
                   <ul class="pagination">
                       {{-- ページ数分ループで表示 --}}
                       <?php for ($x=1; $x <= $pagination1 ; $x++) { ?>
                       <li><a class='pagetab'
                               href="?page1=<?php echo $x; ?>&search_name1=<?php echo $search_name1; ?>"><?php echo $x; ?></a>
                       </li>
                       <?php } ?>
                   </ul>
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
                                   <th>name</th>
                                   <th>提出状況</th>
                                   <th>view</th>
                               </tr>
                           </thead>
                           <?php
                           if (isset($_GET['page2'])) {
                               $page2 = (int) $_GET['page2']; //ページの取得
                           } else {
                               $page2 = 1; //始めのページ
                           }
                           if (isset($_GET['search_name2'])) {
                               $search_name2 = $_GET['search_name2']; //検索名前取得
                           } else {
                               $search_name2 = null;
                           }
                           if (isset($_GET['refinement2'])) {
                               $refinement = $_GET['refinement2']; //検索内容取得
                           } else {
                               $refinement = null;
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
                                   {{-- 提出済みを押している＋提出した人が存在しない場合 --}}
                                   @if ($refinement == 1)
                                       @if (in_array($part->id, $submitcomppartid) == false)
                                           <?php continue; ?>
                                       @endif
                                   @elseif($refinement == 2)
                                       @if (in_array($part->id, $submitcomppartid))
                                           <?php continue; ?>
                                       @endif
                                   @endif
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
                                   @if ($search_name2 != null)
                                       @if (preg_match("/$search_name2/", $part->name) == 0)
                                           <?php continue; ?>
                                       @endif
                                   @endif
                                   <?php $i = 0; ?>
                                   <tr id="<?php echo $count_loop; ?>">
                                       <td class="subcomppartname">{{ $part->id }}</td>
                                       <td class="subcomppartname">{{ $part->name }}</td>
                                       @if (in_array($part->id, $submitcomppartid))
                                           <td style="background-color:#55f;">済</td>
                                           <td class="subcompempname_btn"><button
                                                   style="background-color:#55f;">確認</button></td>
                                       @else
                                           <td style="background-color:#f55;">未</td>
                                           <td class="subcompempname_btn"><button
                                                   style="background-color:#f55;">通知</button>
                                           </td>
                                       @endif
                                   </tr>
                                   <?php
                                   $count_loop = $count_loop + 1;
                                   ?>
                               @endforeach
                           </tbody>
                       </table>
                   @endif
                   <?php
                   $pagination2 = ceil($count_loop / 4);
                   ?>
                   <ul class="pagination">
                       <?php for ($x=1; $x <= $pagination2 ; $x++) { ?>
                       <li><a class='pagetab2_<?php echo $x; ?>'
                               href="?tab=2&page2=<?php echo $x; ?>&search_name2=<?php echo $search_name2; ?>"><?php echo $x; ?></a>
                       </li>
                       <?php } ?>
                   </ul>
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
