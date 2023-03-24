<?php

$tbl = $_REQUEST["selTbl"];


//FOR ACTIVITIES

if($tbl == 'tblEvents'){

//Result
$v1 = $_REQUEST["v1"];

//GoalIndex
$v2 = $_REQUEST["v2"];

$c1 = 'ActID';
	
$c2 = 'GoalIndex';

}

//FOR SUB ACTIVITIES

if($tbl =='tblEvents'){
	$v1 = $_REQUEST["v1"];

	$v2 = $_REQUEST["v2"];

	$c1 = 'Type';

	$c2 = 'Date';
}

include ('../function/Functions.php');

pconn();

//start

//$sql = "UPDATE tblEvents SET STime='$fullSTime', ActID='$newActID', ProID='$newContID', Details='$newDetails' WHERE StartTime='$TimeStamp'";

//act

//$sql = "UPDATE tblEvents SET 
//ActID='$newActID' WHERE ActID='$selAct'";

//end



$sql = "UPDATE $tbl SET $c1  ='$v1' WHERE $c2 ='$v2'";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>