<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />
<h1>Activity Duration</h1>
<h2>(From 2016-09-22)</h2>

<a href="../menu/MenuEventLists.htm">Events Menu</a>

<?php
include('../function/Functions.php');
include('LinkTable.php');

pconn();

setQTime();

$QDate=date_create($QTime);

$FirstDate=date_create("2016-09-22");

$diff=date_diff($FirstDate,$QDate);

$diff1=$diff->format('%a days');

$nweeks = floor($diff1 / 7);

//MODIFY TO ONLY COVER POST 9/21

//set result variable to hold contents of sql query

$sql = "SELECT * FROM tblEvents
    INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE STime > CAST('2016-09-22' AS DATE) ORDER BY STime";

$result = mysqli_query($conn, $sql);

$data = array();

//fill STime, Act, and Cont arrays
while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['STime'];
	$data[1][] = $row['ActDesc'];
}

//count rows in results arrays
$cnt=count($data[0]);

$data[0][] = date_format(date_create($NowTime), 'Y-m-d h:i A');

//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt-1); $x++) {
	$data[2][] = getmins($data[0][$x], $data[0][$x+1]);
	$data[3][] =  gethours($data[2][$x]);
	$data[4][] =  getrmins($data[2][$x], $data[3][$x]);
}

?>
<table>
	<th>Activity</th>
	<th>Time</th>
	<th>Weekly</th>
	<th>Daily</th>
<?php
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
    //Fill Test Array with a combination of Act and Dur array for each event
    $arrTest[] = "('" . $data[1][$x] . "', '" . $data[2][$x] . "')";
 }

//Create query used to populate Test table with contents of Act and Dur arrays
$sql = $query .= implode(',', $arrTest);

//Execute the populate table query
mysqli_query($conn, $sql);

//NORM: Setup query to calculate sum of durations calculated above in the Dur array for each grouping in the Act array

$sumq = 'SELECT ActID, col1, SUM(col2) AS scol, COUNT(col2) AS ecnt FROM tblTest INNER JOIN  tblAct ON tblTest.col1=tblAct.ActDesc WHERE col1!="Untracked Time" GROUP BY col1 ORDER BY ecnt DESC';

//Execute above query
$result = mysqli_query($conn, $sumq);

mysqli_query($conn, $clear);
mysqli_close($conn);

//Reset arrays used to hold results
$data1 = array();

//Store query results in col1 and col2 arrays
while ($row = mysqli_fetch_array($result)) {
	$data1[0][] = $row['col1'];
	$data1[1][] = $row['scol'];
	$data1[2][] = $row['scol'] / $nweeks;
	$data1[3][] = $row['scol'] / $diff1;
	$data1[4][] = $row['ActID'];
	$data1[11][] = $row['ecnt'];
	$data1[12][] = $row['scol'] / $row['ecnt'];
}

//Count the number of rows in col1 array
$cnt=count ($data1[0]);

//Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays
for($x = 0; $x < $cnt; $x++) {
	$data1[5][] = gethours($data1[1][$x]);
	$data1[6][] = getrmins($data1[1][$x], $data1[5][$x]);
	$data1[7][] = gethours($data1[2][$x]);
	$data1[8][] = floor(getrmins($data1[2][$x], $data1[7][$x]));
	$data1[9][] = gethours($data1[3][$x]);
	$data1[10][] = floor(getrmins($data1[3][$x], $data1[9][$x]));
	$data1[13][] = gethours($data1[12][$x]);
	$data1[14][] = floor(getrmins($data1[12][$x], $data1[13][$x]));
}

//set up a for loop to itterate through the contents of the Act array
for($x = 0; $x < ($cnt); $x++) {

    //echo Activity Description [col1] and duration in terms of time using contents of colHr and colMn arrays

	echo "<tr><td>".$data1[0][$x]."</td><td class='doublecol'>".DZero($data1[5][$x]).":".DZero($data1[6][$x])."</td><td class='doublecol'>".DZero($data1[7][$x]).":".DZero($data1[8][$x])."</td><td class='doublecol'>".DZero($data1[9][$x]).":".DZero($data1[10][$x])."</td><td class='doublecol'>".DZero($data1[13][$x]).":".DZero($data1[14][$x])."</td><td>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateAct1.php?selAct={$data1[4][$x]}'\" value=\"U\"</input>").
	"</td></tr>";
}
?>
</table>