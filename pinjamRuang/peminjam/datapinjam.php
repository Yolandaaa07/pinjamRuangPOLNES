<?php
session_start();
require_once '../config/db.php';

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['nama']) || $_SESSION['user_type'] !== 'Peminjam') {
    echo "Sesi tidak ditemukan atau bukan peminjam, silakan login kembali.";
    exit();
}

// Query untuk mengambil data peminjaman
$sql ="SELECT * FROM peminjaman";
$query = $conn->query($sql);
$pinjam = $query->fetch_all(MYSQLI_ASSOC);

//Query untuk mengambil data ruangan
$sql_ruangan = "SELECT * FROM ruangan";
$q = $conn->query($sql_ruangan);
$ruangan = $q->fetch_all(MYSQLI_ASSOC);
// no urut increment
$no = 1;
require_once 'view/header.php';
if (!isset($_GET['p'])) {
    require_once 'view/pinjam.php';
} elseif ($_GET['p'] == 'edit-pinjam') {
    require_once 'view/' . $_GET['p'] . '.php'; // edit-pinjam.php
} elseif ($_GET ['p'] == 'detail-pinjam') {
    require_once 'view/' . $_GET['p'] . '.php'; // detail-pinjam.php
} elseif($_GET['p'] == 'hapus-pinjam'){

    $hapus = $conn->query("DELETE FROM peminjaman WHERE id_pinjam = '$_GET[id]'");
    if ($hapus){
        $_SESSION['pesan'] = '<div class="alert alert-warning" role="alert">Data pinjamRuang Telah Dihapus!</div>';
        header('Location: datapinjam.php');
    } else{
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data pinjamRuang Gagal Dihapus!</div>';
        header('Location: datapinjam.php');
    }
}

require_once 'view/footer.php';
?>
