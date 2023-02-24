<html>
<head>
<title>Update Subtopic</title>
<link rel="stylesheet" href="../../styles.css" />

</head>
<body>
<h1>Update Subtopic</h1>
<?php
include("../view/LinkTable.php");
include("../function/DBConn.php");
include("../function/Functions.php");

$selTop = $_REQUEST["selTop"];

$sql = "SELECT * FROM tblCTSubtopic WHERE CTST ='$selTop'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$defCTST = $row['CTST'];
	$defCTTopic = $row['CTTopic'];
	$defCTSubtopic  = htmlentities($row['CTSubtopic']);
	$defCTSTDetail  = htmlentities($row['CTSTDetail']);
	$defActive = $row['Active'];
	$defTone = $row['Tone'];
}
$conn->close();
?>
<form method="post" action="UpdateCTSubtopic.php">
<table>
	<tr>
		<td>
CTST:
		</td><td>
<b><?php echo $defCTST; ?>
<input type="hidden" name="selCTST" value='<?php echo $defCTST; ?>' ></input>
		</td>
	</tr><tr>
		<td>
Subtopic:
		</td><td>
<input name="newCTSubtopic" value= "<?php echo $defCTSubtopic; ?>" ></input>
		</td>
	</tr><tr>
		<td>
Level 3:
		</td><td>
<?php
include("../function/DBConn.php");
$sql = "SELECT * FROM tblCTTopic";
$result = $conn->query($sql);
?>
<select id='selCTTopic' class='double' name='selCTTopic'>
<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['CTTOP'] . "'>"  . $row['CTTopic'] . "</option>";
}
$conn->close();
?>
</select>
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
		<tr>
	     <td>Tone</td>
	     <td>
	     <select name="selTone" id="selTone">
	     		<option>Positive</option>
	     		<option>Neutral</option>
	     		<option>Negative</option>
	     </select>
	     </td>
	     </tr>
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

var val1 = "<?php echo $defCTTopic ?>";
document.getElementById("selCTTopic").value=val1;

var val2 = "<?php echo $defTone ?>";
document.getElementById("selTone").value=val2;
</script>

</body>
</html>