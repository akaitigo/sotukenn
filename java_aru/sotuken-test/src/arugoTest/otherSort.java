package arugoTest;

public class otherSort {
	
public String[][] SubRate(int days,int Ycounter2[],String staff[][]) {//daysは募集する日数/StaffDaysは各従業員の提出日数　従業員のシフト提出率を計算するメソッド
		
		
		for(int i = 0; staff.length > i; i++) {
			
			double StaffDays = (double)Ycounter2[i];
			int result = (int) Math.round((StaffDays/days)*100);
			staff[i][2] = Integer.toString(result);
		}

		return staff;
		
	}

public String[][] DesSort(String staff[][]){//従業員配列を重み順に並べ替えるメソッド
	
	String SortStaff[][] = new String[staff.length][31];
	for(int f = 0; staff.length > f; f++) {
		for(int g = 0; staff[f].length > g; g++) {
			SortStaff[f][g] = new String(staff[f][g]);//コピー元に干渉しないように　シフト作成用シフト抽出変数
		}
	}
	String StaffHinan[][] = new String[1][13];
	int length = SortStaff.length;
	int length2 = length;
	int count = 1;
	for(int i = 0; length > i; i++) {
		for(int j = count; length2 > j; j++) {
			if(Integer.parseInt(SortStaff[i][1]) < Integer.parseInt(SortStaff[j][1])) {
				StaffHinan[0] = SortStaff[i];
				SortStaff[i] = SortStaff[j];
				SortStaff[j] = StaffHinan[0];
			}
		}
		count++;
	}
	
	return SortStaff;
}

public int[] Ycounter2(String StaffShift[][],int StaffNum){//従業員ごとの出勤日数をカウントするメソッド
	
	int Ycounter2[] = new int[StaffNum];
	
	for(int i = 0; StaffShift.length > i; i++) {
		for(int j = 1; StaffShift[i].length > j; j++) {
			if(!StaffShift[i][j].equals("-1")) {
				Ycounter2[i]++;
			}
		}
		
	}
	
	
	return Ycounter2;
}

public int[][] NeedShiftCounter(int NeedShift[][],String[] ShiftDivider,String[][] ResultShift,int now){//必要なスタッフ数のカウント
	
	
	for(int i = 0; NeedShift.length > i; i++) {//必要なスタッフ数のリセット
		NeedShift[i][0] = i + 1;//変数に日程を代入
		for(int j =0; NeedShift[i].length > j; j++) {
			NeedShift[i][j] = 0;
		}
	}
	
	for(int i = 0; NeedShift.length > i; i++) {//必要なスタッフ数を割り出し
		NeedShift[i][0] = i + 1;//変数に日程を代入
		for(int j =0; NeedShift[i].length > j; j++) {
			for(int k = 0; ResultShift[i].length > k; k++) {
				if(ShiftDivider[now].equals(ResultShift[i][k])) {
					NeedShift[i][j]++;
				}
			}
		}
	}
	return NeedShift;
}

public String[][] ShiftCalc(String[][] StaffShift,String[][] StaffShiftClone,int now,String[] ShiftDivider){//決定するシフトの整理
	
	for(int i = 0; StaffShift.length > i; i++) {
		for(int j = 0; StaffShift[i].length > j; j++) {
			if(!StaffShiftClone[i][j].equals("*")) {
				StaffShiftClone[i][j] = new String(StaffShift[i][j]);//コピー元に干渉しないように　シフト経過確認用変数
			}
		}
	}
	
	for(int i = 0; StaffShift.length > i; i++) {//~のシフトを作成する場合
		for(int j = 1; StaffShift[i].length > j; j++) {
			if(StaffShiftClone[i][j].indexOf("-") == 0 || !StaffShiftClone[i][j].contains("-")) {//シフトの値が-1だった場合スキップ（提出されてない場合）
				continue;
			}
			int num1 = StaffShiftClone[i][j].indexOf("-");//出勤、退勤抜き出しに使用
			double in1 =  Double.parseDouble(StaffShiftClone[i][j].substring(0,num1));//提出シフトの出勤時間抜き出し
			double out1 =  Double.parseDouble(StaffShiftClone[i][j].substring(num1 + 1));//提出シフトの退勤時間抜き出し
			
			int num2 = ShiftDivider[now].indexOf("-");
			double in2 = Double.parseDouble(ShiftDivider[now].substring(0,num2));//募集シフトの出勤時間抜き出し
			double out2 = Double.parseDouble(ShiftDivider[now].substring(num2 + 1));//募集シフトの退勤時間抜き出し
			
			
			
			if(in2 >= in1 && out2 <= out1) {//出勤時間と退勤時間が当てはまるか検査
				StaffShiftClone[i][j] = "Y";
			}else{
				StaffShiftClone[i][j] = "-1";
			}
		}
	}
	return StaffShiftClone;
}

public String[][] ShiftDup(String[][] Shift,String[] ShiftDivider,String[][] StaffShiftClone2,int now){
	
	for(int i = 0; Shift.length > i; i++) {
		for(int j = 1; Shift[i].length > j; j++) {	
			if(Shift[i][j].equals(ShiftDivider[now])) {
				StaffShiftClone2[i][j] = "*";
			}
		}
	}
	
	return StaffShiftClone2;
}

public String[][] End(String[][] Shift,String[][] EndShift,String[] ShiftDivider,String[][] staff,int now){//完成用のシフト
	
	for(int i = 0; Shift.length > i; i++) {
		for(int j = 0; Shift[i].length > j; j++) {
			if(j == 0) {
				EndShift[i][j] = staff[Integer.parseInt(Shift[i][j])][0];
			}
			if(Shift[i][j].equals(ShiftDivider[now])) {
				EndShift[i][j] = new String(Shift[i][j]);//コピー元に干渉しないように　完成のシフトシフト
			}else if(Shift[i][j].equals("-")) {
				EndShift[i][j] = "-";
			}else if(Shift[i][j].equals("×")) {
				EndShift[i][j] = "×";
			}
			
		}
	}
	
	return EndShift;
}

public String[][] ShiftOpti(String[][] StaffShift,String[][] NextDivider,String[][] ResultShift,int days){//決定するシフトの整理（例：１７時がいなかった場合１８時から入れる）
	
	int StaffShiftCount[] = new int[days];
	int ResultShiftCount[] = new int[days];
	int NoStaffShift[] = new int[days];
	int MinusStaff[][] = new int[days][StaffShift.length];
	String StaffShift2[][] = new String[StaffShift.length][StaffShift[0].length];
	String NewResultShift[][] = new String[days][];
	
	for(int i = 0; StaffShift.length > i; i++) {//整列用変数のコピー
		for(int j = 0; StaffShift[i].length > j; j++) {
			StaffShift2[i][j] = new String(StaffShift[i][j]);//コピー元に干渉しないように　シフト作成用シフト抽出変数
			
		}
	}
	
	
	for(int h = 0; NextDivider.length > h; h++) {
		
		
	for(int g = 0; /*NextDivider[h].length - 1  要素数は最大３であり、処理が決まっているので１でOK*/ 1 > g; g++) {
		
		/*if(g == 1) {//要素数３の配列を最適化したら終わる
			break;
		}*/
		
		for(int i = 0; StaffShift2.length > i; i++) {
			for(int j = 1; StaffShift2[i].length > j; j++){
				
				if(StaffShift2[i][j].indexOf("-") == 0 || !StaffShift2[i][j].contains("-")) {//シフトの値が-1だった場合スキップ（提出されてない場合）
					continue;
				}
				
				int num1 = StaffShift2[i][j].indexOf("-");//出勤、退勤抜き出しに使用
				double in1 =  Double.parseDouble(StaffShift2[i][j].substring(0,num1));//提出シフトの出勤時間抜き出し
				double out1 =  Double.parseDouble(StaffShift2[i][j].substring(num1 + 1));//提出シフトの退勤時間抜き出し
				
				int num2 = NextDivider[h][g].indexOf("-");
				double in2 = Double.parseDouble(NextDivider[h][g].substring(0,num2));//募集シフトの出勤時間抜き出し
				double out2 = Double.parseDouble(NextDivider[h][g].substring(num2 + 1));//募集シフトの退勤時間抜き出し
				
				
				
				
				if(in2 >= in1 && out2 <= out1) {
					MinusStaff[j - 1][StaffShiftCount[j - 1]] = i;
					StaffShiftCount[j - 1]++;
				}
			}
			
		}
		
		
		for(int i = 0; ResultShift.length > i; i++) {
			for(int j = 0; ResultShift[i].length - 1 > j; j++){
				
				
				
				/*int num1 = ResultShift[i][j + 1].indexOf("-");//出勤、退勤抜き出しに使用
				double in1 =  Double.parseDouble(ResultShift[i][j + 1].substring(0,num1));//提出シフトの出勤時間抜き出し
				double out1 =  Double.parseDouble(ResultShift[i][j + 1].substring(num1 + 1));//提出シフトの退勤時間抜き出し
				
				int num2 = NextDivider[h][g].indexOf("-");
				double in2 = Double.parseDouble(NextDivider[h][g].substring(0,num2));//募集シフトの出勤時間抜き出し
				double out2 = Double.parseDouble(NextDivider[h][g].substring(num2 + 1));//募集シフトの退勤時間抜き出し
				
				
				
				if(in2 >= in1 && out2 <= out1) {
					ResultShiftCount[i]++;
				}*/
				
				if(ResultShift[i][j + 1].equals(NextDivider[h][g])) {
					ResultShiftCount[i]++;
				}
			}
			
		}
		
		
		
		
		
		for(int f = 0; StaffShiftCount.length > f; f++) {
			
			if(ResultShiftCount[f] > StaffShiftCount[f]) {
				NoStaffShift[f] = ResultShiftCount[f] - StaffShiftCount[f];
				for(int d = 0; ResultShift[f].length > d; d++) {
					if(ResultShift[f][d].equals(NextDivider[h][g])) {
						
						if(NextDivider[h].length == 3) {//候補が2つ以上あった場合
							NewResultShift[f] = new String[ResultShift[f].length];
							NewResultShift[f] = ResultShift[f];
							ResultShift[f] = new String[ResultShift[f].length + 1];
							for(int m = 0; NewResultShift[f].length > m; m++) {
								ResultShift[f][m] = NewResultShift[f][m];
							}
							ResultShift[f][d] = NextDivider[h][g + 1];
							for(int s = 0; ResultShift[f].length > s; s++) {
								if(ResultShift[f][s] == null) {
									ResultShift[f][s] = NextDivider[h][g + 2];
									NoStaffShift[f]--;
								}
							}
						}else {
							//StaffShift2[MinusStaff[f][StaffShiftCount[f]]][f + 1]  = "-1";
							ResultShift[f][d] = NextDivider[h][g + 1];
							NoStaffShift[f]--;
						}
						if(NoStaffShift[f] == 0) {
							break;
						}
					}
				}
			}else if(ResultShiftCount[f] == StaffShiftCount[f]) {//ちょうど足りていた場合に出勤スタッフをマイナス
				for(int a = 0; StaffShiftCount[f] > a; a++) {
					StaffShift2[MinusStaff[f][StaffShiftCount[f]]][f + 1]  = "-1";
				}
			}
			ResultShiftCount[f] = 0;
			StaffShiftCount[f] = 0;
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
	return ResultShift;

}

/**
 * 全角文字は２桁、半角文字は１桁として文字数をカウントする
 * @param str 対象文字列
 * @return 文字数
 */
public int getHan1Zen2(String str) {
  
  //戻り値
  int ret = 0;
  
  //全角半角判定
  char[] c = str.toCharArray();
  for(int i=0;i<c.length;i++) {
    if(String.valueOf(c[i]).getBytes().length <= 1){
      ret += 1; //半角文字なら＋１
    }else{
      ret += 2; //全角文字なら＋２
    }
  }
  
  return ret;
}
}
