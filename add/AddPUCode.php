<?php 
include("../function/DBConn.php");

$PUCode = $_POST["inpPUCode"];
$PUCodeDesc = $_POST["inpPUCodeDesc"];
$Color = $_POST["inpColor"];

$sql = "INSERT INTO tblPUCodes (PUCode, PUCodeDesc, Color)
VALUES ('$PUCode', '$PUCodeDesc', '$Color')";

if ($conn->query($sql) === TRUE) {
	$conn->close();
	header ('Location: ../form/FormPUCode.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}
?>