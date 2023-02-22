<?php
header("Cache-Control: no-cache, must-revalidate");

include ('../function/Functions.php');

pconn();

$ProjID = $_GET['selProj'];
$PU = $_GET['selPU'];

$sql = "SELECT * FROM tblCont WHERE ProjID = '$ProjID' AND Active!='N' ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['ContID'];
	$data[1][] = $row['ContDesc'];
}

mysqli_close($conn);

$dref = "cont";

$nvar = "selCont";

$nref = "#act";

$btncnt=count($data[0]);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

?>

<script>

var data = <?php echo json_encode( $data ); ?>;

var btncnt=<?php echo $btncnt; ?>;

var dref= <?php echo json_encode ($dref); ?>;

var tref= "tbl"+dref;

var nvar= <?php echo json_encode ($nvar); ?>;

var nref= <?php echo json_encode ($nref); ?>;

var PU= <?php echo json_encode ($PU); ?>;

var rowcounter=1;

var rowbtns=4;

var rownum= Math.floor(btncnt/rowbtns);

var lrowbtns=(btncnt%rowbtns);

$('#'+dref).append("<table id="+tref+" width=100%>");

while (rowcounter<=rownum){

$("#"+tref).append("<tr id=r2"+rowcounter+">");

//$('#'+tref).append("<tr>");

var rowbtncounter=1;

while (rowbtncounter<=rowbtns){

	var a = ((rowcounter-1)* rowbtns) + (rowbtncounter-1);

	//alert(data[1][a]);

	$("#r2"+rowcounter). append(`<td><button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets2.php? selPU=` + PU + `&selCont=`+ data[0][a] + `', '#cont')" >` + data[1][a]  + `</button></td>`);

/*
$('#'+tref).append("<td>");

$('#'+tref).append(`<button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets2.php? selPU=` + PU + `&selCont=`+ data[0][a] + `', '#cont')" >` + data[1][a]  + `</button>`);

$('#'+tref).append("</td>");
*/

	rowbtncounter++;
}

$('#'+tref).append("</tr>");

rowcounter++;
}

if (lrowbtns!=0){

	//$('#'+tref).append("<tr>");

	$("#"+tref).append("<tr id=r2"+rowcounter+">");

	for (var i = 1; i <= lrowbtns; i++) {

		var a = ((rowcounter-1)* rowbtns) + (i-1);

		$("#r2"+rowcounter). append(`<td><button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets2.php? selPU=` + PU + `&selCont=`+ data[0][a] + `', '#cont')" >` + data[1][a]  + `</button></td>`);

/*
$('#'+tref).append("<td>");

$('#'+tref).append(`<button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets2.php? selPU=` + PU + `&selCont=`+ data[0][a] + `', '#cont')" >` + data[1][a]  + `</button>`);

$('#'+tref).append("</td>");
*/
	}

$('#'+tref).append("</tr>");
}

$('#'+tref).append("</table>");

$("#act").empty(); 
</script>