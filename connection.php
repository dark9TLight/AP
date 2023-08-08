<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "ap";

//SERVER MATECON
/*$host = "43.74.21.212";
$user = "soemmatecon";
$password = "matecon1234";
$dbname = "matecon";*/

$conn = mysqli_connect($host, $user, $password,$dbname);

if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}
?> 