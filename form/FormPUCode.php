<?php
include("../function/Functions.php");
?>

<html>
<head>
    <title>New PU Code</title>
    <link rel="stylesheet" href="../css/MobileStyle.css" />
</head>

<body>
	<h1>New PU Code</h1>
	<?php include('../view/LinkTable.php'); ?>
	<form method='post' action='../add/AddPUCode.php'>
	<table>
		<tr>
			<td><b>PU Code:</td>
			<td><input type='text' name='inpPUCode'></input></td>
		</tr><tr>
			<td><b>PU Code Desc:</td>
			<td><input type='text' name='inpPUCodeDesc'></input></td>
		</tr><tr>
			<td><b>Color:</td>
			<td><input type='text' name='inpColor'></input></td>
		</tr><tr>
			<td>	<input type="submit" name="submit" /></td></tr>
	</table>
	</form>
<hr />
<?php include("../view/ViewPUCodes.php"); ?>
</body>
</html>