<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

$QTime = date('Y-m-d');

//START QUERIES & ARRAY FILL

$data = array();

//GOAL ARRAYS

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-60 days');
$SQTime = date_format($SQTime,'Y-m-d');

$sql = "SELECT DISTINCT tblGoalOptions.GoalID, tblGoalOptions.Goal, tblGoalOptions.Active, tblNewDailyGoals.ContID, tblCont.ContDesc FROM tblGoalOptions INNER JOIN tblNewDailyGoals ON tblGoalOptions.GoalID = tblNewDailyGoals.Goal INNER JOIN tblCont ON tblNewDailyGoals.ContID = tblCont.ContID INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE tblGoalOptions.Active !=  'N' AND tblProj.ProjStatus != 'Closed' AND tblCont.Active != 'N' AND tblNewDailyGoals.GDate > '$SQTime' ORDER BY tblGoalOptions.Goal";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['GoalID'];
    $data[1][] = $row['ContID'];
    $data[2][] = $row['Goal'] . "<br>" . $row['ContDesc'];
}

//END GOAL ARRAYS

mysqli_close($conn);

$btncnt=count($data[0]);

$GDate = date('Y-m-d');

?>

<table id="btntbl" width=100%>

<script>

var data = <?php echo json_encode( $data ) ?>;

var btncnt=<?php echo $btncnt; ?>

var rowcounter=1;

var rowbtns=4;

var rownum= Math.floor(btncnt/rowbtns);

var lrowbtns=(btncnt%rowbtns);

while (rowcounter<=rownum){

$( "#btntbl" ).append("<tr id=tr"+rowcounter+">");

var rowbtncounter=1;

while (rowbtncounter<=rowbtns){

var a = ((rowcounter-1)* rowbtns) + (rowbtncounter-1);

$("#tr"+rowcounter).append(`<td><button id=` + a + ` onclick="btnJQGoal(`+ a + `)" >` + data[2][a] +`</button></td>`);

rowbtncounter++;
}

$("#btntbl").append("</tr>");

rowcounter++;
}

if (lrowbtns!=0){

$( "#btntbl" ).append("<tr id=tr"+rowcounter+">");

for (var i = 1; i <= lrowbtns; i++) {

var a = ((rowcounter-1)* rowbtns) + (i-1);

$("#tr"+rowcounter).append(`<td><button id=` + a + ` onclick="btnJQGoal(`+ a + `)" >` + data[2][a] +`</button></td>`);
}

$("#btntbl").append("</tr>");

}

$("#btntbl").append("</table>");

</script>
