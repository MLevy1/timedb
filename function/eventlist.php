<?php

include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$varC1='tblEvents.STime';
$varC2='tblAct.ActDesc';
$varC3='tblCont.ContDesc';
$varC4='tblEvents';
$varC5='tblCont';
$varC6='tblEvents.ProID';
$varC7='tblCont.ContID';
$varC8='tblAct';
$varC9='tblEvents.ActID';
$varC10='tblAct.ActID';

$sql = "SELECT $varC1, $varC2, $varC3 FROM $varC4 INNER JOIN $varC5 ON ($varC6=$varC7) INNER JOIN $varC8 ON ($varC9=$varC10) ORDER BY $varC1";

$result = mysqli_query($conn, $sql);

$data = array();
$dtime = array();
$data2 = array();
$data3 =array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row['STime'];
	$dtime[] = date_create($row['STime']);
	$data2[] = $row['ActDesc'];
	$data3[] = $row['ContDesc'];
}

$cnt=count ($data);

//echo $cnt;

mysqli_close($conn);
?>
