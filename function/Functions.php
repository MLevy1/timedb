<?php

if (!function_exists('pconn')) {
	function pconn(){
		//Declare Global connection variable.
		global $conn;

		//000 Webhost Conn
		//$conn = mysqli_connect('mysql9.000webhost.com', 'a7566990_admin', '1234567a', 'a7566990_events');

		//Awardspace Conn
		//$conn = mysqli_connect('fdb13.awardspace.net', '2162348_events', 'M!chaelL3vy', '2162348_events');

		//X10 Hosting
		//$conn = mysqli_connect('localhost', 'mltimed2', '1234567a', 'mltimed2_events');

		//Home
		$conn = mysqli_connect('localhost', 'root', '1234567a', 'tdb');
	}
}

if (!function_exists('setQTime')) {
	function setQTime() {
		//Declare Global time variables.
		global $QTime;
		global $NowTime;

		date_default_timezone_set('America/New_York');

		$QTime = date('Y-m-d');
		$NowTime = date("Y-m-d H:i:s");
	}
}

if (!function_exists('formid')) {
	function formid() {
		global $form;
		$form="..".dirname($_SERVER['PHP_SELF'])."/".basename($_SERVER['PHP_SELF']);
	}
}

if (!function_exists('getmins')) {
	function getmins($stime, $etime) {
		return Round((strtotime($etime)-strtotime($stime))/60);
	}
}

if (!function_exists('getsecs')) {
	function getsecs($stime, $etime) {
		return Round(strtotime($etime)-strtotime($stime));
	}
}

if (!function_exists('gethours')) {
	function gethours($mins) {
	
		if($mins>=0){
			return floor($mins/60);
		}
		else{
			return ceil($mins/60);
		}
	}
}

if (!function_exists('getrmins')) {
	function getrmins($mins, $hours) {
		if($mins>=0){
		$rhrs = ($hours*60);
		return ($mins-$rhrs);
		}else{
		$rhrs = ($hours*60);
		return ($rhrs-$mins);
		}
	}
}

if (!function_exists('lastmins')) {
	function lastmins($stime) {
		$NowTime = date("Y-m-d H:i:s");
		return (Round((strtotime($NowTime)-strtotime($stime))/60));
	}
}

if (!function_exists('plastmins')) {
	function plastmins($stime, $SD) {
	
		if($SD==null){
		$QTime = date('Y-m-d');
		}else{
		$QTime = $SD;
		}
		
		$NowTime = date( "Y-m-d H:i", strtotime( "$QTime +1 day" ) );
		
		return (Round((strtotime($NowTime)-strtotime($stime))/60));
	}
}

if (!function_exists('TMins')) {
	function TMins($mins, $hours) {
		$tmins = ($hours*60);
		return ($tmins+$mins);
	}
}

if (!function_exists('DZero')) {
	function DZero($num){
		if(ABS($num)<10){
			return ('0'.$num);
		}
		else {
			return ($num);
		}
	}
}

if (!function_exists('NegNum')) {
	function NegNum($num1, $num2){
		if($num1<$num2){
			return ('-');
		}
		else {
			return ('+');
		}
	}
}

if (!function_exists('fixstr')) {
function fixstr($string){
	$string = str_replace("'", "''", $string);
	return $string;
}
}

if (!function_exists('addsel')) {
function addsel($selname, $optname, $searchtbl){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname FROM $searchtbl ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname id=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option>" . $row[$optname] . "</option>";
}

echo "</select>";

$conn->close();
}
}

if (!function_exists('addsel2')) {
function addsel2($selname, $optname, $col1name, $searchtbl){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname id=$selname class='smselect'>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row[$optname] . "'>" . $row[$optname] . " " . $row[$col1name] . "</option>";

}

echo "</select>";

$conn->close();
}
}

if (!function_exists('addsel2P')) {
function addsel2P($selname, $optname, $col1name, $searchtbl, $searchPName, $searchPVal){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl WHERE $searchPName = $searchPVal ORDER BY $optname";
$result = $conn->query($sql);

echo "<select name=$selname id=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row[$optname] . "'>" . $row[$optname] . " " . $row[$col1name] . "</option>";

}

echo "</select>";

$conn->close();
}
}

if (!function_exists('addsel3')) {
	function addsel3($selname, $optname, $col1name, $defopt, $searchtbl){

	include("../function/DBConn.php");

	$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl ORDER BY $optname";
	$result = $conn->query($sql);

	echo "<select name=$selname>";

	echo "<option>$defopt</option>";

	while($row = $result->fetch_assoc()) {
		echo "<option value='" . $row[$optname] . "'>" . $row[$optname] . " " . $row[$col1name] . "</option>";
}
	$conn->close();
echo "</select>";
}
}

if (!function_exists('eventbtn')) {
function eventbtn($btnval, $btnname){

	$ActID = substr($btnval, 0, 3);
	$ContID = substr($btnval, 4);

	$a = etime($ActID, $ContID);

	echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname<br>$a</button>";
}
}

if (!function_exists('etime')) {
	function etime($act, $cont){

		global $conn;

		pconn();

		$sql = "SELECT ActID, ProID, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime FROM tblEvents WHERE ActID = '$act' AND ProID = '$cont' GROUP BY ActID, ProID ORDER BY LTime";
	
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_array($result)) {
			$a = $row['LTime']."d";
		}
		mysqli_close($conn);
		return $a;
}
}

if (!function_exists('etimec')) {
	function etimec($cont){

		global $conn;

		pconn();

		$sql = "SELECT ProID, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime FROM tblEvents WHERE ProID = '$cont' GROUP BY ProID ORDER BY LTime";
	
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_array($result)) {
			$a = $row['LTime']."d";
		}
		mysqli_close($conn);
		return $a;
}
}


if (!function_exists('dluc')) {
	function dluc($cont){

		global $conn;

		pconn();

		$sql = "SELECT ProID, COUNT(*) AS cnt, DATE(MAX(STime)) AS DLU FROM tblEvents WHERE ProID = '$cont' GROUP BY ProID ORDER BY DLU";
	
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_array($result)) {
			$a = $row['DLU'];
		}
		mysqli_close($conn);
		return $a;
}
}



if (!function_exists('eventbtnjq')) {
function eventbtnjq($act, $cont, $btnname, $d, $HR){
	
	$btnid0 = $act.$cont;
	
	$btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
	
	$a = etime($act, $cont);
	
	echo "<button id='$btnid' onclick=\"btnJQ('$act', '$cont', '$btnid', '$d', $HR)\">$btnname<br>$a</button>";
}
}

if (!function_exists('socbtnjq')) {
function socbtnjq($act, $cont, $btnname){
	
	$btnid0 = $act.$cont;
	
	$btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
	
	$a = etimec($cont);
	
	echo "<button id='$btnid' onclick=\"btnJQSoc('$act', '$cont', '$btnid')\">$btnname<br>$a</button>";
}
}

if (!function_exists('goalbtnjq')) {
function goalbtnjq($goal, $cont, $GDate, $btnname){
	
	$btnid0 = $goal.$cont;
	
	$btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
	
	echo "<button id='$btnid' class='gbutton' onclick=\"btnJQGoal('$goal', '$cont', '$GDate', '$btnid')\">$btnname</button>";
}
}


if (!function_exists('socialbtn')) {
function socialbtn($btnval, $btnname){
    echo "<button name='selCont' value='$btnval' type='submit'>$btnname</button>";
}
}

if (!function_exists('newbtn')) {
function newbtn($btnname, $btnval, $btncap){

	$a = etimec($btnval);

    echo "<button name='$btnname' value='$btnval' type='submit'>$btncap<br>$a</button>";
}
}

if (!function_exists('fixstr')) {
function fixstr($string){
	$string = str_replace("'", "''", $string);
	return $string;
}
}

if (!function_exists('eventbtn')) {
function cntbtn($btnval1, $btnval2, $btnname1, $btnname2){
	$btnval = $btnval1." ".$btnval2;
	echo $btnval;
	//$btnname = $btnname1." ".$btnname2;
	//echo "<button name='btn_submit' value='$btnval' type='submit'>$btnname</button>";
}
}

if (!function_exists('priorbtnjq')) {
function priorbtnjq(){
	
	pconn();
	
	global $conn;
	
	$sql = "SELECT StartTime, STime, ActID, ProID FROM tblEvents ORDER BY STime DESC LIMIT 2";

	$result = mysqli_query($conn, $sql);

	$arrStartTime = array();
	$arrActID = array();
	$arrContID =array();

	while ($row = mysqli_fetch_array($result)) {
		$arrActID[] = $row['ActID'];
		$arrContID[] = $row['ProID'];
}

	$act = $arrActID[1];
	$cont = $arrContID[1];
	
	echo "<input type='button' class='link'  id='btnPrior' value='Prior' onclick=\"btnJQ('$act', '$cont')\"</button>";	
}
}

if (!function_exists('selActiveCont')) {
function selActiveCont($selname){

pconn();
global $conn;

$sql = "SELECT tblCont.ContID, tblCont.ContDesc FROM tblCont, tblProj WHERE tblCont.ProjID = tblProj.ProjID AND tblProj.ProjStatus!='Closed' AND tblCont.Active!='N' ORDER BY ContID";

$result = mysqli_query($conn, $sql);

echo "<select name=$selname id=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" . $row['ContID'] . " " . $row['ContDesc'] ."</option>";
}
mysqli_close($conn);
echo "</select>";
}
}

if (!function_exists('selActiveAct')) {
function selActiveAct($selname){

pconn();
global $conn;

$sql = "SELECT ActID, ActDesc, Status FROM tblAct WHERE Status !='Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

echo "<select name=$selname id=$selname>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActID'] . " " . $row['ActDesc'] ."</option>";
}
mysqli_close($conn);
echo "</select>";
}
}

if (!function_exists('DailyEventTime')) {
function DailyEventTime($act){

pconn();

global $conn;
global $QTime;
global $NowTime;

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
    $data[2][] = getmins($data[0][$x], $data[0][$x+1]);
}

$arrSum = array();

for($x = 0; $x < ($cnt); $x++) {
    if($data[1][$x] == $act){
        $arrSum[] = $data[2][$x];
    }
}
echo array_sum($arrSum);
}
}


if (!function_exists('stdev')) {
	

function stdev($a){

$cnt = count($a);

$sum = array_sum($a);

$avg = $sum / $cnt;

$c=0;

foreach ($a as $b) {
	$c = $c + pow(($b - $avg),2);
}

$c = ($c/$cnt);

$c = round(sqrt($c),2);

return $c;
}
}




if (!function_exists('etimea')) {
	function etimea($act){

		global $conn;

		pconn();

		$sql = "SELECT ActID, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime FROM tblEvents WHERE ActID = '$act' GROUP BY ActID ORDER BY LTime";
	
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_array($result)) {
			$a = $row['LTime']."d";
		}
		mysqli_close($conn);
		return $a;
}
}



if (!function_exists('addsel2NS')) {
function addsel2NS($selname, $optname, $col1name, $searchtbl){

include("DBConn.php");

$sql = "SELECT DISTINCT $optname, $col1name FROM $searchtbl ORDER BY $col1name";
$result = $conn->query($sql);

echo "<select name=$selname id=$selname class='smselect'>";

echo "<option></option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row[$optname] . "'>" . $row[$col1name] . "</option>";

}

echo "</select>";

$conn->close();
}
}



if (!function_exists('linktable')) {
function linktable(){

$link = $_REQUEST["link"];

if($link == NULL){
include('../view/LinkTable.php');
}

}
}

if (!function_exists('ELTime')) {
	
function ELTime($secs) {
	
	$days = $secs / (60*60*24);
		
	if($days>=1){
		
		return Round($days)."d";
		
	}else{
		
	$hrs = $secs / (60*60);
			
	if($hrs>=1){
				
		return Round($hrs)."h";
					
	}else{
				
	$mins = $secs / 60;
					
	if($mins>=1){
						
		return Round($mins)."m";
					
	}else{
					
		return $secs."s";
	}
	}
	}
}
}

	
?>
