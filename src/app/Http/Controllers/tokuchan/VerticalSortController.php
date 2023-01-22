<?php
    
namespace App\Http\Controllers\tokuchan;

use App\Http\Controllers\Controller;
    use Illuminate\Pagination\LengthAwarePaginator;
    class VerticalSortController extends Controller{

        static $inCount = [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,0],[8,0],[9,0],[10,0],[11,0]];//出勤した回数をカウント INDEX1スタッフの数
        static $k2 = 0;
        
    function verSort($SortStaff,$staff,$NeedShift,$StaffShift,$days,$StaffNum,$MaxWeight,$LowestWeight,$ShiftDivider,$dotw){//確定前のシフトを重み順でランダムで配置
            
            $MaW = $MaxWeight;//重みの最大値
            $LoW = $LowestWeight;//重みの最低値
            $count = [[]];//重みごとの人数をカウント
            for($i = 0; $MaW > $i; $i++){
                for($j = 0; 2 > $j; $j++){
                    $count[$i][$j] = 0;
                }
            }
            //int CanKey[][] = new int[days][];//出勤させるスタッフの人数（１日ごと）
            $CanKey = [[]];
            
            $StaffShiftClone = [[]];

            for($i = 0; $StaffNum > $i; $i++){
                for($j = 0; $days + 1 > $j; $j++){
                    $StaffShiftClone[$i][$j] = 0;
                }
            }
            for($i = 0; count($StaffShift) > $i; $i++) {//確認
                for($j = 0; count($StaffShift[$i]) > $j; $j++) {
                    $StaffShiftClone[$i][$j] = $StaffShift[$i][$j];//コピー元に干渉しないように　シフト作成用シフト抽出変数 
                }
            }
            
            for($i = 0; $days > $i; $i++) {//CanKeyの配列の要素数を決めつつ日にちを入れる処理
                $CanKey[$i] = array_fill(0,$NeedShift[$i][1] + 1,0);
                $CanKey[$i][0] = $i + 1;
            }
            
            for($h = 0; $MaW > $h; $h++) {//重みをIndex0に代入
                $count[$h][0] = $MaW - $h;
            }
              
            for($i = 0; count($SortStaff) > $i; $i++) {//重みごとのスタッフの人数をカウント
                if((int) $SortStaff[$i][1] == $MaW) {
                    $count[$LoW-1][1]++;
                }else if((int) $SortStaff[$i][1] == $MaW-1){
                    $MaW--;
                    $LoW++;
                    $i--;
                }
            }

            $Ycounter = array_fill(0,$days,0);
            for($j = 1; count($StaffShiftClone[0]) > $j; $j++) {
                for($i = 0; count($StaffShiftClone) > $i; $i++) {
                    if(0 == strcmp($StaffShiftClone[$i][$j],"Y")) {
                        $Ycounter[$j-1]++;
                    }
                }
            }
            
            // for($i = 0; counter($Ycounter) > $i; $i++) {
            //     //System.out.println((i + 1) + "日に出勤できる人数：" + Ycounter[i]);
            // }
            
            $MaW = $MaxWeight;
            $LoW = $LowestWeight;
            
            $DeNum = [[]];
            
            for($j = 0; $MaW > $j; $j++) {//重みごとのスタッフの人数分配列の要素を作成
                $DeNum[] = array_fill(0,$count[$j][1],-1);
                //System.out.println("重みが" + (MaW - j) + "である従業員の人数:" + DeNum[j].length);
            }
            
            for($i = 0; count($CanKey) > $i; $i++) {//重みごとに出勤スタッフが決まっていないことを表す-1を代入
                for($j = 1; count($CanKey[$i]) > $j; $j++) {
                    $CanKey[$i][$j] = -1;
                }	
            }
            
            $counter = 0;
            
            for($i = 0; count($SortStaff) > $i; $i++) {//重みごとのスタッフの人数をカウント
                if((int) $SortStaff[$i][1] == $MaW) {
                    $DeNum[$LoW-1][$counter] = (int) $SortStaff[$i][4];
                    $counter++;
                }else if((int) $SortStaff[$i][1] == $MaW-1){
                    $MaW--;
                    $LoW++;
                    $i--;
                    $counter = 0;
                }
            }
            $YosoNum1 = count($DeNum);
            for($i = 0; $YosoNum1 > $i; $i++){
                $YosoNum2 = count($DeNum[$i]);
                for($j = 0; $YosoNum2 > $j; $j++){
                    if(-1 == $DeNum[$i][$j]){
                        unset($DeNum[$i][$j]);
                        $DeNum = array_values($DeNum);
                    }
                }
            }
            // for($i = 0; $YosoNum1 > $i; $i++){
            //     if(count($DeNum[$i]) == 0){
            //         unset($DeNum[$i]);
            //     }
            // }
            // $DeNum = array_values($DeNum);

            $MaW = $MaxWeight;//重みごとの従業員の表示に使用
            $LoW = $LowestWeight;
            
            // for($i = 0; count($DeNum) > $i; $i++) {//重みごとにスタッフが格納されているか確認
            //     //System.out.print("重みが" + (MaW - i) + "である従業員:");
            //     for($j = 0; count($DeNum[$i]) > $j; $j++) {
            //         for($k = 0; count($SortStaff) > $k; $k++) {
            //             if($DeNum[$i][$j] == (int) $SortStaff[$k][8]) {
            //                 //System.out.print($SortStaff[$k][0]);
            //             }
            //         }
            //     }
            //     //System.out.println();
            // }
            
            $k = 0;
            $khinan = 0;
            
            $kCopy = -1;//その日に必要な重みの従業員が見つからなかった場合次の重みに移るための変数
            
            
            for($i = 0; count($CanKey) > $i; $i++) {//日にちごとに必要な人数スタッフを割り当て


                //k = 0; 繁忙期のみ有効に
                
                if($dotw[$i][1] == 1) {
                    $khinan = VerticalSortController::$k2;
                    VerticalSortController::$k2 = $k;
                }
                
                if($Ycounter[$i] == 0) {//その日出勤できる人が一人もいなかったら次の日へ
                    continue;
                }

                for($j = 0; count($CanKey[$i]) - 1 > $j; $j++) {//〇日に必要な人数分割り当て
                    if(count($CanKey[$i]) - 1 >= $Ycounter[$i]) {
                        for($l = 0; count($DeNum) > $l; $l++) {
                            for($n = 0; count($DeNum[$l]) > $n; $n++) {
                                if(0 == strcmp($StaffShiftClone[$DeNum[$l][$n]][$i+1],"Y")) {
                                    $CanKey[$i][$j + 1] = $DeNum[$l][$n];
                                    VerticalSortController::$inCount[$CanKey[$i][$j + 1]][1]++;//出勤日数を調整↑
                                    $j++;
                                }
                            }
                        }
                        break;
                    }
                        for($l = 0; count($DeNum[VerticalSortController::$k2]) > $l; $l++) {
                            // (boolean) $InOrOut = false;//その日に従業員がいたかをチェック
                            for($m = 0; count($CanKey[$i]) - 1 > $m; $m++) {//その日にすでに該当従業員がいた場合スキップ
                                if(0 == strcmp($CanKey[$i][$m + 1],$DeNum[VerticalSortController::$k2][$l])) {
                                    // $InOrOut = true;//LOOPラベルで簡略化可能
                                    continue 2;
                                }
                            }
                            // if(InOrOut) {
                            //     continue;
                            // }
                            /*if(DeNum[k2][l] == CanKey[i][j+1]) {
                                continue;
                            }*/
                            if(0 == strcmp($StaffShiftClone[$DeNum[VerticalSortController::$k2][$l]][$i+1],"Y")) {//まず最初にYである従業員を代入
                                if(0 == strcmp($CanKey[$i][$j+1],-1)) {//CanKeyに何も入っていなかったら
                                    $CanKey[$i][$j+1] = $DeNum[VerticalSortController::$k2][$l];
                                    continue;
                                }
                                if((int)VerticalSortController::$inCount[$DeNum[VerticalSortController::$k2][$l]][1] == (int)VerticalSortController::$inCount[$CanKey[$i][$j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)
                                    
                                }
                                else if((int)VerticalSortController::$inCount[$DeNum[VerticalSortController::$k2][$l]][1] < (int)VerticalSortController::$inCount[$CanKey[$i][$j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)
                                    //System.out.print(DeNum[k2][l]);
                                    $CanKey[$i][$j+1] = $DeNum[VerticalSortController::$k2][$l];
                                    continue;
                                }else if((int)VerticalSortController::$inCount[$DeNum[VerticalSortController::$k2][$l]][1] > (int)VerticalSortController::$inCount[$CanKey[$i][$j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)
                                    continue;
                                }
                                if((int) $staff[$DeNum[VerticalSortController::$k2][$l]][1] == (int) $staff[$CanKey[$i][$j+1]][1]) {//重みを比較
                                    if((int) $staff[$DeNum[VerticalSortController::$k2][$l]][5] > (int) $staff[$CanKey[$i][$j+1]][5]) {//提出率を比較
                                            $CanKey[$i][$j+1] = $DeNum[VerticalSortController::$k2][$l];
                                    }
                                }
                                if((int) $staff[$DeNum[VerticalSortController::$k2][$l]][1] > (int) $staff[$CanKey[$i][$j+1]][1]) {//重みを比較
                                    /*if(inCount[DeNum[k2][l]][1] < inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)*/
                                        $CanKey[$i][$j+1] = $DeNum[VerticalSortController::$k2][$l];
                                    /*}else if(inCount[DeNum[k2][l]][1] > inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較
                                        continue;
                                    }*/
                                }
                                else if((int) $staff[$DeNum[VerticalSortController::$k2][$l]][5] > (int) $staff[$CanKey[$i][$j+1]][5]) {//提出率を比較
                                    /*if(inCount[DeNum[k2][l]][1] < inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)*/
                                        $CanKey[$i][$j+1] = $DeNum[VerticalSortController::$k2][$l];
                                    /*}else if(inCount[DeNum[k2][l]][1] > inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較
                                        continue;
                                    }*/
                                }
                            }
                            else {
                                continue;
                            }
                        }
                        if(0 != strcmp($CanKey[$i][$j+1],-1)) {
                            VerticalSortController::$inCount[$CanKey[$i][$j+1]][1]++;//出勤日数を調整↑
                            if(0 != strcmp($kCopy,-1)) {
                                VerticalSortController::$k2 = $kCopy;
                            }
                        }else if(0 == strcmp($CanKey[$i][$j+1],-1)) {
                            $j--;
                            $kCopy = VerticalSortController::$k2;
                        }
                        VerticalSortController::$k2++;
                        if(VerticalSortController::$k2 == 4) {//重みの最大値によって変わる
                            VerticalSortController::$k2 = 0;
                        }
                    
                }
            }
            
            VerticalSortController::$k2 = $khinan;//逃がした値を再代入
            
            for($i = 0; count($CanKey) > $i; $i++) {//シフトに決定したシフトを代入
                
                for($j = 1; count($CanKey[$i]) > $j; $j++) {//出勤シフトを反映
                    for($kk = 0; count($staff) > $kk; $kk++) {
                        if((int) $CanKey[$i][$j] == (int) $staff[$kk][4]) {
                            $StaffShiftClone[$kk][$i + 1] = $ShiftDivider;
                        }
                    }
                }

                for($kk = 0; count($staff) > $kk; $kk++) {//休みになった、休み希望を反映
                    if(0 == strcmp($StaffShiftClone[$kk][$i + 1],"Y")) {
                        $StaffShiftClone[$kk][$i + 1] = "-";
                    }else if(0 == strcmp($StaffShiftClone[$kk][$i + 1],"-1")) {
                        $StaffShiftClone[$kk][$i + 1] = "×";
                    }
                }
                
            }
            
            
            
            /*for(int i = 0; CanKey.length > i; i++) {//重みごとにスタッフが格納されているか確認
                for(int j = 0; CanKey[i].length > j; j++) {
                    if(j == 0) {
                        System.out.print(CanKey[i][j] + "日の出勤スタッフ：");
                        continue;
                    }
                    for(int kk = 0; staff.length > kk; kk++) {
                        if(CanKey[i][j] == Integer.parseInt(staff[kk][8])) {
                            System.out.print(staff[kk][0]);
                        }
                    }
                }
                System.out.println();
                
            }
            
            for(int i = 0; days > i; i++) {
                int husoku = (NeedShift[i][1] - Ycounter[i]);
                if(Ycounter[i] > NeedShift[i][1]) {
                    husoku = 0;
                }
                System.out.println(i + 1 + "日の不足している従業員数：" + husoku);
                
            }
            for(int i = 0; inCount.length > i; i++) {
                System.out.println(staff[i][0] + "の合計出勤日数：" + inCount[i][1]);
            }
            */
            return $StaffShiftClone;
        }
    
    }
?>