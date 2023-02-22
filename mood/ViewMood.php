<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

formid();

$tbl="tblMood";
$varSel="MoodDT";

setQTime();

//sets the interval
$I = $_REQUEST["I"];

//sets interval to all if undefined
if($I==null){
	
	$I="A";

}


//sets a variable to hold current date
$SQTime = date_create(date('Y-m-d'));

//creates array for data
$data = array();

//creates array to hold list of days
$Daylist = array();

//creates array to hold list of times
$AllTimes = array();

//determines actions if an interval is selected
if($I != "A"){

	//sets variable to # of days in selected interval
	$dm = '-'.$I.' days';

	//sets a variable to the first day of the selected interval
	date_modify($SQTime, $dm);
	$SQTime = date_format($SQTime,'Y-m-d');
	

//MIDNIGHT FIX

	//sets another variable to the first day of the interval
	$SDate1 = $SQTime;

	//sets a variable to current date
	$EDate1 = date('Y-m-d');
	
	//sets a variable to midnight of the date before the first day of the interval
	$SDate0 = date( "Y-m-d", strtotime( "$SDate1 -1 day" ) );

	//determines action if end date is current date (currently the only possibility)
	if($EDate1 == date('Y-m-d')){

		//sets variable to day before end date
		$EDate0 = date( "Y-m-d", strtotime( "$EDate1 -1 day" ) );
	
	}else{
		
		//not relevant yet
		$EDate0 = $EDate1;
	}

//query to pull last mood from each selected day
$LSql = "SELECT DATE(MoodDT) AS mDay, MoodDT, Mood
FROM tblMood 
WHERE MoodDT 
	IN (
		SELECT MAX(MoodDT) 
		FROM tblMood 
		GROUP BY DATE(MoodDT)
	) 
AND DATE(MoodDT) BETWEEN CAST('$SDate0' AS DATE) AND CAST('$EDate0' AS DATE)";

//create variable to hold query results
$result = mysqli_query($conn, $LSql);

//set counter to 0
$c=0;

//populate Daylist with list of days from SQL query
while ($row = mysqli_fetch_array($result)) {

		$a = $row['mDay'];
		
		if($c!=0){
			$Daylist[] = $a;
		}
		
		//create an associative array that stores a record with the final mood from the prior day and midnight of current day as a time
		
		$dtest[date( "Y-m-d H:i:s", strtotime( "$a +1 day" ) )] = $row['Mood'];
	
		$c++;
	
}
$Daylist[]= date('Y-m-d');

//END MIDNIGHT FIX
	
	$sql = "SELECT MoodDT, Mood FROM tblMood WHERE date(MoodDT) >='$SQTime' ORDER BY MoodDT DESC";
	
}else{

//MIDNIGHT FIX

	//sets start date for the analysis
	$SDate1 = "2018-10-10";
	
	//sets end date to current date
	$EDate1 = date('Y-m-d');

	//sets variable to day before start date
	$SDate0 = date( "Y-m-d", strtotime( "$SDate1 -1 day" ) );

	//determines action if end date is current date (always)
	if($EDate1 == date('Y-m-d')){
	
		//sets variable to day before end date
		$EDate0 = date( "Y-m-d", strtotime( "$EDate1 -1 day" ) );
	
	}else{
	
		$EDate0 = $EDate1;
	}

//Pull last events from each selected day
$LSql = "SELECT DATE(MoodDT) AS mDay, MoodDT, Mood
FROM tblMood 
WHERE MoodDT 
	IN (
		SELECT MAX(MoodDT) 
		FROM tblMood 
		GROUP BY DATE(MoodDT)
	) 
AND DATE(MoodDT) BETWEEN CAST('$SDate0' AS DATE) AND CAST('$EDate0' AS DATE)";

$result = mysqli_query($conn, $LSql);

while ($row = mysqli_fetch_array($result)) {
	
	$a = $row['mDay'];
	$Daylist[] = $a;
	
	$dtest[date( "Y-m-d H:i:s", strtotime( "$a +1 day" ) )] = $row['Mood'];
	
}
$Daylist[]= date('Y-m-d');
//END MIDNIGHT FIX


//at this point an associate array exists with the last events from each day


//sql query to pull all moods sorted descending

$sql = "SELECT MoodDT, Mood FROM tblMood ORDER BY MoodDT DESC";

}


//variable to store sql results
$result = mysqli_query($conn, $sql);

//creats array to be used for reporting and charts
$Reporting = array();

//adds sql results to existing array that alread comtains midnight records
while ($row = mysqli_fetch_array($result)) {

  $dtest[$row['MoodDT']]= $row['Mood'];

}

//sorts cumulative array
krsort($dtest);

//creates array to count the number of times each mood score is used during each hour of the day

$DWH = array();

//cycles through all mood records incl midnight adds
foreach($dtest as $x => $xval) {
		
		//creates a php date from the date in each record
		$dx = date_create($x);
		
		//populates data array with the date of each record
		$data[0][] = $x;
		
		//populates data array with the php date object for each record
		$data[1][] = $dx;
		
		//populates data array with the mood score of each record
		$data[2][] = $xval;
		
		//populates data array with the absolute time of each record 
		$data[3][] = date_format ($dx, 'U')*1000;
		
		//populates data array with the year of each record 
		$data[4][] = date_format ($dx, 'Y');
		
		//populates data array with the month of each record 
		$data[5][] = date_format ($dx, 'n')-1;
		
		//populates data array with the day of each record 
		$data[6][] = date_format ($dx, 'j');
		
		//populates data array with the hour of each record 
		$data[7][] = date_format ($dx, 'G');
		
		//populates data array with the minute of each record 
		$data[8][] = date_format ($dx, 'i');
		
		//populates data array with the second of each record 
		$data[9][] = date_format ($dx, 's');
		
		//adds 1 to the count in the DWH array that contains the hour that each mood score was used
		$DWH[$xval][date_format ($dx, 'G')]++;
		
}

/*

At this point, the DWH array contains the number of times each mood score has been used during each hour of the day. 

The data array contains the mood score along with the date parts and full times for each record in the databse.

Daylist contains a list of all days

dtest is an associative array that contains each record including midnight adds 

*/

//close sql
mysqli_close($conn);

//count mood entries
$cnt=count($data[0]);

$Reporting[0][]="Date / Time";
$Reporting[1][]="Mood";
$Reporting[2][]="Date";
$Reporting[3][]="-1";
$Reporting[4][]="-0.5";
$Reporting[5][]="0";
$Reporting[6][]="0.5";
$Reporting[7][]="1";

?>

<!--time chart-->
<div id="line_chart" style="width: '100%'; height: 500px"></div>

<!--mood list table-->
<table width='100%'>
	<th><b>Time</th>
	<th><b>Mood</th>
	<th><b>Duration</th>
	
<?php
//Number of Rows
$L=75;

$C=0;

//print mood events (loop through all)
for($x = 0; $x < $cnt; $x++) {
	
	//identifies the first record
	if($x===0){
	
	    //sets first event to time=0
	    $Reporting[0][] = 0;
	    
	    //create a date variable from the current date
	    $dd = date_create(date());
	   
	   /*
	   
	   POTENTIAL FUTURE SIMPLIFICATION
	   
	   $testarr = darray($dd);
	    
	    for($c=0; $c<=5; $c++){
	    
	    		$arrchart[$c][] = $testarr[$c];
	    }
	    
	    */
	    
	    //Populates chart array with date parts of the current date
		$arrchart[0][] = date_format ($dd, 'Y');
		$arrchart[1][] = date_format ($dd, 'n')-1;
		$arrchart[2][] = date_format ($dd, 'j');
		$arrchart[3][] = date_format ($dd, 'G');
		$arrchart[4][] = date_format ($dd, 'i');
		$arrchart[5][] = date_format ($dd, 's');
	    
	    //Populates reporting array with mood score for first record
	    $Reporting[1][]= $data[2][0];
	    
	    //Populates chart array with mood score for first record
	    $arrchart[6][] = $data[2][0];
	    
	    //sets a variable to the number of hours since the current time
	    
	    $fh = date('U')/(60*60) -date_format($data[1][$x], 'U')/(60*60);
		

		//populates AllTimes array with a record indexed by the date that contains the mood score with a value equal to the number off hours that have past since the event
		
	$AllTimes[(date_format($data[1][$x], 'Y-m-d'))][$data[2][$x]][] = date('U')/(60*60) -date_format($data[1][$x], 'U')/(60*60);
	
	} else{
	
		//sets a variable to the number of hours since the last event
	
		$fh = date_format($data[1][$x-1], 'U')/(60*60) - date_format($data[1][$x], 'U')/(60*60);
	
		//populates AllTimes array with a record indexed by the date that contains the mood score with a value equal to the number off hours that have past since the last event
	
		$AllTimes[date_format($data[1][$x], 'Y-m-d')][$data[2][$x]][] = date_format($data[1][$x-1], 'U')/(60*60) - date_format($data[1][$x], 'U')/(60*60);
	
	}
	
	//sets a variable to the integer of the hour counts above
	$h = floor($fh);
	
	//determines the number off minutes
	$m = round(60*($fh - $h),0);
	
	//display only first 50
	if($x<=$L){
	
	  //new row
	  echo "<tr>";
	
	  //new cell
	  echo "<td class='mtblcell3'>";
	
	  //display the date and time of mood event
	  echo date_format($data[1][$x], 'D m-d h:i A');
	
	  echo "</td>";
	  
	  echo "<td class='mtblcell3'>";
	
	  echo $data[2][$x];
	
	  echo "</td><td class='mtblcell3'>";
	  
	  if($m>=10){
	  
		echo $h.":".$m;
		
	}else{
	
		echo $h.":"."0".$m;
		
	}

	echo "</td><td width='5%'>";
	
	if($x===0){
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDelE('{$data[0][$x]}', '$varSel', '$tbl', '{$data[2][1]}')\" value=\"D\"</input>");
	
	}else{
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDelE('{$data[0][$x]}', '$varSel', '$tbl', '{$data[2][0]}')\" value=\"D\"</input>");
	
	}
	
	echo "</td></tr>";
	  
	}
	
	//sets time for each event to the number of days away from current moment (always a negative number)
	$Reporting[0][] = (date_format($data[1][$x], 'U') - date('U'))/(24*60*60);
	
	$dd= $data[1][$x];
	
	$arrchart[0][] = date_format ($dd, 'Y');
	$arrchart[1][] = date_format ($dd, 'n')-1;
	$arrchart[2][] = date_format ($dd, 'j');
	$arrchart[3][] = date_format ($dd, 'G');
	$arrchart[4][] = date_format ($dd, 'i');
	$arrchart[5][] = date_format ($dd, 's');
	
	//identifies mood events that are before the last event in the final event
	if($x<$cnt-1){
	
	  //creates a record 1 second before each mood event with mood from the prior event
 	  $Reporting[0][] = ((date_format($data[1][$x], 'U')-1) - date('U'))/(24*60*60);
 	  
$dd = $data[1][$x];

date_add($dd, date_interval_create_from_date_string('-1 second'));
	
	$arrchart[0][] = date_format ($dd, 'Y');
	$arrchart[1][] = date_format ($dd, 'n')-1;
	$arrchart[2][] = date_format ($dd, 'j');
	$arrchart[3][] = date_format ($dd, 'G');
	$arrchart[4][] = date_format ($dd, 'i');
	$arrchart[5][] = date_format ($dd, 's');
	
	}
	
date_add($dd, date_interval_create_from_date_string('1 second'));
	
	$Reporting[1][]= $data[2][$x];
	
	$arrchart[6][] = $data[2][$x];
	
	if($x>0){
	
	  $Reporting[1][]= $data[2][$x];
	  
	  $arrchart[6][] = $data[2][$x];
	  
	}

	$AllTimes[date_format($data[1][$x], 'Y-m-d')][2] = array_sum($AllTimes[date_format($data[1][$x], 'Y-m-d')][-1]);
	$AllTimes[date_format($data[1][$x], 'Y-m-d')][3] = array_sum($AllTimes[date_format($data[1][$x], 'Y-m-d')]["-0.5"]);
	$AllTimes[date_format($data[1][$x], 'Y-m-d')][4] = array_sum($AllTimes[date_format($data[1][$x], 'Y-m-d')][0]);
	$AllTimes[date_format($data[1][$x], 'Y-m-d')][5] = array_sum($AllTimes[date_format($data[1][$x], 'Y-m-d')]["0.5"]);
	$AllTimes[date_format($data[1][$x], 'Y-m-d')][6] = array_sum($AllTimes[date_format($data[1][$x], 'Y-m-d')][1]);




	$CTrows = (count($Reporting[0])-1);
	
	$ddrows = (count($arrchart[0])-1);
	
}

/*

At this time in addition to what’s described above, an array containing records showing the duration of each score on each day now exists.

The Reporting array now contains records with each mood event indexed by the amount of time that has passed since it occurred in days.  It also contains auto generated records contain the mood score from immediately before the event occurred for charting purposes.

The arrChart array contains the mood score and date parts for each event including midnight adds and the placeholder records described above.

*/

?>
</table>

<?php 

function dcht($chart, $len) {
		
	if (is_null($len)){
	
		$len = count($chart[0]);
		
	}

	$cs = count($chart);
	
	echo "<table>";
	
	for($x = 0; $x < $len; $x++) {

		echo "<tr>";
	
		for($y = 0; $y < $cs; $y++) {
	
			echo "<td>";
			echo $chart[$y][$x];
			echo "</td>";
	
		}

		echo "</tr>";

	}
	
	echo "</table>";
		
}


function shArr($arr){

echo "<pre>";

print_r($arr);

echo "</pre>";

}

//function to create an array that contains the day parts of a given variable (start cnt, array name, date)
function darray($var){

	$arr = array();

	$arr[0] = date_format ($var, 'Y');
	$arr[1] = date_format ($var, 'n')-1;
	$arr[2] = date_format ($var, 'j');
	$arr[3] = date_format ($var, 'G');
	$arr[4] = date_format ($var, 'i');
	$arr[5] = date_format ($var, 's');

	return $arr;

}

?>

<div id="line_chart1" style="width: '100%'; height: 500px"></div>


<table width=100%>
<th>Day</th>
<th>-1</th>
<th>-0.5</th>
<th>0</th>
<th>0.5</th>
<th>1</th>

<?php
$a=0;

$DCnt = count($Daylist);

if($I=="A"){

$ds=14;

}else{

$ds=$I;

}

$SD = $DCnt-$ds;
foreach ($Daylist as $X)
{

$dx = date_create($X);

$Reporting[2][]=$a;

$Reporting[3][]= round($AllTimes[$X][2],1);
$Reporting[4][]= round($AllTimes[$X][3],1);
$Reporting[5][]= round($AllTimes[$X][4],1);
$Reporting[6][]= round($AllTimes[$X][5],1);
$Reporting[7][]= round($AllTimes[$X][6],1);

$arrchart[7][] = date_format ($dx, 'Y');
$arrchart[8][] = date_format ($dx, 'n')-1;
$arrchart[9][] = date_format ($dx, 'j');


$arrchart[10][]= round($AllTimes[$X][2],1);
$arrchart[11][]= round($AllTimes[$X][3],1); 
$arrchart[12][]= round($AllTimes[$X][4],1);
$arrchart[13][]= round($AllTimes[$X][5],1);
$arrchart[14][]= round($AllTimes[$X][6],1);


if($a>=$SD){
echo "<tr>";
echo "<td>";
echo date("D Y-m-d", strtotime($X));

echo "</td>";

echo "<td>";
echo round($AllTimes[$X][2],1);

echo "</td><td>";
echo round($AllTimes[$X][3],1);

echo "</td><td>";
echo round($AllTimes[$X][4],1);

echo "</td><td>";
echo round($AllTimes[$X][5],1);

echo "</td><td>";
echo round($AllTimes[$X][6],1);
echo "</td>";

echo "</tr>";
}
$a++;
}
echo "</table>";
?>

<div id="line_chart2" style="width: '100%'; height: 500px"></div>

<?php

//$CTrows1 = count($arrchart[7])-1;

$CTrows1 = count($arrchart[10])-1;


$DW = array();

$MonthList = array();

$MthInd = 0;

$MthCnt = -1;

//PROBLEM

foreach ($Daylist as $X)
{

//day of week
$a = date("w", strtotime($X));

//month
$b = date("n", strtotime($X));

//year
$y = date("Y", strtotime($X));


if($b<10){

	$Y = ($y-2019);
	
}else{

	$Y = ($y-2018);

}

$MthVal = date("Y-m", strtotime($X));

if (in_array($MthVal, $MonthList[0])) {

}else{

$MthCnt++;

$MthInd = $MonthList[0][$MthCnt] = $MthVal;

}

$MonthList[1][$MthCnt]++;

$MonthList[2][$b]++;


//number of days in month
$t = date("t", strtotime($X));

//current month
$Ca = date("n", time());

//current day of month
$Cdc = date("j", time());

//populates dimension 0 of the DW array with the total amount of time in each weekday at a mood score

$DW[0][0][$a][] = round($AllTimes[$X][2],1);
$DW[1][0][$a][] = round($AllTimes[$X][3],1);
$DW[2][0][$a][] = round($AllTimes[$X][4],1);
$DW[3][0][$a][] = round($AllTimes[$X][5],1);
$DW[4][0][$a][] = round($AllTimes[$X][6],1);

//populates dimension 1 of the DW array with the total amount of time in each month at a mood score

$DW[0][1][$b][] = round($AllTimes[$X][2],0);
$DW[1][1][$b][] = round($AllTimes[$X][3],0);
$DW[2][1][$b][] = round($AllTimes[$X][4],0);
$DW[3][1][$b][] = round($AllTimes[$X][5],0);
$DW[4][1][$b][] = round($AllTimes[$X][6],0);

}


echo "<table>";
echo "<tr><td>";
echo "Mood";
echo "</td><td>";
echo "Sun";
echo "</td><td>";
echo "Mon";
echo "</td><td>";
echo "Tue";
echo "</td><td>";
echo "Wed";
echo "</td><td>";
echo "Thu";
echo "</td><td>";
echo "Fri";
echo "</td><td>";
echo "Sat";
echo "</td></tr>";

echo "<tr><td>";
echo "-1";

$Reporting[8][0][]="-1";
$Reporting[8][1][]="-0.5";
$Reporting[8][2][]="0";
$Reporting[8][3][]="0.5";
$Reporting[8][4][]="1";
$Reporting[8][5][]="Index";

echo "</td>";
for( $i=0;$i<7;$i++) {
	echo "<td>";
	
	echo array_sum($DW[0][0][$i]);

	$Reporting[8][5][]=$i;	
	$Reporting[8][0][]=array_sum($DW[0][0][$i]);
	
	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "-0.5";
echo "</td>";


for( $i=0;$i<7;$i++) {
	echo "<td>";
	
	echo array_sum($DW[1][0][$i]);

	$Reporting[8][1][]=array_sum($DW[1][0][$i]);
	
	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "0";
echo "</td>";


for( $i=0;$i<7;$i++) {
	echo "<td>";
	
	echo array_sum($DW[2][0][$i]);
	
	$Reporting[8][2][]=array_sum($DW[2][0][$i]);

	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "0.5";
echo "</td>";


for( $i=0;$i<7;$i++) {
	echo "<td>";
	
	echo array_sum($DW[3][0][$i]);
	
	$Reporting[8][3][]=array_sum($DW[3][0][$i]);

	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "1";
echo "</td>";


for( $i=0;$i<7;$i++) {
	echo "<td>";
	
	echo array_sum($DW[4][0][$i]);
	
	$Reporting[8][4][]=array_sum($DW[4][0][$i]);

	echo "</td>";
}

echo "</tr>";
echo "</table>";

?>

<div id="line_chart3" style="width: '100%'; height: 500px"></div>

<?php

$T = array();


echo "<table>";

echo "<tr><th>";
echo "Month";
echo "</th><th>";
echo "-1";
echo "</th><th>";
echo "-0.5";
echo "</th><th>";
echo "0";
echo "</th><th>";
echo "0.5";
echo "</th><th>";
echo "1";
echo "</th></th>";

for( $r=1;$r<13;$r++) {

	echo "<tr><td>".$r."</td>";

	for( $c=0; $c<5;$c++) {
		
		echo "<td>";
		
		echo round(array_sum($DW[$c][1][$r])/$MonthList[2][$r],2);
		
		echo "</td>";
		
	}

	echo "</tr>";

}

echo "</table>";



?>

<div id="line_chart4" style="width: '100%'; height: 500px"></div>

<?php

$Reporting[9][0][]="-1";
$Reporting[9][1][]="-0.5";
$Reporting[9][2][]="0";
$Reporting[9][3][]="0.5";
$Reporting[9][4][]="1";
$Reporting[9][5][]="Hour";

echo "<table>";
echo "<tr><td>";
echo "Mood";
echo "</td><td>";
echo "5";
echo "</td><td>";
echo "6";
echo "</td><td>";
echo "7";
echo "</td><td>";
echo "8";
echo "</td><td>";
echo "9";
echo "</td><td>";
echo "10";
echo "</td><td>";
echo "11";
echo "</td><td>";
echo "12";
echo "</td><td>";
echo "1";
echo "</td><td>";
echo "2";
echo "</td><td>";
echo "3";
echo "</td><td>";
echo "4";
echo "</td><td>";
echo "5";
echo "</td><td>";
echo "6";
echo "</td><td>";
echo "7";
echo "</td><td>";
echo "8";
echo "</td><td>";
echo "9";
echo "</td><td>";
echo "10";
echo "</td><td>";
echo "11";
echo "</td></tr>";


echo "<tr><td>";
echo "-1";
echo "</td>";
for( $i=5;$i<24;$i++) {
	echo "<td>";

	$Reporting[9][5][]=$i;
	$Reporting[9][0][]= $DWH[-1][$i];

	echo $DWH[-1][$i];
	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "-0.5";
echo "</td>";
for( $i=5;$i<24;$i++) {
	echo "<td>";

	$Reporting[9][5][]=$i;
	$Reporting[9][1][]= $DWH["-0.5"][$i];

	echo $DWH["-0.5"][$i];
	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "0";
echo "</td>";
for( $i=5;$i<24;$i++) {
	echo "<td>";

	$Reporting[9][2][]= $DWH[0][$i];
	
	echo $DWH[0][$i];
	echo "</td>";
}

echo " </tr>";

echo "<tr><td>";
echo "0.5";
echo "</td>";
for( $i=5;$i<24;$i++) {
	echo "<td>";

	$Reporting[9][2][]=$i;
	$Reporting[9][3][]= $DWH["0.5"][$i];

	echo $DWH["0.5"][$i];
	echo "</td>";
}

echo " </tr>";


echo "<tr><td>";
echo "1";
echo "</td>";
for( $i=5;$i<24;$i++) {
	echo "<td>";
	echo $DWH[1][$i];

	$Reporting[9][4][]= $DWH[1][$i];
	
	echo "</td>";
}

echo " </tr>";

echo "</table>";



?>
<script>
google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

google.charts.setOnLoadCallback(drawChart1);

google.charts.setOnLoadCallback(drawChart2);

google.charts.setOnLoadCallback(drawChart4);

function drawChart() {

	var data = google.visualization.arrayToDataTable([
		
		<?php
		
		echo "[{label: 'DateTime', type: 'datetime'}, {label: 'Mood'}],";
	
		for( $i=0;$i<$ddrows;$i++) {
			echo '[';
			
			echo "'Date(" . $arrchart[0][$i] . ", " . $arrchart[1][$i] . ", " . $arrchart[2][$i] . ", " . $arrchart[3][$i] . ", " . $arrchart[4][$i] . ", " . $arrchart[5][$i] . ")'";
			
			echo ", ";
			
			echo $arrchart[6][$i];
			
			echo '],';
		}
		
		
        	?>	
	]);
	
	var options = {
	
		lineWidth: 0.3,
		areaOpacity: .5,
		hAxis: {format: 'M-d-yy h'},
		legend: {position: 'none'},
		'chartArea': {'width': '90%', 'height': '80%'}

}

	var chart = new google.visualization.AreaChart(document.getElementById('line_chart'));

	chart.draw(data, options);
}

function drawChart1() {

	var data = google.visualization.arrayToDataTable([
		
		<?php
		
		echo "[{label: 'Day', type: 'datetime'}, {label: '-1'}, {label: '1'}],";
		
		for( $i=0;$i<=$CTrows1;$i++) {
			echo '[';
			
			echo "'Date(" . $arrchart[7][$i] . ", " . $arrchart[8][$i] . ", " . $arrchart[9][$i] . ")'";
			
			
			echo ", ";

			echo $arrchart[10][$i];
			
			echo ", ";
			
			echo $arrchart[14][$i];
			
			echo '],';
		}

        	?>	
	]);

var options = {

		lineWidth: 0.5,
		isStacked: 'false',
		hAxis: {format: 'M-d-yy'},
		legend: {position: 'bottom'},
		'chartArea': {'width': '90%', 'height': '80%'}
		}




	var chart = new google.visualization.AreaChart(document.getElementById('line_chart1'));

	chart.draw(data, options);
}


function drawChart2() {

	var data = google.visualization.arrayToDataTable([
		
		<?php
		echo '[';
		
		echo "'" . $Reporting[8][5][0]. "', ";
		echo "'" . $Reporting[8][0][0]. "', ";
		echo "'" . $Reporting[8][1][0]. "', ";
		echo "'" . $Reporting[8][2][0]. "', ";
		echo "'" . $Reporting[8][3][0]. "', ";
		echo "'" . $Reporting[8][4][0]. "'";

		echo '],';
	
		for( $i=1;$i<7;$i++) {
			echo '[';

			echo "'"; 
			echo $Reporting[8][5][$i] . "', ";
			echo $Reporting[8][0][$i] . ", ";
			echo $Reporting[8][1][$i] . ", ";
			echo $Reporting[8][2][$i] . ", ";
			echo $Reporting[8][3][$i] . ", ";
			echo $Reporting[8][4][$i];

			echo '],';
		}
	
		echo '[';

		echo $Reporting[8][5][$i] . ", ";
		echo $Reporting[8][0][$i] . ", ";
		echo $Reporting[8][1][$i] . ", ";
		echo $Reporting[8][2][$i] . ", ";
		echo $Reporting[8][3][$i] . ", ";			echo $Reporting[8][4][$i];

		echo '],';

        	?>	
	]);

var options = {

		lineWidth: 0.5,
		//isStacked: 'true'
		}

	var chart = new google.visualization.AreaChart(document.getElementById('line_chart2'));

	chart.draw(data, options);
}

function drawChart4() {

	var data = google.visualization.arrayToDataTable([
		
		<?php
		echo '[';

		echo "'" . $Reporting[9][5][0]. "', ";
		echo "'" . $Reporting[9][0][0]. "', ";
		echo "'" . $Reporting[9][1][0]. "', ";
		echo "'" . $Reporting[9][2][0]. "', ";
		echo "'" . $Reporting[9][3][0]. "', ";
		echo "'" . $Reporting[9][4][0]. "'";

		echo '],';
	
		for( $i=1;$i<19;$i++) {

			echo '[';

			echo "'" . $Reporting[9][5][$i]. "', ";
			echo $Reporting[9][0][$i] . ", ";
			echo $Reporting[9][1][$i] . ", ";
			echo $Reporting[9][2][$i] . ", ";
			echo $Reporting[9][3][$i] . ", ";
			echo $Reporting[9][4][$i];

			echo '],';
		}
	
		echo '[';

		echo $Reporting[9][5][$i] . ", ";
		echo $Reporting[9][0][$i] . ", ";
		echo $Reporting[9][1][$i] . ", ";
		echo $Reporting[9][2][$i] . ", ";
		echo $Reporting[9][3][$i] . ", ";
		echo $Reporting[9][4][$i];
		

		echo '],';

        	?>	
	]);

var options = {

		lineWidth: 0.5,
		isStacked: 'false'
		}

	var chart = new google.visualization.AreaChart(document.getElementById('line_chart4'));

	chart.draw(data, options);
}
</script>
<?php   
//$arr = get_defined_vars();
?>