<html>

<head>
<link href="../../styles.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--
<script src="../function/JSFunctions.js"></script>
-->

<?php
include("../function/Functions.php");
include('../function/SqlList.php');

function meventbtnjq($act, $cont, $btnname, $qry, $tid){
	
	$btnid0 = $act.$cont;
	
	$btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
	
	$a = etime($act, $cont);
	
	echo "<button id='$btnid' onclick=\"btnJQm('$act', '$cont', '$btnid')\">$btnname<br>$a</button>";
}

function mZeroFix($a){

	if (is_null($a)){  
		echo 0;  
	}
	else  
	{
	echo $a;
	}  
}

pconn();

setQTime();

$form="..form/FormMorningJQ.php";

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


function mUpdateEvents()
{
    $.ajax({
        url: '../view/FooterEventQueries.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
    })
    .fail(function() {
        $('#vtest').prepend('Error updating.');
    });
    mUpdateQry();
}

function mUpdateQry()
{
    $.ajax({
        url: '../form/qryMorningForm.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#qry').html( data )
    })
    .fail(function() {
        $('#qry').prepend('Error updating.');
    });
}

function btnJQm(act, cont, btnname)
{	
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: cont,
		selTbl: 'tblEvents'
	});
    $("button").css("background-color", "lightgray");
	$("#"+btnname).css("background-color", "lightgreen");
	setTimeout(function(){
        mUpdateEvents();
	}, 500);
	mUpdateQry();
}

</script>
</head>
<body>
<h1>Morning</h1>
<?php linktable(); ?>

<div id ="buttons">

<table width='100%'>
</table>

<table width=100% border='1px solid black'>
<tr>
	<td class='mtblcell'>
		<?php meventbtnjq('B01', 'PERSONAL.2', 'BR');?>
	</td><td class='mtblcell'>
		 <p id='Bathroom'></p>
		 
	</td><td class='mtblcell'>
	
		<?php meventbtnjq('P16', 'Dog', 'Dog'); ?>
	</td><td class='mtblcell'>
		<p id='Dog'></p>
		
</td></tr><tr>
	<td class='mtblcell'>
		<?php meventbtnjq('P29', 'PERSONAL.2', 'Shower'); ?>
	</td><td class='mtblcell'>
		 <p id='Shower'></p>
	</td><td class='mtblcell'>

		<?php meventbtnjq('B02', 'PERSONAL.8', 'Breakfast'); ?>
	</td><td class='mtblcell'>
		<p id='Breakfast'></p>		

</td></tr><tr>
	<td class='mtblcell'>
		<?php meventbtnjq('P09', 'PERSONAL.2', 'Brush Teeth'); ?>
	</td><td class='mtblcell'>
		<p id='Teeth'></p>
	</td><td class='mtblcell'>
		
		<?php meventbtnjq('P30', 'DOG', 'Walk (D)'); ?>	
	</td><td class='mtblcell'>	
		<p id='WDog'></p>		
		
</td></tr><tr>
	<td class='mtblcell'>
		<?php meventbtnjq('P60', 'PERSONAL.2', 'Floss'); ?>		
	</td><td class='mtblcell'>
		<p id='Floss'></p>
	</td><td class='mtblcell'>
		<?php meventbtnjq('P32', 'PERSONAL.2', 'Pack'); ?>
		</td><td class='mtblcell'>
		<p id='Pack'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<?php meventbtnjq('P33', 'PERSONAL.2', 'Shave & Hair'); ?>
	</td><td class='mtblcell'>
		<p id='Shave'></p>
	</td><td class='mtblcell'>
		<?php meventbtnjq('N02', 'TRANS.4', 'Drive (C)'); ?>
		</td><td class='mtblcell'>
		<p id='Drive'></p>
</td></tr><tr>
	<td class='mtblcell'>
		<?php meventbtnjq('P20', 'PERSONAL.2', 'Dress'); ?>		
	</td><td class='mtblcell'>
		<p id='Walk'></p>
	</td> <td class='mtblcell'>
		<?php meventbtnjq('P30', 'TRANS.4', 'Walk (C)'); ?>
	</td><td class='mtblcell'>
		<p id='Total'></p>
	</td></tr> <tr>
	<td class='mtblcell'>			
	</td><td class='mtblcell'>
	</td> <td class='mtblcell'>
		<p><b>Total</p>
	</td><td class='mtblcell'>
		<p id='Total'></p>
	</td></tr>
	
	
</table>
</div>
<div id="qry">
	
	<?php include('../form/qryMorningForm.php'); ?>

</div>

<script>
/*
function mtimer(a, b){

	clearInterval(tvar);

	var count=a;

	var tvar = setInterval(
		function() {
     
    		document.getElementById(b).innerHTML = b+count++;

	}, 1000);

}
*/

//mtimer(arrC.B01, "test");

</script>
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
