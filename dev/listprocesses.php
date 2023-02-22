<?php
include("../function/Functions.php");

pconn();

$sql = "SHOW FULL PROCESSLIST";

$result = mysqli_query($conn, $sql);

print_r ($result);

mysqli_close($conn);

/*
while ($row=mysql_fetch_array($result)) {
  $process_id=$row["Id"];
  if ($row["Time"] > 200 ) {
    $sql="KILL $process_id";
    mysql_query($sql);
  }
  */
  ?>