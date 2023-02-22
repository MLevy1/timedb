<?php
include("../function/password_protect.php");
include("../function/sqlSelect.php");
include("../view/ViewActDurP.php");
include("../function/Functions.php");

formid();
?>
<html>
<head>
	<link rel="stylesheet" href="../css/MobileStyle.css" />
	<title>Mobile Entry Form - Morning</title>
</head>
<body>
<h1>Morning</h1>
<?php include ("../view/LinkTable.php"); ?>
<form method='get' action='../add/AddEvent.php'>
<table width=100% border='1px solid black'>
<tr>
	<td class='mtblcell'>
		<?php eventbtn('B01 PERSONAL.2', 'BR'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Bathroom', 'y');
		 ?>
	</td><td class='mtblcell'>
		<?php eventbtn('P16 Dog', 'Dog'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Dog', 'y');
		?>
</td></tr><tr>
	<td class='mtblcell'>
		<?php eventbtn('P29 PERSONAL.2', 'Shower'); ?>
	</td><td class='mtblcell'>
		<?php
		 echo ActDur('Shower', 'y');
		 ?>
	</td><td class='mtblcell'>
		<?php eventbtn('B02 PERSONAL.8', 'Breakfast'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Breakfast', 'y');
		?>
</td></tr><tr>
	<td class='mtblcell'>
		<?php eventbtn('P09 PERSONAL.2', 'Brush Teeth'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Brush Teeth', 'y');
		?>
	</td><td class='mtblcell'>
		<?php eventbtn('S01 AD', 'Social'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Social', 'y');
		?>
</td></tr><tr>
	<td class='mtblcell'>
		<?php eventbtn('P33 PERSONAL.2', 'Shave & Hair'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Shave & Hair', 'y');
		?>
	</td><td class='mtblcell'>
		<?php eventbtn('P32 PERSONAL.2', 'Pack'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Pack', 'y');
		?>
</td></tr><tr>
	<td class='mtblcell'>
		<?php eventbtn('P20 PERSONAL.2', 'Dress'); ?>
	</td><td class='mtblcell'>
		<?php
		echo ActDur('Dress', 'y');
		?>
	</td><td class='mtblcell'>
		<?php eventbtn('N02 TRANS.1', 'Commute'); ?>
		</td><td class='mtblcell'>
		<?php
		echo ActDur('Drive', 'y');
		?>
</td></tr>
</table>

<input type="hidden" name="form" value="<?php echo $form; ?>">
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>
