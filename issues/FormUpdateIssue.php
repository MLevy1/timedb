<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<html>
<head>
<title>Update Issue</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Update Issue</h1>
<?php
include("../view/LinkTable.php");
include("../function/DBConn.php");
include("../function/Functions.php");

$selIssue = $_REQUEST["selIssue"];

date_default_timezone_set('America/New_York');
$CTime = date("Y-m-d H:i:s");

$sql = "SELECT * FROM tblIssues WHERE IssueID='$selIssue'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
	$dateOpen = $row['dateOpen'];
	$Issueid =$row['Issueid'];
	$IssueDesc =$row['IssueDesc'];
	$IssueStatus =$row['IssueStatus'];
	$IssueUpdate=$row['IssueUpdate'];
}

$conn->close();
?>

<form method='post' action='../issues/UpdateIssue.php'>
<table>
<tr><td>
Issue ID:
</td><td>
<input name="inpIssueid" value='<?php echo $Issueid; ?>' ></input>
</td></tr><tr><td>
Open Date:
</td><td>
<input name="inpDateOpen" value='<?php echo $dateOpen; ?>' ></input>
</td></tr><tr><td>
Satus Date:
</td><td>
<input name="inpStatusDate" value='<?php echo $CTime; ?>' ></input>
</td></tr><tr><td>
Issue Desc:
</td><td>
<textarea cols=40 rows=5 name="inpIssueDesc"><?php echo htmlentities($IssueDesc); ?></textarea>
</td></tr><tr><td>
Issue Status:
</td><td>
	<select name='inpIssueStatus'>
		<option value='Open'>Open</option>
		<option value='Closed'>Closed</option>
	</select>
</td></tr><tr><td>
Issue Update:
</td><td>
<textarea cols=40 rows=5 name="inpIssueUpdate"><?php echo htmlentities($IssueUpdate); ?></textarea>
</td><td>
<input type="submit">
</td></tr>
</form>
</table>
</html>
