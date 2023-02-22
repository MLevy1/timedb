<html>
<head>
<title>Update PU Code</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />

</head>
<body>
<h1>Update PU Code</h1>
<?php
header("Cache-Control: no-cache, must-revalidate");
include("../view/LinkTable.php");
include("../function/DBConn.php");

$selPUCode = $_REQUEST["selPUCode"];

$sql = "SELECT * FROM tblPUCodes WHERE PUCode ='$selPUCode'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$defPUCode = $row['PUCode'];
	$defPUCodeDesc = $row['PUCodeDesc'];
	$defColor = $row['Color'];
}
$conn->close();
?>
<form method="post" action="../update/UpdatePUCode.php">
<table>
	<tr>
		<td>
PUCode:
		</td><td>
<b><?php echo $defPUCode; ?>
<input type="hidden" name="selPUCode" value='<?php echo $defPUCode; ?>' ></input>
		</td>
	</tr><tr>
		<td>
PUCode Desc:
		</td><td>
<input name="newPUCodeDesc" value= '<?php echo $defPUCodeDesc; ?>' ></input>
		</td>
	</tr><tr>
		<td>
Color:
		</td><td>
<input name="newColor" value= '<?php echo $defColor; ?>' ></input>
		</td>
	</tr>
	<tr>	
		<td>
<input type="submit">
		</td>
	</tr>
</form>
</table>
</body>
</html>