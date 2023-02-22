<?php

include ('../function/Functions.php');

pconn();

$oldActID = $_REQUEST["oldActID"];
$oldContID = $_REQUEST["oldContID"];

$newActID = $_REQUEST["newActID"];
$newContID = $_REQUEST["newContID"];

/*
$SDate = $_REQUEST["SDate"];
$EDate = $_REQUEST["EDate"];

$selMinH = $_REQUEST["selMinH"];
$selMaxH = $_REQUEST["selMaxH"];


//Update Act given Act

$sql = "UPDATE tblEvents SET ActID='$newActID'
WHERE ActID='$oldActID' AND date(STime) BETWEEN '$SDate' AND '$EDate' AND HOUR(STime) >= '$selMinH' AND HOUR(STime) <= '$selMaxH'";

//Update Cont given Cont

$sql = "UPDATE tblEvents SET ProID='$newContID'
WHERE ProID='$oldContID' AND date(STime) BETWEEN '$SDate' AND '$EDate' AND HOUR(STime) >= '$selMinH' AND HOUR(STime) <= '$selMaxH'";

//Update Act & Cont given Act and cont

$sql = "UPDATE tblEvents SET ActID='$newActID', ProID='$newContID', WHERE ActID='$oldActID' AND ProID='$oldContID' AND date(STime) BETWEEN '$SDate' AND '$EDate' AND HOUR(STime) >= '$selMinH' AND HOUR(STime) <= '$selMaxH'";
*/


$sql = "UPDATE tblEvents SET ActID='$newActID', ProID='$newContID', WHERE ActID='$oldActID' AND ProID='$oldContID'";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>