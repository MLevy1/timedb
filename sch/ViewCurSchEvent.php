<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

pconn();

$tbl="tblSchedEvents";
$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']); 
$varSel="SESTime";

date_default_timezone_set('America/New_York');

if($selDate==null){
$selDate = date('Y-m-d');
}

$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");


$sql = "SELECT tblSchedEvents.SESTime, tblSchedEvents.SEActID, tblSchedEvents.SEContID, tblAct.ActDesc, tblCont.ContDesc FROM tblSchedEvents INNER JOIN tblCont ON (tblSchedEvents.SEContID= tblCont.ContID) INNER JOIN tblAct ON (tblSchedEvents.SEActID = tblAct.ActID) WHERE tblSchedEvents.SESTime <= '$NowTime' ORDER BY tblSchedEvents.SESTime DESC LIMIT 1";

$result = mysqli_query($conn, $sql);

$ndata = array();

while ($row = mysqli_fetch_array($result)) {
	$ndata[0][] = $row['SESTime'];
	$ndata[1][] = date_create($row['SESTime']);
	$ndata[2][] = $row['ActDesc'];
	$ndata[3][] = $row['ContDesc'];
	$ndata[4][] = $row['SEActID'];
	$ndata[5][] = $row['SEContID'];
}

$sql1 = "SELECT tblSchedEvents.SESTime, tblSchedEvents.SEActID, tblSchedEvents.SEContID, tblAct.ActDesc, tblCont.ContDesc FROM tblSchedEvents INNER JOIN tblCont ON (tblSchedEvents.SEContID= tblCont.ContID) INNER JOIN tblAct ON (tblSchedEvents.SEActID = tblAct.ActID) WHERE tblSchedEvents.SESTime > '$NowTime' ORDER BY tblSchedEvents.SESTime LIMIT 1";

$result1 = mysqli_query($conn, $sql1);

while ($row = mysqli_fetch_array($result1)) {
	$ndata[0][] = $row['SESTime'];
	$ndata[1][] = date_create($row['SESTime']);
	$ndata[2][] = $row['ActDesc'];
	$ndata[3][] = $row['ContDesc'];
	$ndata[4][] = $row['SEActID'];
	$ndata[5][] = $row['SEContID'];
}

$cnt1=count ($ndata[0]);

?>
<script>
function UpdateEvents(a, b)
{
    $.ajax({
        url: '../view/FooterEventQueries.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#vtest').html( data )
    })
    .fail(function() {
        $('#vtest').prepend('No Add: '+a+' '+b+' '+Date()+'<br>');
    });
}


function UpdateButtons1(a)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#buttons').html( data )
    })
    .fail(function() {
        $('#buttons').prepend('X');
    });
}

function UpdateDiv1()
{
    $.ajax({
        url: '../sch/ViewCurSchEvent.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
       	 $('#CSE').html( data )
    })
    .fail(function() {
        $('#CSE').prepend('X');
    });
}

function btnJQSchAdd(act, cont)
{	
	
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: cont,
		selTbl: 'tblEvents'
	});	
	setTimeout(function(){
		UpdateEvents();
        	UpdateDiv1();
		//UpdateButtons1('../btn/btnSetJDyn.php?selHrRange='+e);
        }, 500);
}
</script>
<table>
<?php
for($x = 0; $x < $cnt1; $x++) {
	echo "<tr><td>";
	
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQSchAdd('{$ndata[4][$x]}', '{$ndata[5][$x]}')\" value=\"+\"</input>");
	
	echo "</td><td><b>";
	
	echo date_format($ndata[1][$x],"h:i A");
	
	echo "</td><td><b>";
	echo $ndata[2][$x];
	echo "</td><td><b>";
	echo $ndata[3][$x];
	echo "</td></tr>";
}
mysqli_close($conn);
?>
</table>