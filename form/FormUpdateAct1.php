<html>
<head>
<title>Update Activity</title>
<link rel="stylesheet" href="../../styles.css" />

</head>
<body>
<h1>Update Activity</h1>
<?php
include("../view/LinkTable.php");
include("../function/DBConn.php");
include("../function/Functions.php");

$selAct = $_REQUEST["selAct"];

$sql = "SELECT * FROM tblAct WHERE ActID='$selAct'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$defActID = $row['ActID'];
	$defActDesc = $row['ActDesc'];
	$defPCode = $row['PCode'];
	$defUCode = $row['UCode'];
	$defWklyHrs = $row['WklyHrs'];
	$defWklyMins = $row['WklyMins'];
	$defStatus = $row['Status'];
}
$conn->close();
?>
<form method="post" action="../update/UpdateAct.php">
<table>
	<tr>
		<td>
ActID:
		</td><td>
<b><?php echo $defActID; ?>
<input type="hidden" name="selActID" value='<?php echo $defActID; ?>' ></input>
		</td>
	</tr><tr>
		<td>
Act Desc:
		</td><td>
<input name="newActDesc" value= '<?php echo $defActDesc; ?>' ></input>
		</td>
	</tr><tr>
		<td>
PCode:
		</td><td>
<input name="Pcodesel" id='Pcodesel' value= '<?php echo $defPCode; ?>' ></input>
		</td>
	</tr><tr>
		<td>
UCode:
		</td><td>
<?php
addsel2('Ucodesel', 'PUCode', 'PUCodeDesc', 'tblPUCodes');
?>
		</td>
	</tr><tr>	
		<td>
		Status:
		</td><td>
		<select name="newStatus" id="newStatus">
		<option>Active</option>
		<option>Inactive</option>
		</select>
		</td>
	</tr><tr>
		<td>
Weekly Hours:
		</td><td>
<input name="newWklyHrs" id="nwh" value= '<?php echo $defWklyHrs; ?>'  onload="setval()"></input>
		</td>
	</tr><tr>
		<td>
Weekly Mins:
		</td><td>
<input name="newWklyMins" value= '<?php echo $defWklyMins; ?>' ></input>
		</td>
	</tr><tr>	
		<td>
<input type="submit">
		</td>
	</tr>
</form>
</table>

<script>

var val2 = "<?php echo $defUCode ?>";
document.getElementById("Ucodesel").value=val2;

var val3 = "<?php echo $defStatus ?>";
document.getElementById("newStatus").value=val3;
</script>

</body>
</html>