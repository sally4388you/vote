<?php
session_start();
if(isset($_SESSION['managerID']))
{
    $_SESSION = array();
    session_destroy();
}

echo "<script>location.href='login.php';</script>";
?>