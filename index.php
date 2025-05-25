<?php
include("koneksi.php");

$query = 'SELECT * pasien;';
$result = mysqli_query($koneksi, $query);

?>