<?php

	namespace App\Http\Controllers\tokuchan;
	use Livewire\Commands\S3CleanupCommand;

    class MainController{

        function main(){
			ini_set('max_execution_time', 0);

			(int) $StaffStatus = 15;
			(int) $MaxWeight = 4;
			(int) $LowestWeight = 1;
			// int $NeedShift[][] = new int[days][2]要な人数
			$ShiftDivider = ["10-23","11-23","10-17","11-17","15-23","17-23","18-23","18.5-23","19-23"];
			$NextDivider = [["10-23","11-23"],["11-23","10-17","17-23"],["10-17","11-17"],["15-23","17-23"],["17-23","18-23"],["18-23","18.5-23"],["18.5-23","19-23"]];
			$dotw = [[1,0],[2,0],[3,1],[4,1],[5,1],[6,1],[7,0],[8,0],[9,0],[10,0],[11,1],[12,1] ,[13,1],[14,0],[15,0],[16,0],[17,0],[18,1],[19,1],[20,1],[21,0],[22,1],[23,1],[24,0],[25,1],[26,1],[27,1],[28,0],[29,0],[30,0]];
			$ShiftDividerCount = count($ShiftDivider);

			$StaffShift = [//テストケース　提出シフト
			["0" ,"10-23","-1"   ,"-1"   ,"10-23","10-23","17-23","17-23","10-23","17-23","17-23","-1"   ,"-1"   ,"17-23","-1"   ,"-1"   ,"11-23","17-23","-1"   ,"10-23","10-23","17-23","17-23","10-23","17-23","17-23","-1"   ,"-1"   ,"17-23","-1"   ,"-1"   ],
			["1" ,"10-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","10-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","10-23","18-23","18-23","10-23","-1"   ,"18-23","18-23","18-23"],
			["2" ,"17-23","18-23","17-23","-1"   ,"-1"   ,"-1"   ,"17-23","17-23","18-23","17-23","17-23","17-23","-1"   ,"-1"   ,"-1"   ,"17-23","18-23","17-23","-1"   ,"-1"   ,"-1"   ,"17-23","17-23","18-23","17-23","17-23","17-23","-1"   ,"-1"   ,"-1"   ],
			["3" ,"17-23","17-23","-1"   ,"17-23","17-23","-1"   ,"18-23","17-23","17-23","-1"   ,"17-23","18-23","-1"   ,"18-23","-1"   ,"17-23","17-23","-1"   ,"17-23","17-23","-1"   ,"18-23","17-23","17-23","-1"   ,"17-23","18-23","-1"   ,"18-23","-1"   ],
			["4" ,"-1"   ,"-1"   ,"17-23","17-23","15-23","18-23","15-23","-1"   ,"-1"   ,"17-23","-1"   ,"17-23","18-23","-1"   ,"-1"   ,"-1"   ,"-1"   ,"17-23","17-23","15-23","18-23","15-23","-1"   ,"-1"   ,"17-23","-1"   ,"17-23","18-23","-1"   ,"-1"   ],
			["5" ,"-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"17-23","17-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23"],
			["6" ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ,"-1"   ],
			["7" ,"18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23","18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23"],
			["8" ,"18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23"],
			["9" ,"-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ],
			["10","18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23","18-23","17-23","18-23","-1"   ,"-1"   ,"15-23","18-23","-1"   ,"17-23","18-23","18-23","15-23","15-23","-1"   ,"18-23"],
			["11","18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23","18-23","18-23","-1"   ,"18-23","18-23","18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","18-23","18-23","18-23","18-23"],
			["12","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ,"18-23","-1"   ,"-1"   ,"18-23","-1"   ,"18-23","-1"   ]
			
			];


			$staff = [
					 ["徳澤","4","0","0","18","Y","N","Y","0","130","-1","-1","-1","-1","-1"],
					 ["檜田","3","0","0","18","Y","N","Y","1","-1","120","-1","-1","-1","-1"],
					 ["三浦","3","0","0","18","Y","N","Y","2","-1","120","-1","-1","-1","-1"],
					 ["田中","3","0","0","18","Y","N","Y","3","-1","120","-1","-1","-1","-1"],
					 ["江田","3","0","0","18","Y","N","Y","4","-1","120","-1","-1","-1","-1"],
					 ["福田","3","0","0","18","Y","N","Y","5","-1","120","-1","-1","-1","-1"],
					 ["古澤","1","0","0","18","Y","N","Y","6","-1","120","-1","-1","-1","-1"],
					 ["小畑","3","0","0","18","Y","N","Y","7","-1","120","-1","-1","-1","-1"],			
					 ["豊福","1","0","0","18","Y","N","Y","8","-1","120","-1","-1","-1","-1"],
					 ["中田","3","0","0","18","Y","N","Y","9","-1","120","-1","-1","-1","-1"],
					 ["工藤","1","0","0","18","Y","N","Y","10","-1","120","-1","-1","-1","-1"],
					 ["津曲","2","0","0","18","Y","N","Y","11","-1","120","-1","-1","-1","-1"],
					 ["山村","3","0","0","18","Y","N","Y","12","-1","120","-1","-1","-1","-1"]
					 ];

					 $NeedShift = [//テストケース　必要シフト
						["1","10-23","17-23","17-23","18-23","18-23"],
						["2","10-23","17-23","17-23","18-23"],
						["3","17-23","17-23","17-23","18-23","18-23"],
						["4","15-23","17-23","17-23","18-23"],
						["5","15-23","17-23","18-23","18-23"],
						["6","15-23","17-23","18-23","18-23"],
						["7","15-23","17-23","18-23","18-23","18-23"],
						["8","10-17","15-23","17-23","17-23","17-23"],
						["9","17-23","17-23","17-23","18-23"],
						["10","17-23","17-23","17-23","18-23","18-23"],
						["11","10-23","17-23","18-23","18-23"],
						["12","15-23","17-23","17-23","18-23","18-23"],
						["13","15-23","18-23","18-23","18-23","18-23"],
						["14","18-23","18-23","18-23","18-23"],
						["15","18-23","18-23","18-23","18-23"],
						["16","10-23","10-23","17-23","17-23","18-23","18.5-23"],
						["17","17-23","17-23","18-23"],
						["18","17-23","17-23","17-23","18-23","18-23"],
						["19","15-23","17-23","17-23","18-23"],
						["20","15-23","17-23","18-23","18-23"],
						["21","15-23","17-23","18-23","18-23"],
						["22","15-23","17-23","18-23","18-23","18-23"],
						["23","10-17","15-23","17-23","17-23","17-23"],
						["24","17-23","17-23","17-23","18-23"],
						["25","17-23","17-23","17-23","18-23","18-23"],
						["26","10-23","17-23","18-23","18-23"],
						["27","15-23","17-23","17-23","18-23","18-23"],
						["28","15-23","18-23","18-23","18-23","18-23"],
						["29","18-23","18-23","18-23","18-23"],
						["30","18-23","18-23","18-23","18-23"]
					 ];

			(int) $days = 30;
			(int) $StaffNum = count($staff);
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
			

			
			$c = 0;
			do{
				/*if($c == 40){
					break;
				}$c++;*/
				$Bsc->RoadTimes($EndShift);
				$Bsc->MaxMin($Bsc->RoadTimes($EndShift),$staff,$days, 30 );
				$EndShift = $Bsc->beSort($PerfectShift, $staff, $Bsc->RoadTimes($EndShift), $EndShift);
				}while($Bsc->Stoper1($staff));
				do{
					$Bsc->RoadTimes($EndShift);
					$Bsc->MaxMin($Bsc->RoadTimes($EndShift), $staff, $days, 30);
					$EndShift = $Bsc->beSort2($PerfectShift, $staff, $Bsc->RoadTimes($EndShift), $EndShift);
				}while($Bsc->Stoper2($staff));
			
			print_r($EndShift);

        }
	}

?>