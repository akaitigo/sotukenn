package arugoTest;

public class verticalSort {
	
	int inCount[][] = {{0,0},{1,0},{2,0},{3,0},{4,0},{5,0},{6,0},{7,0},{8,0},{9,0},{10,0},{11,0},{12,0}};//出勤した回数をカウント
	static int k2 = 0;
	
public String[][] verSort(String SortStaff[][],String staff[][],int NeedShift[][],String StaffShift[][],int days,int StaffNum,int MaxWeight,int LowestWeight,String ShiftDivider,int[][] dotw){//確定前のシフトを重み順でランダムで配置
		
		int MaW = MaxWeight;
		int LoW = LowestWeight;
		int count[][] = new int[MaW][MaW];
		int CanKey[][] = new int[days][];//出勤させるスタッフの人数（１日ごと）
		
		String StaffShiftClone[][] = new String[StaffNum][days + 1];//シフト作成用シフト抽出変数
		
		for(int i = 0; StaffShift.length > i; i++) {//確認
			for(int j = 0; StaffShift[i].length > j; j++) {
				StaffShiftClone[i][j] = new String(StaffShift[i][j]);//コピー元に干渉しないように　シフト作成用シフト抽出変数
				
			}
		}
		
		for(int i = 0; CanKey.length > i; i++) {//CanKeyの配列の要素数を決めつつ日にちを入れる処理
			CanKey[i] = new int[NeedShift[i][1]+1];
			CanKey[i][0] = i + 1;
		}
		
		for(int h = 0; MaW > h; h++) {//重みの数を分要素を作成
			count[h][0] = MaW - h;
		}
		
		
		for(int i = 0; SortStaff.length > i; i++) {//重みごとのスタッフの人数をカウント
			if(Integer.parseInt(SortStaff[i][1]) == MaW) {
				count[LoW-1][1]++;
			}else if(Integer.parseInt(SortStaff[i][1]) == MaW-1){
				MaW--;
				LoW++;
				i--;
			}
		}
		int Ycounter[] = new int[days];
		for(int j = 1; StaffShiftClone[0].length > j; j++) {
			for(int i = 0; StaffShiftClone.length > i; i++) {
				if(StaffShiftClone[i][j].equals("Y")) {
					Ycounter[j-1]++;
				}
			}
		}
		
		for(int i = 0; Ycounter.length > i; i++) {
			//System.out.println((i + 1) + "日に出勤できる人数：" + Ycounter[i]);
		}
		
		MaW = MaxWeight;
		LoW = LowestWeight;
		
		int DeNum[][] = new int [MaW][];
		
		for(int j = 0; MaW > j; j++) {//重みごとのスタッフの人数分配列の要素を作成
			DeNum[j] = new int[count[j][1]];
			//System.out.println("重みが" + (MaW - j) + "である従業員の人数:" + DeNum[j].length);
		}
		
		for(int i = 0; CanKey.length > i; i++) {//重みごとに出勤スタッフが決まっていないことを表す-1を代入
			for(int j = 1; CanKey[i].length > j; j++) {
				CanKey[i][j] = -1;
			}	
		}
		
		int counter = 0;
		
		for(int i = 0; SortStaff.length > i; i++) {//重みごとのスタッフの人数をカウント
			if(Integer.parseInt(SortStaff[i][1]) == MaW) {
				DeNum[LoW-1][counter] = Integer.parseInt(SortStaff[i][8]);
				counter++;
			}else if(Integer.parseInt(SortStaff[i][1]) == MaW-1){
				MaW--;
				LoW++;
				i--;
				counter = 0;
			}
		}
		
		MaW = MaxWeight;//重みごとの従業員の表示に使用
		LoW = LowestWeight;
		
		for(int i = 0; DeNum.length > i; i++) {//重みごとにスタッフが格納されているか確認
			//System.out.print("重みが" + (MaW - i) + "である従業員:");
			for(int j = 0; DeNum[i].length > j; j++) {
				for(int k = 0; SortStaff.length > k; k++) {
					if(DeNum[i][j] == Integer.parseInt(SortStaff[k][8])) {
						//System.out.print(SortStaff[k][0]);
					}
				}
			}
			//System.out.println();
			
		}
		
		int k = 0;
		int khinan = 0;
		
		int kCopy = -1;//その日に必要な重みの従業員が見つからなかった場合次の重みに移るための変数
		
		
		for(int i = 0; CanKey.length > i; i++) {//日にちごとに必要な人数スタッフを割り当て
			//k = 0; 繁忙期のみ有効に
			
			if(dotw[i][1] == 1) {
				khinan = k2;
				k2 = k;
			}
			
			if(Ycounter[i] == 0) {//その日出勤できる人が一人もいなかったら次の日へ
				continue;
			}
			LOOP_1:
			for(int j = 0; CanKey[i].length-1 > j; j++) {//〇日に必要な人数分割り当て
				if(CanKey[i].length-1 >= Ycounter[i]) {
					for(int l = 0; DeNum.length > l; l++) {
						for(int n = 0; DeNum[l].length > n; n++) {
							if(StaffShiftClone[DeNum[l][n]][i+1].equals("Y")) {
								CanKey[i][j + 1] = DeNum[l][n];
								inCount[CanKey[i][j + 1]][1]++;//出勤日数を調整↑
								j++;
							}
						}
					}
					break LOOP_1;
				}
					for(int l = 0; DeNum[k2].length > l; l++) {
						boolean InOrOut = false;//その日に従業員がいたかをチェック
						for(int m = 0; CanKey[i].length-1 > m; m++) {//その日にすでに該当従業員がいた場合スキップ
							if(CanKey[i][m + 1] == DeNum[k2][l]) {
								InOrOut = true;//LOOPラベルで簡略化可能
								break;
							}
						}
						if(InOrOut) {
							continue;
						}
						/*if(DeNum[k2][l] == CanKey[i][j+1]) {
							continue;
						}*/
						if(StaffShiftClone[DeNum[k2][l]][i+1].equals("Y")) {//まず最初にYである従業員を代入
							if(CanKey[i][j+1] == -1) {//CanKeyに何も入っていなかったら
								CanKey[i][j+1] = DeNum[k2][l];
								continue;
							}
							if(inCount[DeNum[k2][l]][1] < inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)
								//System.out.print(DeNum[k2][l]);
								CanKey[i][j+1] = DeNum[k2][l];
								continue;
							}
							if(Integer.parseInt(staff[DeNum[k2][l]][1]) > Integer.parseInt(staff[CanKey[i][j+1]][1])) {//重みを比較
								/*if(inCount[DeNum[k2][l]][1] < inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)*/
									CanKey[i][j+1] = DeNum[k2][l];
								/*}else if(inCount[DeNum[k2][l]][1] > inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較
									continue;
								}*/
							}
							else if(Integer.parseInt(staff[DeNum[k2][l]][2]) > Integer.parseInt(staff[CanKey[i][j+1]][2])) {//提出率を比較
								/*if(inCount[DeNum[k2][l]][1] < inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較(すでに入っている従業員のほうが出勤日数が多い場合)*/
									CanKey[i][j+1] = DeNum[k2][l];
								/*}else if(inCount[DeNum[k2][l]][1] > inCount[CanKey[i][j+1]][1]) {//現在の出勤日数を比較
									continue;
								}*/
							}
						}
						else {
							continue;
						}
					}
					if(CanKey[i][j+1] != -1) {
						inCount[CanKey[i][j+1]][1]++;//出勤日数を調整↑
						if(kCopy != -1) {
							k2 = kCopy;
						}
					}else if(CanKey[i][j+1] == -1) {
						j--;
						kCopy = k2;
					}
					k2++;
					if(k2 == 4) {//重みの最大値によって変わる
						k2 = 0;
					}
				
			}
		}
		
		k2 = khinan;//逃がした値を再代入
		
		for(int i = 0; CanKey.length > i; i++) {//シフトに決定したシフトを代入
			
			for(int kk = 0; staff.length > kk; kk++) {//休みになった、休み希望を反映
				if(StaffShiftClone[kk][i + 1].equals("Y")) {
					StaffShiftClone[kk][i + 1] = "-";
				}else if(StaffShiftClone[kk][i + 1].equals("-1")) {
					StaffShiftClone[kk][i + 1] = "×";
				}
			}
			
			for(int j = 1; CanKey[i].length > j; j++) {//出勤シフトを反映
				for(int kk = 0; staff.length > kk; kk++) {
					if(CanKey[i][j] == Integer.parseInt(staff[kk][8])) {
						StaffShiftClone[kk][i + 1] = ShiftDivider;
					}
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
		
		
		
		return StaffShiftClone;
	}

}
