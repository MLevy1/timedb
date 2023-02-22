<?php
include("../function/DBConn.php");

$PUCode = $_REQUEST["selPUCode"];
$PUCodeDesc = $_REQUEST["newPUCodeDesc"];
$Color = $_REQUEST["newColor"];

$sql = "UPDATE tblPUCodes SET PUCodeDesc='$PUCodeDesc', Color='$Color' WHERE PUCode ='$PUCode'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormPUCode.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>