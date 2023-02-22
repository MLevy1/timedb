<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-3 days');
$SQTime = date_format($SQTime,'Y-m-d');

$lsql = "SELECT STime, ActID, ProID FROM tblEvents ORDER BY STime DESC LIMIT 1";

$lresult = mysqli_query($conn, $lsql);

$ldata1 = array();
$ldata2 = array();

while ($lrow = mysqli_fetch_array($lresult)) {
	$ldata1[] = $lrow['ActID'];
	$ldata2[] = $lrow['ProID'];
}

$lact = $ldata1[0];

$lcont = $ldata2[0];

$par = $lact.'|'.$lcont;

echo $par;

echo "<br><br>";

$sql = "SELECT tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc 
FROM tblEvents 
INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID
WHERE tblProj.ProjStatus !=  'Closed'
AND DATE( tblEvents.STime ) >=  '$SQTime'
AND tblAct.Status !=  'Inactive'
AND tblCont.Active != 'N'
ORDER BY tblEvents.STime";

$result = mysqli_query($conn, $sql);

$data1 = array();
$data2 = array();
$data3 = array();
$data4 = array();
$data5 = array();
$data6 = array();
$data7 = array();

while ($row = mysqli_fetch_array($result)) {
	$data1[] = $row['STime'];
	$data2[] = date_create($row['STime']);
	$data3[] = $row['ActID'];
	$data4[] = $row['ProID'];
	$data5[] = $row['StartTime'];
	$data6[] = $row['ActDesc'];
	$data7[] = $row['ContDesc'];
}

$cnt=count ($data1);

$data1[] = $NowTime;
$data2[] = date_create($NowTime);

$arrCurrent = array();
$arrNext = array();
$arrCombo = array();
$arrNEAct = array();
$arrNECont = array();

for($x = 0; $x < $cnt; $x++) {
	
	$arrCurrent[] = $data3[$x] . "|" . $data4[$x];
	
	$arrNext[] = $data3[$x+1] . "|" . $data4[$x+1];
	
	$arrCombo[] = $data3[$x] . "|" . $data4[$x] . "_" . $data3[$x+1] . "|" . $data4[$x+1];
	
	$arrNEAct[] = $data6[$x+1];
	
	$arrNECont[] = $data7[$x+1];
}

//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table
$arrTest = array();

//Setup clear table query
$clear = 'TRUNCATE TABLE tblTest';
$clear2 = 'TRUNCATE TABLE tblTest2';
$clear3 = 'TRUNCATE TABLE tblNextEvent';

//Execute clear table query
mysqli_query($conn, $clear);
mysqli_query($conn, $clear2);
mysqli_query($conn, $clear3);

//Setup insert values query
$query = "INSERT INTO tblNextEvent (`col1`, `col2`, `NEActDesc`, `NEContDesc`) VALUES ";

//Use for loop to itterate through each of the events stored in the Act and Dur arrays
for($x=0; $x<($cnt-1); $x++){
	$arrTest[] = "('" . $arrCurrent[$x] . "', '" . $arrCombo[$x] . "', '" . $arrNEAct[$x] .  "', '" . $arrNECont[$x]  .  "')";
}

//Create query used to populate Test table with contents of Act and Dur arrays
$pop = $query .= implode(',', $arrTest);

//Execute the populate table query
mysqli_query($conn, $pop);

$sql = "SELECT col1, col2, NEActDesc, NEContDesc, COUNT(col1) AS CNT
FROM tblNextEvent 
WHERE col1 = '$par'
GROUP BY col2 
ORDER BY col1, CNT DESC";

/*
//Set selCont variable to selected Cont
$selCont = $_GET["selCont"];

//Setup query to calculate sum of durations calculated above in the Dur array for each grouping in the Cont array

$sumq = "SELECT col1, SUM(col2) AS scol, col3 FROM tblTest2 WHERE col1 = '$selCont' GROUP BY col1, col3 ORDER BY col3";
*/

//Reset arrays used to hold results
$col1 = array();
$col2 = array();
$CNT = array();
$NEAct = array();
$NECont = array();

//Execute above query
$result = mysqli_query($conn, $sql);

//Store query results in col1 and col2 arrays
while ($row = mysqli_fetch_array($result)) {
	$col1[] = $row['col1'];
	$col2[] = $row['col2'];
	$CNT[] = $row['CNT'];
	$NEAct[] = $row['NEActDesc'];
	$NECont[] = $row['NEContDesc'];
}

//Count the number of rows in col1 array
$cnt=count ($col1);

//print_r ($col1);

//print_r ($col2);

$col2a = array();
$col2b = array();

$dchar = '_';

for($x=0; $x<($cnt); $x++){
	$col2a[] = substr($col2[$x], (strpos($col2[$x], $dchar)+1),3);
	
	$col2b[] = substr($col2[$x], (strpos($col2[$x], $dchar)+5));
}
echo "<pre>";
print_r($arrNEAct);
//print_r ($data6);
echo "</pre>";
echo "<br><br>";

echo "<pre>";
print_r($col2);
echo "</pre>";
echo "<br><br>";

echo "data6";
echo "<br>";
print_r($data6[0]);
echo "<br><br>";

echo "col2a";
echo "<br>";
print_r($col2a);
echo "<br><br>";

echo "col2b";
echo "<br>";
print_r($col2b);
echo "<br><br>";

echo "NEAct";
echo "<br>";
print_r ($NEAct);
echo "<br><br>";

echo "NECont";
echo "<br>";
print_r($NECont);
echo "<br><br>";
/*
$dchar = '|';
$pos = strpos($btnfull, $dchar);
$ActID = substr($btnfull, 0, 3);
$ContID = substr($btnfull, 4);
*/

echo "<table>";

for($x = 0; $x < $cnt; $x++) {
	echo "<tr><td>";
	echo $col1[$x];
	echo "</td><td>";
	echo $col2[$x];
	echo "</td><td>";
	echo $CNT[$x];
	echo "</td></tr>";
}

echo "</table>";


$btncnt=count($col2);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

echo "<table width='100%'>";

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
	echo "<tr>";
	$rowbtncounter=1;

	while ($rowbtncounter<=$rowbtns){
 		echo "<td>";

        $btnval1 = $col2a[$btncounter];
        $btnval2 = $col2b[$btncounter];
        $btnname1 = $NEAct[$btncounter];
        $btnname2 = $NECont[$btncounter];

        $btnval = $btnval1." ".$btnval2;

        $btnname = $btnname1."<br>".$btnname2;

        echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname</button>";

 		echo "</td>";
 		$btncounter++;
		$rowbtncounter++;
	}
echo "</tr>";
$rowcounter++;
}
}
if ($lrowbtns!=0){
	echo "<tr>";
	for ($i = 0; $i < $lrowbtns; $i++) {
		echo "<td>";
		
        $btnval1 = $col2a[$btncounter];
        $btnval2 = $col2b[$btncounter];
        $btnname1 = $NEAct[$btncounter];
        $btnname2 = $NECont[$btncounter];

        $btnval = $btnval1." ".$btnval2;

        $btnname = $btnname1."<br>".$btnname2;

        echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname</button>";
		
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}
/*
$clear = 'TRUNCATE TABLE tblTest';
$clear2 = 'TRUNCATE TABLE tblTest2';
$clear3 = 'TRUNCATE TABLE tblNextEvent';

mysqli_query($conn, $clear);
mysqli_query($conn, $clear2);
mysqli_query($conn, $clear3);
*/
mysqli_close($conn);
echo "</table>";

?>
