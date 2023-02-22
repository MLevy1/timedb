<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$sql = "SELECT tblConvos.ConvoTime, tblCTTopic.CTTopic, tblCont.ContDesc
		FROM tblConvos
		INNER JOIN tblCTTopic
		ON (tblConvos.CTTopic=tblCTTopic.CTTOP)
		INNER JOIN tblCont
		ON (tblConvos.ContID=tblCont.ContID)
		WHERE date(tblConvos.ConvoTime) ='$QTime'
		ORDER BY tblConvos.ConvoTime DESC";

$result = mysqli_query($conn, $sql);

$data1 = array();
$data2 = array();
$data3 = array();
$data4 = array();

while ($row = mysqli_fetch_array($result)) {
	$data1[] = $row['ConvoTime'];
	$data2[] = date_create($row['ConvoTime']);
	$data3[] = $row['CTTopic'];
	$data4[] = $row['ContDesc'];
}

$cnt=count ($data1);
?>

<table width='100%'>
	<th><b>Convo Time</th>
	<th><b>Convo Topic</th>
	<th><b>Cont. ID</th>
	
<?php
$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
$tbl="tblConvos";
$varSel="ConvoTime";

for($x = 0; $x < ($cnt); $x++) {
	echo "
	<tr><td width = 15%>".
	date_format($data2[$x],"h:i A").
	"</td><td width = 55%>".
	$data3[$x].
	"</td><td width = 25%>".
	$data4[$x] .
	"</td><td width=5%>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../del/DelEvent.php?form=$form&tbl=$tbl&varSel=$varSel&selEvent=$data1[$x]'\" value=\"D\"</input>").
	"</td></tr>";
}

mysqli_close($conn);
?>
</table>