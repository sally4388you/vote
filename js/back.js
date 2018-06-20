window.onload=window.onresize=function(){
	var height = document.documentElement.clientHeight - 95;
	var width = document.documentElement.clientWidth;
	document.getElementById("basicInfo").style.height = parseInt(height) + "px";
    document.getElementById("left_menu").style.height = parseInt(height) + "px";

    document.getElementById("basicInfo").style.width = parseInt(width) * 0.88 + "px";
    document.getElementById("left_menu").style.width = parseInt(width) * 0.12 + "px";
    if (typeof(submitbutton) != "undefined")
    	document.getElementById("submitbutton").style.width = parseInt(width) * 0.88 - 20 + "px";
    if (typeof(link_valid) != "undefined")
    	document.getElementById("link_valid").style.width = parseInt(width) * 0.88 - 55 + "px";
}

function Juge(theForm){
	if (theForm.LoginId.value == ""){
		alert("请输入卡号");
		return(false);
	}
	if (theForm.password.value == ""){
		alert("请输入密码");
		return(false);
	}
	if (theForm.code.value == ""){
		alert("请输入验证码");
		return(false);
	}
}

function isshow(id,value){
	var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");		
    }
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            var msg = xmlhttp.responseText;
            var isshowpicture = "../images/";
            isshowpicture += (msg == '1') ? "yes" : "no";
            isshowpicture += ".png";
            if (msg == 1){
            	var showbuttons = document.getElementsByClassName('showbutton');
            	for (var i = 0; i < showbuttons.length; i ++){
            		showbuttons[i].src = "../images/no.png";
            		showbuttons[i].value = "0";
            	}
            }
            document.getElementById('isshowpicture' + id).src = isshowpicture;
            document.getElementById('isshowpicture' + id).value = msg;
        }
    }
    xmlhttp.open("GET", "?isshowid=" + id + "&isshowed=" + value, true);
    xmlhttp.send();
}

function uploadbutton(thisvalue){
	var hidevalue = (thisvalue == "intoDB") ? "uppicture" : "intoDB";
	document.getElementById('form_' + hidevalue).style.display = 'none';
	document.getElementById('form_' + thisvalue).style.display = 'inline';
}

function add(){
	document.getElementById('addForm').style.display = "inline-block";
}

function addFormClear(){
	document.getElementById('addForm').style.display = "none";
}

function revise(button){
	if (button.value == "修改" || button.value == "Submit"){
		var name = ["studentid", "name", "department", "introduction"];
		var divs = document.getElementsByClassName('detailtable')[0].getElementsByTagName('div');
		for (var i = 0; i < divs.length; i ++){
			if (i == 3){
				divs[i].innerHTML = "<textarea id='content' name='" + name[i] + "'>" + divs[i].innerHTML.replace("简介:&nbsp;", "") + "</textarea>";
				UE.getEditor('content');
				continue;
			}
			divs[i].innerHTML = "<input name='" + name[i] + "' type='text' value='" + divs[i].innerHTML + "'>";
		}
		document.getElementById('norevise').style.display = "inline";
		button.value = (button.value == "修改") ? "提交" : "Submit";
	}
	else document.getElementById('formRevise').submit();
}

function cancel(button){
	var divs = document.getElementsByClassName('detailtable')[0].getElementsByTagName('div');
	for (var i = 0; i < divs.length; i ++){
		if (i == 3){
			divs[i].innerHTML = "简介:&nbsp;" + divs[i].getElementsByTagName('textarea')[0].value;
			continue;
		}
		divs[i].innerHTML = divs[i].getElementsByTagName('input')[0].value;
	}
	document.getElementById('norevise').style.display = "none";
	button.parentNode.getElementsByTagName('input')[0].value = "修改";
}

function projectDelete(button){
	if (button.checked == false){
		document.getElementById('deletebutton').style.display = "none";
	}
	else{
		var deletes = document.getElementsByClassName('projectDelete');
		for (var i = 0; i < deletes.length; i ++){
			deletes[i].getElementsByTagName('input')[0].checked = false;
			deletes[i].parentNode.getElementsByTagName('select')[0].disabled = true;
		}
		document.getElementById('deletebutton').style.display = "inline";
		button.checked = true;
		button.parentNode.parentNode.getElementsByTagName('select')[0].disabled = false;
	}
}

function studentDelete(){
	document.getElementById('deletebutton').style.display = "none";
	var deletes = document.getElementsByClassName('projectDelete');
	for (var i = 0; i < deletes.length; i ++){
		if (deletes[i].getElementsByTagName('input')[0].checked == true){
			document.getElementById('deletebutton').style.display = "inline";
			break;
		}
	}
}

function list_up_down(){
	var left_ul_title = document.getElementsByClassName('left_ul_title');
	for(var i = 0; i < left_ul_title.length; i ++){
		left_ul_title[i].onclick = function(){
			// this.className=(this.className == "confirm_box choosed")? "confirm_box not-choose":"confirm_box choosed";
			if (this.className == "left_ul_title left_on choosed"){
				this.className = "left_ul_title left_on not-choosed";
			}
			else if (this.className == "left_ul_title choosed"){
				this.className = "left_ul_title not-choosed";
			}
			else if (this.className == "left_ul_title left_on not-choosed"){
				this.className = "left_ul_title left_on choosed";
			}
			else{
				this.className = "left_ul_title choosed";
			}
		}
	}
}

function checktime(theForm){
	var opentime = theForm.opentime.value, closetime = theForm.closetime.value;
	var re = /[0-9]{4}-[0-9]{2}-[0-9]{2}/;
	if(opentime != ""){
		if(!re.test(opentime)){
			alert('时间填写格式不正确');
			theForm.opentime.focus();
			return false;
		}
	}
	else{
		alert("开始时间不能为空");
		theForm.opentime.focus();
		return false;
	}

	if(closetime != ""){
		if(!re.test(closetime)){
			alert('时间填写格式不正确');
			theForm.closetime.focus();
			return false;
		}
	}
	else{
		alert("结束时间不能为空");
		theForm.closetime.focus();
		return false;
	}

	if(opentime.localeCompare(closetime)> 0){
		alert('开始时间不能在活动时间之后');
		theForm.closetime.focus();
		return false;
	}
}

function checkaddForm(theFrom){
	if (theFrom.ch_name.value == ""){
		alert("项目名称不能为空！");
		theFrom.ch_name.focus();
		return false;
	}
	if (theFrom.eng_name.value == ""){
		alert("项目拼音简写不能为空！");
		theFrom.eng_name.focus();
		return false;
	}
}