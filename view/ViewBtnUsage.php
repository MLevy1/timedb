<?php header("Cache-Control: no-cache, must-revalidate");?>

<link rel="stylesheet" href="../../styles.css" />

<?php
include('../function/Functions.php');
include('../view/LinkTable.php');

pconn();

setQTime();

$Now = date_create($NowTime);

$data = array();


$sql = "SELECT tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime, MAX(STime) AS LD
FROM tblEvents 
INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID 
INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID
WHERE tblCont.Active!='N' AND tblProj.ProjStatus!='Closed'
GROUP BY tblAct.ActID, tblCont.ContID 
ORDER BY cnt DESC";

/*

$sql = "SELECT tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime,
FROM tblEvents 
INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID 
INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID
WHERE tblCont.Active!='N' AND tblProj.ProjStatus!='Closed'
GROUP BY tblAct.ActID, tblCont.ContID 
ORDER BY cnt DESC LIMIT 100";

*/

/*
//single event
$sql = "SELECT ActID, ProID, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime FROM tblEvents WHERE ActID = $selAct AND ProID = $selCont GROUP BY ActID, ProID ORDER BY LTime";
*/


$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $data[1][] = $row['ActDesc'];
    $data[2][] = $row['ContDesc'];
    $data[3][] = $row['cnt'];
    $data[4][] = $row['LTime'];
    $data[5][] = $row['LD'];
    $data[6][] = $row['ActID'];
    $data[7][] = $row['ProID'];
}

$cnt=count ($data[1]);

?>
<table width=100%>
    <th>Act. Desc.</th>
    <th>Cont. ID</th>
    <th>Total</th>
    <th>Last</th>
    <th>Elapsed</th>
    
    <!--
    <th>Mon</th>
    <th>Tue</th>
    <th>Wed</th>
    <th>Thu</th>
    <th>Fri</th>
    <th>Sat</th>
    <th>Sun</th>
    -->
    
<?php

for($x = 0; $x < ($cnt); $x++) {
    echo "<tr><td>".$data[1][$x]."</td><td>".$data[2][$x] . "</td><td>" . $data[3][$x] . "</td><td>" . $data[4][$x] . "</td><td>" . $data[5][$x] . "</td><td>". $data[6][$x] . "</td><td>" . $data[7][$x] . "</td></tr>";    
}

echo "</table>";

//etime('S01', 'LM');

mysqli_close($conn);


?>