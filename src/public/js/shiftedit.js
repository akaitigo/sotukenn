function test(id,day) {
    let jsid = id + "-" + day;
    let jstd = id + "*" + day;
    let judge = 0;
    if(document.getElementById(jsid).style.visibility=="visible"){
        if(judge == 0) {
            judge++;
        }else {
            document.getElementById(jsid).style.visibility="hidden";
            document.getElementById(jstd).style.visibility="visible";
        }
    }else {
        document.getElementById(jsid).style.visibility="visible";
        document.getElementById(jstd).style.visibility="hidden";
    }
}