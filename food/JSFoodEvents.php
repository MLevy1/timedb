<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");
?>
<html>
<head>
  <title>JS Food Events</title>
  <link href="../../styles.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../function/JSFunctions1.js"></script>
<script>
function btnJQ1(a)
{	
	var foodid = data[0][a];
	var type = $("#rtype:checked").val();
	var id = a;
	$.post("../add/AddJQ.php",
	{
		v2: foodid,
		v3: type,
		selTbl: 'tblFoodEvents'
	});
	
	$("button").css("background-color", "lightgray");
	
	$("#"+id).css("background-color", "pink");
	
	setTimeout(function(){
	LoadDiv("buttons", "../food/btnFoodEvents.php");
	
        LoadDiv("vtest", "../food/ViewFoodEvents.php");
        }, 500);
       	 
 }

</script>
</head>
<body>
<h1> JS Food Events</h1>
<div id="ltbl">
<?php linktable(); ?>
</div>
<div id="radio">
<table width=50%>
	<tr>
	<td><input type="radio" id="rtype" name="rtype" value="C" style="height:35px; width:35px; vertical-align: middle;">C</td>
	<td><input type="radio" id="rtype" name="rtype" value="M" checked="checked" style="height:35px; width:35px; vertical-align: middle;">M</td>
	<td><input type="button" id="btnJQF" onclick="LoadDiv('form', '../food/JQFoodEvents.php?link=1')" value="Manual"</input></td></tr>
	</table>
</div>
<div id ="buttons">
</div>
<div id="vtest">
</div>
</body>
</html>
<script>

LoadDiv("buttons", "../food/btnFoodEvents.php");

LoadDiv("vtest", "../food/ViewFoodEvents.php");
</script>
