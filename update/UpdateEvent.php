<?php
include("../function/Functions.php");

pconn();

$btnfull = $_GET['btn_submit'];

$TimeStamp = $_GET["TimeStamp"];
$newSTime = $_GET["newSTime"];
$newActID = $_GET["NselAct"];
$newContID = $_GET["NselCont"];
$newDetails = $_GET["newDetails"];
$secs = $_GET["sec"];

$fullSTime = $newSTime.':'.$secs;

$selQDate= $_GET["selQDate"];

$selSDate = $_GET["selSDate"];
$selEDate = $_GET["selEDate"];
$selAct = $_GET["selAct"];
$selCont = $_GET["selCont"];

$selProj = $_REQUEST["selProj"];
$timecode = $_REQUEST["timecode"];
$selUCode = $_REQUEST["selUCode"];

$form1 =  $_GET["form"];

if($btnfull != NULL) {
	$newActID = substr($btnfull, 0, 3);
	$newContID = substr($btnfull, 4);
}

if($form1='../events/ViewSelActContEvents.php'){

	$form = 'Location: ../events/FormEventInfo.php';

}else{

	$form = 'Location: ../form/FormAll.php';
	
}

echo '<input type="hidden" name="selQDate" value="<?php echo $selQDate; ?>">';

$sql = "UPDATE tblEvents SET STime='$fullSTime', ActID='$newActID', ProID='$newContID', Details='$newDetails' WHERE StartTime='$TimeStamp'";

$result = mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql) != TRUE) {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

header ("$form");


?>

