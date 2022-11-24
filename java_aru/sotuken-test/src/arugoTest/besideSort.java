package arugoTest;

public class besideSort {
	
	private static String CompStaff[][];//調整が終わったスタッフを判断するための変数　
	private static double MaxOut[][];//最大労働時間をオーバーしてるスタッフのオーバー時間
	private static double MinOut[][];//最低労働時間をオーバーしているスタッフのオーバー時間
	private static double MaxTime[][];//最大労働時間
	private static double MinTime[][];//最低労働時間
	
	public besideSort(String[][] staff) {
		besideSort.CompStaff = new String[staff.length][3]; //0 > キー値　1 > 最大労働時間のYN 2 >　最低労働時間のYN
		besideSort.MaxOut = new double[staff.length][2];
		besideSort.MinOut = new double[staff.length][2];
		besideSort.MaxTime = new double[staff.length][2];
		besideSort.MinTime = new double[staff.length][2];
		
		for(int i = 0; staff.length > i; i++) {//static変数たちのセット
			MaxOut[i][0] = Integer.parseInt(staff[i][8]);
			MinOut[i][0] = Integer.parseInt(staff[i][8]);
			MaxTime[i][0] = Integer.parseInt(staff[i][8]);
			MinTime[i][0] = Integer.parseInt(staff[i][8]);
			CompStaff[i][0] = staff[i][8];
		}
	}
	
	public double[][] RoadTimes(String[][] EndShift){//従業員の月の労働時間を求めるメソッド
		
		double StaffTimes[][] = new double[EndShift.length][2];
		for(int i = 0; StaffTimes.length > i ; i++) {
			StaffTimes[i][0] = Integer.parseInt(EndShift[i][0]);
		}
		
		for(int i = 0; EndShift.length > i; i++) {//各従業員の労働時間を計算するお！！
			for(int j = 1; EndShift[i].length > j; j++) {
				if(EndShift[i][j].indexOf("-") == 0 || !EndShift[i][j].contains("-")) {
					continue;
				}
					int num1 = EndShift[i][j].indexOf("-");//出勤、退勤抜き出しに使用
					double in1 =  Double.parseDouble(EndShift[i][j].substring(0,num1));//提出シフトの出勤時間抜き出し
					double out1 =  Double.parseDouble(EndShift[i][j].substring(num1 + 1));//提出シフトの退勤時間抜き出し
					StaffTimes[i][1] += out1 - in1;
			}
		}
		
		return StaffTimes;
	}
	
	public void MaxMin(double[][] StaffTimes, String[][] staff, int days, int MonthLastDay) {//月の労働上限、下限を調査
		
		int ShiftRatio = MonthLastDay/days; //月の何割のシフトを決めるか計算
		
		for(int i = 0; staff.length > i; i++) {
				double times = StaffTimes[i][1];
				MaxTime[i][1] = Double.parseDouble(staff[i][10])  / ShiftRatio;//最高労働時間取得
				MinTime[i][1] = Double.parseDouble(staff[i][9])  / ShiftRatio;//最低労働時間取得
				
				if(MaxTime[i][1] == -1 && MinTime[i][1] == -1) {//どちらも制限がなければ次のスタッフへ
					continue;
				}else if(MaxTime[i][1] == -1) {
					MinOut[i][1] = MinTime[i][1] - times;//0より大きければあればアウト
					continue;
				}else if(MinTime[i][1] == -1) {
					MaxOut[i][1] = MaxTime[i][1] - times;//0以下であればアウト
					continue;
				}
				
				MaxOut[i][1] = MaxTime[i][1] - times;//0以下であればアウト
				MinOut[i][1] = MinTime[i][1] - times;//0より大きければあればアウト
		}
		
	}
	
	
	public boolean beSort(String[][] StaffShift,String[][] staff, double[][] StaffTimes, String[][] EndShift) { 
		
		double JobTimeTop = 0;
		int TimeTopStaff = 0;
		int MaxCounter = 0;
		int MinCounter = 0;
		int ConseWork[][] = new int[30][2];//最大連勤数と何日から連勤か
		String CanChange[][] = new String[staff.length][2];
		
		for(int i = 0; CanChange.length > i; i++) {
			CanChange[i][1] = "N";
		}
		
		for(int i = 0; staff.length > i; i++) {//従業員一人ずつ最低労働時間などを参考に時間を調整していく
			
			CanChange[i][0] = staff[i][8];//ついでにキー値を代入しておく
			
			/*if(CompStaff[i][1].equals("N")) {//調整が終わっていたら次のスタッフへ
				continue;
			}*/
			if(MaxTime[i][1] == -1 && MinTime[i][1] == -1) {//どちらも制限がなければ次のスタッフへ
				CompStaff[i][1] = "N";//調整の必要がないためNを代入
				CompStaff[i][2] = "N";//調整の必要がないためNを代入
				continue;
			}
			if(0 > MaxOut[i][1]) {//上限労働時間-実際の労働時間がオーバーしている場合
				CompStaff[i][1] = "Y";//調整の必要があるためYを代入
				MaxCounter++;
			}else {
				CompStaff[i][1] = "N";//調整の必要がないためNを代入
			}
			if(MinOut[i][1] > 0) {//下限労働時間-実際の労働時間がオーバーしている場合
				CompStaff[i][2] = "Y";//調整の必要があるためYを代入
				MinCounter++; 
			}else {
				CompStaff[i][2] = "N";//調整の必要がないためNを代入
			}
				
		}
		
		
		if(MaxCounter == staff.length || MinCounter == staff.length) {//全スタッフが各項目OR全項目調整の必要がある場合は調整が不可能なので処理を返す
			return true;
		}
		
		//int ConseWork2[][] = new int[1][2];//下記ConseWork調整用変数
		int ConseCount = 0;//連勤の回数
		int CanCount = 0;

		
		
		for(int i = 0; CompStaff.length > i; i++) {
			if(CompStaff[i][2].equals("Y")) {//最低労働時間の調整がある場合
				for(int j = 0; EndShift.length > j; j++) {
					for(int k = 1; EndShift[j].length > k; k++) {
						//シフトが休みではなく本人シフトとの比較ではない場合
						if(!EndShift[i][k].equals("-") && !EndShift[i][k].equals("×") && i != j) {
							//シフトが休みではない場合
						if(!EndShift[j][k].equals("-") && !EndShift[j][k].equals("×")) {
								int num1 = EndShift[i][k].indexOf("-");//出勤、退勤抜き出しに使用
								double in1 =  Double.parseDouble(EndShift[i][k].substring(0,num1));//出勤時間抜き出し
								double out1 =  Double.parseDouble(EndShift[i][k].substring(num1 + 1));//提出シフトの退勤時間抜き出し
					
								int num2 = EndShift[j][k].indexOf("-");
								double in2 = Double.parseDouble(EndShift[j][k].substring(0,num2));//出勤時間抜き出し
								double out2 = Double.parseDouble(EndShift[j][k].substring(num2 + 1));//退勤時間抜き出し
							
							
								double times1 = out1 - in1;//労働時間
								double times2= out2 - in2;//労働時間
							
								//比較対象のほうが一日の労働時間が長かったら
								if(times2 > times1) {
								
									int num3 = StaffShift[i][k].indexOf("-");//出勤、退勤抜き出しに使用
									double in3 =  Double.parseDouble(StaffShift[i][k].substring(0,num3));//提出シフトの出勤時間抜き出し
									double out3 =  Double.parseDouble(StaffShift[i][k].substring(num3 + 1));//提出シフトの退勤時間抜き出し
						
									int num4 = StaffShift[j][k].indexOf("-");
									double in4 = Double.parseDouble(StaffShift[j][k].substring(0,num4));//提出シフトの出勤時間抜き出し
									double out4 = Double.parseDouble(StaffShift[j][k].substring(num4 + 1));//提出シフトの退勤時間抜き出し
								
									if(in2 >= in3 && out2 <= out3 && in1 >= in4 && out1 <= out4) {
										String hinan = EndShift[j][k];
										EndShift[j][k] = EndShift[i][k];
										EndShift[i][k] = hinan;
									}
								
								}
							}
						}
					}
				}
			}
		}
		
		
		
		
		for(int i = 0; CompStaff.length > i; i++) {
			if(CompStaff[i][2].equals("Y")) {//最低労働時間の調整がある場合
				for(int j = 1; EndShift[i].length > j; j++) {//残り提出シフトがない場合
					if(EndShift[i][j].equals("-")) {
						CanCount++;
					}
				}
				if(CanCount == 0) {//提出シフトがなくなったら終了 そもそも提出シフトが足りない場合
					CompStaff[i][2] = "YN";
					continue;
				}
				LOOP_1:
				for(int j = 0; EndShift.length > j; j++) {//交代可能なスタッフを選定
					for(int k = 1; EndShift[j].length > k; k++) {
						//シフトが提出で休みであるかつ本人のシフトとの比較ではない場合
						if(EndShift[i][k].equals("-") && i != j) {
							//シフトが休みになっていないか
							if(!EndShift[j][k].equals("-") && !EndShift[j][k].equals("×")) {
								int num1 = StaffShift[i][k].indexOf("-");//出勤、退勤抜き出しに使用
								double in1 =  Double.parseDouble(StaffShift[i][k].substring(0,num1));//提出シフトの出勤時間抜き出し
								double out1 =  Double.parseDouble(StaffShift[i][k].substring(num1 + 1));//提出シフトの退勤時間抜き出し
							
								int num2 = EndShift[j][k].indexOf("-");
								double in2 = Double.parseDouble(EndShift[j][k].substring(0,num2));//募集シフトの出勤時間抜き出し
								double out2 = Double.parseDouble(EndShift[j][k].substring(num2 + 1));//募集シフトの退勤時間抜き出し
								
								if(in2 >= in1 && out2 <= out1) {
									CanChange[j][1] = "Y";//交代可能であることを意味するYを代入
									continue LOOP_1;
								}
							}
						}
					}
				}
				
				
				for(int j = 0; CompStaff.length > j; j++) {//一番労働時間が長いスタッフを見つける
					if(CompStaff[j][2].equals("N")) {//最低労働時間の調整が不要な場合
						//勤務時間が一番長いかつ調整が行われるスタッフではない
						if(StaffTimes[j][1] > JobTimeTop && StaffTimes[j][0] != Double.parseDouble(CompStaff[i][0])) {
							if(CanChange[j][1].equals("Y")) {
								JobTimeTop = StaffTimes[j][1];
								TimeTopStaff = (int) StaffTimes[j][0];
							}
						}
					}
				}

				int count = 0;//最大連勤数をカウント
				int IndexCount = 0;
				for(int j = 1; EndShift[TimeTopStaff].length - 1 > j; j++) {
					if(!EndShift[TimeTopStaff][j].equals("-") && !EndShift[TimeTopStaff][j].equals("×")) {//出勤しているか
						count++;
						if(EndShift[TimeTopStaff].length - 1 == j) {
							ConseWork[IndexCount][0] = count;//連続出勤日数を代入
							ConseWork[IndexCount][1] = j - count;//何日から連勤しているか代入
							ConseCount++;
						}
					}else if(count != 0){
						ConseWork[IndexCount][0] = count;//連続出勤日数を代入
						ConseWork[IndexCount][1] = j - count;//何日から連勤しているか
						count = 0;
						IndexCount++;
						ConseCount++;
					}
				}
				
				int SortCount = 1;
				//下記処理はカプセル化のためにメソッド化していいかも
				for(int j = 0; ConseCount > j; j++) {//そうや！出勤日数順に並べ替えるンゴ！
					for(int k = SortCount; ConseCount > k; k++) {
						if(ConseWork[k][0] > ConseWork[j][0]) {
							int hinan1 = ConseWork[j][0];
							int hinan2 = ConseWork[j][1];//値を避難
							ConseWork[j][0] = ConseWork[k][0];
							ConseWork[j][1] = ConseWork[k][1];
							ConseWork[k][0] = hinan1;
							ConseWork[k][1] = hinan2;
							SortCount++;
						}
					}
				}

				
				//連続出勤日数順に交代できるシフトを探すンゴよ！
				LOOP_1:
				for(int j = 0; ConseCount > j; j++) {
					for(int k = ConseWork[j][0]; k > 0; k--) {
						if(EndShift[i][ConseWork[j][1]].equals("-")) {
							int num1 = StaffShift[i][ConseWork[j][1]].indexOf("-");//出勤、退勤抜き出しに使用
							double in1 =  Double.parseDouble(StaffShift[i][ConseWork[j][1]].substring(0,num1));//提出シフトの出勤時間抜き出し
							double out1 =  Double.parseDouble(StaffShift[i][ConseWork[j][1]].substring(num1 + 1));//提出シフトの退勤時間抜き出し
							
							int num2 = EndShift[TimeTopStaff][ConseWork[j][1]].indexOf("-");
							double in2 = Double.parseDouble(EndShift[TimeTopStaff][ConseWork[j][1]].substring(0,num2));//募集シフトの出勤時間抜き出し
							double out2 = Double.parseDouble(EndShift[TimeTopStaff][ConseWork[j][1]].substring(num2 + 1));//募集シフトの退勤時間抜き出し
							
							if(in2 >= in1 && out2 <= out1) {//当てはまればスタッフの勤務を入れ替える
								EndShift[i][ConseWork[j][1]] = EndShift[TimeTopStaff][ConseWork[j][1]];
								EndShift[TimeTopStaff][ConseWork[j][1]] = "-";
								break LOOP_1;
							}
						}
						ConseWork[j][1]++;
					}
					
				}
			}
		}
		for(int j = 0; CompStaff.length > j; j++) {
			if(CompStaff[j][2].equals("Y")) {
				return true;
			}
		}
		
		return false;
	}
		
		
		//最大出勤時間の場合
public boolean beSort2(String[][] StaffShift,String[][] staff, double[][] StaffTimes, String[][] EndShift) {
				//リセット
		double JobTimeTop = 99999;//
		int TimeTopStaff = 0;
		int MaxCounter = 0;
		int MinCounter = 0;
		int ConseWork[][] = new int[30][2];//最大連勤数と何日から連勤か
		String CanChange[][] = new String[staff.length][2];
		
		for(int i = 0; CanChange.length > i; i++) {
			CanChange[i][1] = "N";
		}
		
		for(int i = 0; staff.length > i; i++) {//従業員一人ずつ最低労働時間などを参考に時間を調整していく
			
			CanChange[i][0] = staff[i][8];//ついでにキー値を代入しておく
			
			/*if(CompStaff[i][1].equals("N")) {//調整が終わっていたら次のスタッフへ
				continue;
			}*/
			if(MaxTime[i][1] == -1 && MinTime[i][1] == -1) {//どちらも制限がなければ次のスタッフへ
				CompStaff[i][1] = "N";//調整の必要がないためNを代入
				CompStaff[i][2] = "N";//調整の必要がないためNを代入
				continue;
			}
			if(0 > MaxOut[i][1]) {//上限労働時間-実際の労働時間がオーバーしている場合
				CompStaff[i][1] = "Y";//調整の必要があるためYを代入
				MaxCounter++;
			}else {
				CompStaff[i][1] = "N";//調整の必要がないためNを代入
			}
			if(MinOut[i][1] > 0) {//下限労働時間-実際の労働時間がオーバーしている場合
				CompStaff[i][2] = "Y";//調整の必要があるためYを代入
				MinCounter++; 
			}else {
				CompStaff[i][2] = "N";//調整の必要がないためNを代入
			}
				
		}
		
		
		if(MaxCounter == staff.length || MinCounter == staff.length) {//全スタッフが各項目OR全項目調整の必要がある場合は調整が不可能なので処理を返す
			return true;
		}
		
		//int ConseWork2[][] = new int[1][2];//下記ConseWork調整用変数
		int ConseCount = 0;//連勤の回数
		int CanCount = 0;

				

				
				for(int i = 0; CompStaff.length > i; i++) {
					if(CompStaff[i][1].equals("Y")) {//最大労働時間の調整がある場合
						for(int j = 0; EndShift.length > j; j++) {
							for(int k = 1; EndShift[j].length > k; k++) {
								//シフトが休みではなく本人シフトとの比較ではない場合
								if(!EndShift[i][k].equals("-") && !EndShift[i][k].equals("×") && i != j) {
									//シフトが休みではない場合
								if(!EndShift[j][k].equals("-") && !EndShift[j][k].equals("×")) {
										int num1 = EndShift[i][k].indexOf("-");//出勤、退勤抜き出しに使用
										double in1 =  Double.parseDouble(EndShift[i][k].substring(0,num1));//出勤時間抜き出し
										double out1 =  Double.parseDouble(EndShift[i][k].substring(num1 + 1));//提出シフトの退勤時間抜き出し
							
										int num2 = EndShift[j][k].indexOf("-");
										double in2 = Double.parseDouble(EndShift[j][k].substring(0,num2));//出勤時間抜き出し
										double out2 = Double.parseDouble(EndShift[j][k].substring(num2 + 1));//退勤時間抜き出し
									
									
										double times1 = out1 - in1;//労働時間
										double times2= out2 - in2;//労働時間
									
										//比較対象のほうが一日の労働時間が長かったら
										if(times1 > times2) {
										
											int num3 = StaffShift[i][k].indexOf("-");//出勤、退勤抜き出しに使用
											double in3 =  Double.parseDouble(StaffShift[i][k].substring(0,num3));//提出シフトの出勤時間抜き出し
											double out3 =  Double.parseDouble(StaffShift[i][k].substring(num3 + 1));//提出シフトの退勤時間抜き出し
								
											int num4 = StaffShift[j][k].indexOf("-");
											double in4 = Double.parseDouble(StaffShift[j][k].substring(0,num4));//提出シフトの出勤時間抜き出し
											double out4 = Double.parseDouble(StaffShift[j][k].substring(num4 + 1));//提出シフトの退勤時間抜き出し
										
											if(in2 <= in3 && out2 >= out3 && in1 <= in4 && out1 >= out4) {
												String hinan = EndShift[j][k];
												EndShift[j][k] = EndShift[i][k];
												EndShift[i][k] = hinan;
											}
										
										}
									}
								}
							}
						}
					}
				}
				
				
				
				
				for(int i = 0; CompStaff.length > i; i++) {
					if(CompStaff[i][1].equals("Y")) {//最大労働時間の調整がある場合
						for(int j = 1; EndShift[i].length > j; j++) {//残り提出シフトがない場合
							if(!EndShift[i][j].equals("-") && !EndShift[i][j].equals("×")) {
								CanCount++;
							}
						}
						if(CanCount == 0) {//提出シフトがなくなったら終了 そもそも提出シフトが足りない場合
							CompStaff[i][2] = "YN";
							continue;
						}
						LOOP_1:
						for(int j = 0; EndShift.length > j; j++) {//交代可能なスタッフを選定
							for(int k = 1; EndShift[j].length > k; k++) {
								//シフトが提出で休みであるかつ本人のシフトとの比較ではない場合
								if(!EndShift[i][k].equals("-") && !EndShift[i][k].equals("×") && i != j) {
									//シフトが休みになっていないか
									if(!StaffShift[j][k].equals("-1") && EndShift[j][k].equals("-")) {
										int num1 = StaffShift[j][k].indexOf("-");//出勤、退勤抜き出しに使用
										double in1 =  Double.parseDouble(StaffShift[j][k].substring(0,num1));//提出シフトの出勤時間抜き出し
										double out1 =  Double.parseDouble(StaffShift[j][k].substring(num1 + 1));//提出シフトの退勤時間抜き出し
									
										int num2 = EndShift[i][k].indexOf("-");
										double in2 = Double.parseDouble(EndShift[i][k].substring(0,num2));//募集シフトの出勤時間抜き出し
										double out2 = Double.parseDouble(EndShift[i][k].substring(num2 + 1));//募集シフトの退勤時間抜き出し
										
										if(in2 >= in1 && out2 <= out1) {
											CanChange[j][1] = "Y";//交代可能であることを意味するYを代入
											continue LOOP_1;
										}
									}
								}
							}
						}
						
						CanCount = 0;//誰も交代可能ではない場合のために使用
						for(int j = 0; CanChange.length > j; j++) {
							if(CanChange[j][1].equals("Y")) {
								 CanCount++;
							}
						}

						if(CanCount == 0) {
							CompStaff[i][1] = "YN";
							continue;
						}
						for(int j = 0; CompStaff.length > j; j++) {//一番労働時間が短いスタッフを見つける
							if(CompStaff[j][2].equals("N")) {//最大労働時間の調整が不要な場合
								//勤務時間が一番短いかつ調整が行われるスタッフではない
								if(StaffTimes[j][1] < JobTimeTop && StaffTimes[j][0] != Double.parseDouble(CompStaff[i][0])) {
									if(CanChange[j][1].equals("Y")) {
										JobTimeTop = StaffTimes[j][1];
										TimeTopStaff = (int) StaffTimes[j][0];
									}
								}
							}
						}

						int count = 0;//最大連休数をカウント
						int IndexCount = 0;
						for(int j = 1; EndShift[TimeTopStaff].length > j; j++) {
							if(EndShift[TimeTopStaff][j].equals("-") || EndShift[TimeTopStaff][j].equals("×")) {//休んでいるか
								count++;
								if(EndShift[TimeTopStaff].length - 1 == j) {
									ConseWork[IndexCount][0] = count;//連続休み日数を代入
									ConseWork[IndexCount][1] = j - count + 1;//何日から休んでいるか代入
									ConseCount++;
								}
							}else if(count != 0){
								ConseWork[IndexCount][0] = count;//連続休み日数を代入
								ConseWork[IndexCount][1] = j - count;//何日から休んでいるか
								count = 0;
								IndexCount++;
								ConseCount++;
							}
						}
						
						
						
						int SortCount = 1;
						//下記処理はカプセル化のためにメソッド化していいかも
						for(int j = 0; ConseCount > j; j++) {//そうや！休み日数順に並べ替えるンゴ！
							for(int k = SortCount; ConseCount > k; k++) {
								if(ConseWork[k][0] > ConseWork[j][0]) {
									int hinan1 = ConseWork[j][0];
									int hinan2 = ConseWork[j][1];//値を避難
									ConseWork[j][0] = ConseWork[k][0];
									ConseWork[j][1] = ConseWork[k][1];
									ConseWork[k][0] = hinan1;
									ConseWork[k][1] = hinan2;
									SortCount++;
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
						for(int j = 0; ConseCount > j; j++) {
							for(int k = ConseWork[j][0]; k > 0; k--) {
								if(EndShift[TimeTopStaff][ConseWork[j][1]].equals("-")) {
									if(!EndShift[i][ConseWork[j][1]].equals("-") && !EndShift[i][ConseWork[j][1]].equals("×")) {
									int num1 = StaffShift[TimeTopStaff][ConseWork[j][1]].indexOf("-");//出勤、退勤抜き出しに使用
									double in1 =  Double.parseDouble(StaffShift[TimeTopStaff][ConseWork[j][1]].substring(0,num1));//提出シフトの出勤時間抜き出し
									double out1 =  Double.parseDouble(StaffShift[TimeTopStaff][ConseWork[j][1]].substring(num1 + 1));//提出シフトの退勤時間抜き出し
									
									int num2 = EndShift[i][ConseWork[j][1]].indexOf("-");
									double in2 = Double.parseDouble(EndShift[i][ConseWork[j][1]].substring(0,num2));//募集シフトの出勤時間抜き出し
									double out2 = Double.parseDouble(EndShift[i][ConseWork[j][1]].substring(num2 + 1));//募集シフトの退勤時間抜き出し
									
									if(in2 >= in1 && out2 <= out1) {//当てはまればスタッフの勤務を入れ替える
										EndShift[TimeTopStaff][ConseWork[j][1]] = EndShift[i][ConseWork[j][1]];
										EndShift[i][ConseWork[j][1]] = "-";
										return true;
									}
									}
								}
								ConseWork[j][1]++;
							}
							
						}
					}
				}
		
		
		
		
		//調整が完了したら終了

		for(int j = 0; CompStaff.length > j; j++) {
			if(CompStaff[j][1].equals("Y")) {
				return true;
			}
		}
		
		return false;
	}
}




