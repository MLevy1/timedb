<?php
include("../function/password_protect.php");
include("../function/sqlSelect.php");
?>
<html>
<head>
	<title>Mobile Entry Form - Evening</title>
	<link rel="stylesheet" href="../../styles.css" />
</head>
<h1>Evening</h1>
<?php include("../view/LinkTable.php"); ?>
<form method="get" action="../add/AddMobileEvent.php">
<table width=100%>
	<tr>
		<td><?php eventbtn('B01 PERSONAL.2', 'BR'); ?></td>
		<td><?php eventbtn('P09 PERSONAL.2', 'Brush Teeth'); ?></td>
		<td><?php eventbtn('P20 PERSONAL.2', 'Get Dressed'); ?></td>
		<td><?php eventbtn('P29 PERSONAL.2', 'Shower'); ?></td>
	</tr><tr>
		<td><?php eventbtn('P16 Dog', 'Dog'); ?></td>
		<td><?php eventbtn('N04 NA', 'Bed'); ?></td>
		<td><?php eventbtn('P14 PERSONAL.8', 'Dinner'); ?></td>
		<td><?php eventbtn('P26 PERSONAL.1', 'JO'); ?></td>
	</tr><tr>
		<td><?php eventbtn('P41 PERSONAL.3', 'Trash'); ?></td>
		<td><?php eventbtn('L02 LEARNING.1', 'Brain Training'); ?></td>
		<td><?php eventbtn('P04 PFIN.00', 'Finances'); ?></td>
		<td><?php eventbtn('L14 PROG.3', 'Web Development'); ?></td>
	</tr><tr>
		<td><?php eventbtn('B06 BREAK', 'Coffee / Water / Tea'); ?></td>
		<td><?php eventbtn('4S01 AD', 'Social'); ?></td>
		<td><?php eventbtn('P11 PERSONAL.3', 'Clean House'); ?></td>
		<td><?php eventbtn('P35 PERSONAL.3', 'Dishes'); ?></td>
	</tr><tr>
		<td><?php eventbtn('P34 PERSONAL.3', 'Laundry'); ?></td>
		<td><?php eventbtn('P37 PERSONAL.3', 'Lawn & Garden'); ?></td>
		<td><?php eventbtn('T03 TRAINING.3', 'CIA Exam'); ?></td>
		<td><?php eventbtn('N03 AD', 'TV (AD)'); ?></td>
	</tr>
</table>
<input type="hidden" name="formcode" value="4">
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>
