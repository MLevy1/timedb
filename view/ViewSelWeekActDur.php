<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />
<h1>Weekly Activity Duration</h1>

<a href="../menu/MenuEventLists.htm">Events Menu</a>

<?php
include('../function/Functions.php');
include('../function/SqlList.php');
include('LinkTable.php');

//connect to sql db
pconn();

//set the name of the form for update / delete functions [MIGHT NOT NEED]
formid();

//DATE PICKER

//Run week picker query
$result = mysqli_query($conn, $sqlWeekPick);
?>
<form method='get' action='ViewSelWeekActDur.php'>

<table>
    <tr><td><b>Start Date</b></td><td>
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

</td><td><input type="submit" /></td></tr></table>

</form>

<!--END DATE PICKER-->

<!--START GET DATES-->
<?php

//Get and format previously selected Start Date
$SDate1 = $_GET["selSDate"];
$SDate = date_create($SDate1);
$SDate = date_format($SDate,"Y-m-d");

//Create variable to hold end date and end date+1
$EDate1 = date_create($SDate1);
date_add($EDate1, date_interval_create_from_date_string("7 days"));
$EDate1 = date_format($EDate1,"Y-m-d");

$EDate = date_create($EDate1);
$EDate = date_format($EDate,"Y-m-d");

$EDate2 = date_create($EDate1);
date_add($EDate2, date_interval_create_from_date_string("1 day"));
$EDate2 = date_format($EDate2,"Y-m-d");

//Set pickers to default values if blank
if ($SDate1 == NULL) {
    $SDate1 = date('Y-m-d');
}
?>

<script>
var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;
</script>

<!--END GET DATES-->

<!--START EVENT QUERIES-->
<?php
sqlBetStartEnd($SDate, $EDate);

sqlFirstofNext($EDate2);

//Run above queries

$result = mysqli_query($conn, $sqlBetStartEnd);

$result2 = mysqli_query($conn, $sqlFirstofNext);
?>
<!--END EVENT QUERIES-->

<!--START ARRAYS-->
<?php
//reset arrays for results

$data = array();

//fill STime, Act, and Cont arrays
while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['STime'];
    $data[1][] = $row['ActDesc'];
}

while ($row = mysqli_fetch_array($result2)) {
    $data[0][] = $row['STime'];
    $data[1][] = $row['ActDesc'];
}

//count rows in results arrays
$cnt=((count ($data, COUNT_RECURSIVE))/count($data))-1;

//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt-1); $x++) {
    $data[2][] = getmins($data[0][$x], $data[0][$x+1]);
    $data[3][] = gethours($data[2][$x]);
    $data[4][] = getrmins($data[2][$x], $data[3][$x]);

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
    $arrTest[] = "('" . $data[1][$x] . "', '" . $data[2][$x] . "')";
 }

//Create query used to populate Test table with contents of Act and Dur arrays
$sql = $query .= implode(',', $arrTest);

//Execute the populate table query
mysqli_query($conn, $sql);

//Execute above query
$result = mysqli_query($conn, $sqlCol1Totals);

//Reset arrays used to hold results
$data2 = array();

//Store query results in col1 and col2 arrays
while ($row = mysqli_fetch_array($result)) {
    $data2[0][] = $row['col1'];

    $data2[1][] = $row['scol'];
}

//Count the number of rows in col1 array
$cnt=((count ($data2, COUNT_RECURSIVE))/count($data2))-1;

//Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays
for($x = 0; $x < $cnt; $x++) {
    $data2[2][] = gethours($data2[1][$x]);

    $data2[3][] = getrmins($data2[1][$x], $data2[2][$x]);
}

//Setup array to hold all activity descriptions

$AllAct = array();

//Setup query to pull all activities

$qryAllAct = 'SELECT DISTINCT ActDesc FROM tblAct';

//Execute above query
$result = mysqli_query($conn, $qryAllAct);
?>

<!--END ARRAYS-->

<!--START TABLE -->

<table>
	<th>Activity</th>
	<th>Time</th>

<?php
//set up a for loop to itterate through the contents of the Act array
for($x = 0; $x < ($cnt); $x++) {

    //echo Activity Description [col1] and duration in terms of time using contents of colHr and colMn arrays
    echo "<tr><td>".$data2[0][$x]."</td><td class='doublecol'>".DZero($data2[2][$x]).":".DZero($data2[3][$x])."</td></tr>";
}

mysqli_close($conn);
?>

</table>

<!--END TABLE -->