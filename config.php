<?php 

$db = mysqli_connect("localhost", "root", "Shubham@123", "webdev");

if (!$db) {
    die("Connectivity Failed: " . mysqli_connect_error());
}


?>