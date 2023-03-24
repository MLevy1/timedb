<?php 
include("./add.php");
$rec = $_POST;

$a = $rec['PCode'];

$pcode = "";

foreach($a as $b => $c) {

    $pcode .= $c;

}

$rec['PCode'] = $pcode;

$vars = [];
$vals = [];

foreach($rec as $var => $val) {
    $vars[] = $var;
    $vals[] = $val;
}

$vars[] = "Status";

$vals[] = "Active";

add($vars, $vals, "tblAct");
?>