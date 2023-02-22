<?php include("../function/DBConn.php");

$selDate = $_GET["selDate"];
$selTime = $_GET["selTime"];
$ActID = $_GET["selAct"];
$ContID = $_GET["selCont"];
//$formcode = $_POST["formcode"];

$STime = $selDate." ".$selTime;

$form1 =  $_GET["form"];
$form = 'Location: ../form/'.$form1.'?selDate='.$selDate.'&selTime='.$selTime;

$btnfull = $_GET['btn_submit'];
if(isset($_GET['btn_submit'])){
$ActID = substr($btnfull, 0, 3);
$ContID = substr($btnfull, 4);
}

$sql = "INSERT INTO tblSchedEvents (SEActID, SEContID, SESTime)
VALUES ('$ActID', '$ContID', '$STime')";

if ($conn->query($sql) != TRUE) {
	 echo "Error: " . $sql . "<br>" . $conn->error;
}
header ("$form");
?>
