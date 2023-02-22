<?php
header("Cache-Control: no-cache, must-revalidate");

include("DBConn.php");

$sql = "SELECT * FROM tblLearnObj";

$result = $conn->query($sql);

echo "<table>";

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["LObj"]."</td><td>"."</td><td>".$row["Details"]."</td><td>".$row["LObjPriority"]."</td><td>".$row["LObjComp"]."</td><td>".$row["LOjbStatus"]."</td><td>".$row["StatusDate"]."</td></tr>";
}
    
} else {
    echo "0 results";
}

echo "</table>";

?>
