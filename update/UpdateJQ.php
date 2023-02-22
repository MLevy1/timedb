<?php

$tbl = $_REQUEST["selTbl"];

//FOR EVENTS
if($tbl === 'tblEvents'){

//Act
$v1 = $_REQUEST["v1"];

//Pro
$v2 = $_REQUEST["v2"];

//TimeStamp
$v3 = $_REQUEST["v3"];

$c1 = 'ActID';
	
$c2 = 'ProID';

$c3 = 'StartTime';

}


//FOR GOALS

if($tbl === 'tblNewDailyGoals'){

//Result
$v1 = $_REQUEST["v1"];

//GoalIndex
$v2 = $_REQUEST["v2"];
	
$c1 = 'Result';
	
$c2 = 'GoalIndex';

}

//FOR DATES

if($tbl ==='tblDateInfo'){
	$v1 = $_REQUEST["v1"];

	$v2 = $_REQUEST["v2"];

	$c1 = 'Type';

	$c2 = 'Date';
}

//FOOD EVENTS

if($tbl ==='tblFoodEvents'){
	$v1 = $_REQUEST["v1"];

	$v2 = $_REQUEST["v2"];

	$c1 = 'FoodID';

	$c2 = 'TimeStamp';
}

//FOODS

if($tbl ==='tblFoods'){
	$v1 = $_REQUEST["v1"];

	$v2 = $_REQUEST["v2"];

	$c1 = 'Food';

	$c2 = 'FoodID';
}

include ('../function/Functions.php');

pconn();
if($tbl === "tblEvents"){

	$sql = "UPDATE $tbl SET $c1 ='$v1',  $c2 ='$v2' WHERE $c3 ='$v3'";

}else{

	$sql = "UPDATE $tbl SET $c1 ='$v1' WHERE $c2 ='$v2'";
	
}

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>