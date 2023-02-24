<?php include("../function/Functions.php"); ?>
<html>
<head>
<title>Past Event</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Past Event</h1>
<?php 
include("../view/LinkTable.php");
$form = $_GET["form"];
$QDate = date('Y-m-d');
$QTime = date('H:i');
$T1 = $QDate.'T'.$QTime;
?>
<form action="../add/AddEvent.php" method="get">
<table>
<tr><td>
<input name="selDT" id="selDT" type=datetime-local>
</td></tr>
</table>
<hr />
<h2>Mobile</h2>

<?php include ("../view/btnSet.php"); ?>

<hr />

<h2>Dynamic</h2>

<?php include ("../view/btnCntSet.php"); ?>

<hr />

<h2>Manual</h2>

<table>

<tr>
	<td><b>Act</td>
	<td><b>Sub Proj</td>
</tr><tr>
<td>
<?php selActiveAct('selAct'); ?>
</td><td>
<?php selActiveCont('selCont'); ?>
</td></tr><tr><td>
<input type="submit">
</td></tr>
</table>
<?php $form = $_GET["form"];?>
<input type="hidden" name="form" value="<?php echo $form; ?>">
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>
<script>
var val = "<?php echo $T1 ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;
</script>
