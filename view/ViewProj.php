<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

pconn();

$I = $_REQUEST["I"];

if($I == 'y'){

$sql = "SELECT * FROM tblProj WHERE ProjStatus='Closed' ORDER BY ProjID";

}else{

$sql = "SELECT * FROM tblProj WHERE ProjStatus!='Closed' ORDER BY ProjID";

}

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['ProjID'];
	$data[1][] = $row['ProjDesc'];
	$data[2][] = $row['PCode'];
	$data[3][] = $row['ProjStatus'];
}

mysqli_close($conn);

$cnt= count ($data[0]);
?>
<table>
<tr>
	<th>Proj ID</th>
	<th>Proj Desc</th>
	<th>P Code</th>
<?php
for($x = 0; $x < ($cnt); $x++) {
        echo "<tr><td style='text-align:center'>".
        $data[0][$x].
        "</td><td style='text-align:left'>".
        $data[1][$x].
        "</td><td style='text-align:center'>".
        $data[2][$x].
        "</td><td>".
        ("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateProj.php?selProj={$data[0][$x]}'\" value=\"U\"</input>").
	"</td></tr>";
}
?>
</table>

<input type="button" class = "link" onclick="displayLProj()" value="Ref" />

<div id='demo'></div>

<script>

var proj = <?php echo json_encode( $data ) ?>;

var cnt = <?php echo json_encode( $cnt ) ?>;

localStorage.setItem("LSProj", JSON.stringify(proj));

var LProj = JSON.parse(localStorage.getItem("LSProj"));

var text, i;

function displayLProj()
{
		
	text = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		text += "<tr><td>" + "</td><td>" + LProj[0][i] + "</td><td>" + LProj[1][i] +"</td><td>" + LProj[2][i] + "</td></tr>";
	
	}
	
	text += "</table>";
	
	
document.getElementById("demo").innerHTML = text;
}
</script>