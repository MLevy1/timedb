<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

$I = $_REQUEST["I"];

if($I == 'y'){

$sql = "SELECT tblCont.ProjID, tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjStatus FROM tblCont INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID WHERE tblProj.ProjStatus!='Closed' AND tblCont.Active='N' ORDER BY ProjID, ContID";

}else{

$sql = "SELECT tblCont.ProjID, tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjStatus FROM tblCont INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID WHERE tblProj.ProjStatus!='Closed' AND tblCont.Active!='N' ORDER BY ProjID, ContID";

}

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['ContID'];
	$data[1][] = $row['ContDesc'];
	$data[2][] = $row['ProjID'];
}
mysqli_close($conn);

$cnt=count($data[0]);

?>
<table width="100%">
	<th>Cont ID</th>
	<th>Cont Desc</th>
	<th>Proj ID</th>
	<th>Last Used</th>
<?php 
for($x = 0; $x < ($cnt); $x++) {
	echo "<tr>";
	for($y = 0; $y <= 1; $y++) {
		echo "<td width='20%'>".
		$data[$y][$x]."</td>";
	}
	echo "<td width='40%'>".
	$data[2][$x]."</td>";
	
	echo "<td width='10%'>".
	dluc($data[0][$x])."</td>";
	echo "<td width='10%'>".
	etimec($data[0][$x])."</td>";
	echo "<td width='10%'>".("<input type=\"button\" class=\"link\" onclick=\"location.href='FormUpdateCont1.php?selCont={$data[0][$x]}'\" value=\"U\"</input>")."</td>";
	echo "</tr>";
}
?>
</table>
<input type="button" class = "link" onclick="displayLConts()" value="Ref" />
<div id='demo'></div>
<script>

var cont = <?php echo json_encode( $data ) ?>;

var cnt = <?php echo json_encode( $cnt ) ?>;

localStorage.setItem("LSConts", JSON.stringify(cont));

var LConts = JSON.parse(localStorage.getItem("LSConts"));

var text, i;

function displayLConts()
{
		
	text = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		text += "<tr><td>" + "</td><td>" + LConts[0][i] + "</td><td>" + LConts[1][i] +"</td><td>" + LConts[2][i] + "</td></tr>";
	
	}
	
	text += "</table>";
	
	
document.getElementById("demo").innerHTML = text;
}
</script>