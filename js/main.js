//********************************************************设置cookie********************************************************//
function getCookie(c_name){
    if (document.cookie.length>0)
    { 
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1)
        { 
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";",c_start);
            if (c_end == -1) c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        } 
    }
    return "";
}

function setCookie(c_name,value,expiredays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) + ((expiredays==null) ? "" : "; expires=" + exdate.toGMTString());
}

function delCookie(name){
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    if(cval != null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//********************************************************设置cookie********************************************************//
function vote(cantellyou){
    setCookie("clandestine",cantellyou);
    location.href = "./vote-per.php";
}

function checkLoginForm(theForm){
    if (theForm.studentid.value == "" || theForm.studentid.value == "个人学号"){
        alert("请输入学号");
        return(false);
    }
    if (theForm.password.value == "" || theForm.password.value == "身份证后6位"){
        alert("请输入身份证后6位");
        return(false);
    }
    if (theForm.name.value == "" || theForm.name.value == "姓名的第一个字"){
        alert("请输入姓名第一个字");
        return(false);
    }
    else return true;
}

function checkvoted(){
    if (getCookie('isvote') == "isvote" || getCookie('back') == 1){
        var vote_per_btn = document.getElementsByClassName("vote-per-btn");
        for (var i = 0; i < vote_per_btn.length; i ++){
            vote_per_btn[i].style.background = "#666666";
        }
    }
}