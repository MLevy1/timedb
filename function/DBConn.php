<?php

//000 Webhost Conn
/*
$servername = "mysql9.000webhost.com";
$username = "a7566990_admin";
$password = "1234567a";
$dbname = "a7566990_events";

//Awardspace Conn
$servername = "fdb13.awardspace.net";
$username = "2162348_events";
$password = "M!chaelL3vy";
$dbname = "2162348_events";


//X10 Hosting
$servername = "localhost";
$username = "mltimed2";
$password = "1234567a";
$dbname = "mltimed2_events";
*/

//Home
$servername = "localhost:3306";
$username = "root";
$password = "1234567a";
$dbname = "tdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
