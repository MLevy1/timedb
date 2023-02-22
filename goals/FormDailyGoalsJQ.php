<?php
header("Cache-Control: no-cache, must-revalidate");
?>
<head>
<link href="../css/MobileStyle.css" rel="stylesheet"/>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src='../function/JSFunctions1.js'></script>


<?php
//START PHP HEAD

include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

$QTime = date('Y-m-d');

//END PHP HEAD
?>

</head>

<body>
<h1>JQ Daily Goals</h1>
<?php linktable(); ?>

<!-- DAILY GOAL HEADER -->

<table>
<tr><td>
Date:
</td><td>
<input type="date" name="GDate" id="GDate">
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
</td></tr>
</table>
<table>
<tr><td>

	<input type="button" class = "link" onclick="LoadDiv('form', '../goals/FormGoalOption.php?link=1')" value="New Goal" />
	
	</td><td>
	
<input type="button" class = "link" onclick="AddNewGoal()" value="Add" />

	</td></tr>
</table>

<!--END HEADER -->

<div id ="buttons">

</div>

<div id="vtest">

</div>

<script>
var val = "<?php echo $QTime ?>";

document.getElementById("GDate").value=val;

function btnJQGoal(a)
{	
	var tvar = $( "#GDate" ) . val();
	
	var goal = data[0][a];
	var cont = data[1][a];
	var id = a;
	
	$.post("../add/AddJQ.php",
	{
		v1: tvar,
		v2: goal,
		v3: cont,
		selTbl: 'tblNewDailyGoals'
	});
	
	$("button").css("background-color", "lightgray");
	
	$("#"+id).css("background-color", "pink");
	
	setTimeout(function(){
	LoadDiv('buttons', '../goals/btnSetJQGoals.php');

LoadDiv('vtest', '../view/ViewNewDailyGoalsP.php');
        }, 500);
       	 
 }

function UpdateGoals()
{
    $.ajax({
        url: '../view/ViewNewDailyGoalsP.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
    })
    .fail(function() {
        $('#vtest').prepend('Error updating.');
    });
}

function AddNewGoal()
{
	var a = $( "#selGoal" ) . val();
	var b = $( "#selCont" ) . val();
	var tvar = $( "#GDate" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: tvar,
		v2: a,
		v3: b,
		selTbl: 'tblNewDailyGoals'
	});
	setTimeout(function(){
	
        LoadDiv('vtest', '../view/ViewNewDailyGoalsP.php');
        
    	LoadDiv('buttons', '../goals/btnSetJQGoals.php');
    	
        }, 1000);
}

LoadDiv('buttons', '../goals/btnSetJQGoals.php');

LoadDiv('vtest', '../view/ViewNewDailyGoalsP.php');

</script>
</body>
</html>