<?php
header("Cache-Control: no-cache, must-revalidate");
?>
<html>
<head>
<link href="../../styles.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../function/JSFunctions.js"></script>
<?php
include("../function/Functions.php");

formid();
date_default_timezone_set('America/New_York');
?>

</head>
<body>
<h1>Prob-Based Dynamic</h1>
<?php include('../view/LinkTable.php');

$selHrRange = $_GET["selHrRange"];

if ($selHrRange == NULL) {
$selHrRange = 3;
}
?>
<div id ="buttons">
<?php include ('../btn/btnJProb.php'); ?>
</div>
<form method='get' action='<?php echo $form; ?>'>
<table>
	<tr><td>
		<select id='selHrRange' name='selHrRange' class='single'>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
			<option>6</option>
			<option>9</option>
			<option>12</option>
		</select>
	</td><td>
		<input type="submit" />
	</td><td>
			<a href="javascript:UpdateEvents();">Update</a>
	</td></tr>
</table>

</form>
<div id="vtest">
<?php include ('../view/FooterEventQueries.php'); ?>
</div>
<script>
var val = "<?php echo $selHrRange ?>";
document.getElementById("selHrRange").value=val;
</script>
</body>
</html>