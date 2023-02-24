<?php
include("../function/Functions.php");
?>

<html>
<head>
    <title>Goals</title>
    <link rel="stylesheet" href="../../styles.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
<script>

function AddNewHGoal()
{
	var a = $( "#inpGoalID" ) . val();
	var b = $( "#inpGoal" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblGoals'
	});
	setTimeout(function(){
	
        LoadDiv("HGoals", "../goals/ViewGoals.php");
        
        }, 100);
}

LoadDiv("HGoals", "../goals/ViewGoals.php");

</script>
    
    
</head>

<body>

	<h1>Goals</h1>
	<?php linktable(); ?>

	<table>
		<tr>

			<td><b>Goal ID:</td>
			<td>
			
			<input type='text' id='inpGoalID' name='inpGoalID'></input>
			
			</td>
			
		</tr><tr>
		
			<td><b>Goal:</td>
			<td>
			
			<textarea rows="3" cols="35" id="inpGoal" name="inpGoal"></textarea>
			
			</td>
			
		</tr>
		
	</table>
	
		<table>
		
<tr><td>
	<input type="button" class = "link" onclick="LoadDiv('form', '../goals/FormGoalOption.php?link=1')" value="Goal Options" />
	</td><td>
<input type="button" class = "link" onclick="AddNewHGoal()" value="Add Goal" />
	</td><td>
<input type="button" class = "link" onclick="LoadDiv('HGoals', '../goals/ViewGoals.php')" value="Active" />
	</td><td>
<input type="button" class = "link" onclick="LoadDiv('HGoals', '../goals/ViewGoals.php?I=y')" value="Inactive" />
	</td></tr>
</table>
	
	
<hr />
<div id='HGoals'>
</div>
</body>
</html>
