<?php
include("../function/DBConn.php");
include("../function/Functions.php");

$IssueID = $_POST["inpIssueid"];
$OpenDate = $_POST["inpDateOpen"];
$IssueDesc = fixstr($_POST["inpIssueDesc"]);
$IssueStatus = fixstr($_POST["inpIssueStatus"]);
$StatusDate = $_POST["inpStatusDate"];
$IssueUpdate = fixstr($_POST["inpIssueUpdate"]);

$sql = "UPDATE tblIssues SET dateOpen='$OpenDate', IssueDesc='$IssueDesc', IssueStatus='$IssueStatus', IssueStatusDate='$StatusDate', IssueUpdate='$IssueUpdate' WHERE Issueid='$IssueID'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
    	$conn->close();
	header("Location: ../issues/FormIssues.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}

?>