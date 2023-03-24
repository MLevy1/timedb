<?php 
include("./add.php");
$rec = $_POST;

$vars = [];
$vals = [];

foreach($rec as $var => $val) {
    $vars[] = $var;
    $vals[] = $val;
}

$vars[] = "Active";

$vals[] = "Y";

add($vars, $vals, "tblCont");
?>
