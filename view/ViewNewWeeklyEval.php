<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../css/MobileStyle.css" />
<h1>Weekly Eval</h1>

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
<form method='get' action='ViewNewWeeklyEval.php'>

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
sqlDGBetStartEnd($SDate, $EDate);

//Run above queries

$result = mysqli_query($conn, $sqlDGBetStartEnd);

?>
<!--END EVENT QUERIES-->

<!--START ARRAYS-->
<?php
//reset arrays for results

$data = array();

//fill STime, Act, and Cont arrays
while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['GDate'];
    $data[1][] = $row['Goal'];
    $data[2][] = $row['Result'];
    $data[3][] = $row['ContDesc'];
}

//count rows in results arrays
$cnt= count ($data[0]);
?>
<!--END ARRAYS-->

<!--START TABLE -->

<table width=100%>
	<th>Date</th>
	<th>Goal</th>
	<th>Score</th>
	<th>Sub-Project</th>

<?php
//set up a for loop to itterate through the contents of the Act array
for($x = 0; $x < ($cnt); $x++) {

    //echo Activity Description [col1] and duration in terms of time using contents of colHr and colMn arrays
    echo "<tr><td align='center' width=20%>".$data[0][$x]."</td><td>".$data[1][$x]."</td><td align='center'>".$data[2][$x]."</td><td>".$data[3][$x]."</td></tr>";
}

mysqli_close($conn);
?>

</table>

<!--END TABLE -->