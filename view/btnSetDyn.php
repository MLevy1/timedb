<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-21 days');
$SQTime = date_format($SQTime,'Y-m-d');

$lsql = "SELECT STime, ActID, ProID FROM tblEvents ORDER BY STime DESC LIMIT 1";

$lresult = mysqli_query($conn, $lsql);

$ldata = array();

while ($lrow = mysqli_fetch_array($lresult)) {
	$ldata[0][] = $lrow['ActID'];
	$ldata[1][] = $lrow['ProID'];
}

$lact = $ldata[0][0];

$lcont = $ldata[1][0];

$par = $lact.'|'.$lcont;

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

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$ndata[1][] = $row['STime'];
	$ndata[2][] = date_create($row['STime']);
	$ndata[3][] = $row['ActID'];
	$ndata[4][] = $row['ProID'];
	$ndata[5][] = $row['StartTime'];
	$ndata[6][] = $row['ActDesc'];
	$ndata[7][] = $row['ContDesc'];
}

$cnt=((count ($ndata, COUNT_RECURSIVE))/count($ndata))-1;

$ndata[1][] = $NowTime;
$ndata[2][] = date_create($NowTime);

for($x = 0; $x < $cnt; $x++) {
	
	//Store current event Act and Cont combo
	$ndata[9][] = $ndata[3][$x] . "|" . $ndata[4][$x];
	
	//Store next event Act and Cont combo
	$ndata[10][] = $ndata[3][$x+1] . "|" . $ndata[4][$x+1];
	
	//Store combo of current and next event Act and Cont combos
	$ndata[11][] = $ndata[3][$x] . "|" . $ndata[4][$x] . "_" . $ndata[3][$x+1] . "|" . $ndata[4][$x+1];
	
	//Store description of next ActID
	$ndata[12][] = $ndata[6][$x+1];	
	
	//Store description of next ContID
	$ndata[13][] = $ndata[7][$x+1];
}

//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table
$arrTest = array();

//Setup clear table query
$clear = 'TRUNCATE TABLE tblNextEvent';

//Execute clear table query
mysqli_query($conn, $clear);

//Setup insert values query
$query = "INSERT INTO tblNextEvent (`col1`, `col2`, `NEAct`, `NECont`) VALUES ";

//Use for loop to itterate through each of the events stored in the Act and Dur arrays
for($x=0; $x<($cnt-1); $x++){

	$arrTest[] = "('" . $ndata[9][$x] . "', '" . $ndata[11][$x] . "', '" . $ndata[12][$x] .  "', '" . $ndata[13][$x]  .  "')";
}

//Create query used to populate Test table with contents of Act and Dur arrays
$pop = $query .= implode(',', $arrTest);

//Execute the populate table query
mysqli_query($conn, $pop);

$sql = "SELECT col1, col2, NEAct, NECont, COUNT(col2) AS CNT
FROM tblNextEvent
WHERE col1 = '$par'
GROUP BY col2 
ORDER BY CNT DESC";

//Execute above query
$result = mysqli_query($conn, $sql);

$arrResults = array();

//Store query results in col1 and col2 arrays
while ($row = mysqli_fetch_array($result)) {
	$arrResults[0][] = $row['col1'];
	$arrResults[1][] = $row['col2'];
	$arrResults[2][] = $row['CNT'];
	$arrResults[3][] = $row['NEAct'];
	$arrResults[4][] = $row['NECont'];
}

$cnt=count($arrResults[0]);

$dchar = '_';

$data = array();

for($x=0; $x<($cnt); $x++){
	
	$data[0][] = substr($arrResults[1][$x], (strpos($arrResults[1][$x], $dchar)+1),3);
	$data[1][] = substr($arrResults[1][$x], (strpos($arrResults[1][$x], $dchar)+5));
	$data[2][] = $arrResults[3][$x] . "<br>" . $arrResults[4][$x];
	
}

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($cnt/$rowbtns);

$lrowbtns=$cnt%$rowbtns;

echo "<table width='100%'>";

if($cnt>=$rowbtns){
while ($rowcounter<=$rownum){
	echo "<tr>";
	$rowbtncounter=1;

	while ($rowbtncounter<=$rowbtns){
 		echo "<td>";

        $btnval1 = $data[0][$btncounter];
        $btnval2 = $data[1][$btncounter];

        $btnval = $btnval1." ".$btnval2;
        
        $btnname = $data[2][$btncounter];

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

        $btnval1 = $data[0][$btncounter];
        $btnval2 = $data[1][$btncounter];

        $btnval = $btnval1." ".$btnval2;
        
        $btnname = $data[2][$btncounter];

        echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname</button>";
		
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}

$clear = 'TRUNCATE TABLE tblNextEvent';

mysqli_query($conn, $clear);

mysqli_close($conn);
echo "</table>";
?>