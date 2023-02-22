<?php
include("../function/Functions.php");

if(isset($_POST['txtNote'])){
	$Note = $_POST['txtNote'];

	$Cont = $_POST['selCont'];
	
	$Open = "Y";
	
	$NextPage = "../pnotes/FormProjNotes.php?selCont=".$Cont;
	
	//date_default_timezone_set('America/New_York');
	//$STime = date("Y-m-d H:i:s");
	
	pconn();
	
	$Note = mysqli_real_escape_string($conn, $Note);

	$sql = "INSERT INTO tblProjNotes (ContID, Note, Open)
	VALUES ('$Cont', '$Note', '$Open')";

	if (mysqli_query($conn, $sql) === TRUE) {
		mysqli_close($conn);

		Header("Location: ".$NextPage);
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		mysqli_close($conn);
	}
}
?>
