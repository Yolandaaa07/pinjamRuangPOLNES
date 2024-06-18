<?php
// Pastikan user sudah login
if (!isset($_SESSION['peminjam_name'])) {
    header('Location: ../login.php');
    exit();
}

// Dapatkan ID pinjam dari query string
$id_pinjam = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Dapatkan detail pinjam berdasarkan ID
$conn = new mysqli('localhost', 'root', '', 'pjmruang');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$query = "SELECT * FROM peminjaman WHERE id_pinjam = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pinjam);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pinjam = $result->fetch_assoc();
   
    // Dapatkan path dokumen
    $docPath = !empty($pinjam['doc']) ? "../peminjam/prosesuploads/" . htmlspecialchars($pinjam['doc']) : '';
    $docLink = !empty($docPath) && file_exists($docPath) ? "<a href='" . htmlspecialchars($docPath) . "' target='_blank'>" . htmlspecialchars($pinjam['doc']) . "</a>" : "Tidak ada dokumen yang diunggah";

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Data pinjam tidak ditemukan</p>";
    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Pinjam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="images/logopolnes.png">
</head>
<body>
<div class="container mt-5">
    <h2>Detail pinjamRuang</h2>
    <hr>
    <a href="../peminjam/datapinjam.php" class="btn btn-success btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>

    <div class="card mt-3">
        <div class="card-header">
            <b>Detail Peminjaman</b>
        </div>
        <div class="card-body">
            <p>Nama Instansi: <?= htmlspecialchars($pinjam['nama']) ?></p>
            <p>No HP: <?= htmlspecialchars($pinjam['nohp']) ?></p>
            <p>Jurusan: <?= htmlspecialchars($pinjam['jurusan']) ?></p>
            <p>Tanggal Mulai: <?= htmlspecialchars($pinjam['date1']) ?></p>
            <p>Tanggal Selesai: <?= htmlspecialchars($pinjam['date2']) ?></p>
            <p>Waktu Mulai: <?= htmlspecialchars($pinjam['time1']) ?></p>
            <p>Waktu Selesai: <?= htmlspecialchars($pinjam['time2']) ?></p>
            <p>Nama Ruang: <?= htmlspecialchars($pinjam['nama_ruang']) ?></p>
            <p>Tujuan: <?= htmlspecialchars($pinjam['tujuan']) ?></p>
            <p>Dokumen: <?= $docLink ?></p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
