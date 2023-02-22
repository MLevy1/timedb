<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

pconn();

$tbl="tblSchedEvents";
$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']); 
$varSel="SESTime";

date_default_timezone_set('America/New_York');

if($selDate==null){
$selDate = date('Y-m-d');
}

$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$sql = "SELECT tblSchedEvents.SESTime, tblSchedEvents.SEActID, tblSchedEvents.SEContID, tblAct.ActDesc, tblCont.ContDesc FROM tblSchedEvents INNER JOIN tblCont ON (tblSchedEvents.SEContID= tblCont.ContID) INNER JOIN tblAct ON (tblSchedEvents.SEActID = tblAct.ActID) WHERE date(tblSchedEvents.SESTime) ='$selDate' ORDER BY tblSchedEvents.SESTime";

$result = mysqli_query($conn, $sql);

$ndata = array();

while ($row = mysqli_fetch_array($result)) {
	$ndata[0][] = $row['SESTime'];
	$ndata[1][] = date_create($row['SESTime']);
	$ndata[2][] = $row['ActDesc'];
	$ndata[3][] = $row['ContDesc'];
	$ndata[4][] = $row['SEActID'];
	$ndata[5][] = $row['SEContID'];
	
}

$cnt1=count ($ndata[0]);

?>
<script>

function btnJQSchAdd(act, cont)
{	
	
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: cont,
		selTbl: 'tblEvents'
	});
	
}

</script>
<hr />
<table width='100%'>
	<th></th>
	<th><b>Start</th>
	<th><b>Act. Desc.</th>
	<th><b>Cont. ID</th>
<?php
for($x = 0; $x < $cnt1; $x++) {

	echo "<tr><td width='5%'>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQSchAdd('{$ndata[4][$x]}', '{$ndata[5][$x]}')\" value=\"A\"</input>");
	
	
	echo "</td><td width='30%'>";
	
	echo date_format($ndata[1][$x],"m-d h:i A");
	
	echo "</td><td width='30%'>";
	
	echo $ndata[2][$x];
	
	echo "</td><td width='30%'>";
	
	echo $ndata[3][$x];
	
	echo "</td><td width='5%'>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"location.href='../sch/FormUpdateSchedEvent.php?selEvent={$ndata[0][$x]}'\" value=\"U\"</input>");
	
	echo "</td><td class='doublecol'>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDelE1('{$ndata[0][$x]}', '$varSel', '$tbl')\" value=\"D\"</input>");
	
	echo "</td></tr>";
}

echo "</table>";
mysqli_close($conn);
?>
