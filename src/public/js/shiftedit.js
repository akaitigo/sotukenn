function chenge(id,day) {
    let jstext = id + "-" + day;
    let jstd = id + "*" + day;
    let chengebtn = id + "-" + day + "chenge";
    let returnbtn = id + "-" + day + "return";
    let batsubtn = id + "-" + day + "batsu";
    document.getElementById(returnbtn).style.visibility="visible";
    document.getElementById(batsubtn).style.visibility="visible";
    document.getElementById(jstext).style.visibility="visible";
    document.getElementById(chengebtn).style.visibility="hidden";
    document.getElementById(jstd).style.visibility="hidden";
}

function shiftreturn(id,day,shift) {
    let jstext = id + "-" + day;
    let jstd = id + "*" + day;
    let chengebtn = id + "-" + day + "chenge";
    let returnbtn = id + "-" + day + "return";
    let batsubtn = id + "-" + day + "batsu";
    document.getElementById(returnbtn).style.visibility="hidden";
    document.getElementById(batsubtn).style.visibility="hidden";
    document.getElementById(jstext).style.visibility="hidden";
    document.getElementById(chengebtn).style.visibility="visible";
    document.getElementById(jstd).style.visibility="visible";
    document.getElementById(jstext).value=shift;
}


function addbatsu(id,day) {
    let jstext = id + "-" + day;
    if(document.getElementById(jstext).style.visibility=="visible"){
        document.getElementById(jstext).value="×";
    }
}