<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

formid();
?>

<html>
<head>
    <title>New Goal Option</title>
    <link rel="stylesheet" href="../css/MobileStyle.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    
function AddNewGoalOpt()
{
	var a = $( "#selGoal" ) . val();
	var b = $( "#inpGoal" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblGoalOptions'
	});
	setTimeout(function(){
	
        LoadDiv('GOpt', '../goals/ViewGoalOptions.php');
        
        }, 100);
}


</script>
    
</head>

<body>
	<h1>New Goal Option</h1>
	<?php linktable(); ?>
	<table>
		<tr>
			<td><b>Goal Option</td>
			<td><input type='text' id='inpGoal' name='inpGoal'></input></td>
		</tr><tr>
			<td><b>Goal</td>
			<td>
			
			<?php
			addsel2('selGoal', 'GoalID', 'Goal', 'tblGoals');
			?>
			
			</td>
	</table>
	<table>
<tr><td>

	<input type="button" class = "link" onclick="LoadDiv('form', '../goals/FormGoal.php?link=1')" value="H Goals" />
	
	</td><td>
	
<input type="button" class = "link" onclick="AddNewGoalOpt()" value="Add Option" />

	</td>
	</tr><tr>
	<td>

<input type="button" class = "link" onclick="LoadDiv('GOpt', '../goals/ViewGoalOptions.php')" value="Active" />

	</td><td>
	
<input type="button" class = "link" onclick="LoadDiv('GOpt', '../goals/ViewGoalOptions.php?I=y')" value="Inactive" />

	</td></tr>
</table>

<hr />
<div id="GOpt">
<?php include("../goals/ViewGoalOptions.php"); ?>
</div>
</body>
</html>
