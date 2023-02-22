<?php
include("../function/DBConn.php");
include("../function/Functions.php");

$CTST = $_REQUEST["selCTST"];
$CTSubtopic = fixstr($_REQUEST["newCTSubtopic"]);
$CTTopic = $_REQUEST["selCTTopic"];
$CTActive = $_REQUEST["selActive"];
$Tone = $_REQUEST["selTone"];

$sql = "UPDATE tblCTSubtopic SET CTST='$CTST', CTSubtopic='$CTSubtopic', CTTopic='$CTTopic', Active ='$CTActive', Tone = '$Tone' WHERE CTST='$CTST'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: FormCTSubtopic.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>