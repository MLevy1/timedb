<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

$sql = "SELECT * FROM tblPUCodes ORDER BY PUCode";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['PUCode'];
	$data[1][] = $row['PUCodeDesc'];
	$data[2][] = $row['Color'];
}
mysqli_close($conn);

$cnt=((count ($data, COUNT_RECURSIVE))/count($data))-1;

?>
<table width="100%">
	<th>PU Code</th>
	<th>Desc</th>
	<th>Color</th>
<?php 
for($x = 0; $x < ($cnt); $x++) {
	echo "<tr>";
	echo "<td>".$data[0][$x]."</td>";
	echo "<td>".$data[1][$x]."</td>";
	echo "<td>".$data[2][$x]."</td>";
	echo "<td width =5% bgcolor=".$data[2][$x]."></td>";
	echo "<td width='10%'>".("<input type=\"button\" class=\"link\" onclick=\"location.href='FormUpdatePUCode.php?selPUCode={$data[0][$x]}'\" value=\"U\"</input>")."</td>";
	echo "</tr>";
}
?>
</table>

<input type="button" class = "link" onclick="displayLPU()" value="Ref" />
<div id='demo'></div>
<script>

var data = <?php echo json_encode( $data ) ?>;

var cnt = <?php echo json_encode( $cnt ) ?>;

localStorage.setItem("LSPU", JSON.stringify(data));

var LPU = JSON.parse(localStorage.getItem("LSPU"));

var text, i;

function displayLPU()
{
		
	text = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		text += "<tr><td>" + "</td><td>" + LPU[0][i] + "</td><td>" + LPU[1][i] +"</td><td>" + LPU[2][i] +"</td></tr>";
	
	}
	
	text += "</table>";
	
	
document.getElementById("demo").innerHTML = text;
}
</script>
