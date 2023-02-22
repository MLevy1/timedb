<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
include("../function/Functions.php");

formid();
?>
<html>
<head>
    <title>New Daily Goals</title>
        <link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>New Daily Goals</h1>
<?php include('../view/LinkTable.php'); ?>
<form method="get" action="../add/AddNewDailyGoals.php">
<table>
<tr><td>
Date:
</td><td>
<input type="date" name="GDate1" id="GDate1">
</td></tr><tr><td>
Goal:
</td><td>
<?php
pconn();
$sql = "SELECT * FROM tblGoalOptions WHERE Active != 'N' ORDER BY Goal";

$result = $conn->query($sql);
?>

<select class='selgoal' id='selGoal' name='selGoal'>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['GoalID'] . "'>" . $row['Goal'] . "</option>";
}
$conn->close();

?>

</td></tr><tr><td>
Cont ID:
</td><td>
<?php
pconn();
$sql = "SELECT DISTINCT tblCont.ProjID, tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjStatus, tblProj.ProjDesc FROM tblCont INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID WHERE tblProj.ProjStatus!='Closed' AND tblCont.Active!='N' ORDER BY ProjID, ContID";

$result = $conn->query($sql);
?>

<select class='selgoal' id='selCont' name='selCont'>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" . $row['ProjDesc'] . " - " . $row['ContDesc'] . "</option>";
}
$conn->close();
?>
</select>
</td></tr><tr><td>
	<input type="button" class = "link" onclick="location.href='../form/FormGoalOption.php';" value="New Goal" />
	</td><td>
	<input class = "link" type="submit"/>
	</td></tr>

<?php include("../view/btnCntSetGoals.php");?>

</table>
</form>
<?php include("../view/ViewNewDailyGoalsP.php"); 
$QTime = date('Y-m-d');
?>

</body>
</html>
<script>
var val = "<?php echo $QTime ?>";
document.getElementById("GDate1").value=val;


$("#GDate1").change(function(){
    $("#dtest").text("Hello world!"); 
    });

</script>
