<?php
include('../function/Functions.php');
include('../view/ViewActDurP.php');
pconn();

$I = $_REQUEST["I"] ?? 'n';

if($I == 'y'){

$sql = "SELECT * FROM tblAct WHERE Status='Inactive' ORDER BY ActID";

}else{

$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActID";

}

$arrWklyHrs = array();
$arrWklyMins = array();

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
	$arrWklyHrs[] = $row['WklyHrs'];
	$arrWklyMins[] = $row['WklyMins'];
}

$MinSum=array_sum($arrWklyMins);
$HrSum=array_sum($arrWklyHrs);

$sum1=$MinSum+(60*$HrSum);
$sum2=$sum1/60;
$sum3=floor($sum2);
$sum4=$sum2-$sum3;
$sum5=floor($sum4*60);
$dif1=(10080-$sum1);
$dif2=$dif1/60;
$dif3=floor($dif2);
$dif4=$dif2-$dif3;
$dif5=floor($dif4*60);
?>
<table width='50%'>
<tr><td class='longcol'>Total Scheduled</td>
<td class='doublecol'><?php echo DZero($sum3).':'.DZero($sum5); ?></td></tr>
<tr><td class='longcol'>Total Remaining</td>
<td class='doublecol'>
<?php 
echo DZero($dif3).':'.DZero($dif5); 
?>
</td></tr>
</table>
<hr/>

<table width="100%">
	<th>Act ID</th>
	<th>Act Desc</th>
	<th>U</th>
	<th>P</th>
	<th>W Hr</th>
	<th>Last</th>
<?php
$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['ActID'];
	$data[1][] = $row['ActDesc'];
	$data[2][] = $row['PCode'];
	$data[3][] = $row['UCode'];
	$data[4][] = $row['WklyHrs'];
	$data[5][] = $row['WklyMins'];
}

$cnt=count ($data[0]);

for($x = 0; $x < $cnt; $x++) {
	echo "<tr><td width='15%' align='center'>".
	$data[0][$x].
	"</td><td width='50%'>".
	$data[1][$x].
	"</td><td width='5%' align='center'>".
	$data[2][$x].
	"</td><td width='10%' align='center'>".
	$data[3][$x].
	"</td><td width='10%' align='center'>".
	$data[4][$x].
	 ":".
	DZero($data[5][$x]).
	"</td><td width='10%' align='center'>".
	etimea($data[0][$x]).
	//ActDur($data[1][$x], 'y').
	"</td><td width='10%'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='FormUpdateAct1.php?selAct={$data[0][$x]}'\" value=\"U\"</input>")."</td></tr>";
} 

mysqli_close($conn);
?>
</table>
<input type="button" class = "link" onclick="displayLActs()" value="Ref" />
<div id='demo'></div>
<div id='olist'></div>
<script>
localStorage.removeItem("LSActs");

LActs = [];

var data = <?php echo json_encode( $data ) ?>;

var cnt = <?php echo json_encode( $cnt ) ?>;

localStorage.setItem("LSActs", JSON.stringify(data));

var LActs = JSON.parse(localStorage.getItem("LSActs"));

var text, i;

/*
for (i = 0; i < localStorage.length; i++)   {
    $("#olist").text(localStorage.key(i) + "=[" + localStorage.getItem(localStorage.key(i)) + "]");
}
*/

function displayLActs()
{
		
	text = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		text += "<tr><td>" + "</td><td>" + LActs[0][i] + "</td><td>" + LActs[1][i] +"</td><td>" + LActs[3][i] + "</td><td>" + LActs[4][i] +"</td></tr>";
	
	}
	
	text += "</table>";
	
	
document.getElementById("demo").innerHTML = text;
}
</script>