<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

//START

$varSQL = $_GET["selSQL"];

if ($varSQL == NULL) {
	$varSQL = "SELECT Active, CTTOP, CTTopic FROM tblCTTopic WHERE Active='Y' ORDER BY CTTopic";
}

switch ($varSQL) {

    //Query containing all events (#1)

        case "A":
            
		$varSQL = "SELECT Active, CTTOP, CTTopic FROM tblCTTopic WHERE Active='Y' ORDER BY CTTopic";

            break;

    //Query containing all events with selected ContID (#2)

        case "I":
            
            $varSQL = "SELECT Active, CTTOP, CTTopic FROM tblCTTopic WHERE Active='N' ORDER BY CTTopic";

            break;

    //Query containing all events with selected ContID (#3)

        case "All":
            
            $varSQL = "SELECT Active, CTTOP, CTTopic FROM tblCTTopic ORDER BY CTTopic";

            break;     
    }

//END

$result = mysqli_query($conn, $varSQL);

echo "<table>";
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>" . 
		$row["CTTopic"] .
		"</td><td>" . 
		$row["Active"] . 
		"</td><td>" . 
		("<input type=\"button\" class=\"link\" onclick=\"location.href='FormUpdateCTTopic.php?selTop=$row[CTTOP]'\" value=\"U\"</input>"). "</td></tr>";
}
} else {
echo "0 results";
}
mysqli_close($conn);
echo "</table>";
?>
