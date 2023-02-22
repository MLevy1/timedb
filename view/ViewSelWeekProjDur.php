<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../css/MobileStyle.css" />
<h1>Weekly Timesheet</h1>

<?php
include('../function/Functions.php');
include('../function/SqlList.php');
include('../view/LinkTable.php');

//connect to sql db
pconn();
formid();

//DATE PICKER

//Run week picker query
$result = mysqli_query($conn, $sqlWeekPick);
$result1 = mysqli_query($conn, $sqlThisWeek);


while($row = mysqli_fetch_assoc($result1)) {
	$arrResult1[]=$row['QDate'];
}
?>
<form method='get' action='ViewSelWeekProjDur.php'>

<table>
    <tr>
        <td><b>Start Date</b></td>
        <td>
            <select name='selSDate' id='selSDate' class='smselect'>
                <?php
                
                //Loop through query results to populate date picker
                while($row = mysqli_fetch_assoc($result)) {
    	           echo "<option value='" . $row['QDate'] . "'>" . $row['QDate']  . "</option>";
                }

                //Free $result variable
                mysqli_free_result($result);

                ?>

            </select>
        </td>
        <td>
            <select name='selPType' id='selPType' class='smselect'>
                <option value='A'>All</option>
                <option value='W'>Work</option>
            </select>
        <td><input type="submit" /></td>
    </tr>
</table>

</form>

<!--END DATE PICKER-->

<!--START GET DATES-->
<?php

echo date_format($SDate,"Y-m-d");

$PType = $_GET["selPType"];

//Get and format previously selected Start Date
$SDate1 = $_GET["selSDate"];

//Set pickers to default values if blank
if ($SDate1 == NULL) {

   $SDate1 = $arrResult1[0];
   $SDate2 = date_create($SDate1);
    
    $SDY = date_format($SDate2,"Y");
    $SDM = date_format($SDate2,"m");
    $SDD = date_format($SDate2,"d");
}

$SDate = date_create($SDate1);

$SDY = date_format($SDate,"Y");
$SDM = date_format($SDate,"m");
$SDD = date_format($SDate,"d");

$SDate = date_format($SDate,"Y-m-d");

//Create variable to hold end date and end date+1
$EDate1 = date_create($SDate1);
date_add($EDate1, date_interval_create_from_date_string("6 days"));
$EDate1 = date_format($EDate1,"Y-m-d");

$EDate = date_create($EDate1);
$EDate = date_format($EDate,"Y-m-d");

$EDate2 = date_create($EDate1);
date_add($EDate2, date_interval_create_from_date_string("1 day"));
$EDate2 = date_format($EDate2,"Y-m-d");

//Set varaibles to start date components
$dates = array();

for($x = 0; $x < 7; $x++) {
	$td = date("Y-m-d", mktime(0, 0, 0, $SDM, $SDD+$x, $SDY));

	$dates[$x] = $td;
}

if ($PType == NULL) {
    $PType = "A";
}
?>

<script>
var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;

var val2 = "<?php echo $PType ?>";
document.getElementById("selPType").value=val2;
</script>

<!--END GET DATES-->

<!--START EVENT QUERIES-->
<?php

sqlBetStartEnd($SDate, $EDate);

sqlFirstofNext($EDate2);

//Run above queries

$result = mysqli_query($conn, $sqlBetStartEnd);

$result2 = mysqli_query($conn, $sqlFirstofNext);
?>
<!--END EVENT QUERIES-->

<!--START ARRAYS-->
<?php

//reset arrays for results
$data = array();

//fill STime, ProjDesc and Date Arrays
while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['STime'];
    $data[1][] = $row['ProjDesc'];
    $data[3][] = date_format(date_create($row['STime']), "Y-m-d");
}

while ($row = mysqli_fetch_array($result2)) {
    $data[0][] = $row['STime'];
    $data[1][] = $row['ProjDesc'];
    $data[3][] = date_format(date_create($data[0][$x]), "Y-m-d");
}

//count rows in results arrays
$cnt=((count ($data, COUNT_RECURSIVE))/count($data))-1;

//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt-1); $x++) { 
    $data[2][] = getmins($data[0][$x], $data[0][$x+1]);
}

//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table
$arrTest = array();

//Setup clear table query
$clear = 'TRUNCATE TABLE tblTest2';

//Execute clear table query
mysqli_query($conn, $clear);

//Setup insert values query
$query = "INSERT INTO tblTest2 (`col1`, `col2`, `col3`) VALUES ";

//Use for loop to itterate through each of the events stored in the Act and Dur arrays
for($x=0; $x<($cnt); $x++){
    $arrTest[] = "('" . $data[1][$x] . "', '" . $data[2][$x] . "', '" . $data[3][$x] . "')";
 }

//Create query used to populate Test table with contents of Act and Dur arrays
$sql = $query .= implode(',', $arrTest);

//Execute the populate table query
mysqli_query($conn, $sql);

$sqlTotals = "SELECT col1, col3, SUM(col2) AS scol FROM tblTest2 GROUP BY col3, col1 ORDER BY col3, col1";

//Execute above query
$result = mysqli_query($conn, $sqlTotals);

//Setup query to pull project names from test table
if($PType=="W"){
    $qryProjList = "SELECT DISTINCT tblTest2.col1, tblProj.PCode FROM tblTest2 INNER JOIN tblProj ON tblTest2.col1=tblProj.ProjDesc WHERE tblProj.PCode='W' OR tblProj.PCode='D' ORDER BY col1";
} else {
    $qryProjList = "SELECT DISTINCT col1 FROM tblTest2 ORDER BY col1";
}

//Execute above query
$result2 = mysqli_query($conn, $qryProjList);

//Fill array with query results
while ($row = mysqli_fetch_array($result2)) {
    $data2[] = $row['col1'];
}

$cnt2=count ($data2);

?>
<!--END ARRAYS-->

<!--START TABLE -->
<hr>
<table>
	<th>Project</th>
	<th>Mon</th>
	<th>Tue</th>
	<th>Wed</th>
	<th>Thu</th>
	<th>Fri</th>
	<th>Sat</th>
	<th>Sun</th>
	<th>Total</th>

    <?php
    //reset query used to store the daily time for each activity
    $data4 = array();

    //set up a for loop to itterate through the contents of the project list array
    for($x = 0; $x < ($cnt2); $x++) {

        echo "<tr>";

        $rowt = 0;

        echo "<td width=28%>".$data2[$x]."</td>";

        //set up a for loop to itterate through the days of the week
        for($z = 0; $z < 7; $z++) {

            echo "<td width=9% align='center'>";

            //reset the array used to store the total daily time for each activity
            $data3 = array();

            //set up the query to calculate the total daily time for each activity
            $qry =  "SELECT col1, col3, SUM(col2) AS scol FROM tblTest2 WHERE col1 = '$data2[$x]' AND col3 = '$dates[$z]' GROUP BY col3, col1 ORDER BY col3, col1";

            //execute above query
            $result3 = mysqli_query($conn, $qry);

            //pull the results of the query into an array (should only be one item)
            while ($row = mysqli_fetch_array($result3)) {
                $data3[] = $row['scol'];
            }

            //add result to the daily acitivity time query
            $data4[$z][$x] = $data3[0];

            //calculate the rounded number of hours
            echo round(($data3[0]/60),1);

            //add the result to the running weekly total for each activity
            $rowt = $rowt + $data3[0];
        
            echo "</td>";

        }

        echo "<td width=9% align='center'>".round(($rowt/60), 1)."</td>";

        echo "</tr>";

    }
mysqli_query($conn, $clear);
    mysqli_close($conn);
    ?>

    <tr>
        <td width=9%><b>Totals</td>
        <?php 

        $GTot = 0;

        for($z1 = 0; $z1 < 7; $z1++){

            echo "<td width=9% align='center'><b>";

            $DTot = 0;

            for($x1 = 0; $x1 < ($cnt2); $x1++) {
                $DTot = $DTot + $data4[$z1][$x1];
            }

            echo round(($DTot/60),1);

            $GTot = $GTot + $DTot;

            echo "</td>";
        }
	
        ?>
        <td width=9% align='center'><b><?php echo round(($GTot/60),1); ?></td>
    </tr>
</table>

<!--END TABLE -->