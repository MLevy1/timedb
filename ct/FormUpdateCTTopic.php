<?php
header("Cache-Control: no-cache, must-revalidate");
?>
<html>
<head>
<title>Update Convo Topic</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />

</head>
<body>
<h1>Update Convo Topic</h1>
<?php
include("../view/LinkTable.php");
include("../function/DBConn.php");

$selTop = $_REQUEST["selTop"];

$sql = "SELECT * FROM tblCTTopic WHERE CTTOP='$selTop'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$defCTTOP = $row['CTTOP'];
	$defCTTopic = htmlentities($row['CTTopic']);
	$defCTL3 = $row['CTL3'];
	$defActive = $row['Active'];
}
$conn->close();

?>
<form method="post" action="UpdateCTTopic.php">
<table>
	<tr>
		<td>
CTTOP:
		</td><td>
<b><?php echo $defCTTOP; ?>
<input type="hidden" name="selCTTOP" value='<?php echo $defCTTOP; ?>' ></input>
		</td>
	</tr><tr>
		<td>
Convo Topic:
		</td><td>
<input name='newCTTopic' value= "<?php echo $defCTTopic; ?>" ></input>
		</td>
	</tr><tr>
		<td>
Active:
		</td><td>
<select id='selActive' class='double' name='selActive'>
<option>Y</option>
<option>N</option>
</select>
		</td>
	</tr><tr>	
		<td>
<input type="submit">
		</td>
	</tr>
</form>
</table>

<script>
var val = "<?php echo $defActive ?>";
document.getElementById("selActive").value=val;

var val1 = "<?php echo $defCTL3 ?>";
document.getElementById("selCTLev3").value=val1;
</script>

</body>
</html>