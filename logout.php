<script src="./js/main.js"></script>
<?php
session_start();
if(isset($_SESSION['studentid'])){
    $_SESSION = array();
    session_destroy();
}

echo "<script>delCookie('isvote');location.href='index.php';</script>";
?>