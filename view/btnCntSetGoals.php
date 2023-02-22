<?php
include("../function/Functions.php");

pconn();

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-60 days');
$SQTime = date_format($SQTime,'Y-m-d');

$sql = "SELECT DISTINCT tblGoalOptions.GoalID, tblGoalOptions.Goal, tblGoalOptions.Active, tblNewDailyGoals.ContID, tblCont.ContDesc FROM tblGoalOptions INNER JOIN tblNewDailyGoals ON tblGoalOptions.GoalID = tblNewDailyGoals.Goal INNER JOIN tblCont ON tblNewDailyGoals.ContID = tblCont.ContID INNER JOIN tblProj on tblCont.ProjID = tblProj.ProjID WHERE tblGoalOptions.Active !=  'N' AND tblProj.ProjStatus != 'Closed' AND tblCont.Active != 'N' AND tblNewDailyGoals.GDate > '$SQTime' ORDER BY tblGoalOptions.Goal";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
    $data[1][] = $row['GoalID'];
    $data[2][] = $row['Goal'];
    $data[3][] = $row['Active'];
    $data[4][] = $row['ContID'];
    $data[5][] = $row['ContDesc'];
}

$btncnt=count($data[1]);

$rowcounter=1;

$btncounter=0;

$rowbtns=3;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

echo "<table width='100%'>";

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
	echo "<tr>";
	$rowbtncounter=1;

	while ($rowbtncounter<=$rowbtns){
 		echo "<td>";

        $btnval1 = $data[1][$btncounter];
        $btnval2 = $data[4][$btncounter];
        $btnname1 = $data[2][$btncounter];
        $btnname2 = $data[5][$btncounter];

        $btnval = $btnval1." ".$btnval2;

        $btnname = $btnname1."<br>".$btnname2;

        echo "<button name='btn_submit' value='$btnval' type='submit' class='gbutton'>$btnname</button>";

 		echo "</td>";
 		$btncounter++;
		$rowbtncounter++;
	}
echo "</tr>";
$rowcounter++;
}
}
if ($lrowbtns!=0){
	echo "<tr>";
	for ($i = 0; $i < $lrowbtns; $i++) {
		echo "<td>";
		
        $btnval1 = $data[1][$btncounter];
        $btnval2 = $data[4][$btncounter];
        $btnname1 = $data[2][$btncounter];
        $btnname2 = $data[5][$btncounter];

        $btnval = $btnval1." ".$btnval2;

        $btnname = $btnname1."<br>".$btnname2;

        echo "<button name='btn_submit' value='$btnval' type='submit' class='gbutton'>$btnname</button>";
		
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}
mysqli_close($conn);
echo "</table>";
?>