<?php
session_start();
require_once '../../config/db.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['peminjam_name'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nama = htmlspecialchars($_POST['nama']);
    $nohp = htmlspecialchars($_POST['nohp']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $tgl_mulai = htmlspecialchars($_POST['date1']);
    $tgl_selesai = htmlspecialchars($_POST['date2']);
    $wkt_mulai = htmlspecialchars($_POST['time1']);
    $wkt_selesai = htmlspecialchars($_POST['time2']);
    $nama_ruang = htmlspecialchars($_POST['nama_ruang']);
    $tujuan = htmlspecialchars($_POST['tujuan']);
    $old_doc = htmlspecialchars($_POST['old_doc']);

    $target_dir = "../../pinjamruang/peminjam/prosesuploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $doc = $old_doc;
    if (isset($_FILES['doc']) && $_FILES['doc']['error'] == UPLOAD_ERR_OK) {
        $target_file = $target_dir . basename($_FILES['doc']['name']);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($fileType != "pdf" && $fileType != "docx") {
            $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Maaf, hanya file PDF dan DOCX yang diizinkan!</div>';
            header('Location: ../view/datapinjam.php?p=edit-pinjam&id=' . $id);
            exit();
        }

        if (move_uploaded_file($_FILES['doc']['tmp_name'], $target_file)) {
            $doc = basename($_FILES['doc']['name']);
        } else {
            $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Gagal mengunggah file!</div>';
            header('Location: ../view/datapinjam.php?p=edit-pinjam&id=' . $id);
            exit();
        }
    }

    $stmt = $conn->prepare("UPDATE peminjaman SET nama = ?, nohp = ?, jurusan = ?, date1 = ?, date2 = ?, time1 = ?, time2 = ?, nama_ruang = ?, tujuan = ?, doc = ? WHERE id_pinjam = ?");
    $stmt->bind_param("ssssssssssi", $nama, $nohp, $jurusan, $tgl_mulai, $tgl_selesai, $wkt_mulai, $wkt_selesai, $nama_ruang, $tujuan, $doc, $id);

    if ($stmt->execute()) {
        $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Data berhasil diperbarui!</div>';
        header('Location: ../datapinjam.php');
        exit();
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Error updating record: ' . $stmt->error . '</div>';
        header('Location: ../datapinjam.php?p=edit-pinjam&id=' . $id);
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Perubahan tidak tersedia</div>';
    header('Location: ../datapinjam.php');
    exit();
}
?>
