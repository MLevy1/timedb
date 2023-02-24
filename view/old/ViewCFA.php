<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<h1>CFA Info</h1>
<link rel="stylesheet" href="../../styles.css" />
<?php
include('../function/Functions.php');
include('../function/SqlList.php');
linktable();

pconn();

formid();

setQTime();

$selProj = "CFA";
$selLev = "4";

//Get and format previously selected Start Date

if($selLev==2){
$SDate = date_create('2016-12-04');
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date

$EDate = date_create('2017-06-03');
$EDate = date_format($EDate,"Y-m-d");
}

if($selLev==3){
$SDate = date_create('2017-07-23');
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date

$EDate = date_create('2018-06-23');
$EDate = date_format($EDate,"Y-m-d");
}


if($selLev==4){
$SDate = date_create('2018-12-02');
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date

$EDate = date_create('2019-06-15');
$EDate = date_format($EDate,"Y-m-d");
}

//Setup query containing all events between selected start and end date

sqlBetStartEnd($SDate, $EDate);

//Setup query containing the first event on the day following selected end date

//set result variable to hold contents of sql query

$result = mysqli_query($conn, $sqlBetStartEnd);

$data = array();

//fill STime, Act, and Cont arrays
while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['STime'];
    $data[1][] = date_create($row['STime']);
    $data[2][] = $row['ActID'];
    $data[3][] = $row['ProjID'];
}

//Free $result variable
mysqli_free_result($result);

//count rows in results arrays
$cnt = count($data[0]);

$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);

//Set Current Date Variables

$EDate3 = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

//Determine if the end date selected is the current date

    //fill Dur, Hrs, and Mins arrays
    for($x = 0; $x < ($cnt); $x++) {
        $data[4][] = getmins($data[0][$x], $data[0][$x+1]);
    }

    //Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table

    $arrTest = array();

    //Setup clear table query

    $clear = 'TRUNCATE TABLE tblTest4';
    mysqli_query($conn, $clear);

    //Setup insert values query

    $query = "INSERT INTO tblTest4 (`col1`, `col2`, `col3`, `col4`) VALUES ";

    //Use for loop to itterate through each of the events stored in the Act and Dur arrays

    for($x=0; $x<($cnt); $x++){
        $arrTest[] =
        "('" .
        date_format($data[1][$x],"Y-m-d") .
        "', '" .
        $data[2][$x] .
        "', '" .
        $data[3][$x] .
        "', '" .
        $data[4][$x] .
        "')";
}

//Create query used to populate Test table with contents of Act and Dur arrays

$sql = $query .= implode(',', $arrTest);

//Execute the populate table query

mysqli_query($conn, $sql);
    
$sumq = "SELECT col1, col2, col3, SUM(col4) AS scol FROM tblTest4 WHERE col2 = 'T03' OR col2 = 'L17' OR col2 = 'L18' AND col3 = '$selProj' GROUP BY col1 ORDER BY col1";

//Execute above query
$result = mysqli_query($conn, $sumq);

$data = array();

    //Store query results in col1 and col2 arrays

    while ($row = mysqli_fetch_array($result)) {
        $data[0][] = $row['col1'];
        $data[1][] = $row['scol'];
    }

    $cnt = count($data[0]);

    //Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays

    for($x = 0; $x < $cnt; $x++) {
        $data[4][] = gethours($data[1][$x]);
        $data[5][] = getrmins($data[1][$x], $data[4][$x]);
    }

mysqli_query($conn, $clear);

$QTime = date('Y-m-d');

$QDate=date_create($QTime);

if($selLev==2){
$FirstDate=date_create("2016-12-04");
}

if($selLev==3){
$FirstDate=date_create("2017-07-23");
}


if($selLev==4){
$FirstDate=date_create("2018-12-02");
}
    
    $sqldates = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE DATE(STime) >= '$SDate' ORDER BY STime";

    $result = mysqli_query($conn, $sqldates);

    $AllDates = array();
    $AllDates1 = array();
    
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

$DateDur = array();

for($x = 0; $x <= $cnt2 -1 ; $x++) {
	$DateDur[$x] = $AllDates1[$x];
}

$diff=date_diff($FirstDate,$QDate);

$diff1=$diff->format('%a days');

$nweeks = floor($diff1 / 7);

$dcSDate = date_create ($SDate);

$dcEDate = date_create ($EDate);

$dcQTime = date_create ($QTime);

$remDays = date_diff($dcQTime, $dcEDate);

$FremDays = $remDays->format( '%a');

$pastDays = date_diff($dcSDate, $dcQTime);

$FpastDays = $pastDays->format( '%a');

$totDays = date_diff($dcSDate, $dcEDate);

$FtotDays = $totDays->format( '%a');

$pctComp = round((($FpastDays / $FtotDays)*100),2);

$arrMinDev = array();

$sumMins = array_sum($data[1]);

$sumHrs = round(($sumMins / 60),2);

$hpd = round(($sumHrs / $FpastDays),2);

$mpd = round(($sumMins / $FpastDays),0);

$cpace = $hpd * $FtotDays;

$mpace = $mpd * $FtotDays;

$trgHrs = 400;

$trgMins = ($trgHrs*60);
$totrgMins = $trgMins-$sumMins;
$DtotrgMins= round(($totrgMins/$FremDays),0);

$totrgHrs = $trgHrs-$sumHrs;
$DtotrgHrs = round(($totrgHrs/$FremDays),2);

/*
$avgHrs = 330;

$avgMins = ($avgHrs*60);
$toavgMins = $avgMins-$sumMins;
$DtoavgMins= round(($toavgMins/$FremDays),0);

$toavgHrs = $avgHrs-$sumHrs;
$DtoavgHrs = round(($toavgHrs/$FremDays),2);
*/


$pctTrg = round((($sumHrs / $trgHrs)*100),2);
//$pctAvg = round((($sumHrs / $avgHrs)*100),2);

//$avgMins = $sumMins/$cnt2;

for($x = 0; $x < $cnt; $x++) {
	$arrMinDev[] = pow(($data[1][$x]-$avgMins), 2);
}

$varMin = array_sum($arrMinDev) / ($cnt2-1);

$stdev = sqrt($varMin);
?>

<div id='tblStats'>
<table width=100%>
	<tr>
		<td>Total Days:</td>
		<td><?php echo $FtotDays; ?></td>
		
		<td>Total Hours:</td>
		<td><?php echo gethours($sumMins).":".DZero(getrmins($sumMins, gethours($sumMins))); ?></td>
		
	</tr><tr>
		<td>Past Days:</td>
		<td><?php echo $FpastDays; ?></td>
		
		<td>Target Time:</td>
		<td><?php echo  $trgHrs; ?></td>
		
	</tr><tr>
		<td>Days Left:</td>
		<td><?php echo $FremDays; ?></td>
		
		<td>To Target:</td>
		<td><?php echo gethours($totrgMins).":".DZero(getrmins($totrgMins, gethours($totrgMins))); ?></td>
		
	</tr></tr>
	
		<td>Pct. Comp:</td>
		<td><?php echo $pctComp;?>%</td>
		
		<td>Pct of Target:</td>
		<td><?php echo  $pctTrg; ?>%</td>
		
	</tr></tr>
	
		<td>Per Day:</td>
		<td><?php echo gethours($mpd).":".DZero(getrmins($mpd, gethours($mpd))); ?></td>

		<td>Per Day:</td>
		<td><?php echo gethours($DtotrgMins).":".DZero(getrmins($DtotrgMins, gethours($DtotrgMins))); ?></td>
		
	</tr></tr>
	
		<td>Per Week:</td>
		<td><?php echo gethours(7*$mpd).":".DZero(getrmins(7*$mpd, gethours(7*$mpd))); ?></td>

		<td>Per Week:</td>
		<td><?php echo gethours((7 * $DtotrgMins)).":".DZero(getrmins((7 * $DtotrgMins), gethours((7 * $DtotrgMins)))); ?></td>
		
	</tr><tr>
	
		<td>Pace:</td>
		<td><?php echo $cpace;
		//echo gethours($mpace).":".DZero(getrmins($mpace, gethours($mpace)));  ?></td>
		
	</tr>
		
</table>
</div>

<?php include('../view/ViewCFA3.php'); ?>

<div id='tblDisp'>
<table>
	<th>Wk</th>
	<th>Start</th>
	<th>Su</th>
	<th>Mo</th>
	<th>Tu</th>
	<th>We</th>
	<th>Th</th>
	<th>Fr</th>
	<th>Sa</th>
	<th>Total</th>
	
<?php
$a = "a";
	
for($x = 0; $x <= ($nweeks); $x++) {
	echo "<tr><td align='center'>".
	$x.
	"</td><td align='center'>".
	$AllDates[($x*7)].
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)+1])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)+2])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)+3])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)+4])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)+5])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)+6])/60),1).
	"</td><td align='center' width=8%>".
	round((($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4]+$DateDur[($x*7)+5]+$DateDur[($x*7)+6])/60),1).
	"</td></tr>";
}
mysqli_close($conn);
?>
</table>
</div>

<?php //echo $mpd * $FtotDays; ?>
<?php include('../view/ViewCFA2.php'); ?>