<?php
include ('../function/Functions.php');

pconn();

$ActID = $_REQUEST["selAct"];
$ContID = $_REQUEST["selCont"];

$form1 =  $_REQUEST["form"];
$form = 'Location: '.$form1;

$btnfull = $_REQUEST['btn_submit'];

if(isset($_REQUEST['btn_submit'])){

	$ActID = substr($btnfull, 0, 3);
	$ContID = substr($btnfull, 4);
	
}

if(isset($_REQUEST['selDT'])){

$STime = $_REQUEST["selDT"];

}

else {

date_default_timezone_set('America/New_York');
$STime = date("Y-m-d H:i:s");

}

$sql = "INSERT INTO tblEvents (ActID, ProID, STime)
VALUES ('$ActID', '$ContID', '$STime')";

if (mysqli_query($conn, $sql) != TRUE) {
	 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     mysqli_close($conn);
}

mysqli_close($conn);
header ("$form");
?>
