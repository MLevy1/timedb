<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');
?>

<script src='../function/JSFunctions1.js'></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php
pconn();

formid();

$tbl="tblEvents";
$varSel="StartTime";

setQTime();

$QT1 = date( "Y-m-d H", strtotime( "$QTime - 1 day" ) );

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE date(tblEvents.STime) >='$QT1' ORDER BY Stime DESC";

$result = mysqli_query($conn, $sql);

$data = array();
$disp = array();

$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['STime'];
	$data[1][] = date_create($row['STime']);
	$data[2][] = $row['ActDesc'];
	$data[3][] = $row['ContDesc'];
	$data[4][] = $row['StartTime'];
	$data[5][] = $row['ActID'];
	$data[6][] = $row['ProID'];
}

mysqli_close($conn);

$cnt= count ($data[2]);

for($x = 0; $x < $cnt; $x++) {

	//TMV
	
		$disp[0][] = substr(date_format(($data[1][$x]), 'c'), 0, 19);
	
	//Act ID
	$disp[1][] = $data[5][$x];
	
	//Cont ID
	$disp[2][] = $data[6][$x];
	
	//Act. Desc.
	$disp[3][] = $data[2][$x];
	
	//Y
	$disp[4][] = "Y";
	
	//Tmt
	$disp[5][] = date_format(($data[1][$x]), 'm-d h:i:s A');
	
	//FT
	$disp[6][] = date_format(($data[1][$x]), 'U')*1000;
	
}

$cols= count ($data);

echo $cols;

if ($form=='../view/FooterEventQueries.php'){
$form='../form/FormDynamicJQ.php';
}
?>
<table width='100%'>
	<th><b>TMV</th>
	<th><b>Act</th>
	<th><b>Cont</th>
	<th><b>Act. Desc.</th>
	<th><b>Y</th>
	<th><b>Tmt</th>
	<th><b>FT</th>
<?php
for($x = 0; $x < ($cnt); $x++) {
	echo "<tr>";
	
		for($y = 0; $y < $cols; $y++) {
	
			echo "<td>";
			
			echo $disp[$y][$x];
			
			echo "</td>";
	
		}
	
	echo "</tr>";
}
?>
</table>
<input type="button" class = "link" onclick="displayLEList()" value="Ref" />
<div id="demo"></div>
<script>
localStorage.removeItem("LSEList");

LEList = [];

var data = <?php echo json_encode( $disp ) ?>;

var cnt = <?php echo json_encode( $cnt ) ?>;

var cols = <?php echo json_encode( $cols ) ?>;

localStorage.setItem("LSEList", JSON.stringify(data));

var LEList = JSON.parse(localStorage.getItem("LSEList"));

var text, i, b;

function displayLEList()
{
	
	text = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		text += "<tr>";
		
		for (b = 0; b < cols; b++){
		
			text += "<td>" + LEList[b][i] + "</td>";
	
	}
	
		text += "</tr>";
	
	}
	
	
	text += "</table>";
	
document.getElementById("demo").innerHTML = text;

}
</script>