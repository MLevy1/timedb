<?php
include("../function/Functions.php");

pconn();

$NoteID = $_REQUEST["inpNoteID"];

$NoteTime = $_REQUEST["inpNoteTime"];

$StatusDate = $_REQUEST["inpStatusDate"];

$ContID = $_REQUEST["inpContID"];

$Note = $_REQUEST["inpNote"];

$Open = $_REQUEST["inpOpen"];

$Note = mysqli_real_escape_string($conn, $Note);

$sql = "UPDATE tblProjNotes SET NoteID='$NoteID', NoteTime='$NoteTime', StatusDate='$StatusDate', ContID='$ContID', Note='$Note', Open='$Open' WHERE NoteID='$NoteID'";

//$result = $conn->query($sql);
$result = mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql) === TRUE) {
    	mysqli_close($conn);
		header("Location: ../pnotes/FormProjNotes.php");
} else {
	echo "Error updating record: " . mysqli_error($conn);
	mysqli_close($conn);
	echo "<br>";
	echo "NoteID: " . $NoteID;
	echo "<br>";
	echo "NoteTime: " . $NoteTime;
	echo "<br>";
	echo "StatusDate: " . $StatusDate;
	echo "<br>";
	echo "ContID: " . $ContID;
	echo "<br>";
	echo "Note: " . $Note;
	echo "<br>";
	echo "Open: " . $Open;
	echo "<br>";
	echo "Query: ". $sql;
}

?>