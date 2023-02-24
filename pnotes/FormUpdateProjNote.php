<?php 
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

pconn();
?>
<html>
<head>
<title>Update Project Note</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>

<h1>Update Project Note</h1>

<?php
include("../view/LinkTable.php");

pconn();

$selNote = $_REQUEST["selNote"];

date_default_timezone_set('America/New_York');

$CTime = date("Y-m-d H:i:s");

$sql = "SELECT * FROM tblProjNotes WHERE NoteID='$selNote'";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)) {

	$NoteID = $row['NoteID'];

	$NoteTime = $row['NoteTime'];

	$ContID = $row['ContID'];

	$Note = $row['Note'];
	
	$Note = mysqli_real_escape_string($conn, $Note);

	$Open = $row['Open'];

}

?>

<form method='post' action='../pnotes/UpdateProjNote.php'>
<table>
<tr><td>
Note ID:
</td><td>
<input name="inpNoteID" value='<?php echo $NoteID; ?>' ></input>
</td></tr><tr><td>
Note Time:
</td><td>
<input name="inpNoteTime" value='<?php echo $NoteTime; ?>' ></input>
</td></tr><tr><td>
Status Date:
</td><td>
<input name="inpStatusDate" value='<?php echo $CTime; ?>' ></input>
</td></tr><tr><td>
Sub Project:
</td><td>
<select id='inpContID' name='inpContID'>
<?php
$sql = "SELECT tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjDesc, tblProj.ProjStatus
        FROM tblCont
        INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID
        WHERE tblProj.ProjStatus!='Closed'
        AND tblCont.Active!='N'
        ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" .$row['ContDesc']." - ".$row['ProjDesc'] . "</option>";
}

mysqli_close($conn);
?>

</select>

</td></tr><tr><td>
Note:
</td><td>
<textarea cols=40 rows=5 name="inpNote"><?php echo $Note; ?></textarea>
</td></tr><tr><td>
Open:
</td><td>
	<select name='inpOpen'>
		<option value='Y'>Y</option>
		<option value='N'>N</option>
	</select>
</td></tr>
<tr><td>
<input type="button" class="link" onclick="location.href='../pnotes/FormProjNotes.php';" value="Back" />
</td><td>
<input type="submit">
</td></tr>
</form>
</table>
<script>
var val = "<?php echo $ContID ?>";
document.getElementById("inpContID").value=val;
</script>


</html>
