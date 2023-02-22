<?php
function addsel($selname, $optname, $searchtbl){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname FROM $searchtbl ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option>" . $row[$optname] . "</option>";
}

echo "</select>";

$conn->close();
}

function addsel2($selname, $optname, $col1name, $searchtbl){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row[$optname] . "'>" . $row[$optname] . " " . $row[$col1name] . "</option>";

}

echo "</select>";

$conn->close();
}

function addsel2P($selname, $optname, $col1name, $searchtbl, $searchPName, $searchPVal){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl WHERE $searchPName = $searchPVal ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row[$optname] . "'>" . $row[$optname] . " " . $row[$col1name] . "</option>";

}

echo "</select>";

$conn->close();
}



function addsel3($selname, $optname, $col1name, $defopt, $searchtbl){

include("../function/DBConn.php");

$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname>";

echo "<option>$defopt</option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row[$optname] . "'>" . $row[$optname] . " " . $row[$col1name] . "</option>";

}

echo "</select>";

$conn->close();
}


function eventbtn($btnval, $btnname){
	echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname</button>";
}

function socialbtn($btnval, $btnname){
    echo "<button name='selCont' value='$btnval' type='submit'>$btnname</button>";
}

function newbtn($btnname, $btnval, $btncap){
    echo "<button name='$btnname' value='$btnval' type='submit'>$btncap</button>";
}
?>