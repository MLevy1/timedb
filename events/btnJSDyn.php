<?php
header("Cache-Control: no-cache, must-revalidate");

include("../function/Functions.php");

pconn();

setQTime();

date_default_timezone_set('America/New_York');

$data = array();

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-21 days');
$SQTime = date_format($SQTime,'Y-m-d');

$NowHr = date("G");
$NowD1 = date("N");

If($NowD1<6){
	$NowD = 1;
}
else{
	$NowD = 0;
}

$MinHr = $NowHr - 6;
$MaxHr = $NowHr + 6;

$s2 = "SELECT MAX(STime) AS MT, CONCAT (ActID, ProID) AS Combo FROM tblEvents GROUP BY Combo ORDER BY MT DESC";

$sql = "SELECT 

tblEvents.ActID,

tblEvents.ProID,

tblAct.ActDesc,

tblCont.ContDesc,

CONCAT (tblAct.ActDesc, tblCont.ContDesc) AS Combo,

CONCAT (tblAct.ActID, tblCont.ContID) AS cmb,

MAX(tblEvents.STime) AS STime

FROM tblEvents

INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID

INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID

INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID

WHERE tblProj.ProjStatus !=  'Closed'
    
AND DATE( tblEvents.STime ) >=  '$SQTime'

AND tblAct.Status !=  'Inactive'

AND tblCont.Active != 'N'

AND EXTRACT( HOUR FROM tblEvents.STime ) BETWEEN $MinHr AND $MaxHr

AND (IF(WEEKDAY(tblEvents.STime)>4,0,1) = $NowD)

GROUP BY Combo

ORDER BY Combo
";


$r2 = mysqli_query($conn, $s2);

while ($row = mysqli_fetch_array($r2)) {
	$da[$row['Combo']] = ELTime(getsecs($row['MT'], $NowTime));

}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['ActID'];
    $data[1][] = $row['ProID'];
    $data[2][] = $row['ActDesc'];
    $data[3][] = $row['ContDesc'];
    $data[4][] = $row['STime'];
    $data[5][] = $da[$row['cmb']];

}

mysqli_close($conn);

$btncnt=count($data[0]);

?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<table id="btntbl" width=100%>

<script>

var data = <?php echo json_encode( $data ) ?>;

var btncnt=<?php echo $btncnt; ?>

var rowcounter=1;

var rowbtns=4;

var rownum= Math.floor(btncnt/rowbtns);

var lrowbtns=(btncnt%rowbtns);

while (rowcounter<=rownum){

$( "#btntbl" ).append("<tr id=tr"+rowcounter+">");

var rowbtncounter=1;

while (rowbtncounter<=rowbtns){

var a = ((rowcounter-1)* rowbtns) + (rowbtncounter-1);

$("#tr"+rowcounter).append(`<td><button id=` + a + ` onclick="btnJQ1(`+ a + `)" >` + data[2][a] +`<br>`+ data[3][a] + `<br>` + data[5][a]+`</button></td>`);

rowbtncounter++;
}

$("#btntbl").append("</tr>");

rowcounter++;
}

if (lrowbtns!=0){

$( "#btntbl" ).append("<tr id=tr"+rowcounter+">");

for (var i = 1; i <= lrowbtns; i++) {

var a = ((rowcounter-1)* rowbtns) + (i-1);

$("#tr"+rowcounter).append(`<td><button id=` + a + ` onclick="btnJQ1(`+ a + `)" >` + data[2][a] +`<br>`+ data[3][a] + `<br>` + data[5][a]+`</button></td>`);
}

$("#btntbl").append("</tr>");

}

$("#btntbl").append("</table>");

</script>