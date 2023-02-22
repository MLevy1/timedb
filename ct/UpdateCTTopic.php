<?php
include("../function/DBConn.php");
include("../function/Functions.php");

$CTTOP = $_REQUEST["selCTTOP"];
$CTTopic = fixstr($_REQUEST["newCTTopic"]);
$CTLev3 = $_REQUEST["selCTLev3"];
$CTActive = $_REQUEST["selActive"];

$sql = "UPDATE tblCTTopic SET CTTOP='$CTTOP', CTL3='$CTLev3', CTTopic='$CTTopic', Active ='$CTActive' WHERE CTTOP='$CTTOP'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: FormCTTopic.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>