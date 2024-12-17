<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "dbusers";

$conn = mysqli_connect($server, $username, $password, $database);

if(!$conn){
//     echo "success";
// }
// else{
    die("Error connecting to db". mysqli_connect_error());
}
?>