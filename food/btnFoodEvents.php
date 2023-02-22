<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

formid();

$tbl="tblFoodEvents";
$varSel="TimeStamp";

//sets the interval
$I = $_REQUEST["I"];


if($I==null){
	
	$I="A";

}

$SQTime = date_create(date('Y-m-d'));

if($I != "A"){

	$dm = '-'.$I.' days';

	date_modify($SQTime, $dm);

	$SQTime = date_format($SQTime,'Y-m-d');
	
		$sql = "SELECT tblFoodEvents.MTime, tblFoods.Food, tblFoodEvents.FoodID FROM tblFoodEvents INNER JOIN tblFoods ON (tblFoodEvents.FoodID=tblFoods.FoodID) WHERE date(MTime) >='$SQTime' GROUP BY  tblFoodEvents.FoodID ORDER BY tblFoods.Food";
	
}else{

	$sql = "SELECT tblFoodEvents.MTime, tblFoods.Food, tblFoodEvents.FoodID FROM tblFoodEvents INNER JOIN tblFoods ON (tblFoodEvents.FoodID=tblFoods.FoodID) GROUP BY  tblFoodEvents.FoodID ORDER BY tblFoods.Food";

}

$result = mysqli_query($conn, $sql);

$data = array();
$Reporting = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['FoodID'];
	$data[1][] = $row['Food'];
	
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

$("#tr"+rowcounter).append(`<td><button id=` + a + ` onclick="btnJQ1(`+ a + `)" >` + data[1][a] + `</button></td>`);

rowbtncounter++;
}

$("#btntbl").append("</tr>");

rowcounter++;
}

if (lrowbtns!=0){

$( "#btntbl" ).append("<tr id=tr"+rowcounter+">");

for (var i = 1; i <= lrowbtns; i++) {

var a = ((rowcounter-1)* rowbtns) + (i-1);

$("#tr"+rowcounter).append(`<td><button id=` + a + ` onclick="btnJQ1(`+ a + `)" >` + data[1][a] +`</button></td>`);
}

$("#btntbl").append("</tr>");

}

$("#btntbl").append("</table>");

</script>