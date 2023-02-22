<?php
include("../function/Functions.php");

pconn();

$form1 =  $_REQUEST["form"];
$form = 'Location: '.$form1;

$qvar = array();

$qvar[0] = 'ActID';
$qvar[1] = 'ActDesc';
$qvar[2] = 'PCode';
$qvar[3] = 'UCode';
$qvar[4] = 'WklyHrs';
$qvar[5] = 'WklyMins';
$qvar[6] = 'Status';

$ActID = $_POST["inpActID"];
$ActDesc = $_POST["inpAct"];
$PCode = $_POST["codesel"];
$UCode = $_POST["usesel"];
$WklyHrs = $_POST["inpWklyHrs"];
$WklyMins = $_POST["inpWklyMins"];
$Status = "Active";

$sql = "INSERT INTO tblAct (ActID, ActDesc, PCode, UCode, WklyHrs, WklyMins, Status)
VALUES ('$ActID', '$ActDesc', '$PCode', '$UCode', '$WklyHrs', '$WklyMins', '$Status')";

if (mysqli_query($conn, $sql) != TRUE) {
	 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     mysqli_close($conn);
}

mysqli_close($conn);
header ("$form");
?>
