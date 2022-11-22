package arugoTest;

import java.util.ArrayList;

public class topmain {
	
		public static void main(String str[]) {
			
			int days = 15; //募集する日数。ここではテストデータとして15日。
			int StaffNum = 13; //スタッフの人数 テストデータとして13人
			int StaffStatus = 9; //スタッフの項目
			int MaxWeight = 4; //重みの最大値
			int LowestWeight = 1; //重みの最低値
			int NeedStaff = 5;//一日に必要な最大スタッフ数
			String staff[][] = new String[StaffNum][StaffStatus];//各スタッフのステータス
			String DecisionShift[][] = new String[days][NeedStaff];//決定シフト
			int NeedShift[][] = {{1,5},{2,3},{3,4},{4,4},{5,5},{6,4},{7,3},{8,3},{9,3},{10,3},{11,4},{12,5},{13,4},{14,3},{15,3}};//１日の必要な人数
			String StaffShift[][] = {
				//1   2   3   4   5   6   7   8   9   10  11  12  13  14  15
			{"0","Y","N","Y","Y","N","Y","N","N","N","Y","N","Y","Y","Y","Y"},//A
			{"1","N","Y","Y","N","N","N","N","Y","N","Y","Y","N","N","Y","Y"},//B
			{"2","Y","Y","Y","Y","N","Y","Y","N","N","N","Y","N","N","N","N"},//C
			{"3","N","N","N","Y","Y","N","N","Y","Y","N","Y","Y","Y","N","Y"},//D
			{"4","N","Y","N","N","N","Y","Y","Y","N","N","N","N","N","N","N"},//E
			{"5","N","Y","Y","Y","Y","N","N","Y","N","Y","N","Y","N","Y","Y"},//F
			{"6","Y","N","N","N","Y","Y","Y","Y","N","Y","Y","Y","Y","Y","N"},//G
			{"7","N","Y","N","N","Y","N","N","N","N","N","N","N","N","N","N"},//H
			{"8","N","Y","Y","Y","Y","Y","Y","Y","Y","Y","Y","Y","Y","Y","Y"},//I
			{"9","N","Y","N","N","N","N","N","Y","Y","N","Y","Y","Y","N","Y"},//J
			{"10","N","N","Y","N","Y","Y","Y","N","Y","Y","Y","Y","N","Y","Y"},//K
			{"11","N","Y","N","Y","N","Y","Y","N","Y","N","N","Y","Y","Y","N"},//L
			{"12","N","N","Y","N","Y","Y","N","Y","N","Y","Y","N","Y","N","N"},};//M      キー値とスタッフがいつシフトを提出しているか
			ArrayList[] calendar = new ArrayList[days];
			
			staff[0][0] = "A";//名前の設定
			staff[0][1] = "4";//重みの設定
			staff[0][2] = "0";//提出率の設定
			staff[0][3] = "0";//仲良し 今回は使用しない
			staff[0][4] = "18";//年齢
			staff[0][5] = "Y";//社保の有無	Y-yes/N-no
			staff[0][6] = "N";//既婚者であるか
			staff[0][7] = "Y";//学生であるか
			staff[0][8] = "0";//キー値
			
			staff[1][0] = "B";//名前の設定
			staff[1][1] = "4";//重みの設定
			staff[1][2] = "0";//提出率の設定
			staff[1][3] = "0";//仲良し
			staff[1][4] = "18";//年齢
			staff[1][5] = "Y";//社保の有無	Y-yes/N-no
			staff[1][6] = "N";//既婚者であるか
			staff[1][7] = "Y";//学生であるか
			staff[1][8] = "1";//キー値

			staff[2][0] = "C";//名前の設定
			staff[2][1] = "3";//重みの設定
			staff[2][2] = "0";//提出率の設定
			staff[2][3] = "0";//仲良し
			staff[2][4] = "18";//年齢
			staff[2][5] = "Y";//社保の有無	Y-yes/N-no
			staff[2][6] = "N";//既婚者であるか
			staff[2][7] = "Y";//学生であるか
			staff[2][8] = "2";//キー値
			
			staff[3][0] = "D";//名前の設定
			staff[3][1] = "4";//重みの設定
			staff[3][2] = "0";//提出率の設定
			staff[3][3] = "0";//仲良し
			staff[3][4] = "18";//年齢
			staff[3][5] = "Y";//社保の有無	Y-yes/N-no
			staff[3][6] = "N";//既婚者であるか
			staff[3][7] = "Y";//学生であるか
			staff[3][8] = "3";//キー値
			
			staff[4][0] = "E";//名前の設定
			staff[4][1] = "3";//重みの設定
			staff[4][2] = "0";//提出率の設定
			staff[4][3] = "0";//仲良し
			staff[4][4] = "18";//年齢
			staff[4][5] = "Y";//社保の有無	Y-yes/N-no
			staff[4][6] = "N";//既婚者であるか
			staff[4][7] = "Y";//学生であるか
			staff[4][8] = "4";//キー値
			
			staff[5][0] = "F";//名前の設定
			staff[5][1] = "2";//重みの設定
			staff[5][2] = "0";//提出率の設定
			staff[5][3] = "0";//仲良し
			staff[5][4] = "18";//年齢
			staff[5][5] = "Y";//社保の有無	Y-yes/N-no
			staff[5][6] = "N";//既婚者であるか
			staff[5][7] = "Y";//学生であるか
			staff[5][8] = "5";//キー値
			
			staff[6][0] = "G";//名前の設定
			staff[6][1] = "2";//重みの設定
			staff[6][2] = "0";//提出率の設定
			staff[6][3] = "0";//仲良し
			staff[6][4] = "18";//年齢
			staff[6][5] = "Y";//社保の有無	Y-yes/N-no
			staff[6][6] = "N";//既婚者であるか
			staff[6][7] = "Y";//学生であるか
			staff[6][8] = "6";//キー値
			
			staff[7][0] = "H";//名前の設定
			staff[7][1] = "2";//重みの設定
			staff[7][2] = "0";//提出率の設定
			staff[7][3] = "0";//仲良し
			staff[7][4] = "18";//年齢
			staff[7][5] = "Y";//社保の有無	Y-yes/N-no
			staff[7][6] = "N";//既婚者であるか
			staff[7][7] = "Y";//学生であるか
			staff[7][8] = "7";//キー値
			
			staff[8][0] = "I";//名前の設定
			staff[8][1] = "2";//重みの設定
			staff[8][2] = "0";//提出率の設定
			staff[8][3] = "0";//仲良し
			staff[8][4] = "18";//年齢
			staff[8][5] = "Y";//社保の有無	Y-yes/N-no
			staff[8][6] = "N";//既婚者であるか
			staff[8][7] = "Y";//学生であるか
			staff[8][8] = "8";//キー値

			staff[9][0] = "J";//名前の設定
			staff[9][1] = "2";//重みの設定
			staff[9][2] = "0";//提出率の設定
			staff[9][3] = "0";//仲良し
			staff[9][4] = "18";//年齢
			staff[9][5] = "Y";//社保の有無	Y-yes/N-no
			staff[9][6] = "N";//既婚者であるか
			staff[9][7] = "Y";//学生であるか
			staff[9][8] = "9";//キー値
			
			staff[10][0] = "K";//名前の設定
			staff[10][1] = "3";//重みの設定
			staff[10][2] = "0";//提出率の設定
			staff[10][3] = "0";//仲良し
			staff[10][4] = "18";//年齢
			staff[10][5] = "Y";//社保の有無	Y-yes/N-no
			staff[10][6] = "N";//既婚者であるか
			staff[10][7] = "Y";//学生であるか
			staff[10][8] = "10";//キー値
			
			staff[11][0] = "L";//名前の設定
			staff[11][1] = "3";//重みの設定
			staff[11][2] = "0";//提出率の設定
			staff[11][3] = "0";//仲良し
			staff[11][4] = "18";//年齢
			staff[11][5] = "Y";//社保の有無	Y-yes/N-no
			staff[11][6] = "N";//既婚者であるか
			staff[11][7] = "Y";//学生であるか
			staff[11][8] = "11";//キー値
		
			staff[12][0] = "M";//名前の設定
			staff[12][1] = "2";//重みの設定
			staff[12][2] = "0";//提出率の設定
			staff[12][3] = "0";//仲良し
			staff[12][4] = "18";//年齢
			staff[12][5] = "Y";//社保の有無	Y-yes/N-no
			staff[12][6] = "N";//既婚者であるか
			staff[12][7] = "Y";//学生であるか
			staff[12][8] = "12";//キー値
		
			int[] Ycounter2 = new int[StaffNum];//従業員ごとの出勤日数
			
			otherSort os = new otherSort();
			verticalSort vs = new verticalSort();
			Ycounter2 = os.Ycounter2(StaffShift, StaffNum);
			staff = os.SubRate(days,Ycounter2,staff);
			String SortStaff[][] = new String[13][9];//重み順に変換用の配列
			SortStaff = os.DesSort(staff);
			/*vs.verSort(SortStaff,staff, NeedShift, NeedShift, StaffShift,
					   DecisionShift, days, StaffNum,MaxWeight,LowestWeight);*/ //重みごとに仮としてシフトを作成するメソッド
			
		}

}
