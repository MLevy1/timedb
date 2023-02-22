<?php

/*
$sql = "SELECT *
        FROM tblCTTopic
        WHERE Active != 'N'
        ORDER BY CTTopic";
 */
 
$sql = "SELECT *
        FROM tblCTTopic
        ORDER BY CTTopic";

$result = mysqli_query($conn, $sql);

$data = array();
$data2 = array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row['CTTOP'];
	$data2[] = $row['CTTopic'];
}

$btncnt=count($data);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
	echo "<tr>";
	$rowbtncounter=1;

	while ($rowbtncounter<=$rowbtns){
 		echo "<td>";
 		newbtn('selTop', $data[$btncounter], $data2[$btncounter]);
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
		newbtn('selTop', $data[$btncounter], $data2[$btncounter]);
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}

mysqli_close($conn);
?>