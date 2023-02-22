<?php 
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");
formid();
?>
<html>
<head>
<title>Issue Management</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Issue Management</h1>
<?php include('../view/LinkTable.php'); ?>
<h2>Add New Issue</h2>
<table>
<form method="post" action="../issues/AddIssue.php">
<tr><td>
<b>Issue Desc: </b>
</td><td>
	<textarea rows="5" cols="40" id="IDesc" name="IDesc"></textarea>
</td></tr><tr><td></td><td>
	<input type="submit" name="submit" />
</td></tr>
</form>
</table>
<hr \>
<h2>Issue List</h2>
<?php include ('../issues/ViewIssues.php'); ?>
</body></html>

