<?php 
include("../function/DBConn.php");

$ProjID = $_POST["inpProjID"];
$ProjDesc = $_POST["inpProj"];
$PCode = $_POST["codesel"];
$ProjStatus = 'Open';

$sql = "INSERT INTO tblProj (ProjID, ProjDesc, PCode, ProjStatus)
VALUES ('$ProjID', '$ProjDesc', '$PCode', '$ProjStatus')";

if ($conn->query($sql) === TRUE) {
	$conn->close();
	header ("Location: ../form/FormProj.php");
} else {
	$conn->close();    
	echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
