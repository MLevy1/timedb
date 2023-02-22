<?php

$tbl="tblEvents";

$v1 = $_REQUEST["v1"];
$v2 = $_REQUEST["v2"];
$v3 = $_REQUEST["v3"];
$v4 = $_REQUEST["v4"];
$v5 = $_REQUEST["v5"];
$v6 = $_REQUEST["v6"];
$v7 = $_REQUEST["v7"];
$v8 = $_REQUEST["v8"];

$c1 = 'ActID';
$c2 = 'ProID';
$c9 = 'Details';

/*

v1: newAct,
v2: newCont,
v3: oldAct,
v4: oldCont,
v5: selSDate,
v6: selEDate,
v7: selMinH,
v8: selMaxH

1. select act v3 & cont v4 / change act v1 & cont v2

2. select act v3 & cont v4 / change act v1 no v2

3. select act v3 & cont v4 / change cont v2 no v1

4. select act v3 & all cont / change act v1 no v2

5. select all act & cont v4 / change cont v2 no v1

4. select act v3 & all cont / change act v1
			
$sql = "UPDATE $tbl SET $c1 = '$v1' WHERE $c1 ='$v3' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

nA.nC.oA.oC

1. No.No.All.All = stop (nono allall)
2. No.No.All.oC = stop (nono)
3. No.No.oA.All = stop (nono)
4. No.No.oA.oC = stop (nono)

5. nA.nC.All.All = stop (allall)
6. nA.nC.All.oC = stop (s1)
7. nA.nC.oA.All = stop (s2)
8. nA.nC.oA.oC = go

9. No.nC.All.All = stop (allall)
10. No.nC.All.oC = go
11. No.nC.oA.All = stop (s3)
12. No.nC.oA.oC = go

13. nA.No.All.All = stop (allall)
14. nA.No.All.oC = stop (s4)
15. nA.No.oA.All = go
16. nA.No.oA.oC = go

*/

include ('../function/Functions.php');

pconn();

if ($v1 == 'No'){
    	$a = 'N';
	}
	else
	{
   		$a = 'O';
}

if ($v2 == 'No') {
    	$b = 'N';
	}
	else
	{
    	$b = 'O';
}

if ($v3 == 'All') {
	    $c = 'A';
    }
    else
    {
    	$c = 'O';
}

if ($v4 == 'All') {
        $c = 'A';
    }
    else
    {
    	$c = 'O';
}


$test1 = $a.$b;
$test2 = $c.$d;


switch ($test1) {

	case "NN":

		break;

	case "NO":

	//No New Activity;  Yes New Cont

		switch($test2){

			case "AA":

				break;

			case "AO":

			// All old act; Yes old cont

				$sql = "UPDATE $tbl SET $c2 = '$v2' WHERE $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

				break;

			case "OA":

			// Yes old act; All old cont

				break;

			case "OO":

			// Yes old act; Yes old cont

				$sql = "UPDATE $tbl SET $c2 = '$v2' WHERE $c1 ='$v3' AND $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

				break;
		}



	case "ON":

	//Yes New Act; No New Cont

		switch($test2){

			case "AA":

				break;

			case "AO":

			// All old act; Yes old cont

				break;

			case "OA":

			// Yes old act; All old cont

				//$c1 = 'ActID'; $c2 = 'ProID'; v1: newAct; v2: newCont; v3: oldAct; v4: oldCont

				$sql = "UPDATE $tbl SET $c1 ='$v1' WHERE $c1 ='$v3' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

				break;


			case "OO":

			// Yes old act; Yes old cont

				//$c1 = 'ActID'; $c2 = 'ProID'; v1: newAct; v2: newCont; v3: oldAct; v4: oldCont

				$sql = "UPDATE $tbl SET $c1 ='$v1' WHERE $c1 ='$v3' AND $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

				break;

		}


	case "OO":

	//Yes New Act; Yes New Cont

		switch($test2){

			case "AA":

				break;

			case "AO":

			// All old act; Yes old cont

				break;

			case "OA":

			// Yes old act; All old cont

				break;

			case "OO":

			// Yes old act; Yes old cont

				//$c1 = 'ActID'; $c2 = 'ProID'; v1: newAct; v2: newCont; v3: oldAct; v4: oldCont

				$sql = "UPDATE $tbl SET $c1 ='$v1', $c2 = '$v2' WHERE $c1 ='$v3' AND $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

				break;

		}

}

/*
if($v1.$v2 != "NoNo"){

	if($v3.$v4 != "AllAll"){

		if($v1=="No"){
		
			if($v2!="No"){
		
				//3. select act v3 & cont v4 / change cont v2
	
				$sql = "UPDATE $tbl SET $c2 = '$v2' WHERE $c1 ='$v3' AND $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";
	
			}
	
		}elseif($v2=="No"){
	
	
			//2. select act v3 & cont v4 / change act v1
			
			
			$sql = "UPDATE $tbl SET $c1 ='$v1', WHERE $c1 ='$v3' AND $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";
			
		}else{

		//1. select act v3 & cont v4 / change act v1 & cont v2

		$sql = "UPDATE $tbl SET $c1 ='$v1', $c2 = '$v2' WHERE $c1 ='$v3' AND $c2 ='$v4' AND HOUR(STime) >= $v7 AND HOUR(STime) <= $v8 AND date(STime) BETWEEN '$v5' AND '$v6'";

		}

	}

}
*/

echo "v1=".$v1;
echo "v2=".$v2;
echo "v3=".$v3;
echo "v4=".$v4;

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>