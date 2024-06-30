<?php
$host = "localhost";
$admin = "admin";
$admin_password = "admin";
$database = "projekat";

$conn = mysqli_connect($host, $admin, $admin_password, $database);

if (!$conn) {
    die("Something went wrong :(");
}
?>