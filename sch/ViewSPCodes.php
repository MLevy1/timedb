<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />

<?php
include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');

$NowTime = date("Y-m-d H:i:s");

if($selDate==null){
$selDate = date('Y-m-d');
}

$data = array();

$sql = "SELECT tblSchedEvents.SESTime, tblAct.ActDesc, tblPUCodes.PUCode, tblPUCodes.PUCodeDesc 
FROM tblSchedEvents
INNER JOIN tblAct ON tblSchedEvents.SEActID = tblAct.ActID
INNER JOIN tblCont ON tblSchedEvents.SEContID = tblCont.ContID
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE date(tblSchedEvents.SEStime) ='$selDate' ORDER BY tblSchedEvents.SESTime";

$result = mysqli_query($conn, $sql);

$arrDur = array();
$arrHrs = array();
$arrMins = array();

while ($row = mysqli_fetch_array($result)) {
	
	$data[0][] = $row['SESTime'];
	$data[1][] = $row['PUCodeDesc'];

}

$cnt = count ($data[0]);

for($x = 0; $x < ($cnt-1); $x++) {
	
	$data[2][] = getmins($data[0][$x], $data[0][$x+1]);
	
}

for($x = ($cnt-1); $x < $cnt; $x++) {
	
	$data[2][] = plastmins($data[0][$x], $selDate);
	
}

?>
<table>
	<th>UCode</th>
	<th>Time</th>
<?php

$arrTest = array();

$clear = 'TRUNCATE TABLE tblTest';

mysqli_query($conn, $clear);

    $query = "INSERT INTO tblTest (`col1`, `col2`) VALUES ";

 	for($x=0; $x<($cnt); $x++){
 		$arrTest[] = "('" . $data[1][$x] . "', '" . $data[2][$x] . "')";
}

$sql = $query .= implode(',', $arrTest);

mysqli_query($conn, $sql);

$sumq = 'SELECT col1, Color, SUM(col2) AS scol FROM tblTest 
INNER JOIN tblPUCodes 
ON (tblTest.col1 = tblPUCodes.PUCodeDesc)
WHERE col1!="Untracked Time" GROUP BY col1 ORDER BY scol DESC';

$col1 = array();
$col2 = array();
$col3 = array();
$colHr = array();
$colMn = array();

$result = mysqli_query($conn, $sumq);

while ($row = mysqli_fetch_array($result)) {
	$col1[] = $row['col1'];
	$col2[] = $row['scol'];
	$col3[] = $row['Color'];
}

$cnt=count ($col1);

for($x = 0; $x < $cnt; $x++) {
	$colHr[] = gethours($col2[$x]);
	$colMn[] = getrmins($col2[$x], $colHr[$x]);
}


for($x = 0; $x < $cnt; $x++) {
	echo "<tr><td class='xlcol'>".$col1[$x]."</td><td class='doublecol'>".DZero($colHr[$x]).":".DZero($colMn[$x])."</td></tr>";
}

mysqli_query($conn, $clear);

mysqli_close($conn);
?>
</table>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'PCode');
        data.addColumn('number', 'Pct');
        data.addRows([
        <?php
        for($x = 0; $x < ($cnt); $x++) {
        	echo "['".$col1[$x]."', ".$col2[$x]."], ";
        }
       
       ?>
          
        ]);

        // Set chart options
        var options = {
                       width: 300,
                       height: 300,
                       colors:
                           <?php
    	echo "['";
        for($x = 0; $x < ($cnt-1); $x++) {
        	echo $col3[$x]."', '";
        }
      
       echo $col3[$cnt-1];
       echo "'],";
       ?>
                       
                       legend: {position: 'none'}};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
