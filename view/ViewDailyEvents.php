<?php header("Cache-Control: no-cache, must-revalidate"); ?>
	<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Event Duration</h1>

<a href="../menu/MenuEventLists.htm">Events Menu</a>

<?php
include('../function/Functions.php');

include("../view/LinkTable.php");

date_default_timezone_set('America/New_York');

pconn();

$sqsel = "SELECT DISTINCT DATE(STime) AS QDate FROM tblEvents ORDER BY STime DESC";

$result = mysqli_query($conn, $sqsel);
?>

<form method='get' action='ViewDailyEvents.php'>
<select name='selQDate' id='selQDate'>

<?php 
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
}
?>

</select>
<input type="submit" name="submit" />
</form>

<?php
$QTime = $_GET["selQDate"];

$date=date_create($QTime);
date_add($date,date_interval_create_from_date_string("1 day"));
$date1 = date_format($date,"Y-m-d");

$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']); 
$tbl="tblEvents";
$varSel="StartTime";

if ($QTime == NULL) {
$QTime = date('Y-m-d');
}

if ($QTime != NULL) {

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents INNER JOIN tblCont ON (tblEvents.ProID=tblCont.ContID) INNER JOIN tblAct ON (tblEvents.ActID=tblAct.ActID) WHERE date(tblEvents.STime) ='$QTime' ORDER BY tblEvents.STime";

$sql2 = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents INNER JOIN tblCont ON (tblEvents.ProID=tblCont.ContID) INNER JOIN tblAct ON (tblEvents.ActID=tblAct.ActID) WHERE date(tblEvents.STime) ='$date1' ORDER BY tblEvents.STime LIMIT 1"; 

$result = mysqli_query($conn, $sql);

$result2 = mysqli_query($conn, $sql2);

$data = array();
$dtime = array();
$data2 = array();
$data3 =array();
$data5 =array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row['STime'];
	$dtime[] = date_create($row['STime']);
	$data2[] = $row['ActDesc'];
	$data3[] = $row['ContDesc'];
	$data5[] = $row['StartTime'];
}

while ($row = mysqli_fetch_array($result2)) {
	$data[] = $row['STime'];
	$dtime[] = date_create($row['STime']);
	$data2[] = $row['ActDesc'];
	$data3[] = $row['ContDesc'];
	$data5[] = $row['StartTime'];

}

$cnt=count ($data);
?>

</tr>
</table>
<hr />
<table width='100%'>
	<th><b>Time</th>
	<th><b>Act Desc</th>
	<th><b>Cont ID</th>
	<th><b>Dur</th>

<script>
var val = "<?php echo $QTime ?>";
document.getElementById("selQDate").value=val;
</script>

<?php
// List of past events
for($x = 0; $x < ($cnt-1); $x++) {
	echo "<tr><td width='20%'>".date_format($dtime[$x],"D m-d h:i A")."</td><td  width='22%'>".$data2[$x]."</td><td width='22%''>".$data3[$x] . "</td><td  width='16%' align='center'>" . gethours(getmins($data[$x], $data[$x+1])) . ":". DZero(getrmins(getmins($data[$x], $data[$x+1]), gethours(getmins($data[$x], $data[$x+1])))) .
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateEvent0.php?form=$form&selQDate=$QTime&selEvent=$data5[$x]'\" value=\"U\"</input>").
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../del/DelEvent.php?form=$form&selQDate=$QTime&tbl=$tbl&varSel=$varSel&selEvent=$data5[$x]'\" value=\"D\"</input>")."</td></tr>";
}

$QTime1 = date('Y-m-d');

if ($QTime == $QTime1){

// Ongoing event
for($x = ($cnt-1); $x < $cnt; $x++) {
	echo "<tr><td width='20%'>".date_format($dtime[$x],"D m-d h:i A")."</td><td width='22%'>".$data2[$x]."</td><td width='22%'>".$data3[$x] . "</td><td width='16%' align='center'>". gethours(lastmins($data[$x])) . ":". DZero(getrmins(lastmins($data[$x]),gethours(lastmins($data[$x])))) .
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateEvent0.php?form=$form&selQDate=$QTime&selEvent=$data5[$x]'\" value=\"U\"</input>").
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../del/DelEvent.php?form=$form&selQDate=$QTime&tbl=$tbl&varSel=$varSel&selEvent=$data5[$x]'\" value=\"D\"</input>")."</td></tr>";
}
}
mysqli_close($conn);
}
?>
</table>
</body>
</html>