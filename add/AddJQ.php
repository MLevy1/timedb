<?php

$tbl = $_REQUEST["selTbl"] ?? null;

$app = $_REQUEST["selApp"] ?? "n";

//FOR EVENTS

if($tbl === 'tblEvents'){

	$SD = $_REQUEST["SD"] ?? null;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$v2 = $_REQUEST["v2"] ?? null;

	$v3 = $_REQUEST["v3"] ?? date("Y-m-d H:i:s");

	$c1 = 'ActID';
	
	$c2 = 'ProID';
	
	$c3 = 'STime';

	if($SD != 'L'){

		$varcnt = 3;

	}else{

		$varcnt = 4;
	
		$c4 = 'StartTime';

	}
}

//FOR GOALS

if($tbl === 'tblNewDailyGoals'){

	$varcnt = 3;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$v2 = $_REQUEST["v2"] ?? null;

	$v3 = $_REQUEST["v3"] ?? null;
	
	$c1 = 'GDate';
	
	$c2 = 'Goal';
	
	$c3 = 'ContID';

}

//FOR GOAL OPTIONS

if($tbl === 'tblGoalOptions'){

	$varcnt = 2;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$v2 = $_REQUEST["v2"] ?? null;
	
	$c1 = 'OGoal';
	
	$c2 = 'Goal';

}

//FOR H GOALS

if($tbl === 'tblGoals'){

	$varcnt = 2;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$v2 = $_REQUEST["v2"] ?? null;
	
	$c1 = 'GoalID';
	
	$c2 = 'Goal';
	
}


//FOR FOODS

if($tbl === 'tblFoods'){

	$varcnt = 1;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$c1 = 'Food';
	
}



//FOR DATES

if($tbl === 'tblDateInfo'){

	$varcnt = 2;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$v2 = $_REQUEST["v2"] ?? null;
	
	$c1 = 'Date1';
	
	$c2 = 'Type';

}

//FOR SCHED

if($tbl === 'tblSchedEvents'){

$varcnt = 3;

$v1 = $_REQUEST["v1"] ?? null;
	
$v2 = $_REQUEST["v2"] ?? null;

$v3 = $_REQUEST["v3"] ?? null;
	
$c1 = 'SEActID';
	
$c2 = 'SEContID';

$c3 = 'SESTime';

}

//FOR MOOD

if($tbl === 'tblMood'){

	$varcnt = 2;

	$v1 = $_REQUEST["v1"] ?? date("Y-m-d H:i:s");

	$v2 = $_REQUEST["v2"] ?? null;
	
	$c1 = 'MoodDT';
	
	$c2 = 'Mood';

}


//FOR WEIGHT

if($tbl === 'tblWeight'){

	$varcnt = 2;

	$v1 = $_REQUEST["v1"] ?? null;
	
	$v2 = $_REQUEST["v2"] ?? null;
	
	$c1 = 'wDateTime';
	
	$c2 = 'Weight';

}



//FOR FOOD

if($tbl === 'tblFoodEvents'){

	$varcnt = 3;

	$v1 = $_REQUEST["v1"] ?? date("Y-m-d H:i:s");

	$v2 = $_REQUEST["v2"] ?? null;

	$v3 = $_REQUEST["v3"] ?? null;
	
	$c1 = 'MTime';
	
	$c2 = 'FoodID';

	$c3 = 'Type';

}

//ACTIVITIES
if($tbl === 'tblAct'){




}


include ('../function/Functions.php');

pconn();

if($varcnt == 1){

	$sql = "INSERT INTO $tbl ($c1) VALUES ('$v1')";
	
	} elseif ($varcnt == 2) {
	
	$sql = "INSERT INTO $tbl ($c1, $c2) VALUES ('$v1', '$v2')";
	
	} elseif ($varcnt == 4) {
	
	$sql = "INSERT INTO $tbl ($c1, $c2, $c3, $c4) VALUES ('$v1', '$v2', '$v3', '$v3')";
	
	} else{

$sql = "INSERT INTO $tbl ($c1, $c2, $c3) VALUES ('$v1', '$v2', '$v3')";

}

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

if($app === 'y'){

	echo '<script>window.close()</script>';

}
?>