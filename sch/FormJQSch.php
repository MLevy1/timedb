<head>
<link href="styles.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="./css/jquery-ui.css" />

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

$QDate = $_GET["selDate"] ?? date('Y-m-d');
$QTime = $_GET["selTime"] ?? date('H:i');
$T1 = $QDate.'T'.$QTime;
//2/23/23 Move Functions to top
?>

<script>
var val = "<?php echo $T1 ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;

$(function () {
     $('#seconds').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#minutes').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#minutes').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#selDurM').spinner({
         spin: function (event, ui) {
             if (ui.value >= 60) {
                 $(this).spinner('value', ui.value - 60);
                 $('#hours').spinner('stepUp');
                 return false;
             } else if (ui.value < 0) {
                 $(this).spinner('value', ui.value + 60);
                 $('#hours').spinner('stepDown');
                 return false;
             }
         }
     });
     $('#selDurH').spinner({
         min: 0});
 });
</script>
</head>

<body>

<script src="./sch/schScripts.js"></script>

<h1>Schedule</h1>

<table>
	<tr>
		<td>
			<input onblur="blurfunct()" name="selDT" id="selDT" type=datetime-local>
		</td>
		<td >
			<input type="button" class= "link"  onclick="location.href='../sch/FormAutoSch.php';" value="Auto" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(5)" value="+05M" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(15)" value="+15M" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(30)" value="+30M" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(60)" value="+01H" />
	</tr>
	<tr>
		<td>
 			<p>
    			<input id="selDurH" name="value" value=0 size=3/>
    			<input id="selDurM" name="value" value=0  size=3/>
			</p>
		</td>
		<td>
			<input type="button" class = "link" onclick="AddSEvent()" value="Sch Event" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(-5)" value="-05M" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(-15)" value="-15M" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(-30)" value="-30M" />
		</td>
		<td>
			<input type="button" class = "link" onclick="AddTime(-60)" value="-01H" />
		</td>
	</tr>
</table>

<?php
include ("./sch/btnSetJQSch.php");
?>

<h1>Dynamic</h1>
<div id ="buttons">
<?php
include ("./sch/btnSetJQDSch.php");
?>
</div>
<h1>Manual</h1>
<table>
<tr><td>
<?php
include("./function/DBConn.php");

$sql = "SELECT * FROM tblAct WHERE Status != 'Inactive' ORDER BY ActDesc";
$result = $conn->query($sql);

echo "<select id='selAct' name='selAct'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActDesc'] . "</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<?php
include("./function/DBConn.php");

$sql = "SELECT tblCont.ContID, tblCont.ContDesc FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE tblProj.Projstatus != 'Closed' AND tblCont.Active!='N' ORDER BY ContID";
$result = $conn->query($sql);

echo "<select id='selCont' name='selCont'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" . $row['ContID'] . " " . $row['ContDesc'] ."</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<input type="button" class = "link" onclick="AddManual()" value="Add" />
</td></tr>
<tr><td>
<input type="button" class = "link" onclick="UpdateSch()" value="Update" />
</td></tr>
<tr><td>
<input type="button" class = "link" onclick="UpdateVar()" value="Var" />
</td></tr>
</table>
</form>

<div id="sched2">

</div>

<div id="sched">
<?php include("./sch/SFooterEventQueries.php"); ?>
</div>


</body>
</html>