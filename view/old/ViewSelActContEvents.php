<?php header("Cache-Control: no-cache, must-revalidate");?>
<h1>Events - Selected Activity and Date Range</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<link rel="stylesheet" href="../css/MobileStyle.css" />

<!-- For Date Picker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php
include('../function/Functions.php');
include("../view/LinkTable.php");

pconn();

formid();


?>

<form method='get' action='<?php echo $form; ?>' >

<table witdth=100%>

    <tr><td><b>Start Date</b></td><td>

    	<p><input type="text" id='selSDate' name='selSDate'></p></td><td>

    	<b>End Date</b></td>

    	<td><p><input type="text" id='selEDate' name='selEDate'></p></td>
    	
<script>
$( function() {
	$( "#selSDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
	$( "#selEDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
 } );
 
 </script>

    	</tr><tr><td><b>Activity</b></td><td>

<select id='selAct' name='selAct' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['ActID'] . "'>" .$row['ActDesc'] . "</option>";
}

mysqli_free_result($result);

?>

</select>
</td><td><b>Project</b></td>
	
	<td>
	
<select id='selProj' name='selProj' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblProj ORDER BY ProjDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ProjID'] . "'>" .$row['ProjDesc'] . "</option>";
}
mysqli_free_result($result);
?>

</select>
	
</td></tr>

<tr>

<td><b>Use Code</td><td>
	
	<select id='selUCode' class='smselect' name='selUCode'>

<option value='All'>All</option>
<option value='AW'>All Work</option>

<?php

$sql = "SELECT * FROM tblPUCodes ORDER BY PUCodeDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['PUCode'] . "'>" .$row['PUCode'] . " - " .$row['PUCodeDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>
	</td>

<td><b>Sub-Project</b></td><td>

<select id='selCont' class='smselect' name='selCont'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE Active!='N' AND ProjStatus != 'Closed' ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ContID'] . "'>" .$row['ProjDesc'] . " - " .$row['ContDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>

</td> </tr>

<tr>

	<td><b>Time Code</b></td>
	<td>
		<select id='timecode' name='timecode' class='smselect'>
			<option selected>H</option>
			<option>M</option>
		</select>
		
</td><td></td>


	<td> <input type="submit" /> </td>
	
</tr>

</table>

</form>

<?php
//Set varaibles for delete buttons

$tbl = 'tblEvents';
$varSel = 'StartTime';

//Get previously selected Activity

$selAct = $_REQUEST["selAct"];
$selProj = $_REQUEST["selProj"];
$selCont = $_REQUEST["selCont"];
$timecode = $_REQUEST["timecode"];
$selUCode = $_REQUEST["selUCode"];

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
$selProj = 'All';
$selCont = 'All';
$timecode = 'H';
$selUCode = 'All';
}

//END
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

var val4 = "<?php echo $timecode ?>";
document.getElementById("timecode").value=val4;

var val5 = "<?php echo $selProj ?>";
document.getElementById("selProj").value=val5;

var val6 = "<?php echo $selUCode ?>";
document.getElementById("selUCode").value=val6;

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
WHERE date(STime) BETWEEN '$SDate' AND '$EDate' 
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
        $data[5][] = $row['ProjID'];
        $data[6][] = $row['UCode'];
        
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

$query = "INSERT INTO tblTest4 (`col1`, `col2`, `col3`, `col4`, `col5`, `col6`) VALUES ";

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
        $data[5][$x] .
        "', '" .
        $arrDur[$x] .
        "', '" .
       $data[6][$x] .
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
    
    if ($selProj == 'All') {
        $c = 'A';
    }
    else
    {
        $c = 'O';
    }
    
if ($selUCode == 'All') {
        $d = 'A';
    }
    elseif ($selUCode =='AW'){
	$d = 'AW';
    }else
    {
        $d = 'O';
    }

$qry = $a.$b.$c.$d;

switch ($qry) {

 //1. all events (AAAA), 2. all act, one cont (AOAA), 3. one act, all cont, all proj (OAAA), 4. one act, one cont, all proj (OOAA), 5. all act, all cont, one proj, (AAOA), 6. one act, all cont, one proj (OAOA) 7. all act, cnt, proj, one use code (AAAO) 8. all work related events AAAAW



//1. Query containing all events (AAAA)

    case "AAAA":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID ORDER BY STime";
        
        break;

//2. Query containing all events with selected ContID (AOAA)

    case "AOAA":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ProID = '$selCont' ORDER BY STime";
        
        break;

//3. Query containing all events with selected ActID 

    case "OAAA":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ActID = '$selAct' ORDER BY STime";
        
	break;

//4. Query containing all events with selected ContID and selected ActID

	case "OOAA":

        $sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblEvents.ActID = '$selAct' AND tblEvents.ProID = '$selCont' ORDER BY STime";
        
        break;
               
//5. all act, all cont, one proj, (AAOA)
	
	case "AAOA":
	
	$sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblCont.ProjID = '$selProj' ORDER BY STime";
	
	break;

//6. one act, all cont, one proj (OAOA) 
	
	case "OAOA":
	
	$sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblCont.ProjID = '$selProj' AND tblEvents.ActID = '$selAct' ORDER BY STime";	
	
	break;

//7. all act, cnt, proj, one use code (AAAO) 

	case "AAAO":

$sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5 FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblAct.UCode = '$selUCode' ORDER BY STime";

	break;

//8. all work related events (AAAAW)
        
        case "AAAAW":

$sql3 = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.Details, tblAct.ActDesc, tblCont.ContDesc, tblTest4.col5, WEEKDAY(tblEvents.STime) AS WD FROM tblEvents INNER JOIN tblTest4 ON tblEvents.StartTime = tblTest4.Col1 INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE tblAct.UCode = 'W' OR tblAct.UCode = 'M' OR tblAct.UCode = 'D' OR tblAct.UCode = 'A' OR tblAct.UCode = 'T' ORDER BY STime";

// For weekends only WEEKDAY(tblEvents.STime)>4"
        
        break;
        
}

//Execute the populate table query

$result = mysqli_query($conn, $sql3);

//Reset arrays for results

$data = array();

//Populate arrays with results of all events query

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = date_create($row['STime']);
    $data[1][] = $row['col5'];
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
	<th><b>Details</th>
	<th><b>Dur</th>

<?php
// List Events

for($x = 0; $x < ($cnt); $x++) {
	echo "<tr><td width='16%'>".
	date_format($data[0][$x],"D m-d h:i A").
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
	"</td><td width='5%' align='center'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateEvent0.php?form=$form&selSDate=$SDate&selEDate=$EDate&selProj=$selProj&timecode=$timecode&selUCode=$selUCode&selAct=$selAct&selCont=$selCont&selEvent={$data[4][$x]}'\" value=\"U\"</input>").
	"</td><td width='5%' align='center'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../del/DelEvent.php?form=$form&selQDate=$QTime&tbl=$tbl&varSel=$varSel&selEvent={$data[4][$x]}'\" value=\"D\"</input>")."</td></tr>";
}

mysqli_close($conn);
?>
</table>

<?php include('../function/StdDev.php'); ?>