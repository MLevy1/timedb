<?php
include("../function/DBConn.php");

$ProjID = $_POST["selProjID"];
$ProjDesc = $_POST["newProjDesc"];
$PCode = $_POST["newPCode"];
$Status = $_POST["newStatus"];

$sql = "UPDATE tblProj SET ProjID='$ProjID', ProjDesc='$ProjDesc', PCode='$PCode', ProjStatus='$Status' WHERE ProjID='$ProjID'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormProj.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>