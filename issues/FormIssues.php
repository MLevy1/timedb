<?php 
	include("../function/Functions.php");
?>
<html>
	<head>
		<title>Issue Management</title>
		<link rel="stylesheet" href="../../styles.css" />
	</head>
	<body>
		<h2>Add New Issue</h2>
		<table>
		<form method="post" action="AddIssue.php">
			<tr>
				<td><b>Issue Desc: </b>
				</td>
				<td>
					<textarea rows="5" cols="40" id="IDesc" name="IDesc"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit" />
				</td>
			</tr>
		</form>
		</table>
		<hr \>
		<h2>Issue List</h2>
		<?php include ('ViewIssues.php'); ?>
	</body>
</html>

