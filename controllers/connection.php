<?php
$cn = mysqli_connect("localhost", "root", "", "wallet");

if(mysqli_connect_errno()) {
    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
    die();
}

?>