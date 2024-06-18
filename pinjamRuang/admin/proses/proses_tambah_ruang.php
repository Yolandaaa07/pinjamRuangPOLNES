<?php
session_start();
require_once '../../config/db.php';

// User tidak bisa langsung mengakses sebelum login
if(!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

// Validasi data form
if (empty($_POST['nama_ruang']) || empty($_POST['jenis']) || empty($_POST['jumlah']) || empty($_POST['kondisi'])) {
    $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Semua kolom harus diisi!</div>';
    header('Location: ../dataruang.php');
    exit();
}

// Tangkap data form
$nama_ruang = $conn->real_escape_string($_POST['nama_ruang']);
$jenis = $conn->real_escape_string($_POST['jenis']);
$jumlah = $conn->real_escape_string($_POST['jumlah']);
$kondisi = $conn->real_escape_string($_POST['kondisi']);
$keterangan = $conn->real_escape_string($_POST['keterangan']); // Keterangan bersifat opsional
$tgl_regis = date('Y-m-d'); // Tanggal sekarang
$petugas = $_SESSION['admin_name']; // Petugas yang login

// Ambil id_user dari tabel users berdasarkan nama petugas
$user_query = $conn->query("SELECT id_user FROM users WHERE username = '$petugas'");
$user_data = $user_query->fetch_assoc();
$id_user = $user_data['id_user'];

// Query SQL untuk memasukkan data ruang baru
$q = "INSERT INTO ruangan (jenis, jumlah, keterangan, kondisi, nama_ruang, tgl_regis, id_user) 
      VALUES ('$jenis', '$jumlah', '$keterangan', '$kondisi', '$nama_ruang', '$tgl_regis', '$id_user')";
$query = $conn->query($q);

if ($query) {
    $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Data pinjamRuang Ditambahkan!</div>';
} else {
    $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data pinjamRuang Gagal Ditambahkan!</div>';
}

header('Location: ../dataruang.php');
exit();
?>
