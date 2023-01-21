function chenge(id,day) {
    let jstext = id + "-" + day;
    let jstd = id + "*" + day;
    let chengebtn = id + "-" + day + "chenge";
    let returnbtn = id + "-" + day + "return";
    let batsubtn = id + "-" + day + "batsu";
    let starttimepull = id + "-" + day + "start";
    let endtimepull = id + "-" + day + "end";
    let haihunpull = id + "-" + day + "haihun";
    document.getElementById(chengebtn).style.visibility="hidden";
    document.getElementById(jstd).style.visibility="hidden";
    document.getElementById(starttimepull).style.visibility="visible";
    document.getElementById(endtimepull).style.visibility="visible";
    document.getElementById(haihunpull).style.visibility="visible";
    document.getElementById(returnbtn).style.visibility="visible";
    document.getElementById(batsubtn).style.visibility="visible";
    document.getElementById(jstext).style.visibility="visible";
}

function shiftreturn(id,day,shift) {
    let jstext = id + "-" + day;
    let jstd = id + "*" + day;
    let chengebtn = id + "-" + day + "chenge";
    let returnbtn = id + "-" + day + "return";
    let batsubtn = id + "-" + day + "batsu";
    let starttimepull = id + "-" + day + "start";
    let endtimepull = id + "-" + day + "end";
    let haihunpull = id + "-" + day + "haihun";
    document.getElementById(starttimepull).style.visibility="hidden";
    document.getElementById(endtimepull).style.visibility="hidden";
    document.getElementById(haihunpull).style.visibility="hidden";
    document.getElementById(returnbtn).style.visibility="hidden";
    document.getElementById(batsubtn).style.visibility="hidden";
    document.getElementById(jstext).style.visibility="hidden";
    document.getElementById(chengebtn).style.visibility="visible";
    document.getElementById(jstd).style.visibility="visible";
    document.getElementById(jstext).value=shift;
}

function addshifttime(id,day) {
    let jstext = id + "-" + day;
    let starttimepull = id + "-" + day + "start";
    let endtimepull = id + "-" + day + "end";
    if(document.getElementById(jstext).style.visibility=="visible"){
        let starttimetext =document.getElementById(starttimepull).value;
        let endtimetext =document.getElementById(endtimepull).value;
        let shifttime = starttimetext + "-" + endtimetext;
        document.getElementById(jstext).value= shifttime;
    }
}

function addbatsu(id,day) {
    let jstext = id + "-" + day;
    let starttimepull = id + "-" + day + "start";
    let endtimepull = id + "-" + day + "end";
    if(document.getElementById(jstext).style.visibility=="visible"){
        document.getElementById(starttimepull).value = "";
        document.getElementById(endtimepull).value = "";
        document.getElementById(jstext).value="×";
    }
}

function update(emppartcountid,emppartname,lastday) {
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
            
            if(inputshifttext == "-" || inputshifttext == "×"){
            }else if (indexstarttext == 0) {
                alert((emppartname[emppartnamearray]) + "さんの" + day + "日の出勤時間を入力してください");
                return false;
            }else if(inputshifttext.lastIndexOf(pattern)+pattern.length===inputshifttext.length){
                alert((emppartname[emppartnamearray]) + "さんの" + day + "日の退勤時間を入力してください");
                return false;
            }else if(shifttime <= 0){
                alert((emppartname[emppartnamearray]) + "さんの" + day +"日に入力ミスがあります");
                return false;
            }
        }
    }
}