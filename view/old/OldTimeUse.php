<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<h1>Time Use Chart</h1>
<a href="../menu/MenuDev.php">Dev Menu</a>
<link rel="stylesheet" href="../../styles.css" />
<?php
include('../function/Functions.php');
include('../view/LinkTable.php');
include('../function/SqlList.php');

pconn();

formid();

setQTime();

$data = array();
$ndata = array();
$arrQT = array();
$arrsql = array();
$arrResult = array();
$arrResult1 = array();

//Run week picker query
$result = mysqli_query($conn, $sqlWeekPick);
$result1 = mysqli_query($conn, $sqlThisWeek);


while($row = mysqli_fetch_assoc($result1)) {
	$arrResult1[]=$row['QDate'];
}

?>
<form method='get' action='ViewTimeUseChart.php'>

<table>
    <tr>
    	<td><b>Start Date</b></td><td>
		<select name='selSDate' id='selSDate' class='ssmselect'>

			<?php

			//Loop through query results to populate date picker
			while($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
			}
?>
		</select>

	</td><td>
		<b>Interval</b>
	</td><td>
		<select name="selInt" id="selInt" class='single'>
			<option>60</option>
			<option>30</option>
			<option>15</option>
			<option>10</option>
			<option>5</option>
			<option>1</option>
		</select>
	</td><td>
		<b>Days</b>
	</td><td>
		<select name="selNumD" id="selNumD" class='single'>
			<option>1</option>
			<option>5</option>
			<option>7</option>
			<option>14</option>
			<option>30</option>
			<option>60</option>
			<option>90</option>
		</select>
	</td>
</tr><tr>
	<td>
	</td><td>
	<input type="submit" />
	</td><td>
		<b>Start Hr</b>
	</td><td>
		<select name="selSHr" id="selSHr" class='single'>
			<option value=0>12 AM</option>
			<option value=1>1 AM</option>
			<option value=2>2 AM</option>
			<option value=3>3 AM</option>
			<option value=4>4 AM</option>
			<option value=5>5 AM</option>
			<option value=6>6 AM</option>
			<option value=7>7 AM</option>
			<option value=8>8 AM</option>
			<option value=9>9 AM</option>
			<option value=10>10 AM</option>
			<option value=11>11 AM</option>
			<option value=12>12 PM</option>
			<option value=13>1 PM</option>
			<option value=14>2 PM</option>
			<option value=15>3 PM</option>
			<option value=16>4 PM</option>
			<option value=17>5 PM</option>
			<option value=18>6 PM</option>
			<option value=19>7 PM</option>
			<option value=20>8 PM</option>
			<option value=21>9 PM</option>
			<option value=22>10 PM</option>
			<option value=23>11 PM</option>
			<option value=24>12 AM</option>
		</select>
	</td><td>
		<b>End Hr</b>
	</td><td>
		<select name="selEHr" id="selEHr" class='single'>
			<option value=0>12 AM</option>
			<option value=1>1 AM</option>
			<option value=2>2 AM</option>
			<option value=3>3 AM</option>
			<option value=4>4 AM</option>
			<option value=5>5 AM</option>
			<option value=6>6 AM</option>
			<option value=7>7 AM</option>
			<option value=8>8 AM</option>
			<option value=9>9 AM</option>
			<option value=10>10 AM</option>
			<option value=11>11 AM</option>
			<option value=12>12 PM</option>
			<option value=13>1 PM</option>
			<option value=14>2 PM</option>
			<option value=15>3 PM</option>
			<option value=16>4 PM</option>
			<option value=17>5 PM</option>
			<option value=18>6 PM</option>
			<option value=19>7 PM</option>
			<option value=20>8 PM</option>
			<option value=21>9 PM</option>
			<option value=22>10 PM</option>
			<option value=23>11 PM</option>
			<option value=24>END</option>
		</select>
	</td>
</tr>
</table>

<?php
//Free $result variable
mysqli_free_result($result);

//Get and format previously selected Start Date

$selInt = $_GET["selInt"];

$selNumD = $_GET["selNumD"];

$selSHr = $_GET["selSHr"];

$selEHr = $_GET["selEHr"];

$SDate1 = $_GET["selSDate"];

$SDate = date_create($SDate1);

$SDY = date_format($SDate,"Y");
$SDM = date_format($SDate,"m");
$SDD = date_format($SDate,"d");

//Set picker to default values if blank
if ($SDate1 == NULL) {

    $SDate1 = $arrResult1[0];
    $SDate2 = date_create($SDate1);
    
    $SDY = date_format($SDate2,"Y");
    $SDM = date_format($SDate2,"m");
    $SDD = date_format($SDate2,"d");
    
    $selInt = 15;
    $selNumD = 7;
    $selSHr = 0;
    $selEHr = 24;
}
?>

<script>
var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;

var val2 = "<?php echo $selInt ?>";
document.getElementById("selInt").value=val2;

var val3 = "<?php echo $selNumD ?>";
document.getElementById("selNumD").value=val3;

var val4 = "<?php echo $selSHr ?>";
document.getElementById("selSHr").value=val4;

var val5 = "<?php echo $selEHr ?>";
document.getElementById("selEHr").value=val5;
</script>

<!--END GET DATES-->

</form>
<table width=100% class='tutable' cellspacing="0" cellpadding="0">
<?php
if($selNumD == 5){

echo "<th>Time</th>";
echo "<th>Mon</th>";
echo "<th>Tue</th>";
echo "<th>Wed</th>";
echo "<th>Thu</th>";
echo "<th>Fri</th>";

}

if($selNumD == 7){
echo "<th>Time</th>";
echo "<th>Mon</th>";
echo "<th>Tue</th>";
echo "<th>Wed</th>";
echo "<th>Thu</th>";
echo "<th>Fri</th>";
echo "<th>Sat</th>";
echo "<th>Sun</th>";
}

$a = $selInt;
$sM = $SDM;
$sD = $SDD;
$sY = $SDY;
$Dcnt = $selNumD;
$rcnt = 0;

for($x = $selSHr; $x < $selEHr; $x++) {

	for($y = 0; $y  < 60 ; $y+=$a) {
	
		$z = (($x*60)+$y)/$a;

		for($b = 0; $b  < $Dcnt ; $b++) {
			
			$test = date("Y-m-d H:i", mktime($x, $y, 0, $sM, $sD+$b, $sY));
			
			$ind = date("h:i A", mktime($x, $y, 0, $sM, $sD+$b, $sY));
			
			$arrQT[$b] = $test;
			
			if($test<$NowTime){
			
			$arrsql[$b] = 
				"SELECT tblEvents.STime, tblAct.UCode, tblPUCodes.Color
				FROM tblEvents
				INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID 
				INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode 
				WHERE tblEvents.STime < '$arrQT[$b]'
				ORDER BY STime DESC
				LIMIT 1";
				
			$arrResult[$b] = mysqli_query($conn, $arrsql[$b]);
	
			while ($row = mysqli_fetch_array($arrResult[$b])) {
	$ndata[$b][0][] = $row['STime'];
	$ndata[$b][1][] = $row['UCode'];
	$ndata[$b][2][] = $row['Color'];
	
				}
			}
		}
		
echo "<tr>";
	
$data[1][]  = $ind;

if($Dcnt < 13) {
	echo "<td><font size=2pts><b>";
	echo $data[1][$z];
	echo "</font></td>";
}

	for($c = 0; $c  < $Dcnt ; $c++) {
		
		echo "<td width='10pts' bgcolor=";
		echo $ndata[$c][2][$rcnt];
		echo ">";
		//echo "<font size=2pts>";
		//echo "</font>";
		echo "</td>";
	}
	
	echo "</tr>";
	$rcnt = $rcnt+1;
}
}
mysqli_close($conn);
?>
</table>