<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "BitcareHospital";

$koneksi = mysqli_connect($host, $user, $password, $database);

if(!$koneksi){
    //log error to file instead of showing it to the user
    error_log("Database connection failed: ". mysqli_connect_error());
    exit;
}
else{
    echo "Koneksi Berhasil";
}
?>