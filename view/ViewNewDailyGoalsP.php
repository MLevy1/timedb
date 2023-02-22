<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');
include('../function/DBConn.php');

$form = "../form/FormDailyGoalsJQ.php";

$tbl="tblNewDailyGoals";
$varSel="GoalIndex";

date_default_timezone_set('America/New_York');
$QDate = date('Y-m-d');

$sql = "SELECT * FROM tblNewDailyGoals
INNER JOIN tblGoalOptions ON tblNewDailyGoals.Goal=tblGoalOptions.GoalID
INNER JOIN tblCont ON tblNewDailyGoals.ContID=tblCont.ContID
INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID
WHERE date(GDate) >='$QDate'
OR Result IS Null
ORDER BY GDate, tblGoalOptions.Goal, tblProj.ProjDesc, tblCont.ContDesc";

$result = $conn->query($sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[1][] = $row['GoalIndex'];
	$data[2][] = date_create($row['GDate']);
	$data[3][] = $row['Priority'];
	$data[4][] = $row['Goal'];
	$data[5][] = $row['ProjDesc'];
	$data[6][] = $row['ContDesc'];
	$data[7][] = $row['Result'];
}

$cnt=count ($data[1]);
?>
<table>
<th>Date</th>
<th> </th>
<th>Goal</th>
<th>ContID</th>
<th>Grd</th>
<?php
if ($result->num_rows > 0) {
    // output data of each row
    for($x = 0; $x < ($cnt); $x++) {
        echo "<tr><td align='center' width=5%>" .
        date_format($data[2][$x],"m-d") .
        
                "</td><td align='center' width=5%>" .
        
        ("<input type=\"button\" class=\"link\" onclick=\"btnJQDel('{$data[1][$x]}', 'GoalIndex', 'tblNewDailyGoals') 
       \" value=\"D\"</input>") .
       
        "</td><td align='left' width=20%>" .
        $data[4][$x] .
        "</td><td align='center' width=25%>" .
        $data[5][$x] . " - " . $data[6][$x] . 
        "</td><td align='center' width=5%>" .
        $data[7][$x] .
        "</td><td align='center' width=4%>" .
               
        ("<input type=\"button\" class=\"link\" onclick=\"btnJQGrade('-1', '{$data[1][$x]}') 
       \" value=\"-1\"</input>") .
        "</td><td align='center' width=4%>" .
        
        ("<input type=\"button\" class=\"link\" onclick=\"btnJQGrade('0', '{$data[1][$x]}') 
       \" value=\"0\"</input>") .
        
        "</td><td align='center' width=4%>" .
        
        ("<input type=\"button\" class=\"link\" onclick=\"btnJQGrade('1', '{$data[1][$x]}') 
       \" value=\"1\"</input>") .
    
        "</td></tr>";
    }
} else {
    echo "0 results";
}
$conn->close();
echo "</table>";
?>
<script>
function btnJQGrade(a, b)
{
	$.post("../update/UpdateJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblNewDailyGoals'
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
}

function btnJQDel(a, b, c)
{
	$.post("../del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
}
</script>

