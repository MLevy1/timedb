<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php

include('../function/Functions.php');

linktable();

pconn();

formid();

setQTime();
?>

<h1>Multi Update</h1>

<table width='100%'>

    <tr><td><b>Start Date</b></td><td>

		<p><input type="date" id='selSDate' name='selSDate'></p>

    </td><td><b>End Date</b></td><td>

    	<p><input type="date" id='selEDate' name='selEDate'></p>

    </td></tr>
    
    <tr><td><b>Min Hour</b></td><td>

		<select id='selMinH' name='selMinH' class='smselect'>

			<option value=0>All</option>
			<option value=0>12 AM</option>
			<option value=1>1 AM</option>
			<option value=2>2 AM</option>
			<option value=3>3 AM</option>
			<option value=4>4 AM</option>
			<option value=5>5 AM</option>
			<option value=6>6 AM</option>
			<option value=7>7 AM</option>
			<option value=8>8 AM</option>
			<option value=9>9 AM</option>
			<option value=10>10 AM</option>
			<option value=11>11 AM</option>
			<option value=12>12 PM</option>
			<option value=13>1 PM</option>
			<option value=14>2 PM</option>
			<option value=15>3 PM</option>
			<option value=16>4 PM</option>
			<option value=17>5 PM</option>
			<option value=18>6 PM</option>
			<option value=19>7 PM</option>
			<option value=20>8 PM</option>
			<option value=21>9 PM</option>
			<option value=22>10 PM</option>
			<option value=23>11 PM</option>
			<option value=24>12 AM</option>

		</select>

    </td><td><b>Max Hour</b></td><td>

		<select id='selMaxH' name='selMaxH' class='smselect'>

			<option value=24>All</option>
			<option value=0>12 AM</option>
			<option value=1>1 AM</option>
			<option value=2>2 AM</option>
			<option value=3>3 AM</option>
			<option value=4>4 AM</option>
			<option value=5>5 AM</option>
			<option value=6>6 AM</option>
			<option value=7>7 AM</option>
			<option value=8>8 AM</option>
			<option value=9>9 AM</option>
			<option value=10>10 AM</option>
			<option value=11>11 AM</option>
			<option value=12>12 PM</option>
			<option value=13>1 PM</option>
			<option value=14>2 PM</option>
			<option value=15>3 PM</option>
			<option value=16>4 PM</option>
			<option value=17>5 PM</option>
			<option value=18>6 PM</option>
			<option value=19>7 PM</option>
			<option value=20>8 PM</option>
			<option value=21>9 PM</option>
			<option value=22>10 PM</option>
			<option value=23>11 PM</option>
			<option value=24>12 AM</option>

		</select>

    </td></tr>
    
    <tr><td><b>Activity</b></td><td>

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

    </td><td><b>New Act</b></td>
	
	<td>
	
		<select id='newAct' name='newAct' class='smselect'>

			<option value='No'>No Change</option>

				<?php

				$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActDesc";

				$result = mysqli_query($conn, $sql);

				while($row = mysqli_fetch_assoc($result)) {
					echo "<option value='" . $row['ActID'] . "'>" .$row['ActDesc'] . "</option>";
				}

				mysqli_free_result($result);

				?>

		</select>
	
	</td></tr>

	</td></tr><tr>

	<td><b>Sub-Project</b></td><td>

		<select id='selCont' class='smselect' name='selCont'>

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

	</td> <td><b>New Sub-Project</b></td><td>

		<select id='newCont' class='smselect' name='newCont'>

			<option value='No'>No Change</option>

				<?php

				$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE Active!='N' AND ProjStatus != 'Closed' ORDER BY ContDesc";

				$result = mysqli_query($conn, $sql);

				while($row = mysqli_fetch_assoc($result)) {
				    echo "<option value='" . $row['ContID'] . "'>" .$row['ProjDesc'] . " - " .$row['ContDesc'] . "</option>";
				}

				mysqli_free_result($result);
				mysqli_close($conn);
				?>

		</select>

	</td> </tr>

<tr><td></td>

<td> 

<input type="button" value="View" onclick="ViewME()"/> </td>
<td></td>
<td> <input type="button" value="Update" onclick="updateEvents()"/> </td> </td>
</tr>

</table>

<p id="test"></p>

<div id="tbl"></div>

<script>

 function ViewME()
{

var selSDate = $( "#selSDate" ).val();
var selEDate = $( "#selEDate" ).val();
var selAct = $( "#selAct" ).val();
var selProj = $( "#selProj" ).val();
var selCont = $( "#selCont" ).val();
var selMinH = $( "#selMinH" ).val();
var selMaxH = $( "#selMaxH" ).val();

var link = "../events/ViewMultiEvents.php?link=1&selAct="+selAct+"&selCont="+ selCont + "&selSDate=" + selSDate + "&selEDate=" + selEDate + "&selMinH="+ selMinH + "&selMaxH=" + selMaxH;

$( "#tbl" ).load(link);

}


function updateEvents(){

var result = confirm("Update Events?");

if (result == true) {

var oldAct = $( "#selAct" ).val();
var oldCont = $( "#selCont" ).val();
var newAct = $( "#newAct" ).val();
var newCont = $( "#newCont" ).val();
var selSDate = $( "#selSDate" ).val();
var selEDate = $( "#selEDate" ).val();
var selMinH = $( "#selMinH" ).val();
var selMaxH = $( "#selMaxH" ).val();

	$.post("../events/UpdateMultiEventJQ.php",
	{
		v1: newAct,
		v2: newCont,
		v3: oldAct,
		v4: oldCont,
		v5: selSDate,
		v6: selEDate,
		v7: selMinH,
		v8: selMaxH
	});
	
	
	setTimeout(function(){
        ViewME();
        }, 100);
	

	var link = "../events/UpdateMultiEventJQ.php"

	$( "#tbl" ).load(link);

}
	
}
</script>