<?php
header("Cache-Control: no-cache, must-revalidate"); 
include("../function/Functions.php");
?>
<html>
<head>
<link rel="stylesheet" href="../../styles.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../function/JSFunctions.js"></script>

<script>
var LProj = JSON.parse(localStorage.getItem("LSProj"));

$("#proj").append("Hi"); 

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

</script>
</head>
<body>
<h1>New JQ Daily Eval</h1>
<?php include('../view/LinkTable.php');?>
<h2>Category</h2>

<div id='cat'>

<?php
pconn();

//GOAL ARRAYS

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-60 days');
$SQTime = date_format($SQTime,'Y-m-d');

$sql = "SELECT DISTINCT tblGoalOptions.GoalID, tblGoalOptions.Goal, tblGoalOptions.Active, tblNewDailyGoals.ContID, tblCont.ContDesc FROM tblGoalOptions INNER JOIN tblNewDailyGoals ON tblGoalOptions.GoalID = tblNewDailyGoals.Goal INNER JOIN tblCont ON tblNewDailyGoals.ContID = tblCont.ContID INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE tblGoalOptions.Active !=  'N' AND tblProj.ProjStatus != 'Closed' AND tblCont.Active != 'N' AND tblNewDailyGoals.GDate > '$SQTime' ORDER BY tblGoalOptions.Goal";

mysqli_close($conn);

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['GoalID'];
	$data[1][] = $row['Goal'];
}

$btncnt=count($data[0]);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;
?>

<script>

var data = <?php echo json_encode( $data ) ?>;

var btncnt=<?php echo $btncnt; ?>

var rowcounter=1;

var rowbtns=4;

var rownum= Math.floor(btncnt/rowbtns);

var lrowbtns=(btncnt%rowbtns);

$("#cat").append("<table id='ctbl' width=100%>");

while (rowcounter<=rownum){

$("#ctbl").append("<tr>");

var rowbtncounter=1;

while (rowbtncounter<=rowbtns){

var a = ((rowcounter-1)* rowbtns) + (rowbtncounter-1);

$("#ctbl").append("<td>");

$("#ctbl").append(`<button id=` + a + ` onclick="Loadbtn('../dev/JQdynbtnsets.php?' + 'selPU' + '=`+ data[0][a] + `', '#proj')" >` + data[1][a]  + `</button>`);

$("#ctbl").append("</td>");

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