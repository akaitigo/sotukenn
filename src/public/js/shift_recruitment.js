// プルダウンが入力されたとき
function addshift(id,minnsubid,storeend) {

    if(minnsubid == 1) {
        let input_textid = id + 'text_main';
        let input_startpull = id + 'start_main';
        let input_endpull = id + 'end_main';
        let starttimetext =document.getElementById(input_startpull).value;
        let endtimetext =document.getElementById(input_endpull).value;
        if(starttimetext > storeend) {
            alert("正しい値を入力してください");
            document.getElementById(input_startpull).value = "";
        }else if(endtimetext > storeend) {
            alert("正しい値を入力してください");
            document.getElementById(input_endpull).value = "";
        }else {
            let shifttime = starttimetext + "-" + endtimetext;
            document.getElementById(input_textid).value= shifttime;
        }
    }else if(minnsubid == 2) {
        let input_textid_main = id + 'text_main';
        let input_textid = id + 'text_sub1';
        let input_startpull = id + 'start_sub1';
        let input_endpull = id + 'end_sub1';

        let input_text_main = document.getElementById(input_textid_main).value
        let starttimetext =document.getElementById(input_startpull).value;
        let endtimetext =document.getElementById(input_endpull).value;

        var pattern = '-';
        let indexstarttext = input_text_main.indexOf("-",0);

        if (indexstarttext == 0) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if(input_text_main.lastIndexOf(pattern)+pattern.length===input_text_main.length){
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if(starttimetext > storeend) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            alert("正しい値を入力してください");       
        }else if(endtimetext > storeend) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_endpull).value = "";
            alert("正しい値を入力してください");
        }else if(input_text_main == "") {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else {
            let shifttime = starttimetext + "-" + endtimetext;
            document.getElementById(input_textid).value= shifttime;
        }
    }else {
        let input_textid_main = id + 'text_main';
        let input_textid_sub1 = id + 'text_sub1';
        let input_textid = id + 'text_sub2';
        let input_startpull = id + 'start_sub2';
        let input_endpull = id + 'end_sub2';

        let input_text_main = document.getElementById(input_textid_main).value
        let input_text_sub1 = document.getElementById(input_textid_sub1).value
        let starttimetext =document.getElementById(input_startpull).value;
        let endtimetext =document.getElementById(input_endpull).value;
        var pattern = '-';
        let indexstarttext = input_text_main.indexOf("-",0);
        let indexstarttext_sub = input_text_sub1.indexOf("-",0);

        if (indexstarttext == 0) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if(input_text_main.lastIndexOf(pattern)+pattern.length===input_text_main.length){
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if (indexstarttext_sub == 0) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if(input_text_sub1.lastIndexOf(pattern)+pattern.length===input_text_sub1.length){
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if(starttimetext > storeend) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("正しい値を入力してください");
        }else if(endtimetext > storeend) {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("正しい値を入力してください");
        }else if(document.getElementById(input_textid_main).value == "") {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にメインの時間を登録してください");
        }else if(document.getElementById(input_textid_sub1).value == "") {
            document.getElementById(input_textid).value = "";
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
            alert("先にサブ１の時間を登録してください");
        }else {
            let shifttime = starttimetext + "-" + endtimetext;
            document.getElementById(input_textid).value= shifttime;
        }
    }
}

// バツボタンが入力された時
function nullshift(id,mainsubid) {
    if(mainsubid == 1) {
        let input_textid = id + 'text_main';
        let input_startpull = id + 'start_main';
        let input_endpull = id + 'end_main';
        document.getElementById(input_startpull).value = "";
        document.getElementById(input_endpull).value = "";
        document.getElementById(input_textid).value = "";
    }else if(mainsubid == 2) {
        let input_textid = id + 'text_sub1';
        let input_startpull = id + 'start_sub1';
        let input_endpull = id + 'end_sub1';
        document.getElementById(input_startpull).value = "";
        document.getElementById(input_endpull).value = "";
        document.getElementById(input_textid).value= "";
    }else {
        let input_textid = id + 'text_sub2';
        let input_startpull = id + 'start_sub2';
        let input_endpull = id + 'end_sub2';
        document.getElementById(input_startpull).value = "";
        document.getElementById(input_endpull).value = "";
        document.getElementById(input_textid).value= "";
    }
}

// プラスボタンが入力されたとき
var counter = 1;
function addcolumn(id_goukei,storestart,storeend) {
    id_goukei = id_goukei + counter;
    sansyou_id = id_goukei - 1;
    let input_textid = sansyou_id + 'text_main';
    let input_startpull = sansyou_id + 'start_main';
    let input_endpull = sansyou_id + 'end_main';
    let text = document.getElementById(input_textid).value;
    let start = document.getElementById(input_startpull).value;
    let end = document.getElementById(input_endpull).value;
    if(text == "") {
        alert("先に上記のメインを入力してください");
    }else if((start == "" || end == "") && counter > 1) {
        alert("先に上記のメインを入力してください");
    }else if(id_goukei > 30) {
        alert("それ以上追加できません");
    }else {
        var table = document.getElementById("recruitment_table");
        var nextrow = table.insertRow(id_goukei);
        var cell_main = nextrow.insertCell(0);
        var cell_sub1 = nextrow.insertCell(1);
        var cell_sub2 = nextrow.insertCell(2);

        let input_text_main = id_goukei + 'text_main';
        let start_main = id_goukei + 'start_main';
        let end_main = id_goukei + 'end_main';
        let main_btn = id_goukei + 'btn_main';
        let input_text_sub1 = id_goukei + 'text_sub1';
        let start_sub1 = id_goukei + 'start_sub1';
        let end_sub1 = id_goukei + 'end_sub1';
        let sub1_btn = id_goukei + 'btn_sub1';
        let input_text_sub2 = id_goukei + 'text_sub2';
        let start_sub2 = id_goukei + 'start_sub2';
        let end_sub2 = id_goukei + 'end_sub2';
        let sub2_btn = id_goukei + 'btn_sub2';

        cell_main.innerHTML = '<input class="shifttext" type="text" name="' + input_text_main + '" id="' + input_text_main + '" readonly="readonly"/>'
                        + '<input class="starttimepull" oninput="addshift(' + id_goukei + ', 1)" type="number" id="' + start_main + '" min="' + storestart + '" max="' + storeend + '" step="0.5" placeholder="出勤"/>'
                        + '<p class="hihunp">-</p>'
                        + '<input class="endtimepull" oninput="addshift(' + id_goukei + ', 1)" type="number" id="' + end_main + '" min="' + storestart + '" max="' + storeend + '" step="0.5" placeholder="退勤"/>'
                        + '<button class="batsubtn" onclick="nullshift(' + id_goukei + ',1)" type="button" id="' + main_btn + '">×</button>';
        
        cell_sub1.innerHTML = '<input class="shifttext" type="text" name="' + input_text_sub1 + '" id="' + input_text_sub1 + '" readonly="readonly"/>'
                        + '<input class="starttimepull" oninput="addshift(' + id_goukei + ',2)" type="number" id="' + start_sub1 + '" min="' + storestart + '" max="' + storeend + '" step="0.5" placeholder="出勤"/>'
                        + '<p class="hihunp">-</p>'
                        + '<input class="endtimepull" oninput="addshift(' + id_goukei + ',2)" type="number" id="' + end_sub1 + '" min="' + storestart + '" max="' + storeend + '" step="0.5" placeholder="退勤"/>'
                        + '<button class="batsubtn" onclick="nullshift(' + id_goukei + ',2)" type="button" id="' + sub1_btn + '">×</button>';

        cell_sub2.innerHTML = '<input class="shifttext" type="text" name="' + input_text_sub2 + '" id="' + input_text_sub2 + '" readonly="readonly"/>'
                        + '<input class="starttimepull" oninput="addshift(' + id_goukei + ',3)" type="number" id="' + start_sub2 + '" min="' + storestart + '" max="' + storeend + '" step="0.5" placeholder="出勤"/>'
                        + '<p class="hihunp">-</p>'
                        + '<input class="endtimepull" oninput="addshift(' + id_goukei + ',3)" type="number" id="' + end_sub2 + '" min="' + storestart + '" max="' + storeend + '" step="0.5" placeholder="退勤"/>'
                        + '<button class="batsubtn" onclick="nullshift(' + id_goukei + ',3)" type="button" id="' + sub2_btn + '">×</button>';
        counter++;
    }
}

// 更新ボタンが入力されたとき
function update(id_goukei) {
    id_goukei = id_goukei + counter - 1;
    for(let id = 1; id <= id_goukei; id++){
        let input_text_mainid = id + 'text_main';
        let input_text_sub1id = id + 'text_sub1';
        let input_text_sub2id = id + 'text_sub2';
        document.getElementById(input_text_mainid).style.background = "#fff";
        document.getElementById(input_text_sub1id).style.background = "#fff";
        document.getElementById(input_text_sub2id).style.background = "#fff";
    }
    for(let id = 1; id <= id_goukei; id++){
        let input_text_mainid = id + 'text_main';
        let input_text_sub1id = id + 'text_sub1';
        let input_text_sub2id = id + 'text_sub2';
        let input_text_main = document.getElementById(input_text_mainid).value;
        let input_text_sub1 = document.getElementById(input_text_sub1id).value;
        let input_text_sub2 = document.getElementById(input_text_sub2id).value;

        if(input_text_main == input_text_sub1 && input_text_main != "") {
            document.getElementById(input_text_mainid).style.background = "rgb(255 251 128 / 89%)";
            document.getElementById(input_text_sub1id).style.background = "rgb(255 251 128 / 89%)";
            alert('メインとサブ１に被りがあります');
            return false;
        }else if(input_text_main == input_text_sub2 && input_text_main != "") {
            document.getElementById(input_text_mainid).style.background = "rgb(255 251 128 / 89%)";
            document.getElementById(input_text_sub2id).style.background = "rgb(255 251 128 / 89%)";
            alert('メインとサブ２に被りがあります');
            return false;
        }else if(input_text_sub1 == input_text_sub2 && input_text_sub2 != "") {
            document.getElementById(input_text_sub1id).style.background = "rgb(255 251 128 / 89%)";
            document.getElementById(input_text_sub2id).style.background = "rgb(255 251 128 / 89%)";
            alert('サブ１とサブ２に被りがあります');
            return false;
        }
        
        for(let checkid = 1; checkid <= id_goukei; checkid++){
            if(id != checkid) {
                let input_check_mainid = checkid + 'text_main';
                let input_check_main = document.getElementById(input_check_mainid).value;
                if(input_text_main == input_check_main) {
                    document.getElementById(input_text_mainid).style.background = "rgb(255 251 128 / 89%)";
                    document.getElementById(input_check_mainid).style.background = "rgb(255 251 128 / 89%)";
                    alert('メインに被りがあります');
                    return false;
                }
            }
        }


        var pattern = '-';
        let indexstarttext = input_text_main.indexOf("-",0);
        let indexstarttext_sub1 = input_text_sub1.indexOf("-",0);
        let indexstarttext_sub2 = input_text_sub2.indexOf("-",0);

        if (indexstarttext == 0 && input_text_main != "") {
            document.getElementById(input_text_mainid).style.background = "rgb(255 251 128 / 89%)";
            alert("メインの時間に誤りがあります");
            return false;
        }else if(input_text_main.lastIndexOf(pattern)+pattern.length===input_text_main.length && input_text_main != ""){
            document.getElementById(input_text_mainid).style.background = "rgb(255 251 128 / 89%)";
            alert("メインの時間に誤りがあります");
            return false;
        }else if (indexstarttext_sub1 == 0 && input_text_sub1 != "") {
            document.getElementById(input_text_sub1id).style.background = "rgb(255 251 128 / 89%)";
            alert("サブ１の時間に誤りがあります");
            return false;
        }else if(input_text_sub1.lastIndexOf(pattern)+pattern.length===input_text_sub1.length && input_text_sub1 != ""){
            document.getElementById(input_text_sub1id).style.background = "rgb(255 251 128 / 89%)";
            alert("サブ１の時間に誤りがあります");
            return false;
        }else if (indexstarttext_sub2 == 0 && input_text_sub2 != "") {
            document.getElementById(input_text_sub2id).style.background = "rgb(255 251 128 / 89%)";
            alert("サブ２の時間に誤りがあります");
            return false;
        }else if(input_text_sub2.lastIndexOf(pattern)+pattern.length===input_text_sub2.length && input_text_sub2 != ""){
            document.getElementById(input_text_sub2id).style.background = "rgb(255 251 128 / 89%)";
            alert("サブ２の時間に誤りがあります");
            return false;
        }


        let start_mainid = id + 'start_main';
        let end_mainid = id + 'end_main';
        let start_sub1id = id + 'start_sub1';
        let end_sub1id = id + 'end_sub1';
        let start_sub2id = id + 'start_sub2';
        let end_sub2id = id + 'end_sub2';

        let start_main = document.getElementById(start_mainid).value;
        let end_main = document.getElementById(end_mainid).value;
        let start_sub1 = document.getElementById(start_sub1id).value;
        let end_sub1 = document.getElementById(end_sub1id).value;
        let start_sub2 = document.getElementById(start_sub2id).value;
        let end_sub2 = document.getElementById(end_sub2id).value;

        let shifttime_main = end_main - start_main;
        let shifttime_sub1 = end_sub1 - start_sub1;
        let shifttime_sub2 = end_sub2 - start_sub2;

        if(shifttime_main <= 0 && start_main != ""){
            document.getElementById(input_text_mainid).style.background = "rgb(255 251 128 / 89%)";
            alert("メインの時間に入力ミスがあります");
            return false;
        }else if(shifttime_sub1 <= 0 && start_sub1 != ""){
            document.getElementById(input_text_sub1id).style.background = "rgb(255 251 128 / 89%)";
            alert("サブ１の時間に入力ミスがあります");
            return false;
        }else if(shifttime_sub2 <= 0 && start_sub2 != ""){
            document.getElementById(input_text_sub2id).style.background = "rgb(255 251 128 / 89%)";
            alert("サブ２の時間に入力ミスがあります");
            return false;
        }


    }
}