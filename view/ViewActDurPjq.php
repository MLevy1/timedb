<?php 
header("Cache-Control: no-cache, must-revalidate");
include ('../function/Functions.php');
include('../function/SqlList.php');

$a = $_GET['test'];

pconn();
setQTime();
  	
$sqlDailyEvents = "SELECT STime, ActID FROM tblEvents WHERE date(tblEvents.STime) ='$QTime' ORDER BY tblEvents.STime";

$result = mysqli_query($conn, $sqlDailyEvents);

//Define first table array variables as arrays.
$data = array();

//Fills Stime, Act and Cont arrays with the results from the above query.
while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['STime'];
    $data[1][] = $row['ActID'];
}

//Set array row counter variable to the number of rows in the query result.
$cnt = count ($data[0]);

$data[0][] = $NowTime;

//Sets Dur array to the duration of each event in the query result.
for($x = 0; $x < ($cnt); $x++) {
    //$data[2][] = getmins($data[0][$x], $data[0][$x+1]);
    $data[2][] = getsecs($data[0][$x], $data[0][$x+1]);
}

$arrSum = array();

for($x = 0; $x < ($cnt); $x++) {
    if($data[1][$x] == $a){
        $arrSum[] = $data[2][$x];
    }
}
echo array_sum($arrSum);
?>