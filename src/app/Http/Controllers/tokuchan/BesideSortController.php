<?php

	namespace App\Http\Controllers\tokuchan;
	use Livewire\Commands\S3CleanupCommand;

    class BesideSortController{

		static $CompStaff = [[]];//調整が終わったスタッフを判断するための変数　
		 static $MaxOut = [[]];//最大労働時間をオーバーしてるスタッフのオーバー時間
		 static $MinOut = [[]];//最低労働時間をオーバーしているスタッフのオーバー時間
		 static $MaxTime = [[]];//最大労働時間
		 static $MinTime = [[]];//最低労働時間

	
	function __construct($staff) {

		for($i = 0; count($staff) > $i; $i++){//0 > キー値　1 > 最大労働時間のYN 2 >　最低労働時間のYN
			for($j = 0; 3 > $j; $j++){
	 			BesideSortController::$CompStaff[$i][$j] = "";
	 		}
	 	}
	 	for($i = 0; count($staff) > $i; $i++){//
	 		for($j = 0; 2 > $j; $j++){
	 			(double) BesideSortController::$MaxOut[$i][$j] = 0.0;
	 			(double) BesideSortController::$MinOut[$i][$j] = 0.0;
	 			(double) BesideSortController::$MaxTime[$i][$j] = 0.0;
	 			(double) BesideSortController::$MinTime[$i][$j] = 0.0;
	 		}
	 	}
		
	 	for($i = 0; count($staff) > $i; $i++) {//static変数たちのセット
			BesideSortController::$MaxOut[$i][0] = $staff[$i][4];
			BesideSortController::$MinOut[$i][0] = $staff[$i][4];
			BesideSortController::$MaxTime[$i][0] = $staff[$i][4];
			BesideSortController::$MinTime[$i][0] = $staff[$i][4];
			BesideSortController::$CompStaff[$i][0] = $staff[$i][4];
	 	}
	 }
	
	function RoadTimes($EndShift){//従業員の月の労働時間を求めるメソッド

		for($i = 0; count($EndShift) > $i; $i++){
			for($j = 0; 2 > $j; $j++){
				(double) $StaffTimes[$i][$j] = 0.0;
			}
		}

		for($i = 0; count($StaffTimes) > $i ; $i++) {
			$StaffTimes[$i][0] = (int) $EndShift[$i][0];
		}
		
		for($i = 0; count($EndShift) > $i; $i++) {//各従業員の労働時間を計算するお！！
			for($j = 1; count($EndShift[$i]) > $j; $j++) {
				if(strpos($EndShift[$i][$j],"-") == 0 || !str_contains($EndShift[$i][$j],"-")) {
					continue;
				}
					(int) $num1 = strpos($EndShift[$i][$j],"-");//出勤、退勤抜き出しに使用
					(double) $in1 =  (double) substr($EndShift[$i][$j],0,$num1);//提出シフトの出勤時間抜き出し
					(double) $out1 =  (double) substr($EndShift[$i][$j],$num1 + 1);//提出シフトの退勤時間抜き出し
					$StaffTimes[$i][1] += $out1 - $in1;
			}
		}
		

		
		return $StaffTimes;
	}
	
	function MaxMin($StaffTimes, $staff, $days, $MonthLastDay) {//月の労働上限、下限を調査
		
		(int) $ShiftRatio = $MonthLastDay/$days; //月の何割のシフトを決めるか計算
		
		for($i = 0; count($staff) > $i; $i++) {
				(double) $times = $StaffTimes[$i][1];
				BesideSortController::$MaxTime[$i][1] = (double) $staff[$i][3]  / $ShiftRatio;//最高労働時間取得
				BesideSortController::$MinTime[$i][1] = (double) $staff[$i][2]  / $ShiftRatio;//最低労働時間取得
				
				if(BesideSortController::$MaxTime[$i][1] == -1 && BesideSortController::$MinTime[$i][1] == -1) {//どちらも制限がなければ次のスタッフへ
					continue;
				}else if(BesideSortController::$MaxTime[$i][1] == -1) {
					BesideSortController::$MinOut[$i][1] = BesideSortController::$MinTime[$i][1] - $times;//0より大きければあればアウト
					continue;
				}else if(BesideSortController::$MinTime[$i][1] == -1) {
					BesideSortController::$MaxOut[$i][1] = BesideSortController::$MaxTime[$i][1] - $times;//0以下であればアウト
					continue;
				}
				
				BesideSortController::$MaxOut[$i][1] = BesideSortController::$MaxTime[$i][1] - $times;//0以下であればアウト
				BesideSortController::$MinOut[$i][1] = BesideSortController::$MinTime[$i][1] - $times;//0より大きければあればアウト
		}
		
	}


	function beSort($StaffShift, $staff, $StaffTimes, $EndShift)
	{

		(double) $JobTimeTop = 0.0;
		(int) $TimeTopStaff = 0;
		(int) $MaxCounter = 0;
		(int) $MinCounter = 0;
		(int) $ConseWork = [[]]; //最大連勤数と何日から連勤か
		$CanChange = [[]];

		for ($i = 0; 31 > $i; $i++) {
			for ($j = 0; 2 > $j; $j++) {
				$ConseWork[$i][$j] = 0;
			}
		}


		for ($i = 0; count($staff) > $i; $i++) {
			$CanChange[$i][0] = $staff[$i][4]; //キー値を代入しておく
			$CanChange[$i][1] = "N";
		}

		for ($i = 0; count($staff) > $i; $i++) { //従業員一人ずつ最低労働時間などを参考に時間を調整していく


			/*if(CompStaff[i][1].equals("N")) {//調整が終わっていたら次のスタッフへ
			continue;
			}*/
			if (BesideSortController::$MaxTime[$i][1] == -1 && BesideSortController::$MinTime[$i][1] == -1) { //どちらも制限がなければ次のスタッフへ
				BesideSortController::$CompStaff[$i][1] = "N"; //調整の必要がないためNを代入
				BesideSortController::$CompStaff[$i][2] = "N"; //調整の必要がないためNを代入
				continue;
			}
			if(0 == strcmp(BesideSortController::$CompStaff[$i][1],"YN")){
			}
			else if (0 > BesideSortController::$MaxOut[$i][1]) { //上限労働時間-実際の労働時間がオーバーしている場合
				BesideSortController::$CompStaff[$i][1] = "Y"; //調整の必要があるためYを代入
				$MaxCounter++;
			} else {
				BesideSortController::$CompStaff[$i][1] = "N"; //調整の必要がないためNを代入
			}
			if(0 == strcmp(BesideSortController::$CompStaff[$i][2],"YN")){
			}
			else if (BesideSortController::$MinOut[$i][1] > 0) { //下限労働時間-実際の労働時間がオーバーしている場合
				BesideSortController::$CompStaff[$i][2] = "Y"; //調整の必要があるためYを代入
				$MinCounter++;
			} else {
				BesideSortController::$CompStaff[$i][2] = "N"; //調整の必要がないためNを代入
			}

		}


		if ($MaxCounter == count($staff) || $MinCounter == count($staff)) { //全スタッフが各項目OR全項目調整の必要がある場合は調整が不可能なので処理を返す
			//BesideSortController::$Stop1 = false;
		}

		//int ConseWork2[][] = new int[1][2];//下記ConseWork調整用変数
		$ConseCount = 0; //連勤の回数
		$CanCount = 0;



		for ($i = 0; count(BesideSortController::$CompStaff) > $i; $i++) {
			if (0 == strcmp(BesideSortController::$CompStaff[$i][2], "Y")) { //最低労働時間の調整がある場合
				for ($j = 0; count($EndShift) > $j; $j++) {
					for ($k = 1; count($EndShift[$j]) > $k; $k++) {
						//シフトが休みではなく本人シフトとの比較ではない場合
						if (0 != strcmp($EndShift[$i][$k], "-") && 0 != strcmp($EndShift[$i][$k], "×") && $i != $j) {
							//シフトが休みではない場合
							if (0 != strcmp($EndShift[$j][$k], "-") && 0 != strcmp($EndShift[$j][$k], "×")) {
								(int) $num1 = strpos($EndShift[$i][$k], "-"); //出勤、退勤抜き出しに使用
								(double) $in1 = (double) substr($EndShift[$i][$k], 0, $num1); //出勤時間抜き出し
								(double) $out1 = (double) substr($EndShift[$i][$k], $num1 + 1); //提出シフトの退勤時間抜き出し

								(int) $num2 = strpos($EndShift[$j][$k], "-");
								(double) $in2 = (double) substr($EndShift[$j][$k], 0, $num2); //出勤時間抜き出し
								(double) $out2 = (double) substr($EndShift[$j][$k], $num2 + 1); //退勤時間抜き出し


								(double) $times1 = $out1 - $in1; //労働時間
								(double) $times2 = $out2 - $in2; //労働時間

								//比較対象のほうが一日の労働時間が長かったら
								if ($times2 > $times1) {

									(int) $num3 = strpos($StaffShift[$i][$k], "-"); //出勤、退勤抜き出しに使用
									(double) $in3 = (double) substr($StaffShift[$i][$k], 0, $num3); //提出シフトの出勤時間抜き出し
									(double) $out3 = (double) substr($StaffShift[$i][$k], $num3 + 1); //提出シフトの退勤時間抜き出し

									(int) $num4 = strpos($StaffShift[$j][$k], "-");
									(double) $in4 = (double) substr($StaffShift[$j][$k], 0, $num4); //提出シフトの出勤時間抜き出し
									(double) $out4 = (double) substr($StaffShift[$j][$k], $num4 + 1); //提出シフトの退勤時間抜き出し

									if ($in2 >= $in3 && $out2 <= $out3 && $in1 >= $in4 && $out1 <= $out4) {
										(String) $hinan = $EndShift[$j][$k];
										$EndShift[$j][$k] = $EndShift[$i][$k];
										$EndShift[$i][$k] = $hinan;
									}

								}
							}
						}
					}
				}
			}
		}




		for ($i = 0; count(BesideSortController::$CompStaff) > $i; $i++) {
			if (0 == strcmp(BesideSortController::$CompStaff[$i][2], "Y")) { //最低労働時間の調整がある場合
				for ($j = 1; count($EndShift[$i]) > $j; $j++) { //残り提出シフトがない場合
					if (0 == strcmp($EndShift[$i][$j], "-")) {
						$CanCount++;
					}
				}
				if ($CanCount == 0) { //提出シフトがなくなったら終了 そもそも提出シフトが足りない場合
					BesideSortController::$CompStaff[$i][2] = "YN";
					continue;
				}
				for ($j = 0; count($EndShift) > $j; $j++) { //交代可能なスタッフを選定
					for ($k = 1; count($EndShift[$j]) > $k; $k++) {
						//シフトが提出で休みであるかつ本人のシフトとの比較ではない場合
						if (0 == strcmp($EndShift[$i][$k], "-") && $i != $j) {
							//シフトが休みになっていないか
							if (0 != strcmp($EndShift[$j][$k], "-") && 0 != strcmp($EndShift[$j][$k], "×")) {
								(int) $num1 = strpos($StaffShift[$i][$k], "-"); //出勤、退勤抜き出しに使用
								(double) $in1 = (double) substr($StaffShift[$i][$k], 0, $num1); //提出シフトの出勤時間抜き出し
								(double) $out1 = (double) substr($StaffShift[$i][$k], $num1 + 1); //提出シフトの退勤時間抜き出し

								(int) $num2 = strpos($EndShift[$j][$k], "-");
								(double) $in2 = (double) substr($EndShift[$j][$k], 0, $num2); //募集シフトの出勤時間抜き出し
								(double) $out2 = (double) substr($EndShift[$j][$k], $num2 + 1); //募集シフトの退勤時間抜き出し

								if ($in2 >= $in1 && $out2 <= $out1) {
									$CanChange[$j][1] = "Y"; //交代可能であることを意味するYを代入
									continue 2;
								}
							}
						}
					}
				}

				for ($j = 0; count(BesideSortController::$CompStaff) > $j; $j++) { //一番労働時間が長いスタッフを見つける
					if (0 == strcmp(BesideSortController::$CompStaff[$j][2], "N")) { //最低労働時間の調整が不要な場合
						//勤務時間が一番長いかつ調整が行われるスタッフではない
						(int) $time = (int) $StaffTimes[$j][1];
						(int) $top = (int) $JobTimeTop;
						if ($time > $top && $time != BesideSortController::$CompStaff[$i][0]) {
							if (0 == strcmp($CanChange[$j][1], "Y")) {
								$JobTimeTop = $StaffTimes[$j][1];
								(int) $TimeTopStaff = (int) $StaffTimes[$j][0];
							}
						}
					}
				}

				//echo $TimeTopStaff."=";

				(int) $count = 0; //最大連勤数をカウント
				(int) $IndexCount = 0;
				for ($j = 1; count($EndShift[$TimeTopStaff]) > $j; $j++) {
					if (0 != strcmp($EndShift[$TimeTopStaff][$j], "-") && 0 != strcmp($EndShift[$TimeTopStaff][$j], "×")) { //出勤しているか
						$count++;
						if (count($EndShift[$TimeTopStaff]) - 1 == $j) {
							$ConseWork[$IndexCount][0] = $count; //連続出勤日数を代入
							$ConseWork[$IndexCount][1] = $j - $count; //何日から連勤しているか代入
							$ConseCount++;
						}
					} else if ($count != 0) {
						$ConseWork[$IndexCount][0] = $count; //連続出勤日数を代入
						$ConseWork[$IndexCount][1] = $j - $count; //何日から連勤しているか
						$count = 0;
						$IndexCount++;
						$ConseCount++;
					}
				}

				//  $YosoNum1 = count($ConseWork);
				//  for($x = 0; $YosoNum1 > $x; $x++){
				//  	$YosoNum2 = count($ConseWork[$x]);
				//  	for($j = 0; $YosoNum2 > $j; $j++){
				//  		if(is_null($ConseWork[$x][$j])){
				//  			$ConseWork[$x][$j] = 0;
				//  		}
				//  	}
				//  }

				(int) $SortCount = 1;
				//下記処理はカプセル化のためにメソッド化していいかも
				for ($j = 0; count($ConseWork) > $j; $j++) { //そうや！出勤日数順に並べ替えるンゴ！
					for ($k = 0; count($ConseWork[$j]) > $k; $k++) {
						if ($ConseWork[$k][0] > $ConseWork[$j][0]) {
							(int) $hinan1 = $ConseWork[$j][0];
							(int) $hinan2 = $ConseWork[$j][1]; //値を避難
							$ConseWork[$j][0] = $ConseWork[$k][0];
							$ConseWork[$j][1] = $ConseWork[$k][1];
							$ConseWork[$k][0] = $hinan1;
							$ConseWork[$k][1] = $hinan2;
						}
					}
					$SortCount++;
				}

				//print_r($ConseWork);
				//echo $ConseCount;

				//連続出勤日数順に交代できるシフトを探すンゴよ！
				for ($j = 0; $ConseCount > $j; $j++) {
					for ($k = $ConseWork[$j][0]; $k > 0; $k--) {
						echo $i;
						echo $ConseWork[$j][1];
						if (0 == strcmp($EndShift[$i][$ConseWork[$j][1]], "-")) {
							(int) $num1 = strpos($StaffShift[$i][$ConseWork[$j][1]], "-"); //出勤、退勤抜き出しに使用
							(double) $in1 = (double) substr($StaffShift[$i][$ConseWork[$j][1]], 0, $num1); //提出シフトの出勤時間抜き出し
							(double) $out1 = (double) substr($StaffShift[$i][$ConseWork[$j][1]], $num1 + 1); //提出シフトの退勤時間抜き出し

							(int) $num2 = strpos($EndShift[$TimeTopStaff][$ConseWork[$j][1]], "-");
							(double) $in2 = (double) substr($EndShift[$TimeTopStaff][$ConseWork[$j][1]], 0, $num2); //募集シフトの出勤時間抜き出し
							(double) $out2 = (double) substr($EndShift[$TimeTopStaff][$ConseWork[$j][1]], $num2 + 1); //募集シフトの退勤時間抜き出し

							if ($in2 >= $in1 && $out2 <= $out1) { //当てはまればスタッフの勤務を入れ替える
								$EndShift[$i][$ConseWork[$j][1]] = $EndShift[$TimeTopStaff][$ConseWork[$j][1]];
								$EndShift[$TimeTopStaff][$ConseWork[$j][1]] = "-";
								break 2;
							}
						}
						$ConseWork[$j][1]++;
					}

				}
			}
		}
		// 	for($j = 0; count(BesideSortController::$CompStaff) > $j; $j++) {
		// 		if(0 == strcmp(BesideSortController::$CompStaff[$j][2],"Y")) {
		// 			return true;
		// 		}
		// 	}

		return $EndShift;
		// }
	}


		//最大出勤時間の場合
		function beSort2($StaffShift, $staff, $StaffTimes, $EndShift)
		{
			//リセット
			(double) $JobTimeTop = 99999;
			(int) $TimeTopStaff = 0;
			(int) $MaxCounter = 0;
			(int) $MinCounter = 0;
			(int) $ConseWork = [[]]; //最大連勤数と何日から連勤か
			$CanChange = [[]];

			for ($i = 0; 31 > $i; $i++) {
				for ($j = 0; 2 > $j; $j++) {
					$ConseWork[$i][$j] = 0;
				}
			}

			for ($i = 0; count($staff) > $i; $i++) {
				for ($j = 0; 2 > $j; $j++) {
					$ConseWork[$i][$j] = "";
				}
			}

			for ($i = 0; count($staff) > $i; $i++) {
				$CanChange[$i][1] = "N";
			}

			for ($i = 0; count($staff) > $i; $i++) { //従業員一人ずつ最低労働時間などを参考に時間を調整していく

				$CanChange[$i][0] = $staff[$i][4]; //ついでにキー値を代入しておく

				/*if(CompStaff[i][1].equals("N")) {//調整が終わっていたら次のスタッフへ
				continue;
				}*/
				if (BesideSortController::$MaxTime[$i][1] == -1 && BesideSortController::$MinTime[$i][1] == -1) { //どちらも制限がなければ次のスタッフへ
					BesideSortController::$CompStaff[$i][1] = "N"; //調整の必要がないためNを代入
					BesideSortController::$CompStaff[$i][2] = "N"; //調整の必要がないためNを代入
					continue;
				}
				if(0 == strcmp(BesideSortController::$CompStaff[$i][1],"YN")){
				}
				if (0 > BesideSortController::$MaxOut[$i][1]) { //上限労働時間-実際の労働時間がオーバーしている場合
					BesideSortController::$CompStaff[$i][1] = "Y"; //調整の必要があるためYを代入
					$MaxCounter++;
				} else {
					BesideSortController::$CompStaff[$i][1] = "N"; //調整の必要がないためNを代入
				}
				if(0 == strcmp(BesideSortController::$CompStaff[$i][2],"YN")){
				}
				if (BesideSortController::$MinOut[$i][1] > 0) { //下限労働時間-実際の労働時間がオーバーしている場合
					BesideSortController::$CompStaff[$i][2] = "Y"; //調整の必要があるためYを代入
					$MinCounter++;
				} else {
					BesideSortController::$CompStaff[$i][2] = "N"; //調整の必要がないためNを代入
				}


			}


			if ($MaxCounter == count($staff) || $MinCounter == count($staff)) { //全スタッフが各項目OR全項目調整の必要がある場合は調整が不可能なので処理を返す
				//BesideSortController::$Stop2 = false;
			}

			//int ConseWork2[][] = new int[1][2];//下記ConseWork調整用変数
			$ConseCount = 0; //連勤の回数
			$CanCount = 0;




			for ($i = 0; count(BesideSortController::$CompStaff) > $i; $i++) {
				if (0 == strcmp(BesideSortController::$CompStaff[$i][1], "Y")) { //最大労働時間の調整がある場合
					for ($j = 0; count($EndShift) > $j; $j++) {
						for ($k = 1; count($EndShift[$j]) > $k; $k++) {
							//シフトが休みではなく本人シフトとの比較ではない場合
							if (0 != strcmp($EndShift[$i][$k], "-") && 0 != strcmp($EndShift[$i][$k], "×") && $i != $j) {
								//シフトが休みではない場合
								if (0 != strcmp($EndShift[$j][$k], "-") && 0 != strcmp($EndShift[$j][$k], "×")) {

									(int) $num1 = strpos($EndShift[$i][$k], "-"); //出勤、退勤抜き出しに使用
									(double) $in1 = (double) substr($EndShift[$i][$k], 0, $num1); //出勤時間抜き出し
									(double) $out1 = (double) substr($EndShift[$i][$k], $num1 + 1); //提出シフトの退勤時間抜き出し

									(int) $num2 = strpos($EndShift[$j][$k], "-");
									(double) $in2 = (double) substr($EndShift[$j][$k], 0, $num2); //出勤時間抜き出し
									(double) $out2 = (double) substr($EndShift[$j][$k], $num2 + 1); //退勤時間抜き出し


									(double) $times1 = $out1 - $in1; //労働時間
									(double) $times2 = $out2 - $in2; //労働時間

									//比較対象のほうが一日の労働時間が長かったら
									if ($times1 > $times2) {

										(int) $num3 = strpos($StaffShift[$i][$k], "-"); //出勤、退勤抜き出しに使用
										(double) $in3 = (double) substr($StaffShift[$i][$k], 0, $num3); //提出シフトの出勤時間抜き出し
										(double) $out3 = (double) substr($StaffShift[$i][$k], $num3 + 1); //提出シフトの退勤時間抜き出し

										(int) $num4 = strpos($StaffShift[$j][$k], "-");
										(double) $in4 = (double) substr($StaffShift[$j][$k], 0, $num4); //提出シフトの出勤時間抜き出し
										(double) $out4 = (double) substr($StaffShift[$j][$k], $num4 + 1); //提出シフトの退勤時間抜き出し

										if ($in2 <= $in3 && $out2 >= $out3 && $in1 <= $in4 && $out1 >= $out4) {
											(String) $hinan = $EndShift[$j][$k];
											$EndShift[$j][$k] = $EndShift[$i][$k];
											$EndShift[$i][$k] = $hinan;
										}

									}
								}
							}
						}
					}
				}
			}




			for ($i = 0; count(BesideSortController::$CompStaff) > $i; $i++) {
				if (0 == strcmp(BesideSortController::$CompStaff[$i][1], "Y")) { //最大労働時間の調整がある場合
					for ($j = 1; count($EndShift[$i]) > $j; $j++) { //残り提出シフトがない場合
						if (0 != strcmp($EndShift[$i][$j], "-") && 0 != strcmp($EndShift[$i][$j], "×")) {
							$CanCount++;
						}
					}
					if ($CanCount == 0) { //提出シフトがなくなったら終了 そもそも提出シフトが足りない場合
						BesideSortController::$CompStaff[$i][2] = "YN";
						continue;
					}

					for ($j = 0; count($EndShift) > $j; $j++) { //交代可能なスタッフを選定
						for ($k = 1; count($EndShift[$j]) > $k; $k++) {
							//シフトが提出で休みであるかつ本人のシフトとの比較ではない場合
							if (0 != strcmp($EndShift[$i][$k], "-") && 0 != strcmp($EndShift[$i][$k], "×") && $i != $j) {
								//シフトが休みになっていないか
								if (0 != strcmp($StaffShift[$j][$k], "-1") && 0 == strcmp($EndShift[$j][$k], "-")) {
									(int) $num1 = strpos($StaffShift[$j][$k], "-"); //出勤、退勤抜き出しに使用
									(double) $in1 = (double) substr($StaffShift[$j][$k], 0, $num1); //提出シフトの出勤時間抜き出し
									(double) $out1 = (double) substr($StaffShift[$j][$k], $num1 + 1); //提出シフトの退勤時間抜き出し

									(int) $num2 = strpos($EndShift[$i][$k], "-");
									(double) $in2 = (double) substr($EndShift[$i][$k], 0, $num2); //募集シフトの出勤時間抜き出し
									(double) $out2 = (double) substr($EndShift[$i][$k], $num2 + 1); //募集シフトの退勤時間抜き出し

									if ($in2 >= $in1 && $out2 <= $out1) {
										$CanChange[$j][1] = "Y"; //交代可能であることを意味するYを代入
										continue 2;
									}
								}
							}
						}
					}

					$CanCount = 0; //誰も交代可能ではない場合のために使用
					for ($j = 0; count($CanChange) > $j; $j++) {
						if (0 == strcmp($CanChange[$j][1], "Y")) {
							$CanCount++;
						}
					}

					if ($CanCount == 0) {
						BesideSortController::$CompStaff[$i][1] = "YN";
						continue;
					}
					for ($j = 0; count(BesideSortController::$CompStaff) > $j; $j++) { //一番労働時間が短いスタッフを見つける
						if (0 == strcmp(BesideSortController::$CompStaff[$j][2], "N")) { //最大労働時間の調整が不要な場合
							//勤務時間が一番短いかつ調整が行われるスタッフではない
							if ($StaffTimes[$j][1] < $JobTimeTop && $StaffTimes[$j][0] != (double) BesideSortController::$CompStaff[$i][0]) {
								if (0 == strcmp($CanChange[$j][1], "Y")) {
									$JobTimeTop = $StaffTimes[$j][1];
									$TimeTopStaff = (int) $StaffTimes[$j][0];
								}
							}
						}
					}

					(int) $count = 0; //最大連休数をカウント
					(int) $IndexCount = 0;
					for ($j = 1; count($EndShift[$TimeTopStaff]) > $j; $j++) {
						if (0 == strcmp($EndShift[$TimeTopStaff][$j], "-") || 0 == strcmp($EndShift[$TimeTopStaff][$j], "×")) { //休んでいるか
							$count++;
							if (count($EndShift[$TimeTopStaff]) - 1 == $j) {
								$ConseWork[$IndexCount][0] = $count; //連続休み日数を代入
								$ConseWork[$IndexCount][1] = $j - $count + 1; //何日から休んでいるか代入
								$ConseCount++;
							}
						} else if ($count != 0) {
							$ConseWork[$IndexCount][0] = $count; //連続休み日数を代入
							$ConseWork[$IndexCount][1] = $j - $count; //何日から休んでいるか
							$count = 0;
							$IndexCount++;
							$ConseCount++;
						}
					}



					$SortCount = 1;
					//下記処理はカプセル化のためにメソッド化していいかも
					for ($j = 0; $ConseCount > $j; $j++) { //そうや！休み日数順に並べ替えるンゴ！
						for ($k = $SortCount; $ConseCount > $k; $k++) {
							if ($ConseWork[$k][0] > $ConseWork[$j][0]) {
								(int) $hinan1 = $ConseWork[$j][0];
								(int) $hinan2 = $ConseWork[$j][1]; //値を避難
								$ConseWork[$j][0] = $ConseWork[$k][0];
								$ConseWork[$j][1] = $ConseWork[$k][1];
								$ConseWork[$k][0] = $hinan1;
								$ConseWork[$k][1] = $hinan2;
								$SortCount++;
							}
						}
					}

					/*for(int j = 0; ConseCount > j; j++) {
					for(int k = 0; ConseWork[j].length > k; k++) {
					System.out.println(ConseWork[j][k]);
					}
					System.out.println();
					}*/

					//連続休み日数順に交代できるシフトを探すンゴよ！
					for ($j = 0; $ConseCount > $j; $j++) {
						for ($k = $ConseWork[$j][0]; $k > 0; $k--) {
							if (0 == strcmp($EndShift[$TimeTopStaff][$ConseWork[$j][1]], "-")) {
								if (0 != strcmp($EndShift[$i][$ConseWork[$j][1]], "-") && 0 != strcmp($EndShift[$i][$ConseWork[$j][1]], "×")) {
									(int) $num1 = strpos($StaffShift[$TimeTopStaff][$ConseWork[$j][1]], "-"); //出勤、退勤抜き出しに使用
									(double) $in1 = (double) substr($StaffShift[$TimeTopStaff][$ConseWork[$j][1]], 0, $num1); //提出シフトの出勤時間抜き出し
									(double) $out1 = (double) substr($StaffShift[$TimeTopStaff][$ConseWork[$j][1]], $num1 + 1); //提出シフトの退勤時間抜き出し

									(int) $num2 = strpos($EndShift[$i][$ConseWork[$j][1]], "-");
									(double) $in2 = (double) substr($EndShift[$i][$ConseWork[$j][1]], 0, $num2); //募集シフトの出勤時間抜き出し
									(double) $out2 = (double) substr($EndShift[$i][$ConseWork[$j][1]], $num2 + 1); //募集シフトの退勤時間抜き出し

									if ($in2 >= $in1 && $out2 <= $out1) { //当てはまればスタッフの勤務を入れ替える
										$EndShift[$TimeTopStaff][$ConseWork[$j][1]] = $EndShift[$i][$ConseWork[$j][1]];
										$EndShift[$i][$ConseWork[$j][1]] = "-";
										return $EndShift;
									}
								}
							}
							$ConseWork[$j][1]++;
						}

					}
				}
			}




			//調整が完了したら終了

			// for($j = 0; count(BesideSortController::$CompStaff) > $j; $j++) {
			// 	if(0 == strpos(BesideSortController::$CompStaff[$j][1],"Y")) {
			// 		//print_r(BesideSortController::$CompStaff);
			// 		return true;
			// 	}
			// }

			// return false;

			return $EndShift;
		}

		function Stoper1($staff)
		{

			(int) $MaxCounter = 0;
			(int) $MinCounter = 0;

			for ($i = 0; count($staff) > $i; $i++) { //従業員一人ずつ最低労働時間などを参考に時間を調整していく


				if (0 > BesideSortController::$MaxOut[$i][1]) { //上限労働時間-実際の労働時間がオーバーしている場合
					$MaxCounter++;
				}
				if (BesideSortController::$MinOut[$i][1] > 0) { //下限労働時間-実際の労働時間がオーバーしている場合
					$MinCounter++;
				}

			}
			if ($MaxCounter == count($staff) || $MinCounter == count($staff)) { //全スタッフが各項目OR全項目調整の必要がある場合は調整が不可能なので処理を返す
				return false;
			}

			for ($j = 0; count(BesideSortController::$CompStaff) > $j; $j++) {
				if (0 == strcmp(BesideSortController::$CompStaff[$j][2], "Y")) {
					return true;
				}
			}
			return false;
		}

		function Stoper2($staff)
		{

		(int) $MaxCounter = 0;
		(int) $MinCounter = 0;

		for ($i = 0; count($staff) > $i; $i++) { //従業員一人ずつ最低労働時間などを参考に時間を調整していく

			if (0 > BesideSortController::$MaxOut[$i][1]) { //上限労働時間-実際の労働時間がオーバーしている場合
				$MaxCounter++;
			} 
			if (BesideSortController::$MinOut[$i][1] > 0) { //下限労働時間-実際の労働時間がオーバーしている場合
				$MinCounter++;
			}

		}


		if ($MaxCounter == count($staff) || $MinCounter == count($staff)) { //全スタッフが各項目OR全項目調整の必要がある場合は調整が不可能なので処理を返す
			return false;
		}
			for ($j = 0; count(BesideSortController::$CompStaff) > $j; $j++) {
				if (0 == strcmp(BesideSortController::$CompStaff[$j][1], "Y")) {
					return true;
				}
			}

			return false;
	}
}




?>