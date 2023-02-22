<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

$sel = $_REQUEST['selEvent'];

$selQDate = $_REQUEST["selQDate"];

$form1 =  $_REQUEST["form"];

$tbl = $_REQUEST["tbl"];

$varSel = $_REQUEST["varSel"];

if($selQDate!=Null){

$form = 'Location: '.$form1."?selQDate=".$selQDate;

} else

	{
		$form = 'Location: '.$form1;
}

$sql1 = "DELETE FROM $tbl WHERE $varSel='$sel'";

echo $sql1;

if ((mysqli_query($conn, $sql1)) === TRUE) {
	mysqli_close($conn);
	header ("$form");
 } else {
	echo "Error deleting record: ". $conn->error;
	mysqli_close($conn);
	include("../view/LinkTable.php");
}

?>
