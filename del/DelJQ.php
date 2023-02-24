<?php

$tbl = $_REQUEST["selTbl"] ?? null;

$v1 = $_REQUEST["v1"] ?? null;

$c1 = $_REQUEST["c1"] ?? null;

include ('../function/Functions.php');

pconn();

$sql = "DELETE FROM $tbl WHERE $c1 ='$v1'";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>