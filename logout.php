<?php
session_start();

// Menghapus semua variabel sesi
session_unset();

// Menghancurkan sesi
session_destroy();

// Mengarahkan pengguna kembali ke halaman login
header("Location: login.php");

// Pastikan untuk keluar dari skrip setelah pengalihan header
exit();

// Jika tipe pengguna adalah Administrator, set $_SESSION['admin_name']
// Jika tipe pengguna adalah Peminjam, set $_SESSION['peminjam_name']
if ($row['user_type'] == 'Administrator') {
    $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Anda Berhasil Logout</div>';
} elseif ($row['user_type'] == 'Peminjam') {
    $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Anda Berhasil Logout</div>';
}
?>
