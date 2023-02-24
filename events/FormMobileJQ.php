<?php
header("Cache-Control: no-cache, must-revalidate");?>
<html>
<head>
<link href="../../styles.css" rel="stylesheet"/>

<script src="../function/JSFunctions.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php
include("../function/Functions.php");

pconn();

$form="../form/FormMobileJQ.php";

global $form;
?>
<script>
	function UpdateSChart()
{
	var a = '../sch/ViewHTUSch.php';
	
	$.ajax({
	url: a,
	type: 'GET',
	dataType: 'html'
	})
	.done(function( data ) {
	$('#SChart').html( data )
	})
	.fail(function() {
	$('#SChart').prepend('X');
	});
}


function UpdateAChart()
{
	var a = '../view/ViewHTimeUse.php';
	
	$.ajax({
	url: a,
	type: 'GET',
	dataType: 'html'
	})
	.done(function( data ) {
	$('#AChart').html( data )
	})
	.fail(function() {
	$('#AChart').prepend('X');
	});

}

function ShowCharts() {
	UpdateAChart();
	UpdateSChart();
}


</script>
</head>
<body>
<h1>Mobile</h1>
<?php linktable(); ?>

<div id ="buttons">

<?php include('../btn/btnSetJQ.php'); ?>

</div>

</form>
<a href="javascript:UpdateEvents();">Update</a>
<div id="AChart">
</div>
<div id="SChart">
</div>
<div id="vtest">
<?php include("../view/FooterEventQueries.php"); ?>
</div>
</body>
</html>