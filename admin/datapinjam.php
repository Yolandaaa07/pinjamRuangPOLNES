<?php
session_start();
require_once '../config/db.php';
require_once 'view/header.php';


// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'pjmruang');

// Penanganan form submission untuk persetujuan/tolak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pinjam'])) {
    $id_pinjam = $_POST['id_pinjam'];
    $status_pjm = '';

    if (isset($_POST['setuju'])) {
        $status_pjm = 'Disetujui';
    } elseif (isset($_POST['tolak'])) {
        $status_pjm = 'Ditolak';
    } elseif (isset($_POST['tunggu'])) {
        $status_pjm = 'Menunggu';
    }

    $stmt = $conn->prepare("UPDATE peminjaman SET status_pjm = ? WHERE id_pinjam = ?");
    $stmt->bind_param("si", $status_pjm, $id_pinjam);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status_pjm' => $status_pjm,
            'message' => 'Status berhasil diubah'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengubah status'
        ]);
    }
    $stmt->close();
    exit();
}

// Mengambil data dari database
$query = "SELECT * FROM peminjaman WHERE status_pjm = 'Menunggu'";
$result = $conn->query($query);

// Periksa apakah query berhasil dieksekusi
if (!$result) {
    // Jika query gagal, tampilkan pesan error
    echo "Query gagal dieksekusi: " . $conn->error;
    exit;
}

// Ambil semua hasil query
$data_pinjam = $result->fetch_all(MYSQLI_ASSOC);

// no urut increment
$no = 1;
require_once 'view/header.php';
if (!isset($_GET['p'])) {
    require_once 'view/pinjam.php';
} elseif ($_GET['p'] == 'hapus-pinjam' && isset($_GET['id'])) {
    $id_to_delete = intval($_GET['id']); // Melindungi terhadap SQL Injection dengan mengonversi nilai menjadi integer
    $stmt = $conn->prepare("DELETE FROM peminjaman WHERE id_pinjam = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['pesan'] = '<div class="alert alert-warning" role="alert">Data pinjamRuang Telah Dihapus!</div>';
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Gagal Menghapus Data!</div>';
    }

    $stmt->close();
    header('Location: pinjam.php');
    exit;
} else {
    echo "Halaman tidak ditemukan";
}
?>