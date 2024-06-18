<?php
session_start();
require_once '../config/db.php';

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

// select semua data peminjam yang telah diverifikasi
$sql = "SELECT * FROM users WHERE user_type = 'Peminjam' AND verifikasi = 1";
$query = $conn->query($sql);
$peminjam = $query->fetch_all(MYSQLI_ASSOC);

// no urut increment
$no = 1;
require_once 'view/header.php';
if (!isset($_GET['p'])) {
    require_once 'view/peminjam.php';
} elseif ($_GET['p'] == 'hapus-peminjam') {

    $hapus = $conn->query("DELETE FROM users WHERE id_user = '$_GET[id]'");
    if ($hapus) {
        $_SESSION['pesan'] = '<div class="alert alert-warning" role="alert">Data Peminjam Telah Dihapus!</div>';
        header('Location: datapeminjam.php');
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data Peminjam Gagal Dihapus!</div>';
        header('Location: datapeminjam.php');
    }
}

require_once 'view/footer.php';
?>
