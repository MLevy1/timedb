<?php
include("../function/Functions.php");

if(isset($_POST['IDesc'])){
	$IDesc = htmlentities($_POST['IDesc']);
	$IStatus = "Open";
	
	date_default_timezone_set('America/New_York');
	$STime = date("Y-m-d H:i:s");
	
	pconn();
	
	$IDesc = mysqli_real_escape_string($conn, $IDesc);

	$sql = "INSERT INTO tblIssues (dateOpen, IssueDesc, IssueStatus)
	VALUES ('$STime', '$IDesc', '$IStatus')";

	if (mysqli_query($conn, $sql) === TRUE) {
		mysqli_close($conn);

		Header("Location: ../issues/FormIssues.php");
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		mysqli_close($conn);
	}
}
?>
