
$(document).ready(function () {
	let url = new URL(window.location.href);// URLを取得
	let params = url.searchParams;// URLSearchParamsオブジェクトを取得
	var list = document.getElementById("widget");


	if (params.get('tab') != 2) {
		var newWidget = "<div class='widget-wrapper'> <ul class='tab-wrapper'></ul> <div class='new-widget'></div></div>";
		$(".widget").hide();
		$(".widget3").hide();
		$(".widget:first").before(newWidget);
		$(".widget > div").each(function () {
			$(".tab-wrapper").append("<li class='tab' onclick='tabchange()'>" + this.id + "</li>");
			$(this).appendTo(".new-widget",);
	
		});
		$(".tab").click(function () {
			$(".new-widget > div").hide();
			$('#' + $(this).text()).show();
			$(".tab").removeClass("active-tab");
			$(this).addClass("active-tab");
			document.getElementById("mom_scopeday").style.visibility ="visible";
			document.getElementById("createshift_btn").style.visibility ="visible";
			if(document.getElementById("mom_colorbox").value == 0) {
				document.getElementById("mom_colorbox").style.visibility ="visible";
			}else {
				document.getElementById("mom_colorbox").style.visibility ="hidden";
			}
		});
		$(".tab:first").click();
	} else {
		var newWidget = "<div class='widget-wrapper'> <ul class='tab-wrapper'></ul> <div class='new-widget'></div></div>";
		$(".widget3").hide();
		$(".widget3").before(newWidget);
		$(".widget > div").each(function () {
			$(".tab-wrapper").append("<li class='tab'>" + this.id + "</li>");
			$(this).appendTo(".new-widget",);
		});
		$(".tab").click(function () {
			$(".new-widget > div").hide();
			$('#' + $(this).text()).show();
			$(".tab").removeClass("active-tab");
			$(this).addClass("active-tab");
		});
		$(".tab").click();
	}
});

function tabchange() {
	document.getElementById("mom_scopeday").style.visibility ="hidden";
	document.getElementById("createshift_btn").style.visibility ="hidden";
	document.getElementById("mom_colorbox").style.visibility ="visible";
}

// 日にち選択プルダウン
function shiftpull(maxday,maxtime) {
	let startdayinput = Number(document.getElementById("startdaypull").value);
    let enddayinput = Number(document.getElementById("enddaypull").value);
	maxtime = maxtime + 1;
	for(let thisday = 1; thisday <= maxday; thisday++) {
		document.getElementById(thisday).style.background = "#fff";
		for(let time = 1; time <= maxtime; time++) {
			ninp = thisday + '*' + time;
			if(thisday % 2 == 0) {
				document.getElementById(ninp).style.background = "#fff";
				document.getElementById(ninp).style.borderBottom = "none";
			}else {
				document.getElementById(ninp).style.background = "#f0f0f0";
				document.getElementById(ninp).style.borderBottom = "none";
			}
		}
	}

	if(startdayinput != "" && enddayinput != "") {
		for(let thisday = startdayinput; thisday <= enddayinput; thisday++) {
			document.getElementById(thisday).style.background = "rgba(218, 249, 255)";
			for(let time = 1; time <= maxtime; time++) {
				ninp = thisday + '*' + time;
				ninp_top = (startdayinput - 1) + '*' + time;
				if(startdayinput - 1 == 0) {
					ninp_top = startdayinput + '*' + time;
				}
				if(startdayinput == enddayinput) {
					document.getElementById(ninp).style.background = "rgba(218, 249, 255)";
					document.getElementById(ninp).style.borderBottom = "thin solid rgb(186, 186, 186)";
					document.getElementById(ninp_top).style.borderBottom = "thin solid rgb(186, 186, 186)";
				}else {
					document.getElementById(ninp).style.background = "rgba(218, 249, 255)";
					document.getElementById(ninp).style.borderBottom = "thin solid rgb(186, 186, 186)";
					document.getElementById(ninp_top).style.borderBottom = "thin solid rgb(186, 186, 186)";
				}
			}
		}
	}

}

// 日にち選択ボタン
function scopeday(day,maxday,maxtime) {
    let startdayinput = Number(document.getElementById("startdaypull").value);
    let enddayinput = Number(document.getElementById("enddaypull").value);
	maxtime = maxtime + 1;
	if(startdayinput == "" && enddayinput == "") {
		document.getElementById("startdaypull").value = day;
		for(let thisday = 1; thisday <= maxday; thisday++) {
			document.getElementById(thisday).style.background = "#fff";
			for(let time = 1; time <= maxtime; time++) {
				ninp = thisday + '*' + time;
				if(thisday % 2 == 0) {
					document.getElementById(ninp).style.background = "#fff";
					document.getElementById(ninp).style.borderBottom = "none";
				}else {
					document.getElementById(ninp).style.background = "#f0f0f0";
					document.getElementById(ninp).style.borderBottom = "none";
				}
			}
		}
		document.getElementById(day).style.background = "rgba(218, 249, 255)";
		for(let time = 1; time <= maxtime; time++) {
			ninp = thisday + '*' + time;
			document.getElementById(ninp).style.background = "rgba(218, 249, 255)";
		}
	}else if(startdayinput != "" && enddayinput == "") {
		document.getElementById("enddaypull").value = day;
		for(let thisday = startdayinput; thisday <= day; thisday++) {
			document.getElementById(thisday).style.background = "rgba(218, 249, 255)";
			for(let time = 1; time <= maxtime; time++) {
				ninp = thisday + '*' + time;
				ninp_top = (startdayinput - 1) + '*' + time;
				if(startdayinput - 1 == 0) {
					ninp_top = startdayinput + '*' + time;
				}
				if(startdayinput == enddayinput) {
					document.getElementById(ninp).style.background = "rgba(218, 249, 255)";
					document.getElementById(ninp).style.borderBottom = "thin solid rgb(186, 186, 186)";
					document.getElementById(ninp_top).style.borderBottom = "thin solid rgb(186, 186, 186)";
				}else {
					document.getElementById(ninp).style.background = "rgba(218, 249, 255)";
					document.getElementById(ninp).style.borderBottom = "thin solid rgb(186, 186, 186)";
					document.getElementById(ninp_top).style.borderBottom = "thin solid rgb(186, 186, 186)";
				}
			}
		}
	}else {
		document.getElementById("startdaypull").value = day;
		document.getElementById("enddaypull").value = "";
		for(let thisday = 1; thisday <= maxday; thisday++) {
			document.getElementById(thisday).style.background = "#fff";
			for(let time = 1; time <= maxtime; time++) {
				ninp = thisday + '*' + time;
				if(thisday % 2 == 0) {
					document.getElementById(ninp).style.background = "#fff";
					document.getElementById(ninp).style.borderBottom = "none";
				}else {
					document.getElementById(ninp).style.background = "#f0f0f0";
					document.getElementById(ninp).style.borderBottom = "none";
				}
			}
		}
		document.getElementById(day).style.background = "rgba(218, 249, 255)";
		for(let time = 1; time <= maxtime; time++) {
			ninp = thisday + '*' + time;
			document.getElementById(ninp).style.background = "rgba(218, 249, 255)";
		}
	}
}


// マイナスボタン
function scopeminus(time) {
    let startdayinput =Number(document.getElementById("startdaypull").value);
    let enddayinput =Number(document.getElementById("enddaypull").value);
	if(startdayinput == "") {
		alert("最初の日を入力してください");
	}else if(enddayinput == "") {
		alert("最後の日を入力してください");
	}else if(startdayinput > enddayinput) {
		alert("入力ミスがあります");
	}else {
		startdayinput_number = Number(startdayinput);
		enddayinput_number = Number(enddayinput);
		for(let day = startdayinput_number; day <= enddayinput_number; day++){
			let nin_id = day + "-" + time;
			let ninzu = Number(document.getElementById(nin_id).value);
			if(ninzu != "") {
				ninzu = ninzu - 1;
				if(ninzu == 0) {
					document.getElementById(nin_id).value = "";
					document.getElementById(nin_id).style.visibility ="hidden";
				}else {
					document.getElementById(nin_id).value = ninzu;
				}
			}
		}
	}
}

// プラスボタン
function scopeplus(time) {
    let startdayinput =Number(document.getElementById("startdaypull").value);
    let enddayinput =Number(document.getElementById("enddaypull").value);
	if(startdayinput == "") {
		alert("最初の日を入力してください");
	}else if(enddayinput == "") {
		alert("最後の日を入力してください");
	}else if(startdayinput > enddayinput) {
		alert("入力ミスがあります");
	}else {
		startdayinput_number = Number(startdayinput);
		enddayinput_number = Number(enddayinput);
		for(let day = startdayinput_number; day <= enddayinput_number; day++){
			let nin_id = day + "-" + time;
			let nin_gouid = day + "-gou";
			let ninzu = Number(document.getElementById(nin_id).value);
			let nin_gou = document.getElementById(nin_gouid).textContent;
			let day_nin_gou = Number(nin_gou.replace('人',''));
			if(ninzu == "") {
				ninzu = 0;
			}
			ninzu = ninzu + 1;
			day_nin_gou = day_nin_gou + 1;
			document.getElementById(nin_id).value = ninzu;
			document.getElementById(nin_gouid).textContent = day_nin_gou + "人";
			document.getElementById(nin_id).style.visibility ="visible";
		}
	}
}

// シフト作成ボタン
function needshift(maxday,maxtime) {
	for(let day = 1; day <= maxday; day++){
		for(let time = 1; time <= maxtime; time++){
			let nin_id = day + "-" + time;
			document.getElementById(nin_id).disabled = false;
		}
	}
}