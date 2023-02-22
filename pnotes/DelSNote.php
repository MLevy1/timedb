<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

$sel = $_REQUEST['selSNote'];
$note = $_REQUEST['selNote'];

$form1 = "../pnotes/FormProjNoteDetails.php?selNote=";

$form = 'Location: '.$form1.$note;

$sql1 = "DELETE FROM tblProjSubNotes WHERE SubNoteID ='$sel'";

echo $sql1;

if ((mysqli_query($conn, $sql1)) === TRUE) {
	mysqli_close($conn);
	echo "selSNote= ".$sel;
	header ("$form");
 } else {
	echo "Error deleting record: ". $conn->error;
	mysqli_close($conn);
	include("../view/LinkTable.php");
}

?>
