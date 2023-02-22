<?php 
include("../function/password_protect.php"); 
include("../function/sqlSelect.php");
?>
<html>
<head>
	<title>Mobile Entry Form - Driving</title>
	<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Driving</h1>
<?php include("../view/LinkTable.php"); ?>
<form method="get" action="../add/AddMobileEvent.php">
<table width='100%'>
<tr><td>
<?php eventbtn('N02 PERSONAL.5', 'Drive'); ?>
</td><td>
<?php eventbtn('P30 PERSONAL.4', 'Walk'); ?>
</td></tr><tr><td>
<?php eventbtn('P32 PERSONAL.2', 'Pack'); ?>
</td><td>
<?php eventbtn('P40 PERSONAL.2', 'Gas'); ?>
</td></tr><tr><td>
<?php eventbtn('B01 PERSONAL.2', 'BR'); ?>
</td><td>
<?php eventbtn('P16 Dog', 'Dog'); ?>
</td></tr><tr><td>
<?php eventbtn('P36 PERSONAL.7', 'Groceries'); ?>
</td><td>
<?php eventbtn('S09 AD', 'Events'); ?>
</td></tr><tr><td>
<?php eventbtn('S10 AD', 'Shopping (S)'); ?>
</td><td>
<?php eventbtn('P14 PERSONAL.8', 'Dinner'); ?>
</td></tr><tr><td>
<?php eventbtn('P49 PERSONAL.9', 'Air Travel'); ?>
</td><td>
<?php eventbtn('S01 AD', 'Social'); ?>
</td></tr>
<input type="hidden" name="formcode" value="3">
</table>
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>
