<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

/*

DISPLAY MIN MAX AND CHANGES FROM

SHOW GAIN LOSS 30 DAYS ETC

*/

pconn();

formid();

$tbl="tblWeight";
$varSel="wDateTime";

//sets the interval
$I = $_REQUEST["I"];

//sets the grouping structure 
$A = $_REQUEST["A"];

//sets the end date
$E = $_REQUEST["E"]; 

//min, avg, max, etc.

if($I==null){
	
	$I=365;

}

if($A==null){

	$A="A";

}

if($E==null){

	$SQTime = date_create(date('Y-m-d'));
	$N = "Y";
	
}else{

	$ETime = $SQTime = date_create($E);
	$N = "N";
	$ETime = date_format($ETime,'Y-m-d');

}

$IA = $I.$A.$N;

if($I != "A"){

	$dm = '-'.$I.' days';

	date_modify($SQTime, $dm);

	$SQTime = date_format($SQTime,'Y-m-d');
	
	if($N == "Y"){
	
	switch($A){
	
		case "A":
		
			$sql = "SELECT wDateTime, Weight AS dispW FROM tblWeight WHERE date(wDateTime) >='$SQTime' ORDER BY wDateTime DESC";
		
			break;
		
		case "L":
			
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, MIN(Weight) AS dispW FROM tblWeight WHERE date(wDateTime) >='$SQTime' GROUP BY D ORDER BY wDateTime DESC";
		
			break;
		
		case "M":
			
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, AVG(Weight) AS dispW FROM tblWeight WHERE date(wDateTime) >='$SQTime' GROUP BY D ORDER BY wDateTime DESC";
			
			break;
	
		case "H":
		
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, MAX(Weight) AS dispW FROM tblWeight WHERE date(wDateTime) >='$SQTime' GROUP BY D ORDER BY wDateTime DESC";
		
			break;
	}
	//closes switch
	
	}else{
	
		switch($A){
	
		case "A":
		
			$sql = "SELECT wDateTime, Weight AS dispW FROM tblWeight WHERE date(wDateTime) BETWEEN '$SQTime' AND '$ETime' ORDER BY wDateTime DESC";
		
			break;
		
		case "L":
			
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, MIN(Weight) AS dispW FROM tblWeight WHERE date(wDateTime) BETWEEN '$SQTime' AND '$ETime' GROUP BY D ORDER BY wDateTime DESC";
		
			break;
		
		case "M":
			
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, AVG(Weight) AS dispW FROM tblWeight WHERE date(wDateTime) BETWEEN '$SQTime' AND '$ETime' GROUP BY D ORDER BY wDateTime DESC";
			
			break;
	
		case "H":
		
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, MAX(Weight) AS dispW FROM tblWeight WHERE date(wDateTime) BETWEEN '$SQTime' AND '$ETime' GROUP BY D ORDER BY wDateTime DESC";
		
			break;
	}
	//closes switch
		
	}
	//closes N condition
}else{
//executed when the all interval is selected

	if($N == "Y"){
	
	switch($A){
	
		case "A":

			$sql = "SELECT wDateTime, Weight AS dispW FROM tblWeight ORDER BY wDateTime DESC";
			
			break;
		
		case "L":
		
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, MIN(Weight) AS dispW FROM tblWeight GROUP BY D ORDER BY wDateTime DESC";
			
			break;
			
		case "M":
		
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, AVG(Weight) AS dispW FROM tblWeight GROUP BY D ORDER BY wDateTime DESC";
			
			break;
			
		case "H":
		
			$sql = "SELECT DATE(wDateTime) AS D, wDateTime, MAX(Weight) AS dispW FROM tblWeight GROUP BY D ORDER BY wDateTime DESC";
		
			break;
	}
	//closes switch
	
	}else{
	
	//runs if date is selected
	
		echo "DATE!!!!!";
		//echo $SQTime;
		echo "<br>";
		echo $ETime;
	
	}
	//closes N condition
}
//closes block that is executed when the all interval is selected

$result = mysqli_query($conn, $sql);

$data = array();

$Reporting = array();

$LSArr = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['wDateTime'];
	$LSArr[0][] = $row['wDateTime'];
	
	$data[1][] = date_create($row['wDateTime']);
	
	$data[2][] = ROUND($row['dispW'],1);
	$LSArr[1][] = ROUND($row['dispW'],1);
	
	$data[3][] = substr(date_format(date_create($row['wDateTime']), 'c'),0,19);
	$LSArr[2][] = substr(date_format(date_create($row['wDateTime']), 'c'),0,19);
}

mysqli_close($conn);

$cnt=count($data[0]);

$SW = $data[2][0];

$Reporting[0][]="Date / Time";
$Reporting[1][]="Weight";
$Reporting[2][]="Date / Time";

?>
<div id="line_chart" style="width: 900px; height: 500px"></div>
<table width='100%'>
	<th><b>Time</th>
	<th><b>Weight</th>
	<th><b>Change</th>
<?php
for($x = 0; $x < $cnt; $x++) {

	$Reporting[0][]= date_format($data[1][$x], 'U')/(24*60*60) - date_format($data[1][0], 'U')/(24*60*60);
	
	$Reporting[1][]= $data[2][$x];
	
	$Reporting[2][]= 
	"new Date(". 
	date_format($data[1][$x], 'Y') . 
	", " . 
	(date_format($data[1][$x], 'n') -1) . 
	", " . 
	date_format($data[1][$x], 'j') . 
	", " . 
	date_format($data[1][$x], 'G') . 
	", " . 
	number_format(date_format($data[1][$x], 'i')) . 
	")";

		$Reporting[3][]= number_format(date_format($data[1][$x], 'r'));
		
		
if($x<10000){
	echo "<tr>";
	echo "<td>";
	
	echo date_format($data[1][$x], 'D y-m-d h:i:s A');
	
	echo "</td>";
	echo "<td style='text-align:center'>";
	echo $data[2][$x];
	
	if($x<($cnt-1)){
	
		echo "</td><td style='text-align:center'>";
		echo round(($data[2][$x]-$data[2][$x+1]),1);
		
	}else{
	
		echo "</td><td>";
		echo "N/A";
	}
	
	echo "</td><td>";
	echo ("<input type=\"button\" class=\"link\" onclick=\"btnJQDelE('{$data[0][$x]}', '$varSel', '$tbl')\" value=\"D\"</input>");
	
	echo "</td></tr>";
}
	$CTrows = (count($Reporting[0])-1);

}
?>
</table>


<input type="button" class = "link" onclick="displayLWgt()" value="Ref" />
<div id='ListDiv'></div>

<script>
//Removes existing local storage item
localStorage.removeItem("LSWgt");

//Resets JS array
LWgt = [];

//Pulls contents of the php array into a JS array
var arrJSL = <?php echo json_encode( $LSArr ) ?>;

//Pulls the counter variable from PHP to JS
var cnt = <?php echo json_encode( $cnt ) ?>;

//Sets the Local Storage item to the contents of the JS array

localStorage.setItem("LSWgt", JSON.stringify(arrJSL));

//Pulls the contents of the newly created local storage object into a new JS variable

var LWgt = JSON.parse(localStorage.getItem("LSWgt"));

//Declares variables for storing the text string that will be used to display the contents of the local storage object and the counter for the loop

var WList, i;

//displays the contents of the local storage object on the current page

function displayLWgt()
{
	
	WList = "<table>";
	
	for (i = 0; i < cnt; i++) {
		
		WList += "<tr><td>" + LWgt[0][i] + "</td><td>" + LWgt[2][i] +"</td><td>" + LWgt[3][i] +"</td></tr>";
	
	}
	
	WList += "</table>";

document.getElementById("ListDiv").innerHTML = WList;

}
</script>


<pre>
</pre>

<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		
		<?php
	echo '[';
	echo "'" . $Reporting[2][0]. "', ";
	echo "'" . $Reporting[1][0]. "'";
	echo '],';
	
for( $i=1;$i<$CTrows;$i++) {
	echo '[';
	echo $Reporting[2][$i] . ", ";
	echo $Reporting[1][$i];
	echo '],';
	}
	
echo '[';
echo $Reporting[2][$i] . ", ";
echo $Reporting[1][$i];
echo '],';

        ?>	
		]);

		var options = {
			
			trendlines: { 
				0: {
					type: 'linear',
					showR2: true,
					visibleInLegend: true
					} 
				} 
			
		};

		var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

		chart.draw(data, options);
	}
</script>