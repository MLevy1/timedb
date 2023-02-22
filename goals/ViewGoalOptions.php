<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

$I = $_REQUEST["I"];

if($I == 'y'){

$sql = "SELECT tblGoalOptions.GoalID, tblGoalOptions.Goal, tblGoals.Goal AS Goal1, tblGoalOptions.Active FROM tblGoalOptions LEFT JOIN tblGoals ON tblGoalOptions.OGoal=tblGoals.GoalID WHERE Active = 'N' ORDER BY tblGoals.Goal, tblGoalOptions.Goal";

}else{

$sql = "SELECT tblGoalOptions.GoalID, tblGoalOptions.Goal, tblGoalOptions.Active, tblGoals.Goal AS Goal1 FROM tblGoalOptions LEFT JOIN tblGoals ON tblGoalOptions.OGoal=tblGoals.GoalID WHERE tblGoals.Status != 'Closed' ORDER BY tblGoals.Goal, tblGoalOptions.Goal";

$sql2 = "SELECT tblGoals.GoalID, tblGoals.Goal FROM tblGoals LEFT JOIN tblGoalOptions ON tblGoalOptions.OGoal = tblGoals.GoalID WHERE tblGoals.Status != 'Closed' AND tblGoalOptions.OGoal IS NULL";

}


$result = mysqli_query($conn, $sql);

$result2 = mysqli_query($conn, $sql2);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['GoalID'];
	$data[1][] = $row['Goal'];
	$data[2][] = $row['Goal1'];
	$data[3][] = $row['Active'];
}

while ($row = mysqli_fetch_array($result2)) {
	$data[4][] = $row['Goal'];
}

$cnt=count ($data[0]);

$cnt2=count ($data[4]);

mysqli_close($conn);
?>
<table width="100%">
<?php
    for($x = 0; $x < ($cnt); $x++) {
    
    if($data[2][$x]!=$ld2){
	echo "<tr><td colspan=2><h3>".$data[2][$x]. "</h3></td></tr>";
	}    
    
    if(($data[3][$x]!='N') or ($I == 'y')){
   
	echo "<tr><td width='5%'>".("<input type=\"button\" class=\"link\" onclick=\"location.href='../goals/FormUpdateGoalOption.php?selGO={$data[0][$x]}'\" value=\"U\"</input>")."</td>";
    

	echo "<td>".$data[1][$x]."</td></tr>";
	
	}
	
	$ld2 = $data[2][$x];
} 

for($x = 0; $x < ($cnt2); $x++) {
	echo "<tr><td colspan=2><h3>".$data[4][$x]. "</h3></td></tr>";

}
?>
</table>