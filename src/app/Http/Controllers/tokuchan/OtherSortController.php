<?php 

namespace App\Http\Controllers\tokuchan;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class OtherSortController extends Controller
{
	function SubRate($days, $Ycounter, $staff)
	{ //提出率を出すメソッド

		for ($i = 0; count($staff) > $i; $i++) {

			(double) $StaffDays = $Ycounter[$i];
			(int) $result = floor(($StaffDays / $days) * 100); //提出率を算出
			$staff[$i][5] = (String) $result;
		}



		return $staff;
	}

	function DeSort($staff)
	{ //従業員を重み順に並べ替えるメソッド

		$SortStaff = $staff;

		for ($i = 0; count($SortStaff) > $i; $i++) {
			$Sort_keys[$i] = $SortStaff[$i][1];
		}

		array_multisort($Sort_keys, SORT_DESC, $SortStaff);

		return $SortStaff;

	}

	function Ycounter($StaffShift, $StaffNum)
	{ //従業員ごとの出勤日数をカウントするメソッド
		$Ycounter = array_fill(0, count($StaffShift) , 0);

		for ($i = 0; count($StaffShift) > $i; $i++) {
			for ($j = 1; count($StaffShift[$i]) > $j; $j++) {
				if (0 != strcmp($StaffShift[$i][$j],"-1")) {
					$Ycounter[$i]++;
				}
			}
		}
		return $Ycounter;
	}

	function NeedShiftCounter($days, $ShiftDivider, $NeedShift, $now)
	{ //時間帯ごとの必要なスタッフ数
		$NeedShiftDays = [];
		for ($i = 0; $days > $i; $i++) { //必要なスタッフ数配列の初期化
			$NeedShiftDays[$i] = [$i + 1, 0];
		}



		for ($i = 0; count($NeedShiftDays) > $i; $i++) { //必要なスタッフ数を割り出し
			for ($j = 1; count($NeedShiftDays[$i]) > $j; $j++) {
				for ($k = 0; count($NeedShift[$i]) > $k; $k++) {
					if (0 == strcmp($ShiftDivider[$now],$NeedShift[$i][$k])) {
						$NeedShiftDays[$i][$j]++;
					}
				}
			}
		}

		return $NeedShiftDays;

	}

	function ShiftCalc($StaffShift, $StaffShiftClone, $now, $ShiftDivider)
	{ //決定するシフトの整理

		for ($i = 0; count($StaffShift) > $i; $i++) {
			for ($j = 0; count($StaffShift[$i]) > $j; $j++) {
				if (0 != strcmp($StaffShiftClone[$i][$j],"*")) {
					$StaffShiftClone[$i][$j] = $StaffShift[$i][$j];
				}
			}
		}

		for ($i = 0; count($StaffShift) > $i; $i++) { //~のシフトを作成する場合
			for ($j = 1; count($StaffShift[$i]) > $j; $j++) {
				if (strpos($StaffShiftClone[$i][$j], "-") == 0 || !str_contains($StaffShiftClone[$i][$j], "-")) { //シフトの値が-1だった場合スキップ（提出されてない場合）
					continue;
				}
				(int) $num1 = strpos($StaffShiftClone[$i][$j], "-"); //出勤、退勤抜き出しに使用
				(double) $in1 = (Double) substr($StaffShiftClone[$i][$j], 0, $num1); //提出シフトの出勤時間抜き出し
				(double) $out1 = (Double) substr($StaffShiftClone[$i][$j], $num1 + 1); //提出シフトの退勤時間抜き出し

				(int) $num2 = strpos($ShiftDivider[$now], "-");
				(double) $in2 = (Double) substr($ShiftDivider[$now], 0, $num2); //募集シフトの出勤時間抜き出し
				(double) $out2 = (Double) substr($ShiftDivider[$now], $num2 + 1); //募集シフトの退勤時間抜き出し



				if ($in2 >= $in1 && $out2 <= $out1) { //出勤時間と退勤時間が当てはまるか検査
					$StaffShiftClone[$i][$j] = "Y";
				} else {
					$StaffShiftClone[$i][$j] = "-1";
				}
			}
		}
		return $StaffShiftClone;
	}

	function ShiftDup($Shift, $ShiftDivider, $StaffShiftClone2, $now)
	{

		for ($i = 0; count($Shift) > $i; $i++) {
			for ($j = 1; count($Shift[$i]) > $j; $j++) {
				if (0 == strcmp($Shift[$i][$j],$ShiftDivider[$now])) {
					$StaffShiftClone2[$i][$j] = "*";
				}
			}
		}
		return $StaffShiftClone2;
	}

	function End($Shift, $EndShift, $ShiftDivider, $staff, $now)
	{ //完成用のシフト
		for ($i = 0; count($Shift) > $i; $i++) {
			for ($j = 0; count($Shift[$i]) > $j; $j++) {
				if ($j == 0) {
					$EndShift[$i][$j] = $i;
				}
				if (0 == strcmp($Shift[$i][$j],$ShiftDivider[$now])) {
					$EndShift[$i][$j] = $Shift[$i][$j]; //コピー元に干渉しないように　完成のシフトシフト
				} else if (0 == strcmp($Shift[$i][$j],"-")) {
					$EndShift[$i][$j] = "-";
				} else if (0 == strcmp($Shift[$i][$j],"×")) {
					$EndShift[$i][$j] = "×";
				}

			}
		}

		return $EndShift;
	}
	function ShiftOpti($StaffShift, $NextDivider, $NeedShift, $days)
	{ //決定するシフトの整理（例：１７時がいなかった場合１８時から入れる）

		$StaffShiftCount = array_fill(0, $days, 0);
		$ResultShiftCount = array_fill(0, $days, 0);
		$NoStaffShift = array_fill(0, $days, 0);

		$MinusStaff = [[]];

		for ($i = 0; $days > $i; $i++) {
			for ($j = 0; count($StaffShift) > $j; $j++) {
				$MinusStaff[$i][$j] = 0;
			}
		}

		$StaffShift2 = [[]];

		for ($i = 0; count($StaffShift) > $i; $i++) { //整列用変数のコピー
			for ($j = 0; count($StaffShift[$i]) > $j; $j++) {
				$StaffShift2[$i][$j] = $StaffShift[$i][$j]; //コピー元に干渉しないように　シフト作成用シフト抽出変数

			}
		}


		for ($h = 0; count($NextDivider) > $h; $h++) {


			for ($g = 0; /*NextDivider[h].length - 1  要素数は最大３であり、処理が決まっているので１でOK*/1 > $g; $g++) {

				/*if(g == 1) {//要素数３の配列を最適化したら終わる
				break;
				}*/

				for ($i = 0; count($StaffShift2) > $i; $i++) {
					for ($j = 1; count($StaffShift2[$i]) > $j; $j++) {

						if (strpos($StaffShift2[$i][$j], "-") == 0 || !str_contains($StaffShift2[$i][$j], "-")) { //シフトの値が-1だった場合スキップ（提出されてない場合）
							continue;
						}

						(int) $num1 = strpos($StaffShift2[$i][$j], "-"); //出勤、退勤抜き出しに使用
						(double) $in1 = (double) substr($StaffShift2[$i][$j], 0, $num1); //提出シフトの出勤時間抜き出し
						(double) $out1 = (double) substr($StaffShift2[$i][$j], $num1 + 1); //提出シフトの退勤時間抜き出し

						(int) $num2 = strpos($NextDivider[$h][$g], "-");
						(double) $in2 = (double) substr($NextDivider[$h][$g], 0, $num2); //募集シフトの出勤時間抜き出し
						(double) $out2 = (double) substr($NextDivider[$h][$g], $num2 + 1); //募集シフトの退勤時間抜き出し



						if ($in2 >= $in1 && $out2 <= $out1) {
							$MinusStaff[$j - 1][$StaffShiftCount[$j - 1]] = $i;
							$StaffShiftCount[$j - 1]++;
							
						}
					}

				}
				

				
				for ($i = 0; count($NeedShift) > $i; $i++) {
					for ($j = 0; count($NeedShift[$i]) > $j; $j++) {//-1??

						/*int num1 = ResultShift[i][j + 1].indexOf("-");//出勤、退勤抜き出しに使用
						double in1 =  Double.parseDouble(ResultShift[i][j + 1].substring(0,num1));//提出シフトの出勤時間抜き出し
						double out1 =  Double.parseDouble(ResultShift[i][j + 1].substring(num1 + 1));//提出シフトの退勤時間抜き出し
						
						int num2 = NextDivider[h][g].indexOf("-");
						double in2 = Double.parseDouble(NextDivider[h][g].substring(0,num2));//募集シフトの出勤時間抜き出し
						double out2 = Double.parseDouble(NextDivider[h][g].substring(num2 + 1));//募集シフトの退勤時間抜き出し
						
						
						
						if(in2 >= in1 && out2 <= out1) {
						ResultShiftCount[i]++;
						}*/
						if($j == 0){
							continue;
						}
						if (0 == strcmp($NeedShift[$i][$j],$NextDivider[$h][$g])) {
							$ResultShiftCount[$i]++;
						}
					}

				}





				for ($f = 0; count($StaffShiftCount) > $f; $f++) {

					if ($ResultShiftCount[$f] > $StaffShiftCount[$f]) {
						$NoStaffShift[$f] = $ResultShiftCount[$f] - $StaffShiftCount[$f];
						for ($d = 0; count($NeedShift[$f]) > $d; $d++) {
							if (0 == strcmp($NeedShift[$f][$d],$NextDivider[$h][$g])) {

								if (count($NextDivider[$h]) == 3) { //候補が2つ以上あった場合
									$NeedShift[$f][$d] = $NextDivider[$h][$g + 1];
									array_push($NeedShift[$f],$NextDivider[$h][$g + 2]);
									$NoStaffShift[$f]--;
								} else {
									//StaffShift2[MinusStaff[f][StaffShiftCount[f]]][f + 1]  = "-1";
									$NeedShift[$f][$d] = $NextDivider[$h][$g + 1];
									$NoStaffShift[$f]--;
								}
								if ((int)$NoStaffShift[$f] == 0) {
									break;
								}
							}
						}
					} else if (0 == strcmp($ResultShiftCount[$f],$StaffShiftCount[$f])) { //ちょうど足りていた場合に出勤スタッフをマイナス
						for ($a = 0; $StaffShiftCount[$f] > $a; $a++) {
							$StaffShift2[$MinusStaff[$f][$StaffShiftCount[$f]]][$f + 1] = "-1";
						}
					}
					$ResultShiftCount[$f] = 0;
					$StaffShiftCount[$f] = 0;
				}

				/*
				for(int i = 0; ResultShift.length > i; i++) {//確認用
				for(int j = 0; ResultShift[i].length > j; j++) {
				System.out.print(ResultShift[i][j] + "　");
				}
				System.out.println();
				}
				
				
				for(int i = 0; StaffShift2.length > i; i++) {//確認用
				for(int j = 0; StaffShift2[i].length > j; j++) {
				System.out.print(StaffShift2[i][j] + "　");
				}
				System.out.println();
				}
				*/



			}



		}
		return $NeedShift;

	}

// 	/**
// 	 * 全角文字は２桁、半角文字は１桁として文字数をカウントする
// 	 * @param str 対象文字列
// 	 * @return 文字数
// 	 */
// 	function getHan1Zen2($str) {

// 	  //戻り値
// 	  (int) $ret = 0;

// 	  //全角半角判定
// 	  char[] c = str.toCharArray();
// 	  for(int i=0;i<c.length;i++) {
// 		if(String.valueOf(c[i]).getBytes().length <= 1){
// 		  ret += 1; //半角文字なら＋１
// 		}else{
// 		  ret += 2; //全角文字なら＋２
// 		}
// 	  }

// 	  return ret;
// 	}
// }

}

?>