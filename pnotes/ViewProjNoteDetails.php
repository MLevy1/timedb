<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

pconn();

$data = array();

$selNote = $_REQUEST["selNote"];

if($selNote===Null){
    $selNote=1;
}

$sql = "SELECT * FROM tblProjSubNotes WHERE ProjNote = '$selNote'";

$result = mysqli_query($conn, $sql);

$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']); 
$tbl="tblProjSubNotes";
$varSel="SubNoteID";


while($row = mysqli_fetch_assoc($result)) {

    	$data[0][]=$row["SubNoteID"];
        $data[1][]=$row["ProjNote"];
    	$data[2][]=$row["SubNoteDate"];
        $data[3][]=$row["SubNote"];
        $data[4][]=$row["SubNoteOpen"];
        $data[5][]=date_create($row["SubNoteDate"]);
}

$cnt=count($data[0]);

echo "<table width=100%>";
echo "<th>Time</th>";
echo "<th>Subnote</th>";

for($x = 0; $x < ($cnt); $x++) {

        echo "<tr><td width=40% style='text-align:center'>";
        echo date_format($data[5][$x],"Y-m-d h:i A");
        echo "</td><td width=55%>";
        echo $data[3][$x];
		echo "</td><td width=5% style='text-align:center'>";
        echo ("<input type=\"button\" class=\"link\" onclick=\"location.href='../pnotes/DelSNote.php?selNote={$data[1][$x]}&selSNote={$data[0][$x]}'\" value=\"D\"</input>");
        echo "</td></tr>";
}

echo "</table>";
?>