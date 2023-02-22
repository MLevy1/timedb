<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.each demo</title>
  <style>
  div {
    color: blue;
  }
  div#five {
    color: red;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  
  <!--START -->
  
  
  <?php
include("../function/Functions.php");

pconn();

date_default_timezone_set('America/New_York');

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

$MinHr = $NowHr - 1;
$MaxHr = $NowHr + 1;

$sql = "SELECT EXTRACT( HOUR FROM tblEvents.STime ) AS EventHr,
    WEEKDAY(tblEvents.STime) AS EventDay,
    IF(WEEKDAY(tblEvents.STime)>4,0,1) AS WKI,
    tblEvents.ActID,
    tblEvents.ProID,
    tblAct.ActDesc,
    tblCont.ContDesc,
    COUNT( * ) AS cnt
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
    GROUP BY tblAct.ActID, tblCont.ContID
    ORDER By tblAct.ActDesc,  tblCont.ContID";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $data1a[] = $row['ActDesc'];
    $data2a[] = $row['ContDesc'];
    $data3a[] = $row['cnt'];
    $data4a[] = $row['ActID'];
    $data5a[] = $row['ProID'];
    $data6a[] = $row['ActID'] . "_" . $row['ProID'];
}

$btncnt=count($data1a);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

?>
<!-- END -->
  
</head>
<body>
 
 <?php
 for ($i = 0; $i < $btncnt; $i++) {
echo "<div id=".$i."></div>";
 }
 ?>
<script>

var c = <?php echo $btncnt; ?>;

var act = <?php echo '["' . implode ('", "' , $data4a) . '"]' ?>;

var cont = <?php echo '["' . implode ('", "' , $data5a) . '"]' ?>;

var AC = <?php echo '["' . 
implode ('", "' , $data6a) . 
'"]' ?>;

a=0;

var arr = [ "one", "two", "three", "four", "five" ];

/*
jQuery.each( AC, function( i, val ) {
  //$( "#" + i ).text( val.substr(4) );
  btnAct = val.substr(0, 3);
  $( "#" + i ).text( btnAct );
});
*/

jQuery.each( AC, function( i, val ) {

$("#btn"+i).click(function(){
	btnAct = val.substr(0, 3);
	btnCont = val.substr(4);
	$.post("jquery_post1.php",
		{
			selAct: btnAct,
			selCont: btnCont
		});
		UpdateEvents();
	});
}

</script>

 <?php
for ($i = 0; $i < $btncnt; $i++) {
	
	//echo '<button id="btn'.$i.'">' . $data1a[$i] . ' '. $data2a[$i] . '</button>';

echo '<button id="btn' . $i . '">'.$data1a[$i] . ' '. $data2a[$i] . '</button>';

	echo $i;
}
?>

<div id="vtest">
<?php include ('ViewTest3.php'); ?>
</div>
<script>
function UpdateEvents()
{
    $.ajax({
        url: 'ViewTest3.php',
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
        $('#vtest').html( data );
    })
    .fail(function() {
        $('#vtest').prepend('Error updating.');
    });
}
</script>



</body>
</html>
