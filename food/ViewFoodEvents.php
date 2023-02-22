<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

formid();

$tbl="tblFoodEvents";
$varSel="TimeStamp";


//sets the interval
$I = $_REQUEST["I"];


if($I==null){
	
	$I="A";

}

$SQTime = date_create(date('Y-m-d'));

if($I != "A"){

	$dm = '-'.$I.' days';

	date_modify($SQTime, $dm);

	$SQTime = date_format($SQTime,'Y-m-d');
	
		$sql = "SELECT tblFoodEvents.TimeStamp,  tblFoodEvents.MTime, tblFoods.Food, tblFoodEvents.Type, tblFoodEvents.FoodID FROM tblFoodEvents INNER JOIN tblFoods ON (tblFoodEvents.FoodID=tblFoods.FoodID) WHERE date(MTime) >='$SQTime' ORDER BY MTime DESC";
	
}else{

	$sql = "SELECT tblFoodEvents.TimeStamp,  tblFoodEvents.MTime, tblFoods.Food, tblFoodEvents.Type, tblFoodEvents.FoodID FROM tblFoodEvents INNER JOIN tblFoods ON (tblFoodEvents.FoodID=tblFoods.FoodID) ORDER BY MTime DESC";

}

$result = mysqli_query($conn, $sql);

$data = array();
$Reporting = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['TimeStamp'];
	$data[1][] = $row['MTime'];
	$data[2][] = date_create($row['MTime']);
	$data[3][] = $row['Food'];
	$data[4][] = $row['Type'];
	$data[5][] = $row['FoodID'];
}

mysqli_close($conn);

$cnt=count($data[0]);

?>

<table width='100%'>
	<th><b>Time</th>
	<th><b>Food</th>
	<th><b>Type</th>
	<th><b>Elapsed</th>
<?php
for($x = 0; $x < $cnt; $x++) {
	echo "<tr>";
	
	echo "<td class='mtblcell3'>";
	
	echo date_format($data[2][$x], 'Y-D m-d h:i A');
	
	echo "</td><td class='mtblcell3'>";
	
	echo $data[3][$x];

	echo "</td><td class='mtblcell3'>";
	
	echo $data[4][$x];
	
	echo "</td><td class='mtblcell3'>";
	
	if($x===0){
		
		$fh = date('U')/(60*60) -date_format($data[2][$x], 'U')/(60*60);
		
	}else{
	
	$fh = date_format($data[2][$x-1], 'U')/(60*60) - date_format($data[2][$x], 'U')/(60*60);
	
	}
	
	$h = floor($fh);
	
	$m = round(60*($fh - $h),0);
	
	if($m>=10){
		echo $h.":".$m;
	}else{
		echo $h.":"."0".$m;
	}

	echo "</td><td width='5%'>";

echo ("<input type=\"button\" class=\"link\" onclick=\"btnEdit1('{$data[0][$x]}', '$varSel', '$tbl', '{$data[3][$x]}')\" value=\"E\"</input>");

	echo "</td><td width='5%'>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"JDel('{$data[0][$x]}', '$varSel', '$tbl', 'vtest', '../food/ViewFoodEvents.php')\" value=\"D\"</input>");
	
	
	echo "</td></tr>";

}

?>
</table>
