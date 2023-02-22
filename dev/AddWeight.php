<?php
include ('../function/Functions.php');

$W = $_GET["txtWeight"];

$STime = $_GET["selDT"];

$form1 =  $_GET["form"];

$form = 'Location: '.$form1;

pconn();

$sql = "INSERT INTO tblWeight (Weight, wDateTime)
VALUES ('$W', '$STime')";

if ($W > 0) {
if (mysqli_query($conn, $sql) != TRUE) {
	 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
     mysqli_close($conn);
}
}
mysqli_close($conn);

header ("$form");
?>