<?php include("../function/DBConn.php");

$ContID = $_GET["selCont"];
$CTTOP = $_GET["selTop"];
$form = $_GET["form"];
$btnSet = $_GET["selbtnSet"];

$cont = "?selCont=".$ContID."&selbtnSet=".$btnSet;


$sql = "INSERT INTO tblConvos (CTTopic, ContID)
VALUES ('$CTTOP', '$ContID')";

if ($conn->query($sql) != TRUE) {
	 echo "Error: " . $sql . "<br>" . $conn->error;
}

if($form == Null){
$form = "FormCTSocial.php";
}

header ("Location: ".$form.$cont);
?>
