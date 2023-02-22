<?php include("../function/password_protect.php"); ?>
<html>
<head>
    <title>New Convo Topic</title>
<?php include("../function/sqlSelect.php"); ?>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
	<h1>New Convo Topic</h1>
	<a href="../form/FormCT1.php">New Subtopic</a>
	<?php include('../view/LinkTable.php'); ?>
	<form method='post' action='../add/AddConvoTopic.php'>
	<table>
		<tr>
			<td>Level 1</td>
			<td>
<?php addsel('lev1sel', 'Level1', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Level 2</td>
			<td>
<?php addsel('lev2sel', 'Level2', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Level 3</td>
			<td>
<?php addsel('lev3sel', 'Level3', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Topic</td>
			<td>
<?php addsel('topsel', 'Topic', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Time</td>
			<td>
<?php addsel('timesel', 'Time', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Tone</td>
			<td>
<?php addsel('tonesel', 'Tone', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Subtopic</td>
			<td>
<?php addsel('subsel', 'Subtopic', 'tblConvoTopics'); ?>
			</td></tr>
		<tr>
			<td>Details</td>
			<td>
				<textarea rows="8" cols="50" name='txtDetails'></textarea>
			</td></tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" />
			</td></tr>
</table></form>
<?php include("../view/ViewConvoTopics.php"); ?>
</body></html>
