<?php
include("../function/DBConn.php");

$ActID = $_REQUEST["selActID"];
$ActDesc = $_REQUEST["newActDesc"];
$ContID = $_REQUEST["selCont"];
$PCode = $_REQUEST["Pcodesel"];
$UCode = $_REQUEST["Ucodesel"];
$WklyHrs = $_REQUEST["newWklyHrs"];
$WklyMins = $_REQUEST["newWklyMins"];
$Status = $_REQUEST["newStatus"];

$sql = "UPDATE tblAct SET ActDesc='$ActDesc', PCode='$PCode', UCode='$UCode', WklyHrs='$WklyHrs', WklyMins='$WklyMins', Status='$Status' WHERE ActID='$ActID'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormAct.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>