<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

$sql = "SELECT ProjID, ContID, ContDesc, Active FROM tblCont WHERE ProjID='$selProj' ORDER BY ContID";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['ProjID'];
	$data[1][] = $row['ContID'];
	$data[2][] = $row['ContDesc'];
	$data[3][] = $row['Active'];
}
mysqli_close($conn);

$cnt=count($data[0]);

?>
<table>
	<th>Cont ID</th>
	<th>Cont Desc</th>
	<th>Active</th>
	<th>Last Used</th>
<?php 
for($x = 0; $x < $cnt; $x++) {
	echo "<tr>";
		echo "<td width='20%'>".$data[1][$x]."</td>";
		echo "<td width='40%'>".$data[2][$x]."</td>";
		echo "<td width='10%'>".$data[3][$x]."</td>";
		echo "<td width='10%'>".etimec($data[1][$x])."</td>";
		echo "<td width='10%'>".("<input type=\"button\" class=\"link\" onclick=\"location.href='FormUpdateCont1.php?selCont={$data[1][$x]}'\" value=\"U\"</input>")."</td>";
	echo "</tr>";
}
?>
</table>