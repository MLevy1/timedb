<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<html>
<head>
<link href="../css/MobileStyle.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>

</script>
<?php
include("../function/Functions.php");

formid();
date_default_timezone_set('America/New_York');
?>

</head>
<body>
<h1>Dynamic</h1>
<?php 

linktable();

$selHrRange = $_GET["selHrRange"];

if ($selHrRange == NULL) {
$selHrRange = 3;
}
?>
<div id ="buttons">
<?php include ('../btn/btnSetJDyn.php'); ?>
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


function UpdateEvents(a, b)
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
        $('#vtest').prepend('No Add: '+a+' '+b+' '+Date()+'<br>');
    });
}

function UpdateDiv(url, div)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $(div).html( data )
    })
    .fail(function() {
        $(div).prepend('X');
    });
}


function UpdateButtons(a)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#buttons').html( data )
    })
    .fail(function() {
        $('#buttons').prepend('X');
    });
}

function UpdateLinks()
{
    $.ajax({
        url: '../view/LinkTable.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#ltbl').html( data )
    })
    .fail(function() {
        ;
    });
}

function btnJQ(a, b, c, d, e)
{	
	//var page= '../btn/btnSetJDyn.php?selHrRange='.e;
	
	var page1= '../btn/btnSetJDyn.php';
	
	$.post("../add/AddJQ.php",
	{
		v1: a,
		v2: b,
		selTbl: 'tblEvents'
	});
	setTimeout(function(){
        UpdateEvents(a, b);
        }, 500);
        UpdateLinks();
        if(d==='y'){
        	UpdateDiv('../sch/ViewCurSchEvent.php', 'CSE');
        	UpdateButtons('../btn/btnSetJDyn.php?selHrRange='+e);
        }
        if(d==='n'){
        	UpdateButtons('../btn/btnSetJQ.php');
        }
        if(d==='p'){
        	UpdateButtons('../btn/btnJProb.php');
        }
	$("button").css("background-color", "lightgray");
	$("#"+c).css("background-color", "pink");
}


function btnJQDel(a, b, c)
{
	$.post("../del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateGoals();
        }, 100);
}

function UpdatePView(a)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#view').html( data )
    })
    .fail(function() {
        $('#view').prepend('X');
    });
}

</script>
</body>
</html>