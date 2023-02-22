<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

$form1 = $_GET["form"];

$app = $_GET["app"];

$form = 'Location: '.$form1;

$sql = "SELECT StartTime, STime, ActID, ProID FROM tblEvents ORDER BY STime DESC LIMIT 2";

$result = mysqli_query($conn, $sql);

$arrStartTime = array();
$arrActID = array();
$arrContID =array();

while ($row = mysqli_fetch_array($result)) {
	$arrActID[] = $row['ActID'];
	$arrContID[] = $row['ProID'];
}

$ActID = $arrActID[1];
$ProID = $arrContID[1];

date_default_timezone_set('America/New_York');
$STime = date("Y-m-d H:i:s");

$sql = "INSERT INTO tblEvents (ActID, ProID, STime)
VALUES ('$ActID', '$ProID', '$STime')";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

if($app === 'y'){

	echo '<script>window.close()</script>';

}else{
	header ("$form");
}
?>