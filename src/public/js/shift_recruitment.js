function addshift(id,minnsubid) {
    if(minnsubid == 1) {
        let input_textid = id + 'text_main';
        let input_startpull = id + 'start_main';
        let input_endpull = id + 'end_main';
        let starttimetext =document.getElementById(input_startpull).value;
        let endtimetext =document.getElementById(input_endpull).value;
        let shifttime = starttimetext + "-" + endtimetext;
        document.getElementById(input_textid).value= shifttime;
    }else if(minnsubid == 2) {
        let input_textid_main = id + 'text_main';
        let input_textid = id + 'text_sub1';
        let input_startpull = id + 'start_sub1';
        let input_endpull = id + 'end_sub1';
        let starttimetext =document.getElementById(input_startpull).value;
        let endtimetext =document.getElementById(input_endpull).value;
        let shifttime = starttimetext + "-" + endtimetext;
        if(document.getElementById(input_textid_main).value == "") {
            alert("先にメインの時間を登録してください");
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
        }else {
            document.getElementById(input_textid).value= shifttime;
        }
    }else {
        let input_textid_main = id + 'text_main';
        let input_textid_sub1 = id + 'text_sub1';
        let input_textid = id + 'text_sub2';
        let input_startpull = id + 'start_sub2';
        let input_endpull = id + 'end_sub2';
        let starttimetext =document.getElementById(input_startpull).value;
        let endtimetext =document.getElementById(input_endpull).value;
        let shifttime = starttimetext + "-" + endtimetext;

        if(document.getElementById(input_textid_main).value == "") {
            alert("先にメインの時間を登録してください");
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
        }else if(document.getElementById(input_textid_sub1).value == "") {
            alert("先にサブ１の時間を登録してください");
            document.getElementById(input_startpull).value = "";
            document.getElementById(input_endpull).value = "";
        }else {
            document.getElementById(input_textid).value= shifttime;
        }
    }
}

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

var counter = 0;
function addcolumn(id_goukei,storestart,storeend) {
    id_goukei = id_goukei + counter;
    sannsyou_id = id_goukei - 1;
    let input_textid = sannsyou_id + 'text_main';
    let input_startpull = sannsyou_id + 'start_main';
    let input_endpull = sannsyou_id + 'end_main';
    let text = document.getElementById(input_textid).value;
    let start = document.getElementById(input_startpull).value;
    let end = document.getElementById(input_endpull).value;
    if(text == "") {
        alert("先に上記のメインを入力してください");
    }else if((start == "" || end == "") && counter > 0) {
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

function update(id,minnsubid) {
    for(let id = 1; id <= emppartcountid; id++){
        let emppartnamearray = id -1;
        for (let day = 1; day <= lastday; day++){
            let jstext = id + "-" + day;
            let starttimepull = id + "-" + day + "start";
            let endtimepull = id + "-" + day + "end";
            let inputshifttext = document.getElementById(jstext).value;
            var pattern = '-';
            let indexstarttext = inputshifttext.indexOf("-",0);

            let indexstartnumber = parseFloat(document.getElementById(starttimepull).value);
            let indexendnumber = parseFloat(document.getElementById(endtimepull).value);
            let shifttime = indexendnumber - indexstartnumber;
            
            if(shifttime <= 0){
                alert((emppartname[emppartnamearray]) + "さんの" + day +"日に入力ミスがあります");
                return false;
            }
        }
    }
}