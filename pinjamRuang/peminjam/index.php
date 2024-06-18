<?php 
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['nama']) || $_SESSION['user_type'] !== 'Peminjam') {
    echo "Sesi tidak ditemukan atau bukan peminjam, silakan login kembali.";
    exit();
}
//view
require_once 'view/header.php';
require_once 'view/dashboard.php'; //content
require_once 'view/footer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pinjamRuang POLNES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    </style>
</head>
<body>
</body>
</html>