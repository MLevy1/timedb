<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="../function/JSFunctions1.js"></script>

<link rel="stylesheet" href="../css/MobileStyle.css" />
<?php

include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$SDate = date_create('2018-12-02');
$SDate = date_format($SDate,"Y-m-d");

$sql = "SELECT *
FROM tblCont 
INNER JOIN tblProj
ON (tblCont.ProjID=tblProj.ProjID)
WHERE tblCont.Active!='N'
AND tblProj.ProjID='CFA'";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['ContID'];
	$data[1][] = $row['ContDesc'];
	$data[2][] = $row['ProjID'];
}

$cnt=count ($data[0]);

?>
<table>
	<th>Section</th>
	<th>Study</th>
	<th> Flashcards </th>
	<th> Lecture </th>
<?php

for($x = 2; $x < $cnt; $x++) {

	$cont = $data[0][$x];
	$cd = substr($data[1][$x],9);

	echo "<tr>";
	echo "<td><b>";
	echo substr($data[1][$x],9);
	echo "</td><td>";
	$btn = 'Study '.$cd;
	eventbtnjq('T03', $cont, $btn, 'y');
	echo "</td><td>";
	$btn = 'Flashcards '.$cd;
	eventbtnjq('L18', $cont, $btn, 'y');
	echo "</td><td>";
	$btn = 'Lecture '.$cd;
	eventbtnjq('L17', $cont, $btn, 'y');
	echo "</td></tr>";
}

echo "</table>";

 mysqli_close($conn);
?>
