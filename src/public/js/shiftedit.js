function test(id,day) {
    let jsid = id + "-" + day;
    let jstd = id + "*" + day;
    if(document.getElementById(jsid).style.visibility=="visible"){
        document.getElementById(jsid).style.visibility="hidden";
        document.getElementById(jstd).style.visibility="visible";
    }else {
        document.getElementById(jsid).style.visibility="visible";
        document.getElementById(jstd).style.visibility="hidden";
    }
}