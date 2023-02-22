<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

pconn();

setQTime();

$QT1 = date( "Y-m-d", strtotime( "$QTime -90 days" ) );

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE date(tblEvents.STime) >='$QT1' ORDER BY Stime DESC";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = date_create($row['STime']);
	
	$data[1][] = $row['ActDesc'];
	
	$data[2][] = $row['ActID'];
	
	$data[3][] = $row['ProID'];
}


mysqli_close($conn);

$cnt= count ($data[2]);
?>
<button onclick="displayLE2()">Ref</button>
<table width='100%'>
	<th>tmv</th>
	<th>act</th>
	<th>cont</th>
	<th>A2</th>
	<th>'N'</th>
	<th>tmt</th>
	<th>ft</th>

<?php
for($x = 0; $x < $cnt; $x++) {
	echo "<tr>";
	
	echo "<td>";
	
	echo substr(date_format($data[0][$x], 'c'), 0, 19);
	
	echo "</td><td>";
	
	echo $data[2][$x];
	
	echo "</td><td>";
	
	echo $data[3][$x];
	
	echo "</td><td>";
	
	echo $data[1][$x];
	
	echo "</td><td>";
	
	echo "N";
	
	echo "</td><td>";
	
	echo substr(date_format($data[0][$x], 'm-d h:i:s A'), 0, 19);
	
	echo "</td><td>";
	
	echo date_format($data[0][$x], 'U')*1000;
	
	echo "</td>";
	
	echo "</tr>";
}

/*

**LS FORMAT**

tmv, act, cont, A2, 'N', tmt, ft

tmv: NDTime
act: actID => $data[5]
cont: contID => $data[6]
A2: bname => ActDesc => $data[2]
tmt: ShTime
ft: FT

arrTime = [NDTime, FT, ShTime];

NDTime= Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + Sec;
2020-09-09T03:14:22
Y-m-dTH:i:s

ShTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + Sec + ' ' + AP
09-09 03:14:22 AM
m-d h:i:s A

FT = m.getTime();
U*1000

1599635662526
1599634667
*/

?>
</table>
<div id="ListDiv">
<script>
//Removes existing local storage item
localStorage.removeItem("LSEvent2");

//Resets JS array
LEvent2 = [];

//Pulls contents of the php array into a JS array
var arrJSL = <?php echo json_encode( $data ) ?>;

//Pulls the counter variable from PHP to JS
var cnt = <?php echo json_encode( $cnt ) ?>;

//Sets the Local Storage item to the contents of the JS array

localStorage.setItem("LSEvent2");", JSON.stringify(arrJSL));

//Pulls the contents of the newly created local storage object into a new JS variable

var LEvent2 = JSON.parse(localStorage.getItem("LSEvent2"));

//Declares variables for storing the text string that will be used to display the contents of the local storage object and the counter for the loop

var EList2, i;

//displays the contents of the local storage object on the current page

function displayLE2()
{
	/*
	EList2 = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		EList2 += "<tr><td>" + LEvent2[0][i] + "</td><td>" + LEvent2[2][i] +"</td><td>" + LEvent2[3][i] +"</td></tr>";
	
	}
	
	EList2 += "</table>";

document.getElementById("ListDiv").innerHTML = EList2;
 */
alert(1);
}
</script>