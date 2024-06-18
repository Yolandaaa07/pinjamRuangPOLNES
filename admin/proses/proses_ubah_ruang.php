<?php
session_start();
require_once '../../config/db.php';

if(!isset($_SESSION['admin_name'])){
    header('Location: ../login.php');
    exit();
}

if(isset($_POST['simpan'])){
    $id = $_POST['id'];
    $nama_ruang = $_POST['nama_ruang'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $kondisi = $_POST['kondisi'];
    $keterangan = $_POST['keterangan'];
    $petugas = $_SESSION['admin_name'];

// Ambil id_user dari tabel users berdasarkan nama petugas
$user_query = $conn->query("SELECT id_user FROM users WHERE username = '$petugas'");
$user_data = $user_query->fetch_assoc();
$id_user = $user_data['id_user'];

    $update = $conn->query("UPDATE ruangan SET nama_ruang = '$nama_ruang',
                                               jenis = '$jenis',
                                               jumlah = '$jumlah',
                                               kondisi = '$kondisi',
                                               keterangan = '$keterangan',
                                               id_user ='$id_user'
                            WHERE id_ruang = '$id'");
    if ($update) {
        $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Data pinjamRuang Telah Diubah!</div>';
        header('Location: ../dataruang.php');
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data pinjamRuang Gagal Diubah!</div>';
        header('Location: ../dataruang.php?p=edit-ruang&id=' . $_POST['id']);
    }    
}
?>