<?php
header("Cache-Control: no-cache, must-revalidate"); 
include("../function/Functions.php");
?>
<html>
<head>
<link rel="stylesheet" href="../css/MobileStyle.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../function/JSFunctions.js"></script>

<script>
var LProj = JSON.parse(localStorage.getItem("LSProj"));

function Loadbtn(page, seldiv)
{
    $.ajax({
        url: page,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $(seldiv).html( data )
    })
    .fail(function() {
        $(seldiv).prepend('X');
    });
    
}

function btnJQ1(a) {

	alert(a);
	
}

function addProjbtn() {

    var pbtn = "<button onclick='addContbtn()'>Project</button>";
   
    $("#proj").empty(); 
    
    $("#proj").append(pbtn); 
    
}

function addContbtn() {

    var cbtn = "<button onclick='addActbtn()'>Sub-Project</button>";
   
    $("#cont").append(cbtn); 
}

function addActbtn() {

    var abtn = "<button onclick='addEventBtn()'>Activity</button>";
   
    $("#act").append(abtn); 
}

</script>
</head>
<body>
<h1>New JQ Event</h1>
<?php linktable(); ?>
<h2>Category</h2>

<div id='cat'>

<?php
pconn();

$sql = "SELECT DISTINCT tblAct.PCode, tblPUCodes.PUCodeDesc FROM tblAct INNER JOIN tblPUCodes ON tblAct.PCode=tblPUCodes.PUCode";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['PCode'];
	$data[1][] = $row['PUCodeDesc'];
}

mysqli_close($conn);

$btncnt=count($data[0]);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;
?>

<script>
$( document ).ready(function() {

var data = <?php echo json_encode( $data ) ?>;

var btncnt=<?php echo $btncnt; ?>

var rowcounter=1;

var rowbtns=4;

var rownum= Math.floor(btncnt/rowbtns);

var lrowbtns=(btncnt%rowbtns);

$("#cat").append("<table id='ctbl' width=100%>");

while (rowcounter<=rownum){

	$("#ctbl").append("<tr id=r"+rowcounter+">");

	var rowbtncounter=1;

	while (rowbtncounter<=rowbtns){

		var a = ((rowcounter-1)* rowbtns) + (rowbtncounter-1);

$("#r"+rowcounter).append(`<td><button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets.php?' + 'selPU' + '=`+ data[0][a] + `', '#proj')" >` + data[1][a]  + `</button></td>`);

		rowbtncounter++;
	}

	$("#ctbl").append("</tr>");
	
	rowcounter++;
}

if (lrowbtns!=0){

	$("#ctbl").append("<tr>");

	for (var i = 1; i <= lrowbtns; i++) {

		var a = ((rowcounter-1)* rowbtns) + (i-1);

	$("#ctbl").append("<td>");

	$("#ctbl").append(`<button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets.php?selPU=`+ data[0][a] + `','#proj')" >` + data[1][a]  + `</button>`);

	$("#ctbl").append("</td>");
}

$("#ctbl").append("</tr>");
}

$("#ctbl").append("</table>");

$("#cont").empty(); 

$("#act").empty(); 

});

</script>

</table>

</div>

<p id='test'></p>

<h2>Project</h2>

<div id='proj'></div>

<h2>Sub-Project</h2>

<div id='cont'></div>

<h2>Activity</h2>

<div id='act'></div>
<a href="javascript:UpdateEvents();">Update</a>
<div id="vtest">
<?php include ('../view/FooterEventQueries.php'); ?>
</div>

</body>
</html>