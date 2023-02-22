<?php
header("Cache-Control: no-cache, must-revalidate");

include ('../function/Functions.php');

pconn();

$cont = $_GET['selCont'];
$PU = $_GET['selPU'];

$sql = "SELECT * FROM tblAct WHERE PCode LIKE '%$PU%' AND Status != 'Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['ActID'];
	$data[1][] = $row['ActDesc'];
}

mysqli_close($conn);

$dref = "act";

$btncnt=count($data[0]);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

?>

<script>

function JQPost(act, cont)
{
    $.post("../add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        selTbl: 'tblEvents'
    });
    
    $("#proj").empty(); 
    $("#cont").empty(); 
    $("#act").empty(); 
    
    UpdateEvents();
    
}

var data = <?php echo json_encode( $data ); ?>;

var btncnt=<?php echo $btncnt; ?>;

var dref= <?php echo json_encode ($dref); ?>;

var cont= <?php echo json_encode ($cont); ?>;

var tref= "tbl"+dref;

var rowcounter=1;

var rowbtns=4;

var rownum= Math.floor(btncnt/rowbtns);

var lrowbtns=(btncnt%rowbtns);

$('#'+dref).append("<table id="+tref+" width=100%>");

while (rowcounter<=rownum){

	$("#"+tref).append("<tr id=r3"+rowcounter+">");

	var rowbtncounter=1;

	while (rowbtncounter<=rowbtns){

		var a = ((rowcounter-1)* rowbtns) + (rowbtncounter-1);
		
		$("#r3"+rowcounter). append(`<td><button id=` + a + ` onclick="JQPost('`+ data[0][a] + `','` + cont + `')" >` + data[1][a] + `</button></td>`);

		rowbtncounter++;
	}

$('#'+tref).append("</tr>");

rowcounter++;
}

if (lrowbtns!=0){

$("#"+tref).append("<tr id=r3"+rowcounter+">");

for (var i = 1; i <= lrowbtns; i++) {

var a = ((rowcounter-1)* rowbtns) + (i-1);

		$("#r3"+rowcounter). append(`<td><button id=` + a + ` onclick="JQPost('`+ data[0][a] + `','` + cont + `')" >` + data[1][a] + `</button></td>`);

}

$('#'+tref).append("</tr>");
}

$('#'+tref).append("</table>");
</script>