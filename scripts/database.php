<?php


//error_reporting(0);

$host = "127.0.0.1"; // MySQL host name eg. localhost
$user = "root"; // MySQL user. eg. root ( if your on localserver)
$password = ""; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "flashquiz"; // MySQL Database name

$DBH = new PDO("mysql:host=$host;dbname=$database", $user, $password);
 
// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

$ajax_con=mysqli_connect($host,$user,$password); 
if (!$ajax_con)
{
    die('Could not connect: ' . mysqli_error());
}   

mysqli_select_db($ajax_con,$database);
// Callum Pilton