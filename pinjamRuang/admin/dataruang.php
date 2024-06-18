<?php
session_start();
require_once '../config/db.php';
require_once 'view/header.php';

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

// Insert new ruangan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_ruang = $_POST['nama_ruang'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $kondisi = $_POST['kondisi'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("INSERT INTO ruangan (nama_ruang, jenis, jumlah, kondisi, keterangan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $nama_ruang, $jenis, $jumlah, $kondisi, $keterangan);
    $stmt->execute();
    $stmt->close();

    $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Data ruangan berhasil ditambahkan!</div>';
    header("Location: dataruang.php");
    exit();
}

// Query untuk mengambil data ruang
$sql ="SELECT * FROM ruangan";
$query = $conn->query($sql);
$data_ruang = $query->fetch_all(MYSQLI_ASSOC);

// no urut increment
$no = 1;

require_once 'view/header.php';

if (isset($_SESSION['pesan'])) {
    echo $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if (!isset($_GET['p'])) {
    require_once 'view/ruang.php';
} elseif ($_GET['p'] == 'edit-ruang') {
    require_once 'view/' . $_GET['p'] . '.php'; // edit-ruang.php
} elseif ($_GET['p'] == 'detail-ruang') {
    require_once 'view/' . $_GET['p'] . '.php'; // detail-ruang.php
} elseif($_GET['p'] == 'hapus-ruang') {
    $hapus = $conn->query("DELETE FROM ruangan WHERE id_ruang = '$_GET[id]'");
    if ($hapus) {
        $_SESSION['pesan'] = '<div class="alert alert-warning" role="alert">Data ruangan telah dihapus!</div>';
        header('Location: dataruang.php');
        exit();
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data ruangan gagal dihapus!</div>';
        header('Location: dataruang.php');
        exit();
    }
}

require_once 'view/footer.php';
?>
