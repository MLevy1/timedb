<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

$btnfull = $_GET['btn_submit'];

$TimeStamp = $_GET["TimeStamp"];
$newSTime = $_GET["newSTime"];
$newActID = $_GET["NselAct"];
$newContID = $_GET["NselCont"];

echo $btnfull;

echo $TimeStamp;

if($btnfull != NULL) {
	$newActID = substr($btnfull, 0, 3);
	$newContID = substr($btnfull, 4);
}

$form = 'Location: FormJQSch.php';

$sql = "UPDATE tblSchedEvents SET SESTime='$newSTime', SEActID='$newActID', SEContID='$newContID' WHERE SESTime='$TimeStamp'";

$result = mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql) != TRUE) {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

header ("$form");
?>