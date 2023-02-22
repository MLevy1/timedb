<?php
include("../function/Functions.php");

if(isset($_POST['txtSubNote'])){
	$SubNote =$_POST['txtSubNote'];
			
	$ProjNote = $_POST['selNoteID'];

	date_default_timezone_set('America/New_York');
	
	$STime = date("Y-m-d H:i:s");

	$SubNoteOpen = "Y";
	
	$Next = "../pnotes/FormProjNoteDetails.php?selNote=".$ProjNote;
	
	pconn();
	
	$SubNote = mysqli_real_escape_string($conn, $SubNote);
	
	$sql = "INSERT INTO tblProjSubNotes (ProjNote, SubNoteDate, SubNoteOpen, SubNote)
	VALUES ('$ProjNote', '$STime', '$SubNoteOpen', '$SubNote')";

	if (mysqli_query($conn, $sql) === TRUE) {
		mysqli_close($conn);

		Header("Location: ".$Next);
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		mysqli_close($conn);
	}
	
}

?>
