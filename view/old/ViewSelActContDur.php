<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<h1>Daily Duration - Selected Activity</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<link rel="stylesheet" href="../../css/MobileStyle.css" />

<!-- For Date Picker -->
<link rel="stylesheet" href="../css/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!--For Chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php
include('../../function/Functions.php');
include('../../view/LinkTable.php');

pconn();

formid();

setQTime();
?>

<form method='get' action='<?php echo $form; ?>'>

<table width='100%'>

    <tr><td><b>Start Date</b></td><td>

		<p><input type="text" id='selSDate' name='selSDate'></p>

    </td><td><b>End Date</b></td><td>

    	<p><input type="text" id='selEDate' name='selEDate'></p>

<script>
$( function() {
	$( "#selSDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
	$( "#selEDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
 } );
 </script>

    </td></tr><tr><td><b>Activity</b></td><td>

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
	</td>

<td><b>Sub-Project</b></td><td>

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

	<td><b>Time Code</b></td>
	<td>
		<select id='timecode' name='timecode' class='smselect'>
			<option selected>H</option>
			<option>M</option>
			<option>WD</option>
			
		</select>
		
</td><td><b>Chart</td><td>


<select id='ctype' name='ctype' class='smselect'>
			<option value=1 >Time</option>
			<option value=10 >Std Dev</option>
			
		</select>

</td></tr><tr><td></td>

	<td> <input type="submit" /> </td>
	
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
$ctype = $_REQUEST["ctype"];

//Get and format previously selected Start Date

$SDate1 = $_REQUEST["selSDate"];
$SDate = date_create($SDate1);
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date

$EDate1 = $_REQUEST["selEDate"];
$EDate = date_create($EDate1);
$EDate = date_format($EDate,"Y-m-d");

//Create variable to hold the day after the selected end date

$EDate2 = date_create($EDate1);
date_add($EDate2, date_interval_create_from_date_string("1 day"));
$EDate2 = date_format($EDate2,"Y-m-d");

//Set pickers to default values if blank
if ($SDate1 == NULL) {
$EDate1 = date('Y-m-d');
$SDate1  = date('Y-m-d', strtotime('1 month ago'));
$selAct = 'All';
$selProj = 'All';
$selCont = 'All';
$timecode = 'H';
$selUCode = 'All';
}

$dtest = array();
?>

<script>
var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;

var val1 = "<?php echo $EDate1 ?>";
document.getElementById("selEDate").value=val1;

var val2 = "<?php echo $selAct ?>";
document.getElementById("selAct").value=val2;

var val3 = "<?php echo $selCont ?>";
document.getElementById("selCont").value=val3;

var val4 = "<?php echo $timecode ?>";
document.getElementById("timecode").value=val4;

var val5 = "<?php echo $selProj ?>";
document.getElementById("selProj").value=val5;

var val6 = "<?php echo $selUCode ?>";
document.getElementById("selUCode").value=val6;

</script>

<?php

//MIDNIGHT FIX

$SDate0 = date( "Y-m-d", strtotime( "$SDate1 -1 day" ) );

if($EDate1 == date('Y-m-d')){

	$EDate0 = date( "Y-m-d", strtotime( "$EDate1 -1 day" ) );
}else{
	$EDate0 = $EDate1;
}

//Pull last events from each selected day
$LSql = "SELECT DATE(STime) AS cDay, STime, Color, tblEvents.StartTime, tblEvents.STime, tblAct.ActID, tblAct.ActDesc, tblCont.ContID, tblCont.ContDesc, tblProj.ProjID, tblProj.ProjDesc, tblAct.UCode
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
INNER JOIN tblProj 
ON (tblCont.ProjID= tblProj.ProjID) 
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE STime 
	IN (
		SELECT MAX(STime) 
		FROM tblEvents 
		GROUP BY DATE(STime)
	) 
AND DATE(STime) BETWEEN CAST('$SDate0' AS DATE) AND CAST('$EDate0' AS DATE)";

$result = mysqli_query($conn, $LSql);

$ldata = array();

while ($row = mysqli_fetch_array($result)) {
	
	$a = $row['cDay'];
	
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['ActID'];
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['ContID'];
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['ProjID'];
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['UCode'];
	
}

//END MIDNIGHT FIX

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

//Setup query containing the first event on the day following selected end date

$sql2 = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActID, tblAct.ActDesc, tblCont.ContID, tblCont.ContDesc, tblProj.ProjID, tblProj.ProjDesc, tblAct.UCode 
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct
ON (tblEvents.ActID=tblAct.ActID) 
INNER JOIN tblProj 
ON (tblCont.ProjID= tblProj.ProjID) 
WHERE date(tblEvents.STime) ='$EDate2' ORDER BY tblEvents.STime LIMIT 1";

//set result variable to hold contents of sql query
if(isset($_GET['selAct'])){
    //Run above queries

    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);

    $data = array();

    //fill STime, Act, and Cont arrays
    while ($row = mysqli_fetch_array($result)) {  
        
	 $dtest[$row['STime']][] = $row['ActID'];
 	 $dtest[$row['STime']][] = $row['ContID'];
 	 $dtest[$row['STime']][] = $row['ProjID'];
 	 $dtest[$row['STime']][] = $row['UCode'];
 	 
    }

ksort($dtest);

$data = array();

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

    //fill STime, Act, and Cont arrays
    
    /*
    while ($row = mysqli_fetch_array($result2)) {
        $data[0][] = $row['STime'];
        $data[1][] = date_create($row['STime']);
        $data[2][] = $row['ActID'];
        $data[3][] = $row['ContID'];
        $data[4][] = $row['ProjID'];
        $data[6][] = $row['UCode'];
    }

    //Free $result variable
    mysqli_free_result($result2);

	*/

    //count rows in results arrays
    $cnt = count ($data[1]);

    //Set Current Date Variables

    $EDate3 = date('Y-m-d');
    $NowTime = date("Y-m-d H:i:s");

    //Determine if the end date selected is the current date

    if ($EDate == $EDate3){

    //Add row to end of arrays with current date and time

    $data[0][] = date_format(date_create($NowTime), 'Y-m-d h:i A');

    }

    //fill Dur, Hrs, and Mins arrays
    for($x = 0; $x < ($cnt-1); $x++) {
        $data[5][] = getmins($data[0][$x], $data[0][$x+1]);
    }


//print_r($data);

    $arrWECnt = array();

    $qryDates = "SELECT DISTINCT DATE(STime) AS D, IF(WEEKDAY(DATE(STime))>4,1,0) AS WD, IF(Type='O',1,0) AS PTO, IF(Type='H',1,0) AS WFH 
    FROM tblEvents LEFT JOIN tblDateInfo ON DATE( tblEvents.STime ) = tblDateInfo.Date1
    WHERE DATE(STIME) BETWEEN CAST('$SDate1' AS DATE) AND CAST('$EDate1' AS DATE) 
    AND STime IS NOT NULL ORDER BY STime DESC";

    $resDates = mysqli_query($conn, $qryDates);

    while ($row = mysqli_fetch_array($resDates)) {
        $arrWECnt[0][] = $row['WD'];
        $arrWECnt[1][] = $row['PTO'];
        $arrWECnt[2][] = $row['WFH'];
    }        

    while ($row = mysqli_fetch_array($resDates)) {
        $arrWECnt[0][] = $row['PTO'];
    }

    $WEcnt = array_sum($arrWECnt[0]);
    $PTOcnt = array_sum($arrWECnt[1]);
    $WFHcnt = array_sum($arrWECnt[2]);

    //Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table

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
        date_format($data[1][$x],"Y-m-d") .
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
    }else
    {
        $d = 'O';
    }

    $qry = $a.$b.$c.$d;
    
    //1. all events (AAAA), 2. all act, one cont (AOAA), 3. all act, all cont, one proj, (AAOA), 4. one act, all cont, all proj (OAAA), 5. one act, one cont, all proj (OOAA), 6. one act, all cont, one proj (OAOA) 7. all act, cnt, proj, one use code (AAAO) 8. all work related events AAAAW

    switch ($qry) {

    //Query containing all events (#1)

        case "AAAA":
            
		$sumq = "SELECT col1, SUM(col5) AS scol FROM tblTest4 GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ContID (#2)

        case "AOAA":
            
            $sumq = "SELECT col1, col3, SUM(col5) AS scol FROM tblTest4 WHERE col3 = '$selCont1' GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ContID (#3)

        case "AAOA":
            
            $sumq = "SELECT col1, col4, SUM(col5) AS scol FROM tblTest4 WHERE col4 = '$selProj1' GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ActID (#4)

        case "OAAA":
            
            $sumq = "SELECT col1, col2, SUM(col5) AS scol FROM tblTest4 WHERE col2 = '$selAct1' GROUP BY col1 ORDER BY col1";

            break;

    //Query containing all events with selected ContID and selected ActID (#5)

        case "OOAA":
            
            $sumq = "SELECT col1, col2, col3, SUM(col5) AS scol FROM tblTest4 WHERE col2 = '$selAct1' AND col3 = '$selCont1' GROUP BY col1 ORDER BY col1";

            break;
            
                //Query containing all events with selected ActID and ProjID (#6)

        case "OAOA":
            
            $sumq = "SELECT col1, col2, col4, SUM(col5) AS scol FROM tblTest4 WHERE col2 = '$selAct1' AND col4 = '$selProj1' GROUP BY col1 ORDER BY col1";

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
    }

    $cnt = count ($data[0]);

    //Use gethours and getrmins functions (on col2 array [which contains each sum of dur for each act]) to fill colHr and colMn arrays

    for($x = 0; $x < $cnt; $x++) {
        $data[4][] = gethours($data[1][$x]);
        $data[5][] = getrmins($data[1][$x], $data[4][$x]);
    }
}
mysqli_query($conn, $clear);

$QTime = date('Y-m-d');

$QDate=date_create($QTime);

$FirstMon1 = date('Y-m-d', strtotime('last monday', strtotime($SDate1)));

$FirstMon = date_create($FirstMon1);

$D1 = date_diff(date_create($SDate1), $FirstMon);

$D2 = date_diff(date_create($SDate1), date_create($EDate1));

$D2A = $D2->format('%a');

$D1A=$D1->format('%a');

if($D1A==7){
	$FirstMon1 = $SDate1;
	$FirstMon = date_create($SDate1);
	}

$sqldates = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents WHERE DATE(STime) is not null AND DATE(STIME) BETWEEN CAST('$FirstMon1' AS DATE) AND CAST('$EDate1' AS DATE) ORDER BY STime";

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

$DateDur = array();

for($x = 0; $x <= $cnt2 -1 ; $x++) {
	$DateDur[$x] = $AllDates1[$x];
}

$EDate2 = date_create($EDate2);

$diff=date_diff($FirstMon,$EDate2);

$diff1=$diff->format('%a days');

$diff1= $diff1-1;

$nweeks = floor($diff1 / 7);
?>

<table>
	<th>Wk</th>
	<th>Start</th>
	<th>Mo</th>
	<th>Tu</th>
	<th>We</th>
	<th>Th</th>
	<th>Fr</th>
	
<?php

if($timecode!="WD"){
	echo "<th>Sa</th>";
	echo "<th>Su</th>";
}

?>

	<th>Total</th>
	<th>Std Dev</th>
	
	
<?php

$Reporting = array();

$Reporting[0][] = "WK Start";
$Reporting[1][] = "Weekly";
$Reporting[2][] = "Mon";
$Reporting[3][] = "Tue";
$Reporting[4][] = "Wed";
$Reporting[5][] = "Thurs";
$Reporting[6][] = "Fri";
$Reporting[7][] = "Sat";
$Reporting[8][] = "Sun";
$Reporting[9][] = "Wk";
$Reporting[10][] = "Std Dev";


//$data = array();
$a = "a";
	
	for($x = 0; $x <= ($nweeks); $x++) {
		
		if($timecode=="M"){
		echo "<tr><td align='center'>";
		echo $x;
		$Reporting[9][]=$x;
		
		echo "</td><td align='center'>";
		
		echo $AllDates[($x*7)];
		$Reporting[0][]=$AllDates[($x*7)];
		
		echo "</td><td align='center' width=8%>";
		echo $DateDur[($x*7)];
		echo "</td><td align='center' width=8%>";
		echo $DateDur[($x*7)+1];
		echo "</td><td align='center' width=8%>";
		echo $DateDur[($x*7)+2];
		echo "</td><td align='center' width=8%>";
		echo $DateDur[($x*7)+3];
		echo "</td><td align='center' width=8%>";
		echo $DateDur[($x*7)+4];
		echo "</td><td align='center' width=8%>";
		
		echo $DateDur[($x*7)+5];
		echo "</td><td align='center' width=8%>";
		echo $DateDur[($x*7)+6];
		
		echo "</td><td align='center' width=8%>";
		
		echo ($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4]+$DateDur[($x*7)+5]+$DateDur[($x*7)+6]);
		
		$Reporting[1][]=($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4]+$DateDur[($x*7)+5]+$DateDur[($x*7)+6]);
		
		echo "</td><td align='center' width=8%>";
		
		echo stdev(array ($DateDur[($x*7)],$DateDur[($x*7)+1], $DateDur[($x*7)+2], $DateDur[($x*7)+3], $DateDur[($x*7)+4],$DateDur[($x*7)+5], $DateDur[($x*7)+6]));
		
		$Reporting[10][]= stdev(array ($DateDur[($x*7)],$DateDur[($x*7)+1], $DateDur[($x*7)+2], $DateDur[($x*7)+3], $DateDur[($x*7)+4],$DateDur[($x*7)+5], $DateDur[($x*7)+6]));

		echo "</td></tr>";
		
		}
		
		
		elseif($timecode=="WD")
		{
		
		echo "<tr><td align='center'>";
		echo $x;
		$Reporting[9][]=$x;
		echo "</td><td align='center'>";
		
		echo $AllDates[($x*7)];
		$Reporting[0][]=$AllDates[($x*7)];
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($DateDur[($x*7)])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($DateDur[($x*7)+1])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($DateDur[($x*7)+2])/60),1);
		echo "</td><td align='center' width=8%>";
		
		echo round((($DateDur[($x*7)+3])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($DateDur[($x*7)+4])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round((($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4])/60),1);
		
		$Reporting[1][]= round((($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4])/60),1);
		
		echo "</td><td align='center' width=8%>";
		
		echo round(stdev(array ($DateDur[($x*7)],$DateDur[($x*7)+1], $DateDur[($x*7)+2], $DateDur[($x*7)+3], $DateDur[($x*7)+4]))/60,2);
		
		$Reporting[10][]= stdev(array ($DateDur[($x*7)]/60,$DateDur[($x*7)+1]/60, $DateDur[($x*7)+2]/60, $DateDur[($x*7)+3]/60, $DateDur[($x*7)+4]/60));
		
		echo "</td></tr>";
		
		}
		
		
		else
		{
		echo "<tr><td align='center'>";
		echo $x;
		$Reporting[9][]=$x;
		echo "</td><td align='center'>";
		
		echo $AllDates[($x*7)];
		$Reporting[0][]=$AllDates[($x*7)];
		
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)+1])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)+2])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)+3])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)+4])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)+5])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)+6])/60),1);
		echo "</td><td align='center' width=8%>";
		echo round((($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4]+$DateDur[($x*7)+5]+$DateDur[($x*7)+6])/60),1);
		
		$Reporting[1][]= round((($DateDur[($x*7)]+$DateDur[($x*7)+1]+$DateDur[($x*7)+2]+$DateDur[($x*7)+3]+$DateDur[($x*7)+4]+$DateDur[($x*7)+5]+$DateDur[($x*7)+6])/60),1);
		echo "</td><td align='center' width=8%>";
		echo stdev(array ($DateDur[($x*7)]/60,$DateDur[($x*7)+1]/60, $DateDur[($x*7)+2]/60, $DateDur[($x*7)+3]/60, $DateDur[($x*7)+4]/60,$DateDur[($x*7)+5]/60, $DateDur[($x*7)+6]/60));
		
		$Reporting[10][]= stdev(array ($DateDur[($x*7)]/60,$DateDur[($x*7)+1]/60, $DateDur[($x*7)+2]/60, $DateDur[($x*7)+3]/60, $DateDur[($x*7)+4]/60,$DateDur[($x*7)+5]/60, $DateDur[($x*7)+6]/60));
		
		echo "</td></tr>";
		}
}

$CTrows=count($Reporting[0])-1;
mysqli_close($conn);
?>
</table>

<?php

$arrMinDev = array();

$wrkDays = $D2A - $WEcnt - $PTOcnt;

$sumMins = array_sum($data[1]);

$avgMins = $sumMins/$D2A;

$pwMins = $sumMins/$nweeks;

$pwdMins = $sumMins/$wrkDays;

for($x = 0; $x < $cnt; $x++) {
	$arrMinDev[] = pow(($data[1][$x]-$avgMins), 2);
}

$varMin = array_sum($arrMinDev) / ($D2A-1);

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
        <td align='center'>Per Workday</td>
        <td align='center'><?php echo $wrkDays; ?></td>
        <td align='center'><?php echo round($pwdMins, 2); ?></td>
        <td align='center'><?php echo round(($pwdMins/60), 2); ?></td>
	</tr> <tr>
		<td align='center'>Per Week</td>
        <td align='center'><?php echo $nweeks; ?></td>
		<td align='center'><?php echo round($pwMins, 2); ?></td>
		<td align='center'><?php echo round(($pwMins/60), 2); ?></td>
		</tr><tr>
        <td align='center'>WE Count</td>
        
        <td align='center'><?php echo $WEcnt; ?></td>
		
	</tr><tr>
	
        <td align='center'>PTO Count</td>
        <td align='center'><?php echo $PTOcnt; ?></td>
    </tr><tr>
        <td align='center'>WFH Count</td>
        <td align='center'><?php echo $WFHcnt; ?></td>
</table>

<script type="text/javascript">
//For chart

	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	echo "'" . $Reporting[9][0], "', ";
	echo "'" . $Reporting[$ctype][0], "'";
	echo '],';
	
for( $i=1;$i<$CTrows;$i++) {
	echo '[';
	//echo "'" . $Reporting[9][$i], "', ";
	
	echo $Reporting[9][$i], ", ";
	echo $Reporting[$ctype][$i];
	echo '],';
	}
	
echo '[';
//echo "'" . $Reporting[9][$i], "', ";

echo $Reporting[9][$i], ", ";
echo $Reporting[$ctype][$i];
echo '],';

        ?>	
		]);

		var options = {
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
