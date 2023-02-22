<?php
include('../function/Functions.php');

pconn();

formid();

//Setup query to populate date picker

$sqsel = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents ORDER BY STime DESC";

//Run date picker query

$result = mysqli_query($conn, $sqsel);

?>
<form method='get' action='<?php echo $form; ?>'>

<table width='100%'>
    <tr><td width='25%'><b>Start Date</b></td><td width='25%'>
<select name='selSDate' id='selSDate' class='smselect'>

<?php

//Loop through query results to populate date picker

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
}

//Free $result variable

mysqli_free_result($result);

?>

</select>
    </td><td width='25%'><b>End Date</b></td><td width='25%'>
<select name='selEDate' id='selEDate' class='smselect'>

<?php

$result = mysqli_query($conn, $sqsel);

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
}

mysqli_free_result($result);

?>

</select>

    </td></tr><tr><td width='25%'><b>Activity</b></td><td width='25%'>

<select id='selAct' name='selAct' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['ActID'] . "'>" .$row['ActDesc'] . "</option>";
}

mysqli_free_result($result);

?>

</select>

</td><td width='25%'><b>Sub-Project</b></td><td width='25%'>

<select id='selCont' name='selCont' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE Active!='N' AND ProjStatus != 'Closed' ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ContID'] . "'>" .$row['ProjDesc'] . " - " .$row['ContDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>

</td></tr><tr><td width='25%'>

<input type="submit" />

</td></tr>
</table>

</form>