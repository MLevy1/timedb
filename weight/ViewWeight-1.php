<?php

header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

pconn();

$sql = "SELECT * FROM tblWeight ORDER BY wDateTime DESC";
			
$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['wDateTime'];
	
	$data[1][] = $row['Weight'];
	
}

mysqli_close($conn);

$cnt=count($data[0]);

?>
<!-- Bootstrap library -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- Export link -->
<div class="col-md-12 head">
    <div class="float-right">
        <a href="Export.php" class="btn btn-success"><i class="dwn"></i> Export</a>
    </div>
</div>

<table>

	<th><b>Time</th>
	<th><b>Weight</th>

<?php
for($x = 0; $x < $cnt; $x++) {

	echo "<tr>";
	echo "<td>";
	
	echo $data[0][$x];
	
	echo "</td><td style='text-align:center'>";
	
	echo $data[1][$x];
	
	echo "</td></tr>";
}
?>
</table>