<?php
$host = "localhost:3306";
$user = "root";
$password = "1234567a";
$dbname = "tdb";

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);



// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

?>

