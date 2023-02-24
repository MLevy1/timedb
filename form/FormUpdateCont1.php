<?php
header("Cache-Control: no-cache, must-revalidate");

//include ("../function/sqlSelect.php");
?>
<html>
<head>
    <title>Update Control</title>
    <link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Update Control</h1>
<?php
include("../view/LinkTable.php");
include("../function/DBConn.php");

$selCont = $_GET["selCont"];

$sql = "SELECT * FROM tblCont WHERE ContID='$selCont'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $defProjID = $row['ProjID'];
	$defContID = $row['ContID'];
	$defContDesc = $row['ContDesc'];
	$defActive = $row['Active'];
}

$conn->close();

?>
<form method="post" action="../update/UpdateCont.php">
<table>
<tr>
    <td>
        Project ID:
    </td><td>
            <?php addsel3('selProjID', 'ProjID', 'ProjDesc', $defProjID, 'tblProj'); ?>
    </td>
</tr><tr>
    <td>
        ContID:
    </td><td>
               <input name="newContID" value='<?php echo $defContID; ?>' ></input>
    </td>
</tr><tr>
    <td>
        Cont Desc:
    </td><td>
		<input name="newContDesc" value= '<?php echo $defContDesc; ?>' ></input>
    </td>
</tr><tr>
    <td>
    	Active:
    </td><td>
    <select name="newActive" id="newActive">
    <option>Y</option>
    <option>N</option>
    </select>
    </td></tr>
    <tr><td>
    	<input type="button" class="link" onclick="location.href='../form/FormCont.php';" value="Back" />
    	</td><td>
        <input type="submit">
    </td>
</tr>
</form>
</table>
</body>
<script>
var val = "<?php echo $defActive ?>";
document.getElementById("newActive").value=val;
</script>

</html>