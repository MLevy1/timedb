<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");
?>
<html>
<head>
	<title>Convo Entry</title>
	<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<h1>Convo Entry</h1>
<?php include("../view/LinkTable.php"); ?>
<form action="AddConvoRec.php" method="get">

<?php
pconn();

formid();

$selCont1 = $_GET ["selCont"];
$btnSet = $_GET ["selbtnSet"];

?>
<table width=100%>
	<tr><td align='center' width=25%><b>
	<?php echo $selCont1; ?>
	</td><td width=25%>
	
	<input type='button' id='btnreload' class='link' onclick='location.href="FormCTSocial.php";' value='Back' />
	
	</td><td width=25%>

	<?php 
	
	$location = $form.'?selCont='.$selCont1.'&selbtnSet=All';
	
	echo "<input type='button' id='btnreload' class='link' onclick='location.href=\"$location \";' value='All' />";
	
	?>

	</td><td width=25%>
	
	<?php
	
	$location = $form.'?selCont='.$selCont1.'&selbtnSet=Prior';
	
	echo "<input type='button' id='btnreload1' class='link' onclick='location.href=\"$location \";' value='Prior' />";
	
	?>

	</td></tr>
</table>

<table width=100%>

<?php 

if($btnSet==="All"){
include ("CTAllbtnSet.php");
}
else{
include ("CTbtnCntSet.php");
}

?>

</table>

<input type="hidden" name="selCont" value="<?php echo $selCont1; ?>">
<input type="hidden" name="form" value="<?php echo $form; ?>">
</form>
<?php include("ViewConvoRecs.php"); ?>
</body>
</html>