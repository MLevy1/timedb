<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

$I = $_REQUEST["I"];

if($I == 'y'){

$sql = "SELECT * FROM tblGoals WHERE Status = 'Closed' ORDER BY GoalID";

}else{

$sql = "SELECT * FROM tblGoals WHERE Status != 'Closed' ORDER BY GoalID";

}

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['GoalID'];
	$data[1][] = $row['Goal'];
	$data[2][] = $row['Status'];
}

$cnt=count ($data[0]);
?>
<table width="100%">
	<th>Goal</th>
<?php
    for($x = 0; $x < ($cnt); $x++) {
	echo "<tr><td width='10%'>".
	$data[0][$x].
	"</td><td width='85%'>".
	$data[1][$x].
	"</td><td width='5%'>".("<input type=\"button\" class=\"link\" onclick=\"location.href='../goals/FormUpdateGoal.php?selGoal={$data[0][$x]}'\" value=\"U\"</input>")."</td></tr>";
} 

mysqli_close($conn);
echo "</table>";