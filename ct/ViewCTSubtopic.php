<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

$varSQL = $_GET["selSQL"];

if ($varSQL == NULL) {
	$varSQL = "SELECT * FROM tblCTSubtopic
INNER JOIN tblCTTopic ON tblCTSubtopic.CTTopic = tblCTTopic.CTTOP
WHERE tblCTSubtopic.Active != 'N'
AND tblCTTopic.Active != 'N'
ORDER BY tblCTTopic.CTTopic, tblCTSubtopic.CTSubtopic";
}

switch ($varSQL) {

    //Query containing all events (#1)

        case "A":
            
		$varSQL = "SELECT * FROM tblCTSubtopic INNER JOIN tblCTTopic ON tblCTSubtopic.CTTopic = tblCTTopic.CTTOP WHERE tblCTSubtopic.Active != 'N' AND tblCTTopic.Active != 'N' ORDER BY tblCTTopic.CTTopic, tblCTSubtopic.CTSubtopic";

            break;

    //Query containing all events with selected ContID (#2)

        case "I":
            
            $varSQL = "SELECT * FROM tblCTSubtopic INNER JOIN tblCTTopic ON tblCTSubtopic.CTTopic = tblCTTopic.CTTOP WHERE tblCTSubtopic.Active = 'N' OR tblCTTopic.Active = 'N' ORDER BY tblCTTopic.CTTopic, tblCTSubtopic.CTSubtopic";

            break;

    //Query containing all events with selected ContID (#3)

        case "P":
            
            $varSQL = "SELECT * FROM tblCTSubtopic INNER JOIN tblCTTopic ON tblCTSubtopic.CTTopic = tblCTTopic.CTTOP WHERE tblCTSubtopic.Active != 'N' AND tblCTTopic.Active != 'N' AND tblCTSubtopic.Tone = 'Positive' ORDER BY tblCTTopic.CTTopic, tblCTSubtopic.CTSubtopic";

            break;

    //Query containing all events with selected ActID (#4)

        case "N":
            
            $varSQL = "SELECT * FROM tblCTSubtopic INNER JOIN tblCTTopic ON tblCTSubtopic.CTTopic = tblCTTopic.CTTOP WHERE tblCTSubtopic.Active != 'N' AND tblCTTopic.Active != 'N' AND tblCTSubtopic.Tone = 'Neutral' ORDER BY tblCTTopic.CTTopic, tblCTSubtopic.CTSubtopic";

            break;

    //Query containing all events with selected ContID and selected ActID (#5)

        case "Neg":
            
            $varSQL = "SELECT * FROM tblCTSubtopic INNER JOIN tblCTTopic ON tblCTSubtopic.CTTopic = tblCTTopic.CTTOP WHERE tblCTSubtopic.Active != 'N' AND tblCTTopic.Active != 'N' AND tblCTSubtopic.Tone = 'Negative' ORDER BY tblCTTopic.CTTopic, tblCTSubtopic.CTSubtopic";

            break;     
    }


$result = mysqli_query($conn, $varSQL);
?>

<table>

<?php

$data = array();

while($row = mysqli_fetch_array($result)) {
	$data[0][] = $row["CTTopic"];
	$data[1][] = $row["CTSubtopic"];
	$data[2][] = $row["Tone"];
	$data[3][] = $row["CTST"];
}

$cnt=((count ($data, COUNT_RECURSIVE))/count($data))-1;

for($x = 0; $x < $cnt; $x++) {
$b = $data[3][$x];
echo "<tr><td>" . 
	$data[0][$x] . 
	"</td><td>" . ">" . 
	"</td><td>" . 
	$data[1][$x] .
	"</td><td>" .
	$data[2][$x] .
	"</td><td>" . 
	("<input type=\"button\" class=\"link\" onclick=\"location.href='FormUpdateCTSubtopic.php?selTop=$b'\" value=\"U\"</input>"). "</td></tr>";
}

$cntTone = array();

foreach ($data[2] as $value) {
	if ($value == "Positive") {
		$cntTone[0] = $cntTone[0] + 1;
	}
	if ($value == "Neutral") {
		$cntTone[1] = $cntTone[1] + 1;
	}
	if ($value == "Negative") {
		$cntTone[2] = $cntTone[2] + 1;
	}
}

mysqli_close($conn);
?>
</table>
<table>
<tr><td>Positive</td><td>Neutral</td><td>Negative</td></tr>
<tr><td><?php echo $cntTone[0]; ?></td><td><?php echo $cntTone[1]; ?></td><td><?php echo $cntTone[2]; ?></td></tr>
</table>