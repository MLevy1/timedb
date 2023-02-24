<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

pconn();

$data = array();

$arrPNote = array();

$selNote = $_REQUEST["selNote"];

if($selNote===Null){
    $selNote=1;
}

$sql0 = "SELECT * FROM tblProjNotes WHERE NoteID = '$selNote'";

$result0 = mysqli_query($conn, $sql0);

while($row = mysqli_fetch_assoc($result0)) {
        $arrPNote[]=$row["NoteTime"];
        $arrPNote[]=$row["ContID"];
        $arrPNote[]=$row["Note"];
        $arrPNote[]=$row["NoteID"];
}

?>
<html>
<head>
<title>Project Note Details</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Project Note Details</h1>
<?php include('../view/LinkTable.php'); ?>
<h2>Project Note Info</h2>
<table>
        <th>Time</th>
        <th>Sub-Project</th>
        <th>Note</th>
        <tr><td>
        <?php echo $arrPNote[0]; ?>
        </td><td>
        <?php echo $arrPNote[1]; ?>
        </td><td>
        <?php echo $arrPNote[2]; ?>
        </td></tr>
</table>
<h2>Add New Sub-Note</h2>
<table>
<form method="post" action="../pnotes/AddProjSubNote.php">
<tr><td colspan=2>
	<textarea rows="5" cols="40" id="txtSubNote" name="txtSubNote"></textarea>
    <input type="hidden" name="selNoteID" value='<?php echo $arrPNote[3]; ?>'></input>
</td></tr>
<tr><td>
<input type="button" class="link" onclick="location.href='../pnotes/FormProjNotes.php';" value="Back" />
</td><td>
	<input type="submit" name="submit" />
</td></tr>
</form>
</table>
<hr \>
<h2>Notes List</h2>
<?php include ('../pnotes/ViewProjNoteDetails.php'); ?>
</body></html>

