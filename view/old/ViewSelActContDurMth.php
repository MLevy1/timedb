<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<h1>Monthly Duration</h1>

<!--For Chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<link rel="stylesheet" href="../css/MobileStyle.css" />

<?php
include('../function/Functions.php');
include('../view/LinkTable.php');

pconn();

formid();

setQTime();

//Setup query to populate date picker

$sqsel = "SELECT DISTINCT EXTRACT( YEAR_MONTH FROM STime ) AS QDate, EXTRACT( YEAR FROM STime ) AS QYr, EXTRACT( MONTH FROM STime ) AS QMth FROM tblEvents ORDER BY STime DESC";

//Run date picker query

$result = mysqli_query($conn, $sqsel);

?>
<form method='get' action='<?php echo $form; ?>'>

<table width='100%'>
    
    <tr><td><b>Activity</b></td><td>

<select id='selAct' name='selAct' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['ActID'] . "'>" .$row['ActDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>
</td><td><b>Project</b></td>
	
	<td>
	
<select id='selProj' name='selProj' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblProj ORDER BY ProjDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ProjID'] . "'>" .$row['ProjDesc'] . "</option>";
}
mysqli_free_result($result);
?>

</select>
	
	</td></tr>

</td></tr><tr>
	<td><b>Time Code</b></td>
	<td>
		<select id='timecode' name='timecode' class='smselect'>
			<option selected>H</option>
			<option>M</option>
		</select>
		
</td><td><b>Sub-Project</b></td><td>

<select id='selCont' class='smselect' name='selCont'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE Active!='N' AND ProjStatus != 'Closed' ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ContID'] . "'>" .$row['ProjDesc'] . " - " .$row['ContDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>

</td> </tr>

<tr>
	<td><b>Use Code</td><td>
	
	<select id='selUCode' class='smselect' name='selUCode'>

<option value='All'>All</option>
<option value='AW'>All Work</option>

<?php

$sql = "SELECT * FROM tblPUCodes ORDER BY PUCodeDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['PUCode'] . "'>" .$row['PUCode'] . " - " .$row['PUCodeDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>
	</td><td></td>
	
	<td><input type="submit" /> </td>
	
</tr>

</table>
</form>


<?php

//Get previously selected Activity

$selAct = $_REQUEST["selAct"];
$selProj = $_REQUEST["selProj"];
$selCont = $_REQUEST["selCont"];
$timecode = $_REQUEST["timecode"];
$selUCode = $_REQUEST["selUCode"];

//Set pickers to default values if blank
if ($selAct == NULL) {
$selAct = 'All';
$selProj = 'All';
$selCont = 'All';
$timecode = 'H';
$selUCode = 'All';
}
?>

<script>
var val = "<?php echo $selUCode ?>";
document.getElementById("selUCode").value=val;

var val2 = "<?php echo $selAct ?>";
document.getElementById("selAct").value=val2;

var val3 = "<?php echo $selCont ?>";
document.getElementById("selCont").value=val3;

var val4 = "<?php echo $timecode ?>";
document.getElementById("timecode").value=val4;

var val5 = "<?php echo $selProj ?>";
document.getElementById("selProj").value=val5;
</script>

<?php
//Setup query containing all events between selected start and end date

$sql = "SELECT STime, tblEvents.ActID, ContID, tblProj.ProjID, tblAct.UCode
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
INNER JOIN tblProj 
ON (tblCont.ProjID= tblProj.ProjID) 
ORDER BY tblEvents.STime";

//set result variable to hold contents of sql query

if(isset($_GET['selAct'])){
	//Run above queries
	
	$result = mysqli_query($conn, $sql);

	$data = array();

	//fill STime, Act, and Cont arrays
	while ($row = mysqli_fetch_array($result)) {
		$data[0][] = $row['STime'];
        	$data[1][] = date_create($row['STime']);
        	$data[2][] = $row['ActID'];
        	$data[3][] = $row['ContID'];
        	$data[4][] = $row['ProjID'];
        	$data[6][] = $row['UCode'];
	}
	
	//Free $result variable
    	mysqli_free_result($result);

    	//count rows in results arrays
    	$cnt = count ($data[1]);
	
    	//Set Current Date Variable
    	$NowTime = date("Y-m-d H:i:s");

    	//Add row to end of arrays with current date and time

    	$data[0][] = date_format(date_create($NowTime), 'Y-m-d h:i:s A');

}

//fill Dur, Hrs, and Mins arrays


for($x = 0; $x < $cnt; $x++) {
	$data[5][] = getmins($data[0][$x], $data[0][$x+1]);
}


//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table

    $arrTest = array();

    //Setup clear table query

    $clear = 'TRUNCATE TABLE tblTest4';
    mysqli_query($conn, $clear);


    //Setup insert values query

    $query = "INSERT INTO tblTest4 (`col1`, `col2`, `col3`, `col4`, `col5`, `col6`) VALUES ";

    //Use for loop to itterate through each of the events stored in the Act and Dur arrays


for($x=0; $x<$cnt; $x++){
  
	$arrTest[] = "('" . 
	date_format($data[1][$x],"Ym") . "', '" . 
	$data[2][$x] . "', '" . 
	$data[3][$x] . "', '" . 
	$data[4][$x] . "', '" . 
	$data[5][$x] . "', '" . 
	$data[6][$x] ."')";
}

    //Create query used to populate Test table with contents of Act and Dur arrays

    $sql = $query .= implode(',', $arrTest);

    //Execute the populate table query

    mysqli_query($conn, $sql);

    //Get the previously selected activity

    $selAct1 = $_GET["selAct"];
    $selCont1 = $_GET["selCont"];
    $selProj1 = $_GET["selProj"];
    $selUCode1 = $_GET["selUCode"];

    //Switch to determine which queries to run to fill results arrays below

    if ($selAct == 'All'){
        $a = 'A';
    }
    else
    {
        $a = 'O';
    }

    if ($selCont == 'All') {
        $b = 'A';
    }
    else
    {
        $b = 'O';
    }
    
    if ($selProj == 'All') {
        $c = 'A';
    }
    else
    {
        $c = 'O';
    }

if ($selUCode == 'All') {
	$d = 'A';
    }
    elseif ($selUCode =='AW'){
	$d = 'AW';
    }
    else
    {
        $d = 'O';
    }

    $qry = $a.$b.$c.$d;
    
    //1. all events (AAA), 2. all act, one cont (AOA), 3. all act, all cont, one proj, (AAO), 4. one act, all cont, all proj (OAA), 5. one act, one cont, all proj (OOA), 6. one act, all cont, one proj (OAO)

    switch ($qry) {

    //Query containing all events (#1)

        case "AAAA":
            
		$sumq = "SELECT col1, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ContID (#2)

        case "AOAA":
            
            $sumq = "SELECT col1, col3, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col3 = '$selCont1' GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ContID (#3)

        case "AAOA":
            
            $sumq = "SELECT col1, col4, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col4 = '$selProj1' GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ActID (#4)

        case "OAAA":
            
            $sumq = "SELECT col1, col2, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col2 = '$selAct1' GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ContID and selected ActID (#5)

        case "OOAA":
            
            $sumq = "SELECT col1, col2, col3, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col2 = '$selAct1' AND col3 = '$selCont1' GROUP BY col1 ORDER BY col1";

            break;
            
                //Query containing all events with selected ActID and ProjID (#6)

       case "OAOA":
            
	$sumq = "SELECT col1, col2, col4, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col2 = '$selAct1' AND col4 = '$selProj1' GROUP BY col1 ORDER BY col1";

	break;
            
	case "AAAO":
            
	$sumq = "SELECT col1, col6, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col6 = '$selUCode1' GROUP BY col1 ORDER BY col1";

            break;
            
            case "AAAAW":
            
	$sumq = "SELECT col1, col6, SUM(col5) AS scol, COUNT(col1) AS cnt FROM tblTest4 WHERE col6 = 'W' OR col6 = 'M' OR col6 = 'D' or col6 = 'A' or col6 = 'T' GROUP BY col1 ORDER BY col1";

            break;

    }

    //Execute above query
    $result = mysqli_query($conn, $sumq);

    $data = array();

    //Store query results in col1 and col2 arrays

    while ($row = mysqli_fetch_array($result)) {
        $data[0][] = $row['col1'];
        $data[1][] = $row['scol'];
        $data[2][] = $row['cnt'];
    }

    $cnt = count ($data[0]);
    
    //Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays

    for($x = 0; $x < $cnt; $x++) {
        $data[4][] = gethours($data[1][$x]);
        $data[5][] = getrmins($data[1][$x], $data[4][$x]);
    }

mysqli_query($conn, $clear);

$QTime = date('Y-m-d');

$QYM = date('Ym');

$FMth = "201605";

$QDay = date('d');

$QDate=date_create($QTime);

//NEED TO ADD BACK THE ALLDATES ARRAY STUFF TO FIX THE ZERO PROBLEM

$sqldates = "SELECT DISTINCT EXTRACT( YEAR_MONTH FROM STime ) AS QDate, EXTRACT( YEAR FROM STime ) AS QYr, EXTRACT( MONTH FROM STime ) AS QMth FROM tblEvents ORDER BY STime";

//$sqldates = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE DATE(STime) is not null ORDER BY STime";

    $result = mysqli_query($conn, $sqldates);

    $AllDates = array();
    
    while ($row = mysqli_fetch_array($result)) {
        $AllDates[0][] = $row['QDate'];
        $AllDates[4][] = cal_days_in_month(CAL_GREGORIAN,($row['QMth']),($row['QYr']));
        $AllDates[5][] = $row['QMth'];
    }
    $cnt2 = count ($AllDates[0]);
    $cnt3 = 0;

    for($a = 0; $a < ($cnt2); $a++){
        if(in_array($AllDates[0][$a], $data[0])){
		$AllDates[1][$a] = $data[1][$cnt3];
		$AllDates[2][$a] = $data[2][$cnt3];
		$cnt3++;
        }
        else{
	$AllDates[1][$a] = 0;
	$AllDates[2][$a] = 0;
	}
    }

//END ZERO FIX
?>
<table>
	<th>Month</th>
	<th>Total</th>
	<th>Days</th>
	<th>D.Avg</th>
	<th>Count</th>
	<th>C.Avg</th>
	
<?php
$a = "a";

$Reporting = array();

$arrTDays = array();

$Reporting[0][] = "Month";
$Reporting[1][] = "Time";
$Reporting[2][] = "DAvg";
$Reporting[3][] = "Count";
$Reporting[4][] = "CAvg";
$Reporting[5][] = "Mth";

	
	for($x = 0; $x <= ($cnt2-1); $x++) {
		
		$Reporting[5][]= $x;
		
		if($timecode=="M"){
		
			//col 1: Month
			echo "<tr><td align='center'>".
			$AllDates[0][($x)];
			
			$Reporting[0][]= $AllDates[0][($x)];
			
			//col 2: Time
			echo "</td><td align='center'>".
			$AllDates[1][($x)];
			
			$Reporting[1][]= $AllDates[1][($x)];
			
			//col 3: DAvg
			echo "</td><td align='center'>";
		
		if($AllDates[0][$x]==$QYM){
			echo $QDay;
			
			$arrTDays[] = $QDay;
			
			echo "</td><td align='center'>".
			round(($AllDates[1][$x]/$QDay),2);
			
			$Reporting[2][]= round(($AllDates[1][$x]/$QDay),2);
			
		}
		
		elseif($AllDates[0][$x]==$FMth){
			echo 6;
			
			$arrTDays[] = 6;
			
			echo "</td><td align='center'>";
			
			echo round(($AllDates[1][$x]/60)/6,2);
			
			$Reporting[2][]= round(($AllDates[1][$x]/60)/6,2);
			
		}
		
		else{
			echo $AllDates[4][$x];
			
			$arrTDays[] = $AllDates[4][$x];
			
			echo "</td><td align='center'>".
			round(($AllDates[1][$x]/$AllDates[4][$x]),2);
			
			$Reporting[2][]= round(($AllDates[1][$x]/$AllDates[4][$x]),2);
			
		}
		echo "</td><td align='center'>".
		$AllDates[2][$x];
		
		$Reporting[3][]= $AllDates[2][$x];
		
		echo "</td><td align='center'>".
		round(($AllDates[1][$x]/$AllDates[2][$x]),2);
		
		$Reporting[4][]=round(($AllDates[1][$x]/$AllDates[2][$x]),2);
		
		echo "</td></tr>";
		}
		else{
			echo "<tr><td align='center'>".
			$AllDates[0][($x)];
			
			$Reporting[0][]= $AllDates[0][($x)];
			
			echo "</td><td align='center'>".
			round((($AllDates[1][($x)])/60),1).
			"</td><td align='center'>";
		
			$Reporting[1][]= round((($AllDates[1][($x)])/60),1);
		
		if($AllDates[0][$x]==$QYM){
			echo $QDay;
			
			$arrTDays[] = $QDay;
			
			echo "</td><td align='center'>".
			round(((($AllDates[1][($x)])/60)/$QDay),2);
			
			$Reporting[2][]= round(((($AllDates[1][($x)])/60)/$QDay),2);
			
		}
		elseif($AllDates[0][$x]==$FMth){
			echo 6;
			
			$arrTDays[] = 6;
			
			echo "</td><td align='center'>";
			
			echo round(($AllDates[1][$x]/60)/6,2);
			
			$Reporting[2][]= round(($AllDates[1][$x]/60)/6,2);
			
		}
		else{
			$arrTDays[] = $AllDates[4][$x];
			
			echo $AllDates[4][($x)].
			"</td><td align='center'>".
			round(((($AllDates[1][($x)])/60)/$AllDates[4][($x)]),2);
			
			$Reporting[2][]= round(((($AllDates[1][($x)])/60)/$AllDates[4][($x)]),2);
			
		}
		echo "</td><td align='center'>".
		$AllDates[2][$x];
		
		$Reporting[3][]= $AllDates[2][$x];
		
		echo "</td><td align='center'>".
		round(((($AllDates[1][$x])/60)/$AllDates[2][$x]),2).
		"</td></tr>";
		
		$Reporting[4][]= round(((($AllDates[1][$x])/60)/$AllDates[2][$x]),2);
		}
}

$CTrows = (count($Reporting[0])-1);

mysqli_close($conn);
?>
</table>

<?php
$arrMinDev = array();

$sumMins = array_sum($data[1]);

$TDays = array_sum($arrTDays);

$avgMins = $sumMins/$cnt2;

$DavgMins = $sumMins/$TDays;

for($x = 0; $x < $cnt; $x++) {
	$arrMinDev[] = pow(($data[1][$x]-$avgMins), 2);
}

$varMin = array_sum($arrMinDev) / ($cnt2-1);

$stdev = sqrt($varMin);

?>
<table>
	<tr>
		<td></td>
		<td align='center'>Mins</td>
		<td align='center'>Hours</td>
	</tr><tr>
		<td align='center'>Event Count</td>
		<td align='center'><?php echo $cnt; ?></td>
		<td></td>
	</tr><tr>
		<td align='center'>Total Time</td>
		<td align='center'><?php echo $sumMins; ?></td>
		<td align='center'><?php echo round (($sumMins/60),2); ?></td>
	</tr><tr>
		<td align='center'>Mean</td>
		<td align='center'><?php echo round($avgMins, 2); ?></td>
		<td align='center'><?php echo round(($avgMins/60), 2); ?></td>
	</tr><tr>
		<td align='center'>Grand Mean</td>
		<td align='center'><?php echo round($DavgMins, 2); ?></td>
		<td align='center'><?php echo round(($DavgMins/60), 2); ?></td>
	</tr><tr>
		<td align='center'>Std Dev</td>
		<td align='center'><?php echo round($stdev, 2); ?></td>
		<td align='center'><?php echo round(($stdev/60), 2); ?></td>
	</tr>
</table>
<script>
	var STime = '<?php

	echo "[";
	for( $i=0;$i<$cnt2-1;$i++) {
		echo '"'.$AllDates[0][$i],'", ';

		}
	echo $data[0][$i].'"';
	echo "]";

	?>';
</script>

<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	//echo "'" . $Reporting[0][0]. "', ";
	echo "'" . $Reporting[5][0]. "', ";
	echo "'" . $Reporting[2][0]. "'";
	//echo "'" . $Reporting[4][0] . "'";
	echo '],';
	
for( $i=1;$i<$CTrows;$i++) {
	echo '[';
	//echo "'" . $Reporting[0][$i] . "', ";
	echo $Reporting[5][$i] . ", ";
	echo $Reporting[2][$i];
	//echo $Reporting[4][$i];
	echo '],';
	}
	
echo '[';
//echo "'" . $Reporting[0][$i], "', ";
echo $Reporting[5][$i] . ", ";
echo $Reporting[2][$i];
//echo $Reporting[4][$i];
echo '],';

        ?>	
		]);

		var options = {
			//title: 'Company Performance',
			//curveType: 'function',
			//legend: { position: 'bottom' }
			
			trendlines: { 
				0: {
					type: 'linear',
					showR2: true,
					visibleInLegend: true
					} 
				} 
			
		};

		var chart = new google.visualization.ColumnChart(document.getElementById('line_chart'));

		chart.draw(data, options);
	}
</script>
<div id="line_chart" style="width: 900px; height: 500px"></div>

