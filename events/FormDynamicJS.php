<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

date_default_timezone_set('America/New_York');
?>
<html>
<head>
  <title>JS Dynamic</title>
  <link href="../css/MobileStyle.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../function/JSFunctions1.js"></script>
<script>
function showAlert(a) { 
	var act = data[0][a];
	var cont = data[1][a];
    	alert( act+cont );
}

function btnJQ1(a, b, c, d)
{	
	var act = data[0][a];
	var cont = data[1][a];
	var id = a;
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: cont,
		selTbl: 'tblEvents'
	});
	
	$("button").css("background-color", "lightgray");
	
	$("#"+id).css("background-color", "pink");
	
	setTimeout(function(){
	LoadDiv("buttons", "../events/btnJSDyn.php");
	
        LoadDiv("vtest", "../view/FooterEventQueries.php");
        }, 500);
       	 
 }

</script>
</head>
<body>
<h1>JS Dynamic</h1>
<div id="ltbl">
<?php linktable(); ?>
</div>
<div id ="buttons">
</div>
<a href="javascript:UpdateEvents();">Update</a>
<div id="vtest">
</div>
</body>
</html>
<script>
LoadDiv("buttons", "../events/btnJSDyn.php");

LoadDiv("vtest", "../view/FooterEventQueries.php");
</script>
