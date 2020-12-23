<?php


$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "ipl-db2";
    
$c = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbname) or die("Connect failed: %s\n". $conn -> error);


?>