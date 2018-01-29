<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['managerID']))
{
    if (isset($_POST['managerID']))
    {
        $managerID = $_POST['managerID'];
        $password = $_POST['password'];
        $isExist = 0;

        $sql = "SELECT * FROM `manager`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
        {
            if ($managerID == $row['managerID'])
            {
                $isExist += 1;
                break;
            }
        }
        if ($isExist == 0) echo "<script>alert('该用户不存在');</script>";
        else
        {
            $sql = "SELECT * FROM `manager` WHERE `managerID`='$managerID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_BOTH);
            $_SESSION['managerID'] = $managerID;
            if ($password == $row['password'])  echo "<script>location.href='back.php?project=jsbzr';</script>";
            else echo "<script>alert('密码输入有误');</script>";
        }
    }
}
else
{
    $home_url = 'back.php?project=tp';
    header('Location: '.$home_url);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/logIn2.css" rel="stylesheet" type="text/css" />
<title>投票管理系统</title>
<script language="javascript">
    function Juge(theForm){
        if(theForm.managerID.value == ""){
            alert("请输入用户名");
            theForm.userID.focus();
            return(false);
        }
        if(theForm.password.value == ""){
            alert("请输入密码");
            theForm.password.focus();
            return(false);
        }
    }
</script>
</head>
<body>
	<div class="main">
    	<div class="logo"><img src="../images/logo.jpg" /></div>
        <div class="inf_title">登录系统</div>
    	<div class="inf_box">
            <form action="" method="post" onsubmit="return Juge(this)">
            	<input class="inf_input" type="text" name="managerID" />
            	<input class="inf_input" type="password" name="password" />
                <span class="bt_box">
                    <button type="submit" class="bt"><div>登 录</div></button>
                </span>
            </form>
        	<div class="company">投票管理系统<span><!-- http://vip.yishion.com --></span></div>
        </div>
        <div class="announce"><font>版 权 声 明</font>华中科技大学网络应用与研发中心 （<a href="http://nadc.org.cn" target="_blank">NADC</a>）</div>
    </div>
</body>
</html>
