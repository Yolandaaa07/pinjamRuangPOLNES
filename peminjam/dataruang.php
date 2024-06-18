<?php
session_start();
require_once '../config/db.php';

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['nama']) || $_SESSION['user_type'] !== 'Peminjam') {
    echo "Sesi tidak ditemukan atau bukan peminjam, silakan login kembali.";
    exit();
}

// Query untuk mengambil data ruang dengan join ke tabel users
$sql ="SELECT * FROM ruangan";
$query = $conn->query($sql);
$ruangan = $query->fetch_all(MYSQLI_ASSOC);

// no urut increment
$no = 1;
require_once 'view/header.php';
require_once 'view/ruang.php';
   // Penghapusan Data
if (isset($_GET['id'])) {
    $hapus_stmt = $conn->prepare("DELETE FROM ruangan WHERE id_ruang = ?");
    $hapus_stmt->bind_param("i", $_GET['id']);
    if ($hapus_stmt->execute()) {
        $_SESSION['pesan'] = '<div class="alert alert-warning" role="alert">Data pinjamRuang Telah Dihapus!</div>';
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data pinjamRuang Gagal Dihapus!</div>';
    }
    $hapus_stmt->close();
    
    // Pengalihan setelah penghapusan data
    header('Location: dataruang.php');
    exit(); // Pastikan untuk keluar setelah melakukan pengalihan
}

require_once 'view/footer.php';
?>