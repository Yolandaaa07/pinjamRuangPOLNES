<?php
session_start();
require_once '../config/db.php';

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_SESSION['nama'];
    $nama_ruang = isset($_POST['nama_ruang']) ? htmlspecialchars($_POST['nama_ruang']) : '';
    $tanggal_pinjam = isset($_POST['tanggal_pinjam']) ? htmlspecialchars($_POST['tanggal_pinjam']) : '';
    $nohp = isset($_POST['nohp']) ? htmlspecialchars($_POST['nohp']) : '';
    $jurusan = isset($_POST['jurusan']) ? htmlspecialchars($_POST['jurusan']) : '';
    $tgl_mulai = isset($_POST['date1']) ? htmlspecialchars($_POST['date1']) : '';
    $tgl_selesai = isset($_POST['date2']) ? htmlspecialchars($_POST['date2']) : '';
    $wkt_mulai = isset($_POST['time1']) ? htmlspecialchars($_POST['time1']) : '';
    $wkt_selesai = isset($_POST['time2']) ? htmlspecialchars($_POST['time2']) : '';
    $tujuan = isset($_POST['tujuan']) ? htmlspecialchars($_POST['tujuan']) : '';

    // Proses pengunggahan file jika ada
    $doc = '';
    if (isset($_FILES['doc']) && $_FILES['doc']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../../peminjam/prosesuploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($_FILES['doc']['name']);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($fileType != "pdf" && $fileType != "docx") {
            $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Hanya file PDF dan DOCX yang diizinkan!</div>';
            header('Location: ../datapinjam.php'); // Ganti dengan halaman form Anda
            exit();
        }

        if (!move_uploaded_file($_FILES['doc']['tmp_name'], $target_file)) {
            $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Gagal mengunggah file!</div>';
            header('Location: ../datapinjam.php'); // Ganti dengan halaman form Anda
            exit();
        } else {
            $doc = basename($_FILES['doc']['name']);
        }
    }

    if (!empty($nama_ruang) && !empty($tanggal_pinjam)) {
        // Jika data peminjaman ruangan dari proses_pinjam.php
        $stmt_ruang = $conn->prepare("SELECT * FROM ruangan WHERE nama_ruang = ?");
        $stmt_ruang->bind_param("s", $nama_ruang);
        $stmt_ruang->execute();
        $result_ruang = $stmt_ruang->get_result();
        $ruang = $result_ruang->fetch_assoc();
        $stmt_ruang->close();

        $stmt = $conn->prepare("INSERT INTO peminjaman (nama, nama_ruang, kondisi, jumlah, jenis, tanggal_pinjam) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiis", $nama, $ruang['nama_ruang'], $ruang['kondisi'], $ruang['jumlah'], $ruang['jenis'], $tanggal_pinjam);
    } else if (!empty($nama) && !empty($nohp) && !empty($jurusan) && !empty($tgl_mulai) && !empty($tgl_selesai) && !empty($wkt_mulai) && !empty($wkt_selesai) && !empty($nama_ruang) && !empty($tujuan)) {
        // Jika data peminjaman ruang dengan dokumen dari proses_tambah_pinjam.php
        $stmt = $conn->prepare("INSERT INTO peminjaman (nama, nohp, jurusan, date1, date2, time1, time2, nama_ruang, tujuan, doc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $nama, $nohp, $jurusan, $tgl_mulai, $tgl_selesai, $wkt_mulai, $wkt_selesai, $nama_ruang, $tujuan, $doc);
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data yang dimasukkan tidak lengkap!</div>';
        header('Location: ../datapinjam.php');
        exit();
    }

    if ($stmt->execute()) {
        $_SESSION['pesan'] = '<div class="alert alert-success" role="alert">Data peminjaman berhasil ditambahkan!</div>';
    } else {
        $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Data peminjaman gagal ditambahkan!</div>';
    }
    $stmt->close();
} else {
    $_SESSION['pesan'] = '<div class="alert alert-danger" role="alert">Pengajuan tidak tersedia!</div>';
    header('Location: ../datapinjam.php'); // Ganti dengan halaman form Anda
    exit();
}

$conn->close();

header('Location: ../datapinjam.php'); // Ganti dengan halaman form Anda
exit();
?>
