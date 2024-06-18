<?php
session_start();
require_once '../config/db.php';

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

// Koneksi database
$conn = new mysqli('localhost', 'root', '', 'pjmruang');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// select semua data peminjam dengan status 'Disetujui'
$sql = "SELECT * FROM peminjaman WHERE status_pjm = 'Disetujui'";
$query = $conn->query($sql);
$rsetuju = $query->fetch_all(MYSQLI_ASSOC);

// no urut increment
$no = 1;

require_once 'view/header.php';

require_once 'view/ruangtrpjm.php'; // Mengarahkan ke halaman yang benar

if (!isset($_GET['p'])) {
    // Tidak melakukan apa-apa jika tidak ada parameter
} elseif ($_GET['p'] == 'hapus-peminjam' && isset($_GET['id'])) {
    $id_to_delete = intval($_GET['id']);
    $hapus = $conn->query("DELETE FROM peminjaman WHERE id_pinjam = '$id_to_delete'");
    if ($hapus) {
        $_SESSION['pesan'] = '<div class="alert alert-warning" role="alert">Data Peminjam Telah Dihapus!</div>';
        header('Location: datapinjamRuang.php');
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data Peminjam Gagal Dihapus!</div>';
        header('Location: datapinjamRuang.php');
    }
}

require_once 'view/footer.php';
?>
