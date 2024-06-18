<?php
//koneksi ke database
$host = "sql308.infinityfree.com";
$user= "if0_36750743";
$password="tSgczSE3ne7M1f";
$db="if0_36750743_pinjamruang";
$conn = mysqli_connect($host,$user,$password,$db);
if (!$conn) {
    die("Koneksi Gagal:".mysqli_connect_error());
}



?>
