<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

formid();

$tbl="tblFoods";
$varSel="FoodID";

$sql = "SELECT * FROM tblFoods ORDER BY Food";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['FoodID'];
	$data[1][] = $row['Food'];
	
}

mysqli_close($conn);

$cnt=count($data[0]);

?>

<table width='100%'>
	<th><b>Food</th>
<?php
for($x = 0; $x < $cnt; $x++) {
	echo "<tr>";
	
	echo "</td><td>";
	
	echo $data[1][$x];
	
	echo "</td><td>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnEdit1('{$data[0][$x]}', '$varSel', '$tbl', '{$data[1][$x]}')\" value=\"E\"</input>");
	
	echo "</td><td>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDelE('{$data[0][$x]}', '$varSel', '$tbl')\" value=\"D\"</input>");
	
	echo "</td></tr>";

}

?>
</table>
