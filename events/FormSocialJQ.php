<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/Functions.php");

$form='../form/FormSocialJQ.php';
?>
<html>
<head>
	<title>Social</title>
	<link rel="stylesheet" href="../css/MobileStyle.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--
<script src="../function/JSFunctions.js"></script>
-->
</head>
<h1>Social</h1>
<?php 
linktable();

pconn();

$sql="SELECT * FROM tblAct WHERE PCode LIKE  '%S%' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);
?>

<!--
NEED TO FIGURE OUT HOW TO UPDATE BUTTONS WHENEVER SELECT IS CHANGED
-->


<select name='selAct' id='selAct'>
<option value='S01'>Social</option>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActDesc'] . "</option>";
}
mysqli_close($conn);
?>
</select>
<hr />

<table width=100%>

<?php
pconn();

$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE ProjStatus != 'Closed' 
AND PCode = 'S' 
AND Active != 'N'
ORDER BY tblCont.ContDesc";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$data[0][] = $row['ContID'];
	$data[1][] = $row['ContDesc'];
}

$btncnt=count($data[0]);
/*

FROM DYNJQ

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['ActID'];
    $data[1][] = $row['ProID'];
    $data[2][] = $row['ActDesc'] . "<br>" . $row['ContDesc'];
}


*/
?>

<script>

function UpdateEvents()
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
        $('#vtest').prepend('Error updating.');
    });
}

function btnJQSoc(a, b, c)
{	
	var act = $( "#selAct" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: b,
		selTbl: 'tblEvents'
	});
	setTimeout(function(){
        UpdateEvents();
        }, 100);
	$("button").css("background-color", "lightgray");
	$("#"+c).css("background-color", "pink");
}


</script>

<?php
$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

echo "<table width='100%'>";

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
    echo "<tr>";
    $rowbtncounter=1;

    while ($rowbtncounter<=$rowbtns){
        
        $act = $selAct;
        $cont = $data[0][$btncounter];
        $btnname = $data[1][$btncounter];
        
        echo "<td width='25%'>";
        
        socbtnjq($act, $cont, $btnname);
        
        echo "</td>";
        
        $btncounter++;
        $rowbtncounter++;
    }
    
echo "</tr>";
$rowcounter++;
}
}
if ($lrowbtns!=0){
    echo "<tr>";
    for ($i = 0; $i < $lrowbtns; $i++) {
    
        $act = "S01";
        $cont = $data[0][$btncounter];
        $btnname = $data[1][$btncounter];
        
        echo "<td width='25%'>";
        
        socbtnjq($act, $cont, $btnname);
        
        echo "</td>";
        
        $btncounter++;
    }
    echo "</tr>";
}
mysqli_close($conn);
echo "</table>";

/*

ORIG SOCIAL


$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
	echo "<tr>";
	$rowbtncounter=1;

	while ($rowbtncounter<=$rowbtns){
 		echo "<td>";
 		newbtn('selCont', $data[$btncounter], $data2 [$btncounter]);
 		echo "</td>";
 		$btncounter++;
		$rowbtncounter++;
	}
echo "</tr>";
$rowcounter++;
}
}
if ($lrowbtns!=0){
	echo "<tr>";
	for ($i = 0; $i < $lrowbtns; $i++) {
		echo "<td>";
		newbtn('selCont', $data[$btncounter], $data2 [$btncounter]);
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}

mysqli_close($conn);


*/

?>

<input type="hidden" name="form" value="<?php echo $form; ?>">

<a href="javascript:UpdateEvents();">Update</a>
<div id="vtest">
<?php include("../view/FooterEventQueries.php"); ?>
</div>

</body>
</html>