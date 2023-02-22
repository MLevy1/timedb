<?php
include("../function/Functions.php");

pconn();

date_default_timezone_set('America/New_York');

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-21 days');
$SQTime = date_format($SQTime,'Y-m-d');


$NowHr = date("G");
$NowD1 = date("N");

If($NowD1<6){
	$NowD = 1;
} 
else{
	$NowD = 0;
}

$MinHr = $NowHr - 6;
$MaxHr = $NowHr + 6;

$sql = "SELECT EXTRACT( HOUR FROM tblEvents.STime ) AS EventHr, 
    WEEKDAY(tblEvents.STime) AS EventDay,
    IF(WEEKDAY(tblEvents.STime)>4,0,1) AS WKI, 
    tblEvents.ActID, 
    tblEvents.ProID, 
    tblAct.ActDesc, 
    tblCont.ContDesc, 
    COUNT( * ) AS cnt
    FROM tblEvents
    INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
    INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID
    WHERE tblProj.ProjStatus !=  'Closed'
    AND DATE( tblEvents.STime ) >=  '$SQTime'
    AND tblAct.Status !=  'Inactive'
    AND tblCont.Active != 'N'
    AND EXTRACT( HOUR FROM tblEvents.STime ) BETWEEN $MinHr AND $MaxHr
    AND (IF(WEEKDAY(tblEvents.STime)>4,0,1) = $NowD) 
    GROUP BY tblAct.ActID, tblCont.ContID
    ORDER By tblAct.ActDesc,  tblCont.ContID";
	
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $data1[] = $row['ActDesc'];
    $data2[] = $row['ContDesc'];
    $data3[] = $row['cnt'];
    $data4[] = $row['ActID'];
    $data5[] = $row['ProID'];
}

$btncnt=count($data1);

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

        $btnval1 = $data4[$btncounter];
        $btnval2 = $data5[$btncounter];
        $btnname1 = $data1[$btncounter];
        $btnname2 = $data2[$btncounter];

        $btnval = $btnval1." ".$btnval2;

	 $a = etime($btnval1, $btnval2);

        $btnname = $btnname1."<br>".$btnname2."<br>".$a;
        
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
		
        $btnval1 = $data4[$btncounter];
        $btnval2 = $data5[$btncounter];
        $btnname1 = $data1[$btncounter];
        $btnname2 = $data2[$btncounter];

        $btnval = $btnval1." ".$btnval2;
        
        $a = etime($btnval1, $btnval2);

        $btnname = $btnname1."<br>".$btnname2."<br>".$a;

        echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname</button>";
		
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}
mysqli_close($conn);
echo "</table>";
?>