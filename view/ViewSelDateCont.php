<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../css/MobileStyle.css" />
<h1>Sub-Project Duration - Date Range</h1>

<a href="../menu/MenuEventLists.htm">Events Menu</a>

<?php
include('../function/Functions.php');
include('LinkTable.php');

//connect to sql db
pconn();

//set the name of the form for update / delete functions
$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);

//DATE PICKERS

//Setup query to populate date picker

$sqsel = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents ORDER BY STime DESC";

//Run date picker query

$result = mysqli_query($conn, $sqsel);

?>
<form method='get' action='ViewSelDateCont.php'>

<table width='100%'>
    <tr><td width='25%'><b>Start Date</b></td><td width='25%'>
<select name='selSDate' id='selSDate' class='smselect'>

<?php

//Loop through query results to populate date picker

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
}

//Free $result variable

mysqli_free_result($result);

?>

</select>
    </td><td width='25%'><b>End Date</b></td><td width='25%'>
<select name='selEDate' id='selEDate' class='smselect'>

<?php

$result = mysqli_query($conn, $sqsel);

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
}

mysqli_free_result($result);

?>

</select>

</td><td><input type="submit" /></td></tr></table>

</form>


<!--
END DATE PICKERS

START GET DATES
-->
<?php
//Get and format previously selected Start Date

$SDate1 = $_GET["selSDate"];
$SDate = date_create($SDate1);
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date

$EDate1 = $_GET["selEDate"];
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
}

?>

<script>
var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;

var val1 = "<?php echo $EDate1 ?>";
document.getElementById("selEDate").value=val1;
</script>


<!--
END GET DATES
-->

<!--
START EVENT QUERIES
-->
<?php
//Setup query containing all events between selected start and end date

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblProj.ProjDesc, tblCont.ContDesc FROM tblEvents INNER JOIN tblCont ON (tblEvents.ProID=tblCont.ContID) INNER JOIN tblProj ON (tblCont.ProjID=tblProj.ProjID)  WHERE date(tblEvents.STime) BETWEEN '$SDate' AND '$EDate' ORDER BY tblEvents.STime";

//Setup query containing the first event on the day following selected end date

$sql2 = "SELECT tblEvents.StartTime, tblEvents.STime, tblProj.ProjDesc, tblCont.ContDesc 
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblProj 
ON (tblCont.ProjID=tblProj.ProjID)
WHERE date(tblEvents.STime) ='$EDate2' ORDER BY tblEvents.STime LIMIT 1";

//Run above queries

$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);

?>
<!--
END EVENT QUERIES
-->

<!--
START ARRAYS
-->
<?php 
//reset arrays for results
$arrSTime = array();
$arrProj = array();
$arrCont = array();
$arrDur = array();
$arrHrs = array();
$arrMins = array();

//fill STime, Act, and Cont arrays
while ($row = mysqli_fetch_array($result)) {
	$arrSTime[] = $row['STime'];
	$arrProj[] = $row['ProjDesc'];
	$arrCont[] = $row['ContDesc'];
}

while ($row = mysqli_fetch_array($result2)) {
	$arrSTime[] = $row['STime'];
	$arrProj[] = $row['ActDesc'];
}

//count rows in results arrays
$cnt=count ($arrSTime);

//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt-1); $x++) {
	$arrDur[] = getmins($arrSTime[$x], $arrSTime[$x+1]);
	$arrHrs[] = gethours($arrDur[$x]);
	$arrMins[] = getrmins($arrDur[$x], $arrHrs[$x]);
}

//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table
$arrTest = array();

//Setup clear table query
$clear = 'TRUNCATE TABLE tblTest';

//Execute clear table query
mysqli_query($conn, $clear);

//Setup insert values query
$query = "INSERT INTO tblTest (`col1`, `col2`) VALUES ";

//Use for loop to itterate through each of the events stored in the Act and Dur arrays
for($x=0; $x<($cnt); $x++){
    $arrTest[] = "('" . $arrCont[$x] . "', '" . $arrDur[$x] . "')";
 }

//Create query used to populate Test table with contents of Act and Dur arrays
$sql = $query .= implode(',', $arrTest);


//Execute the populate table query
mysqli_query($conn, $sql);

//Setup query to calculate sum of durations calculated above in the Dur array for each grouping in the Act array

$sumq = 'SELECT col1, SUM(col2) AS scol FROM tblTest WHERE col1!="Untracked Time" GROUP BY col1 ORDER BY scol DESC';

//Setup query to sort the contents of the Test table
//$sumq = 'SELECT col1, col2 FROM tblTest ORDER BY col2 DESC';


//Reset arrays used to hold results
$col1 = array();
$col2 = array();
$colHr = array();
$colMn = array();

//Execute above query
$result = mysqli_query($conn, $sumq);

//Store query results in col1 and col2 arrays
while ($row = mysqli_fetch_array($result)) {
	$col1[] = $row['col1'];
	$col2[] = $row['scol'];
}

//Count the number of rows in col1 array
$cnt=count ($col1);

//Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays
for($x = 0; $x < $cnt; $x++) {
	$colHr[] = gethours($col2[$x]);
	$colMn[] = getrmins($col2[$x], $colHr[$x]);
}

?>

<!--END ARRAYS-->

<!--START TABLE -->

<table>
	<th>Project</th>
	<th>Time</th>
	
<?php 
//set up a for loop to itterate through the contents of the Act array
for($x = 0; $x < ($cnt); $x++) {

    //echo Activity Description [col1] and duration in terms of time using contents of colHr and colMn arrays
	
	echo "<tr><td>".$col1[$x]."</td><td class='doublecol'>".DZero($colHr[$x]).":".DZero($colMn[$x])."</td></tr>";
	
}

mysqli_close($conn);
?>

</table>

<!--END TABLE -->
