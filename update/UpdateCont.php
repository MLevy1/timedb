<?php
include("../function/DBConn.php");

$ProjID = $_POST["selProjID"];
$ContID = $_POST["newContID"];
$ContDesc = $_POST["newContDesc"];
$Active = $_POST["newActive"];

$sql = "UPDATE tblCont SET ProjID='$ProjID', ContID='$ContID', ContDesc='$ContDesc', Active ='$Active' WHERE ContID='$ContID'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormCont.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>