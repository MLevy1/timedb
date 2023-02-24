<html>
<body>
<?php header("Cache-Control: no-cache, must-revalidate");?>
<h1>Time Use</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<link rel="stylesheet" href="../../styles.css" />

<!-- For Date Picker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
include('../function/Functions.php');
linktable();

pconn();

?>
<!--Date selectors -->

<table>

    <tr>
    
    	<td align='center'><b>Start</td>
   	<td align='center'><b>End</td>
	<td align='center'><b>Days<td>    
	<td></td>
    </tr><tr>
 
    <td><p><input type="text" id='selSDate' class='ssmselect' name='selSDate'></p></td>

    <td><p><input type="text" id='selEDate' class='ssmselect' name='selEDate'></p></td>

    <td>
    	<select id='selDT' name='selDT' class='single'>
    		<option>ALL</option>
    		<option>WD</option>
    		<option>WE</option>
    	</select>
    </td>
    <td> <input type="button" onclick="ViewChart()" value="Run"/> </td>
	
</tr>

</table>
<div id="tbl"></div>
</body>
</html>

<script>
$( function() {
	$( "#selSDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
	$( "#selEDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
 } );
 
 
 function ViewChart()
{
	var SD = $( "#selSDate" ) . val();
	
	var ED = $( "#selEDate" ) . val();
	
	var DT = $( "#selDT" ) . val();
	
	var F = "../time/ViewTimeUse.php?selSDate=" + SD + "&selEDate=" + ED + "&selDT=" + DT;
	
	$("#tbl").load(F);

}

var D = new Date();

var DY = D.getFullYear();
var DM = D.getMonth();
var DD = D.getDate();

var D1 = DY+"-"+(DM+1)+"-"+DD;

$( "#selEDate" ) . val(D1);

var U = D.getTime();

var WMS = (1000*60*60*24*7);

var U2 = U-WMS;

var D = new Date(U2);

var DY = D.getFullYear();
var DM = D.getMonth();
var DD = D.getDate();

var D2 = DY+"-"+(DM+1)+"-"+DD;

$( "#selSDate" ) . val(D2);

var F = "../time/ViewTimeUse.php?selSDate=" + D2 + "&selEDate=" + D1 + "&selDT=ALL";

$("#tbl").load(F);
 </script>