<!DOCTYPE html>
<html lang="en">
	<head>
		<link href="../../styles.css" rel="stylesheet"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8" />
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
	<form>
		<table>
			<tr>
				<td>Date:</td>
				<td>
					<input type="date" name="GDate" id="GDate">
				</td>
			</tr>
			<tr>
				<td>Goal:</td>
				<td>
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
				</td>
			</tr>
			<tr>
			
				<td>Cont ID:</td>
				<td>
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
				</td>
			</tr>
		</table>
		<input type="button" class = "link" onclick="AddNewGoal()" value="Add" />
		
</form>

				<button class = "link" onclick="LoadDiv('form', './timedb/goals/FormGoalOption.php?link=1')">New Goal</button>
		<!--END HEADER -->

		<div id ="buttons"></div>
		<div id="vtest"></div>		
		<div id="form"></div>
				<script>alert(1);</script>
	</body>
</html>