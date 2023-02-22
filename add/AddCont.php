<?php 
include("../function/DBConn.php");

$ContID = $_POST["inpContID"];
$Cont = $_POST["inpCont"];
$ProdID = $_POST["projsel"];

$sql = "INSERT INTO tblCont (ContID, ContDesc, ProjID, Active)
VALUES ('$ContID', '$Cont', '$ProdID', 'Y')";

if ($conn->query($sql) === TRUE) {
	$conn->close();
	header ('Location: ../form/FormCont.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}
?>
