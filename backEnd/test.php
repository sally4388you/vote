<?php
include "config.php";
// $sql = "DELETE FROM `voter_2016`";
$sql = "SELECT * FROM `voter_2016` LIMIT 10";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
	echo $row['name']." ".$row['studentid']." ".$row['identityid']."<br />";
}

?>