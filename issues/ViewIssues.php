<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

$sql = "SELECT * FROM tblIssues WHERE IssueStatus != 'Closed'";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['Issueid'];
	$data[1][] = $row['dateOpen'];
	$data[2][] = date_create($row['dateOpen']);
	$data[3][] = $row['IssueDesc'];
}

mysqli_close($conn);

$cnt= count ($data[0]);

echo "<table width=100%>";

for($x = 0; $x < ($cnt); $x++) {
        echo "<tr><td width=20% style='text-align:center'>".
        date_format($data[2][$x],"Y-m-d h:i A").
        "</td><td  width=5% style='text-align:center'>".
        $data[0][$x].
        "</td><td width=70%>".
        $data[3][$x].
        "</td><td width=5%>".
        ("<input type=\"button\" class=\"link\" onclick=\"location.href='../issues/FormUpdateIssue.php?selIssue={$data[0][$x]}'\" value=\"U\"</input>").
	"</td></tr>";
	}

echo "</table>";

?>
