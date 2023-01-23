<?php

	namespace App\Http\Controllers\tokuchan;
	use Illuminate\Support\Facades\Auth;
	use App\Models\admin;
	use App\Models\Store;
	use App\Models\Employee;
	use App\Models\Parttimer;
	use Livewire\Commands\S3CleanupCommand;
	use App\Models\StaffShift;
	use App\Models\NeedShift;
	use App\Models\Shiftdivider;
	use App\Models\Nextdivider;
	use App\Models\CompleteShift;

    class MainController{

        function main(){
			//$asa ini_get('max_execution_time');
			//set_time_limit(3000);
			$month = 1;//何月のシフトを作成するか
			(int) $StaffStatus = 6;//固定値
			(int) $MaxWeight = 4;//固定値
			(int) $LowestWeight = 1;//固定値
			$month;
			// int $NeedShift[][] = new int[days][2]要な人数
			//$ShiftDivider = [];
			//$NextDivider = [["10-23","11-23"],["11-23","10-17","17-23"],["10-17","11-17"],["15-23","17-23"],["17-23","18-23"],["18-23","18.5-23"],["18.5-23","19-23"]];
			$dotw = [[1,0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,0],[8,0],[9,0],[10,0],
					[11,0],[12,0] ,[13,0],[14,0],[15,0],[16,0],[17,0],[18,0],[19,0],
					[20,0],[21,0],[22,0],[23,0],[24,0],[25,0],[26,0],[27,0],[28,0],
					[29,0],[30,0],[31,0]];//繁忙期が1,そうでない時期は0 1の場合は重み順に入れられる

			//  $StaffShift = [//テストケース　提出シフト
			//  ["0" ,"10-23","-1"   ,"-1"   ,"10-23","10-23","17-23","17-23","10-23","17-23","17-23","-1"   ,"-1"   ,"17-23","-1"   ,"-1"   ,"11-23","17-23","-1"   ,"10-23","10-23","17-23","17-23","10-23","17-23","17-23","-1"   ,"-1"   ,"17-23","-1"   ,"-1"   ,"18-23"],
			//  ["1" ,"10-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","10-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","10-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","18-23","18-23"],
			//  ["2" ,"17-23","18-23","17-23","-1"   ,"-1"   ,"-1"   ,"17-23","17-23","18-23","17-23","17-23","17-23","-1"   ,"-1"   ,"-1"   ,"17-23","18-23","17-23","-1"   ,"-1"   ,"-1"   ,"17-23","17-23","18-23","17-23","17-23","17-23","-1"   ,"-1"   ,"-1"   ,"18-23"],
			//  ["3" ,"17-23","17-23","-1"   ,"17-23","17-23","-1"   ,"18-23","17-23","17-23","-1"   ,"17-23","18-23","-1"   ,"18-23","-1"   ,"17-23","17-23","-1"   ,"17-23","17-23","-1"   ,"18-23","17-23","17-23","-1"   ,"17-23","18-23","-1"   ,"18-23","-1"   ,"18-23"],
			//  ["4" ,"-1"   ,"-1"   ,"17-23","17-23","15-23","18-23","15-23","-1"   ,"-1"   ,"17-23","-1"   ,"17-23","18-23","-1"   ,"-1"   ,"-1"   ,"-1"   ,"17-23","17-23","15-23","18-23","15-23","-1"   ,"-1"   ,"17-23","-1"   ,"17-23","18-23","-1"   ,"-1"   ,"18-23"],
			//  ["5" ,"-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23"],
			//  ["6" ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"18-23"],
			//  ["7" ,"18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23","18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23","18-23"],
			//  ["8" ,"18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23"],
			//  ["9" ,"-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23"],
			//  ["10","18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23","18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23","18-23"],
			//  ["11","18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23"]//,
			//  //["12","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ]
			//  ];

			$storeid = 1;

			//store1のシフト時間の次候補を取得
			
			$NextDividerdb = Nextdivider::where('store_id',$storeid)->get();
			$counterX = 0;
			foreach($NextDividerdb as $ndd){
				$NextDivider[$counterX][0] = $ndd->main;
				$NextDivider[$counterX][1] = $ndd->sub1;
				$NextDivider[$counterX][2] = $ndd->sub2;
				$how = count($NextDivider[$counterX]);
				for($i = 0; $how > $i; $i++){
					if(is_null($NextDivider[$counterX][$i])){
						unset($NextDivider[$counterX][$i]);
					}
				}
				$NextDivider = array_values($NextDivider);
				$counterX++;
			}
			
			//store1のシフト時間候補を取得
			$storeid =1;
			$ShiftDividerdb = Shiftdivider::where('store_id',$storeid)->get();
			$counterX = 0;
			foreach($ShiftDividerdb as $sdd){
				$ShiftDivider[0] = $sdd->time1;$ShiftDivider[1] = $sdd->time2;$ShiftDivider[2] = $sdd->time3;
				$ShiftDivider[3] = $sdd->time4;$ShiftDivider[4] = $sdd->time5;$ShiftDivider[5] = $sdd->time6;
				$ShiftDivider[6] = $sdd->time7;$ShiftDivider[7] = $sdd->time8;$ShiftDivider[8] = $sdd->time9;
				$ShiftDivider[9] = $sdd->time10;$ShiftDivider[10] = $sdd->time11;$ShiftDivider[11] = $sdd->time12;
				$ShiftDivider[12] = $sdd->time13;$ShiftDivider[13] = $sdd->time14;$ShiftDivider[14] = $sdd->time15;
				$how = count($ShiftDivider);
				for($i = 0; $how > $i; $i++){
					if(is_null($ShiftDivider[$i])){
						unset($ShiftDivider[$i]);
					}
				}
				
				$ShiftDivider = array_values($ShiftDivider);
			}
			//print_r($ShiftDivider);
			$ShiftDividerCount = count($ShiftDivider);
			//store1の必要なシフトを取得
			
			$NeedShiftdb = NeedShift::where('store_id',$storeid)->get();
			$counterX = 0;
			foreach($NeedShiftdb as $nsd){
				$NeedShift2[$counterX][0] = $nsd->day;
				$NeedShift2[$counterX][1] = $nsd->time1;
				$NeedShift2[$counterX][2] = $nsd->time2;
				$NeedShift2[$counterX][3] = $nsd->time3;
				$NeedShift2[$counterX][4] = $nsd->time4;
				$NeedShift2[$counterX][5] = $nsd->time5;
				$NeedShift2[$counterX][6] = $nsd->time6;
				$NeedShift2[$counterX][7] = $nsd->time7;
				$NeedShift2[$counterX][8] = $nsd->time8;
				$NeedShift2[$counterX][9] = $nsd->time9;
				$NeedShift2[$counterX][10] = $nsd->time10;
				$how = count($NeedShift2[$counterX]);
				for($i = 0; $how > $i; $i++){
					if(is_null($NeedShift2[$counterX][$i])){
						unset($NeedShift2[$counterX][$i]);
					}
				}
				$NeedShift2 = array_values($NeedShift2);
				$counterX++;
			}
			//print_r($NeedShift);
			//store1のスタッフの提出シフトの取得
			//提出シフトが31日前提　固定値が３か所ほどあるので注意
			
			$StaffShiftdb = StaffShift::where('store_id',$storeid)->where('month',$month)->get();
			$counterX = 0;
			foreach($StaffShiftdb as $ssd){
				$StaffShift[$counterX][0] = $counterX;
				$StaffShift[$counterX][1] = $ssd->day1;$StaffShift[$counterX][2] = $ssd->day2;$StaffShift[$counterX][3] = $ssd->day3;
				$StaffShift[$counterX][4] = $ssd->day4;$StaffShift[$counterX][5] = $ssd->day5;$StaffShift[$counterX][6] = $ssd->day6;
				$StaffShift[$counterX][7] = $ssd->day7;$StaffShift[$counterX][8] = $ssd->day8;$StaffShift[$counterX][9] = $ssd->day9;
				$StaffShift[$counterX][10] = $ssd->day10;$StaffShift[$counterX][11] = $ssd->day11;$StaffShift[$counterX][12] = $ssd->day12;
				$StaffShift[$counterX][13] = $ssd->day13;$StaffShift[$counterX][14] = $ssd->day14;$StaffShift[$counterX][15] = $ssd->day15;
				$StaffShift[$counterX][16] = $ssd->day16;$StaffShift[$counterX][17] = $ssd->day17;$StaffShift[$counterX][17] = $ssd->day17;
				$StaffShift[$counterX][18] = $ssd->day18;$StaffShift[$counterX][19] = $ssd->day19;$StaffShift[$counterX][20] = $ssd->day20;
				$StaffShift[$counterX][21] = $ssd->day22;$StaffShift[$counterX][22] = $ssd->day22;$StaffShift[$counterX][23] = $ssd->day23;
				$StaffShift[$counterX][24] = $ssd->day24;$StaffShift[$counterX][25] = $ssd->day25;$StaffShift[$counterX][26] = $ssd->day26;
				$StaffShift[$counterX][27] = $ssd->day27;$StaffShift[$counterX][28] = $ssd->day28;$StaffShift[$counterX][29] = $ssd->day29;
				$StaffShift[$counterX][30] = $ssd->day30;$StaffShift[$counterX][31] = $ssd->day31;
				$how = count($StaffShift[$counterX]);
				for($i = 0; $how > $i; $i++){
					if(is_null($StaffShift[$counterX][$i])){
						unset($StaffShift[$counterX][$i]);
					}
				}
				$StaffShift = array_values($StaffShift);
				$counterX++;
			}


			//store1のスタッフのステータスの取得
			
			// $adminid=Auth::guard('admin')->id();
        	// $storeid = admin::where('id',$adminid)->value('store_id');
        	$employees = Employee::where('store_id',$storeid)->get();
        	$parttimers = Parttimer::where('store_id',$storeid)->get();
			$counterX = 0;
			foreach($employees as $emp){
				$staff[$counterX][0] = $emp->name;
				$staff[$counterX][1] = $emp->weight;
				$staff[$counterX][2] = $emp->monthminworktime;
				$staff[$counterX][3] = $emp->monthmaxworktime;
				$staff[$counterX][4] = $counterX;
				$staff[$counterX][5] = 0;
				$counterX++;
			}
			foreach($parttimers as $emp){
				$staff[$counterX][0] = $emp->name;
				$staff[$counterX][1] = $emp->weight;
				$staff[$counterX][2] = $emp->monthminworktime;
				$staff[$counterX][3] = $emp->monthmaxworktime;
				$staff[$counterX][4] = $counterX;
				$staff[$counterX][5] = 0;
				$counterX++;
			}
			


			// $staff = [
			// 		 ["徳澤","4","0","0","18","Y","N","Y","0","130","-1","-1","-1","-1","-1"],
			// 		 ["檜田","3","0","0","18","Y","N","Y","1","-1","120","-1","-1","-1","-1"],
			// 		 ["三浦","3","0","0","18","Y","N","Y","2","-1","120","-1","-1","-1","-1"],
			// 		 ["田中","3","0","0","18","Y","N","Y","3","-1","120","-1","-1","-1","-1"],
			// 		 ["江田","3","0","0","18","Y","N","Y","4","-1","120","-1","-1","-1","-1"],
			// 		 ["福田","3","0","0","18","Y","N","Y","5","-1","120","-1","-1","-1","-1"],
			// 		 ["古澤","1","0","0","18","Y","N","Y","6","-1","120","-1","-1","-1","-1"],
			// 		 ["小畑","3","0","0","18","Y","N","Y","7","-1","120","-1","-1","-1","-1"],
			// 		 ["豊福","1","0","0","18","Y","N","Y","8","-1","120","-1","-1","-1","-1"],
			// 		 ["中田","3","0","0","18","Y","N","Y","9","-1","120","-1","-1","-1","-1"],
			// 		 ["工藤","1","0","0","18","Y","N","Y","10","-1","120","-1","-1","-1","-1"],
			// 		 ["津曲","2","0","0","18","Y","N","Y","11","-1","120","-1","-1","-1","-1"],
			// 		 ["山村","3","0","0","18","Y","N","Y","12","-1","120","-1","-1","-1","-1"]
			// 		 ];

					//   $NeedShift = [//テストケース　必要シフト
					//  	["1","10-23","17-23","17-23","18-23","18-23"],
					//  	["2","10-23","17-23","17-23","18-23"],
					//  	["3","17-23","17-23","17-23","18-23","18-23"],
					//  	["4","15-23","17-23","17-23","18-23"],
					//  	["5","15-23","17-23","18-23","18-23"],
					//  	["6","15-23","17-23","18-23","18-23"],
					//  	["7","15-23","17-23","18-23","18-23","18-23"],
					//  	["8","10-17","15-23","17-23","17-23","17-23"],
					//  	["9","17-23","17-23","17-23","18-23"],
					//  	["10","17-23","17-23","17-23","18-23","18-23"],
					//  	["11","10-23","17-23","18-23","18-23"],
					//  	["12","15-23","17-23","17-23","18-23","18-23"],
					//  	["13","15-23","18-23","18-23","18-23","18-23"],
					//  	["14","18-23","18-23","18-23","18-23"],
					//  	["15","18-23","18-23","18-23","18-23"],
					//  	["16","10-23","10-23","17-23","17-23","18-23","18.5-23"],
					//  	["17","17-23","17-23","18-23"],
					//  	["18","17-23","17-23","17-23","18-23","18-23"],
					//  	["19","15-23","17-23","17-23","18-23"],
					//  	["20","15-23","17-23","18-23","18-23"],
					//  	["21","15-23","17-23","18-23","18-23"],
					//  	["22","15-23","17-23","18-23","18-23","18-23"],
					//  	["23","10-17","15-23","17-23","17-23","17-23"],
					//  	["24","17-23","17-23","17-23","18-23"],
					//  	["25","17-23","17-23","17-23","18-23","18-23"],
					//  	["26","10-23","17-23","18-23","18-23"],
					//  	["27","15-23","17-23","17-23","18-23","18-23"],
					//  	["28","15-23","18-23","18-23","18-23","18-23"],
					//  	["29","18-23","18-23","18-23","18-23"],
					//  	["30","18-23","18-23","18-23","18-23"],
					//  	["31","18-23","18-23","18-23"]
					//   ];
					$NeedShift = [[]];
					  for($i = 0; count($NeedShift2) > $i; $i++){
						for($j = 0; count($NeedShift2[$i]) > $j; $j++){
							$NeedShift[$i][$j] = $NeedShift2[$i][$j];
						}
					  }

			(int) $days = count($StaffShift[0]) - 1;
			(int) $StaffNum = count($staff);
			(int) $LastDay = count($StaffShift[0]) - 1;//作成するシフトの最終日
			$PerfectShift = [[]];


			for($i = 0; count($StaffShift) > $i; $i++) {
				for($j = 0; count($StaffShift[$i]) > $j; $j++) {
					$PerfectShift[$i][$j] = $StaffShift[$i][$j];//コピー元に干渉しないように　シフト作成用シフト抽出変数

				}
			}

			$EndShift = [[]];
			for($i = 0; $StaffNum > $i; $i++){
				$EndShift[$i][0] = $i;
				for ($j = 0; $days + 1 > $j; $j++){
					$EndShift[$i][$j] = "";
				}
			}
			$StaffSHiftClone = $StaffShift;

			$Osc = new OtherSortController;
			$Vsc = new VerticalSortController;
			$Bsc = new BesideSortController($staff);
			$Ycounter = $Osc->Ycounter($StaffShift,$StaffNum);
			$staff = $Osc->SubRate($days,$Ycounter,$staff);
			$SortStaff = $Osc->DeSort($staff);
			$NeedShift = $Osc->ShiftOpti($StaffShift, $NextDivider, $NeedShift, $days);


			for($now = 0;$ShiftDividerCount > $now; $now++){
				$NeedShiftC = $Osc->NeedShiftCounter($days,$ShiftDivider,$NeedShift,$now);
				$StaffShiftClone2 = $Osc->ShiftCalc($StaffShift,$StaffSHiftClone,$now,$ShiftDivider);
				$Shift = $Vsc->verSort($SortStaff, $staff, $NeedShiftC, $StaffShiftClone2, $days, $StaffNum, $MaxWeight, $LowestWeight, $ShiftDivider[$now], $dotw);
				$StaffShiftClone2 = $Osc->ShiftDup($Shift,$ShiftDivider,$StaffShiftClone2,$now);
				$EndShift = $Osc->End($Shift,$EndShift,$ShiftDivider,$staff,$now);
				$StaffSHiftClone = $StaffShiftClone2;
			}

			do{
				$Bsc->RoadTimes($EndShift);
				$Bsc->MaxMin($Bsc->RoadTimes($EndShift),$staff,$days, $LastDay );
				$EndShift = $Bsc->beSort($PerfectShift, $staff, $Bsc->RoadTimes($EndShift), $EndShift);
				echo 1;
				}while($Bsc->Stoper1($staff));
				do{
					$Bsc->RoadTimes($EndShift);
					$Bsc->MaxMin($Bsc->RoadTimes($EndShift), $staff, $days, $LastDay );
					$EndShift = $Bsc->beSort2($PerfectShift, $staff, $Bsc->RoadTimes($EndShift), $EndShift);
					echo 2;
				}while($Bsc->Stoper2($staff));
			//print_r($EndShift);
			//完成したシフトの登録
			$CompleteShiftdb = CompleteShift::where('store_id',$storeid)->where('month',$month)->get();
			$CounterX = 0;
			foreach($CompleteShiftdb as $csd){
				for($i = 1; count($EndShift[$CounterX]) > $i; $i++){
					$dayIs = "day".(String)$i;
					$csd->$dayIs = $EndShift[$CounterX][$i];
				}
				$csd->timestamps = false;
				$csd->save();
				$CounterX++;
			}
			$CounterX = 0;
			foreach($CompleteShiftdb as $csd){
				for($i = 1; count($EndShift[$CounterX]) > $i; $i++){
					$dayIs = "day".(String)$i;
					echo $csd->$dayIs;
				}
				echo '<br>';
				$CounterX++;
			}

			//return view('shiftView', compact('EndShift','StaffShift','staff'));
        }
	}

?>
