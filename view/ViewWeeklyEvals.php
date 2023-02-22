<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/DBConn.php');

$sql = "SELECT * FROM tblWEvals";
$result = $conn->query($sql);

echo "<table>";

echo "<tr><td>" . "<b>Date" . "</td><td>" . "<b>Goal 1" . "</td><td>" . "<b>Goal 2" .  "</td><td>" . "<b>Goal 3" . "</td><td>" . "<b>Goal 4" . "</td><td>" . "<b>Goal 5" . "</td></tr>";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["weDate"] . "</td><td>" . $row["weGoal1txt"] . "</td><td>" . $row["weGoal2txt"] ."</td><td>" . $row["weGoal3txt"] . "</td><td>" .$row["weGoal4txt"] . "</td><td>" .$row["weGoal5txt"] . "</td></tr>";
    }
} else {
    echo "0 results";
}
$conn->close();
echo "</table>";

?>
