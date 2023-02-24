<?php header("Cache-Control: no-cache, must-revalidate");?>

<link rel="stylesheet" href="../../styles.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php
include('../function/Functions.php');
linktable();

pconn();

formid();

//Get previously selected Activity

$selAct = $_REQUEST["selAct"];
$selCont = $_REQUEST["selCont"];
$selMinH = $_REQUEST["selMinH"];
$selMaxH = $_REQUEST["selMaxH"];

//Get and format previously selected Start Date

$SDate1 = $_REQUEST["selSDate"];
$SDate = date_create($SDate1);
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date

$EDate1 = $_REQUEST["selEDate"];
$EDate = date_create($EDate1);
$EDate = date_format($EDate,"Y-m-d");

//Create variable to hold the day after the selected end date

$EDate2 = date_create($EDate1);
date_add($EDate2, date_interval_create_from_date_string("1 day"));
$EDate2 = date_format($EDate2,"Y-m-d");

//Create variable to hold the name and path of the current page

$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);

//Set pickers to default values if blank 

if ($SDate1 == NULL) {
$SDate1 = date('Y-m-d');
$EDate1 = date('Y-m-d');
$selAct = 'All';
$selCont = 'All';
}

?>

<script>

var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;

var val1 = "<?php echo $EDate1 ?>";
document.getElementById("selEDate").value=val1;

var val2 = "<?php echo $selAct ?>";
document.getElementById("selAct").value=val2;

var val3 = "<?php echo $selCont ?>";
document.getElementById("selCont").value=val3;
</script>

<?php

//Setup query containing all events between selected start and end date
$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActID, tblAct.ActDesc, tblCont.ContID, tblCont.ContDesc, tblProj.ProjID, tblProj.ProjDesc, tblAct.UCode
FROM tblEvents
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
INNER JOIN tblProj 
ON (tblCont.ProjID= tblProj.ProjID) 
WHERE date(STime) BETWEEN '$SDate' AND '$EDate' AND HOUR(tblEvents.STime) >= '$selMinH' AND HOUR(tblEvents.STime) <= '$selMaxH'
ORDER BY STime";

//Setup query containing the first event on the day following selected end date
$sql2 = "SELECT *
FROM tblEvents 
WHERE date(STime) ='$EDate2' ORDER BY STime LIMIT 1";

//Run above queries

$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);

//Reset arrays for results

$data = array();

//Populate arrays with results of all events query

while ($row = mysqli_fetch_array($result)) {
        $data[0][] = $row['STime'];
        $data[1][] = date_create($row['STime']);
        $data[2][] = $row['StartTime'];
        $data[3][] = $row['ActID'];
        $data[4][] = $row['ContID'];
    }

//Free $result variable

mysqli_free_result($result);

//Populate arrays with results of first next day event query

while ($row = mysqli_fetch_array($result2)) {
	$data[0][] = $row['STime'];
	$data[1][] = date_create($row['STime']);
}

//Free $result variable

mysqli_free_result($result2);

//Count rows in arrays

$cnt=count ($data[0]);

//Set Current Date Variables

$EDate3 = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

//Determine if the end date selected is the current date

if ($EDate == $EDate3){

//Add row to end of arrays with current date and time

$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);

}

	
//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt); $x++) {
    $arrDur[] = getmins($data[0][$x], $data[0][$x+1]);
}

//use arrays to populate test2 table

//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table

$arrTest = array();

//Setup clear table query

$clear = 'TRUNCATE TABLE tblTest4';

//Execute clear table query

mysqli_query($conn, $clear);

//Setup insert values query

$query = "INSERT INTO tblTest4 (`col1`, `col2`, `col3`, `col4`) VALUES ";

//Use for loop to itterate through each of the events stored in the Act and Dur arrays

for($x=0; $x<($cnt); $x++){
        $arrTest[] =
        "('" .
        $data[2][$x] .
        "', '" .
        $data[3][$x] .
        "', '" .
        $data[4][$x] .
        "', '" .
        $arrDur[$x] .
        "')";
     }

//Create query used to populate Test table with contents of Act and Dur arrays

$sql = $query .= implode(',', $arrTest);

//Execute the populate table query

mysqli_query($conn, $sql);

//Switch to determine which queries to run to fill results arrays below

    if ($selAct == 'All'){
        $a = 'A';
    }
    else
    {
        $a = 'O';
    }

    if ($selCont == 'All') {
        $b = 'A';
    }
    else
    {
        $b = 'O';
    }

$qry = $a.$b;

switch ($qry) {

 //1. all events (AA), 2. all act, one cont (AO), 4. one act & one cont (OO), 6. one act, all cont, one proj (OA) 
 
//1. Query containing all events (AA)

    case "AA":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.Col4 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID ORDER BY Time(STime)";
        
        break;

//2. Query containing all events with selected ContID (AO)

    case "AO":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc , tblTest4.Col4 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ProID = '$selCont' ORDER BY Time(STime)";
        
        break;

//3. Query containing all events with selected ActID 

    case "OA":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc , tblTest4.Col4 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ActID = '$selAct' ORDER BY Time(STime)";
        
	break;

//4. Query containing all events with selected ContID and selected ActID

	case "OO":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.Col4 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ActID = '$selAct' AND tblEvents.ProID = '$selCont' ORDER BY CAST(tblTest4.Col4 AS INTEGER)";
        
        break;
        
}

//Execute the populate table query

$result = mysqli_query($conn, $sql3);

//Reset arrays for results

$data = array();

//Populate arrays with results of all events query

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = date_create($row['STime']);
    $data[1][] = $row['Col4'];
    $data[2][] = $row['ActDesc'];
    $data[3][] = $row['ContDesc'];
    $data[4][] = $row['StartTime'];
    $data[5][] = $row['Details'];
    $data[6][] = $row['WD'];
    
}

//Count rows in arrays
$cnt=count ($data[0]);

if ($EDate != $EDate3){
//$cnt = ($cnt-1);
}
?>

</tr>
</table>
<hr />
<table width='100%'>
	<th><b>Time</th>
	<th><b>Act - Cont</th>

<?php
// List Events

for($x = 0; $x < ($cnt); $x++) {
	echo "<tr><td width='16%'>".
	date_format($data[0][$x],"D y-m-d h:i A").
	"</td><td  width='30%'>".
	$data[2][$x].
	"->".
	$data[3][$x].
	"</td><td  width='29%'>".
	$data[5][$x].
	"</td><td  width='15%' align='center'>".
	gethours($data[1][$x]).
	":".
	DZero(getrmins($data[1][$x], gethours($data[1][$x]))).
	"</td></tr>";
}

mysqli_close($conn);
?>
</table>

<?php include('../function/StdDev.php'); ?>