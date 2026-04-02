<?php
$host="localhost";
$user="root";
$pass="";
$db="your_db";

$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("DB Error");
}
?>
