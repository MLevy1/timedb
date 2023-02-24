<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<h1>Sleep</h1>

<link rel="stylesheet" href="../../styles.css" />

<!--For Chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php
include('../function/Functions.php');
linktable();

pconn();

formid();

setQTime();

//Sets End Date to current day
$EDate1 = date('Y-m-d');

//Sets Start Date to 6 months ago
$SDate1  = date('Y-m-d', strtotime('6 months ago'));

//Moves Start Date to most recent Monday (for chart)
$SDate1 = date('Y-m-d', strtotime('last sunday', strtotime($SDate1)));

//Sets SDate & EDate to the variables determined above
$SDate = $SDate1;
$EDate = $EDate1;

//clear dtest array (used in midnight fix and...)
$dtest = array();

//Setup query containing all events between selected start and end date

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActID, tblAct.ActDesc, tblCont.ContID, tblCont.ContDesc, tblProj.ProjID, tblProj.ProjDesc, tblAct.UCode 
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
INNER JOIN tblProj 
ON (tblCont.ProjID= tblProj.ProjID) 
WHERE date(tblEvents.STime) BETWEEN '$SDate' AND '$EDate' ORDER BY tblEvents.STime";

    //Run above query

    $result = mysqli_query($conn, $sql);

    $data = array();

    //fill STime, Act, and Cont arrays
    while ($row = mysqli_fetch_array($result)) {  
        
	 $dtest[$row['STime']][] = $row['ActID'];
 	 $dtest[$row['STime']][] = $row['ContID'];
 	 $dtest[$row['STime']][] = $row['ProjID'];
 	 $dtest[$row['STime']][] = $row['UCode'];
 	 
	}

//sorts based on event time
ksort($dtest);

//dtest array now contains all events and midnight cutoffs in the period

echo "<pre>";
//print_r($dtest);
echo "</pre>";

//creates data array be used for...

$data = array();

//loops through dtest array and fills data array (col0 is the event time)

foreach($dtest as $x => $xval) {
	
	$data[0][]=$x;
	$data[1][]=date_create($x);
	$data[2][]=$xval[0];
	$data[3][]=$xval[1];
	$data[4][]=$xval[2];
	$data[6][]=$xval[3];
	
}

    //Free $result variable
    mysqli_free_result($result);

    //count rows in results arrays
    $cnt = count ($data[1]);

    //Add row to end of arrays with current date and time

    $data[0][] = date_format(date_create($NowTime), 'Y-m-d h:i A');


    //fill Dur array
    for($x = 0; $x < ($cnt-1); $x++) {
        $data[5][] = getmins($data[0][$x], $data[0][$x+1]);
        
        //fill array with the date
        $data[7][]=date_format($data[1][$x],"Y-m-d");
        
        //fill array with the hour of start time
	$data[8][]=intval(date_format($data[1][$x],"G"));
	
	//if start time is less than 6PM, sleep is credited to the current day, if greater, it’s credited to the next day
	if($data[8][$x]<18){
	
		$data[9][]=$data[7][$x];
		
	}else{
		
		$ActDay = $data[7][$x];
		
		$data[9][]=date( "Y-m-d", strtotime ( "$ActDay + 1 day" ) );
		
        }
        
    }

echo "<pre>";
//print_r($data[8]);
//print_r($data[9]);
echo "</pre>";

    //Reset the Test Array, which will be used to setup the query that will insert only sleep events into the Test table

    $arrTest = array();

    //Setup clear table query

    $clear = 'TRUNCATE TABLE tblTest4';
    mysqli_query($conn, $clear);

    //Setup insert values query

    $query = "INSERT INTO tblTest4 (`col1`, `col2`, `col3`, `col4`, `col5`, `col6`) VALUES ";

    //Use for loop to itterate through each of the events stored in the Act and Dur arrays

    for($x=0; $x<($cnt); $x++){
        $arrTest[] =
        "('" .
        $data[9][$x] .
        "', '" .
        $data[2][$x] .
        "', '" .
        $data[3][$x] .
        "', '" .
        $data[4][$x] .
        "', '" .
        $data[5][$x] .
        "', '" .
        $data[6][$x] .
        "')";
     }

//END

    //Create query used to populate Test table with contents of Act and Dur arrays

    $sql = $query .= implode(',', $arrTest);

    //Execute the populate table query

    mysqli_query($conn, $sql);

$sumq = "SELECT col1, col2, SUM(col5) AS scol FROM tblTest4 WHERE col2 = 'N04' GROUP BY col1 ORDER BY col1";

    //Execute above query
    $result = mysqli_query($conn, $sumq);

    $data = array();

    //Store query results in col1 and col2 arrays

    while ($row = mysqli_fetch_array($result)) {
        $data[0][] = $row['col1'];
        $data[1][] = $row['scol'];
    }

    $cnt = count ($data[0]);

    //Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays

    for($x = 0; $x < $cnt; $x++) {
        $data[4][] = gethours($data[1][$x]);
        $data[5][] = getrmins($data[1][$x], $data[4][$x]);
    }

mysqli_query($conn, $clear);

$QTime = date('Y-m-d');

$QDate=date_create($QTime);

$sqldates = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE DATE(STime) is not null AND DATE(STIME) BETWEEN CAST('$SDate1' AS DATE) AND CAST('$EDate1' AS DATE) ORDER BY STime";

    $result = mysqli_query($conn, $sqldates);

    $AllDates = array();
    $AllDates1 = array();
    
    if(strtotime($SDate1) < strtotime('2016-5-30')){
    	$AllDates[0]="2016-05-23";
    	$AllDates[1]="2016-05-24";
    	$AllDates[2]="2016-05-25";
    }

    while ($row = mysqli_fetch_array($result)) {
        $AllDates[] = $row['QDate'];
    }
    
    $cnt2 = count ($AllDates);
    $cnt3 = 0;

    for($a = 0; $a < ($cnt2); $a++){
        if(in_array($AllDates[$a], $data[0])){
		$AllDates1[$a] = $data[1][$cnt3];
		$cnt3++;
        }
        else{
	$AllDates1[$a] = 0;
	}
    }

echo "<pre>";
//print_r($data[1]);
echo "</pre>";

$EDate2 = date_create($EDate2);

$diff=date_diff(date_create($SDate1),$EDate2);

$diff1=$diff->format('%a days');

//$diff1= $diff1-1;

$nweeks = floor($diff1 / 7);

$WD = $EDate2->format('w');
?>

<table>
	<th></th>
	<th>Start</th>
	<th>S</th>
	<th>M</th>
	<th>T</th>
	<th>W</th>
	<th>T</th>
	<th>F</th>
	<th>S</th>
	<th>Total</th>
	<th>Std Dev</th>
	
	
<?php

$Reporting = array();

$Reporting[0][] = "WK Start";
$Reporting[1][] = "Weekly";
$Reporting[2][] = "Sun";
$Reporting[3][] = "Mon";
$Reporting[4][] = "Tue";
$Reporting[5][] = "Wed";
$Reporting[6][] = "Thu";
$Reporting[7][] = "Fri";
$Reporting[8][] = "Sat";
$Reporting[9][] = "Wk";
$Reporting[10][] = "Std Dev";

//$data = array();
$a = "a";
	
	for($x = 0; $x <= ($nweeks); $x++) {
		
		echo "<tr><td align='center'>";
		
		//echo $x;
		
		$Reporting[9][]=$x;
		
		echo "</td><td align='center'>";
		
		echo $AllDates[($x*7)];
		
		$Reporting[0][]=$AllDates[($x*7)];
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)])/60),1);
		
		$Reporting[2][] = round((($data[1][($x*7)])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)+1])/60),1);
		
		$Reporting[3][] = round((($data[1][($x*7)+1])/60),1);
				
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)+2])/60),1);
		
		$Reporting[4][] = round((($data[1][($x*7)+2])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)+3])/60),1);
		
		$Reporting[5][] = round((($data[1][($x*7)+3])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)+4])/60),1);
		
		$Reporting[6][] = round((($data[1][($x*7)+4])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)+5])/60),1);
		
		$Reporting[7][] = round((($data[1][($x*7)+5])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)+6])/60),1);
		
		$Reporting[8][] = round((($data[1][($x*7)+6])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($data[1][($x*7)]+$data[1][($x*7)+1]+$data[1][($x*7)+2]+$data[1][($x*7)+3]+$data[1][($x*7)+4]+$data[1][($x*7)+5]+$data[1][($x*7)+6])/60),1);
		
		$Reporting[1][]= round((($data[1][($x*7)]+$data[1][($x*7)+1]+$data[1][($x*7)+2]+$data[1][($x*7)+3]+$data[1][($x*7)+4]+$data[1][($x*7)+5]+$data[1][($x*7)+6])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		$arrSD=[];
		
		for($y = 0; $y <= 6; $y++) {
		
			if($data[1][($x*7)+$y]>0){
		
				$arrSD[]= $data[1][($x*7)+$y]/60;
			}
		
		}
		
		//echo stdev(array ($data[1][($x*7)]/60,$data[1][($x*7)+1]/60, $data[1][($x*7)+2]/60, $data[1][($x*7)+3]/60, $data[1][($x*7)+4]/60,$data[1][($x*7)+5]/60, $data[1][($x*7)+6]/60));
		
		//$Reporting[10][]= stdev(array ($data[1][($x*7)]/60,$data[1][($x*7)+1]/60, $data[1][($x*7)+2]/60, $data[1][($x*7)+3]/60, $data[1][($x*7)+4]/60,$data[1][($x*7)+5]/60, $data[1][($x*7)+6]/60));
		
		echo stdev($arrSD);
		
		$Reporting[10][]=stdev($arrSD);
		
		echo "</td></tr>";

}

echo "</table>";

echo "count=".count($data[1]);

mysqli_close($conn);
?>


<?php

$arrMinDev = array();

$sumMins = array_sum($data[1]);

$avgMins = $sumMins/$cnt;

$pwMins = $sumMins/$nweeks;

$pwdMins = $sumMins/$wrkDays;

for($x = 0; $x < $cnt; $x++) {
	$arrMinDev[] = pow(($data[1][$x]-$avgMins), 2);
}

$varMin = array_sum($arrMinDev) / ($cnt-1);

$stdev = sqrt($varMin);

?>
<table>
	<tr>
		<td></td>
		<td align='center'>Count</td>
        <td align='center'>Mins</td>
		<td align='center'>Hours</td>
	</tr><tr>
		<td align='center'>Total Time</td>
        <td></td>
		<td align='center'><?php echo $sumMins; ?></td>
		<td align='center'><?php echo round (($sumMins/60),2); ?></td>
	</tr><tr>
		<td align='center'>Mean (Per Day)</td>
        <td align='center'><?php echo $D2A; ?></td>
		<td align='center'><?php echo round($avgMins, 2); ?></td>
		<td align='center'><?php echo round(($avgMins/60), 2); ?></td>
	</tr><tr>
		<td align='center'>Std Dev</td>
        <td></td>
		<td align='center'><?php echo round($stdev, 2); ?></td>
		<td align='center'><?php echo round(($stdev/60), 2); ?></td>
	</tr><tr>
  
    
	</tr> <tr>
		<td align='center'>Per Week</td>
        <td align='center'><?php echo $nweeks; ?></td>
		<td align='center'><?php echo round($pwMins, 2); ?></td>
		<td align='center'><?php echo round(($pwMins/60), 2); ?></td>
		</tr><tr>
      
	
</table>

<table>
<th>Date</th>
<th>D0</th>
<th>D-1</th>
<th>D-2</th>
<th>D-3</th>
<th>Total</th>
<th>Avg</th>
<?php
$CD = count($data[0]);

$P = 4;

//$CD = floor($CD/$P)*$P;

$x=$CD-1;

while($x >= $P-1) {

	echo "<tr>";
	
	$RT = 0;
	
	echo "<td>";
	
	echo $data[0][$x];
	
	echo "</td>";
	
		for($y=0; $y<$P; $y++) {
	
			//echo "<td>";
			//echo $data[0][$x-$y];
			$CS = floor($data[1][$x-$y]/60);
			
			switch ($CS){
			
			case 10:
			
				echo "</td><td align='center' style='color:white; background-color:darkblue'>";
			
			break;
			
			case 9:
			
				echo "</td><td align='center' style='color:white; background-color:blue'>";
			
			break;
			
			case 8:
			
				echo "</td><td align='center' style='background-color:cyan'>";
			
			break;
			
			case 7:
			
				echo "</td><td align='center' style='background-color:green'>";
			
			break;
			
			case 6:
			
				echo "</td><td align='center' style='background-color:yellow'>";
			
			break;
			
			case 5:
			
				echo "</td><td align='center' style='background-color:orange'>";
			
			break;
			
			case 4:
			
				echo "</td><td align='center' style='background-color:darkorange'>";
			
			break;
			
			case 3:
			
				echo "</td><td align='center' style='background-color:red'>";
			
			break;
			
			case 2:
			
				echo "</td><td align='center' style='color:white; background-color:darkred'>";
			
			break;
			
			}
			
			echo round($data[1][$x-$y]/60,1);
			
			$RT = $RT + $data[1][$x-$y];
			
			echo "</td>";
			
		}
	
	$x--;
	
	echo "<td>";
	echo round($RT/60,1);
	$arrSD[]= $RT;
	$Reporting[11][$x] = round($RT/60,1);
	echo "</td><td>";
	echo round(($RT/60)/$P,1);
	echo "</td>";
	
	echo "</tr>";
}

?>
</table>

<?php

echo stdev($arrSD);
echo "<br>";
echo stdev($arrSD)/$P;

?>

<pre>
<?php 
//print_r($arrSD); 
?>
</pre>

<script>
//For chart

	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

google.charts.setOnLoadCallback(drawChartSD);

google.charts.setOnLoadCallback(drawChart2);

google.charts.setOnLoadCallback(drawChart3);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	echo "'" . "Col1", "', ";
	echo "'" . "Weekly", "'";
	echo '],';
	
for( $i=1;$i<$nweeks+2;$i++) {
	echo '[';
	echo $i, ", ";
	echo $Reporting[1][$i];
	echo '],';
	}
        ?>	
		]);

		var options = {
			hAxis: {title: 'Col1',  titleTextStyle: {color: '#333'}}
			};

		var chart = new google.visualization.AreaChart(document.getElementById('WChart'));

		chart.draw(data, options);
	}
	
	
	function drawChart2() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	echo "'" . "Col1", "', ";
	echo "'" . "Col2", "'";
	echo '],';
	
for( $i=0;$i<$cnt;$i++) {
	echo '[';
	echo $i, ", ";
	echo $data[1][$i]/60;
	echo '],';
	}
        ?>	
		]);

		var options = {
			hAxis: {title: 'Col1',  titleTextStyle: {color: '#333'}}
			};

		var chart = new google.visualization.AreaChart(document.getElementById('DChart'));

		chart.draw(data, options);
	}
	
	function drawChartSD() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	echo "'" . "Col1", "', ";
	echo "'" . "Avg", "', ";
	echo "'" . "STDev", "'";
	echo '],';
	
for( $i=1;$i<$nweeks+2;$i++) {
	echo '[';
	echo $i, ", ";
	echo $Reporting[1][$i]/7, ", ";
	echo $Reporting[10][$i];
	echo '],';
	}
        ?>	
		]);

		var options = {
			hAxis: {title: 'Col1',  titleTextStyle: {color: '#333'}}
			};

		var chart = new google.visualization.AreaChart(document.getElementById('ASChart'));

		chart.draw(data, options);
	}
	
	
	function drawChart3() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	echo "'" . "Col1", "', ";
	echo "'" . "MA", "'";
	echo '],';
	
for( $i=1;$i<$nweeks+2;$i++) {
	echo '[';
	echo $i, ", ";
	echo $Reporting[1][$i]/7, ", ";
	echo $Reporting[10][$i];
	echo '],';
	}
        ?>	
		]);

		var options = {
			hAxis: {title: 'Col1',  titleTextStyle: {color: '#333'}}
			};

		var chart = new google.visualization.AreaChart(document.getElementById('ASChart'));

		chart.draw(data, options);
	}
	
	
</script>
<h2>Daily</h2>
<div id="DChart" style="width: 900px; height: 500px"></div>
<h2>Weekly</h2>
<div id="WChart" style="width: 900px; height: 500px"></div>
<h2>Avg / StDev</h2>
<div id="ASChart" style="width: 900px; height: 500px"></div>