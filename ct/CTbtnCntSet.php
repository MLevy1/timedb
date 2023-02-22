<?php
/*
include("../function/Functions.php");

pconn();

$selCont1 = $_GET ["selCont"];
*/

if($selCont1 == Null) {
    $selCont1 = "AD";    
}

$sql = "SELECT DISTINCT tblCTTopic.CTTOP, tblCont.ContDesc, tblCTTopic.CTTopic, COUNT( * ) AS CNT
FROM tblConvos
INNER JOIN tblCTTopic ON tblConvos.CTTopic = tblCTTopic.CTTOP
INNER JOIN tblCont ON tblConvos.ContID = tblCont.ContID
WHERE tblCont.ContID = '$selCont1'
GROUP BY CTTOP
ORDER BY CNT DESC";
	
$result = mysqli_query($conn, $sql);

    $data[] = array();

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['CTTOP'];
    $data[1][] = $row['CTTopic'];

}

$btncnt=count($data[1]);

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
        newbtn('selTop', $data[0][$btncounter], $data[1][$btncounter]);
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
        newbtn('selTop', $data[0][$btncounter], $data[1][$btncounter]);
        echo "</td>";
        $btncounter++;
	}
	echo "</tr>";
}
mysqli_close($conn);
?>