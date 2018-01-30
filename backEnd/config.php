<?php
	$dbhost = "localhost";
	// $dbuser = "vote";
	$dbuser = "remote";
	$dbname = "vote_hust";
	// $dbpassword = "2VTF4K0XNAYMWZ";
	$dbpassword = "199551";
	$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	mysqli_query($conn, "SET NAMES 'UTF8'");
	error_reporting(0);
?>
<?php
	@set_time_limit(1800);
	date_default_timezone_set ('Asia/Shanghai');
?>