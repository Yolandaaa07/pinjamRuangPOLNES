<?php
// Ambil nama instansi dari sesi
$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="icon" type="image/png" href="images/logopolnes.png">
<style>
    .content h3 {
        font-size: 30px;
        color: #333;
    }
    .content h3 span {
        background: #0A6847;
        color: white;
        border-radius: 5px;
        padding: 0 15px;
    }
    .content h1 span {
        color: #0A6847;
    }
    .content p {
        font-size: 25px;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
<div class="content">
    <br>
    <h3>Hi, <span><?php echo htmlspecialchars($_SESSION['peminjam_name']); ?></span></h3>
    <h1>Selamat Datang di <span>pinjamRuang POLNES</span></h1>
</div>
<div class="container col-8 mt-5">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card" style="width: 18rem; height: 12rem; border: 3px solid #CBCBCB;">
                <div class="card-body">
                    <?php 
                    $q = $conn->query("SELECT COUNT(*) AS jmlruang FROM ruangan");
                    $ruang = $q->fetch_array();
                    ?>
                    <h5 class="card-title">Data Ruangan POLNES</h5>
                    <p class="card-text">Ruangan yang ada di POLNES</p>
                    <h4><?= htmlspecialchars($ruang['jmlruang']); ?></h4>
                    <a href="dataruang.php" class="card-link">Lihat Data Ruangan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card" style="width: 22rem; height: 12rem; border: 3px solid #CBCBCB;">
                <div class="card-body">
                    <?php 
                    // Query untuk menghitung jumlah peminjaman berdasarkan nama instansi yang login
                    $q = $conn->prepare("SELECT COUNT(*) AS jmlpinjam FROM peminjaman WHERE nama = ?");
                    $q->bind_param("s", $nama);
                    $q->execute();
                    $result = $q->get_result();
                    $pinjam = $result->fetch_array();
                    ?>
                    <h5 class="card-title">Pengajuan pinjamRuang POLNES</h5>
                    <p class="card-text">Isi form setelah mendapat tanda tangan desposisi WADIR II</p>
                    <h4><?= htmlspecialchars($pinjam['jmlpinjam']); ?></h4>
                    <a href="../peminjam/datapinjam.php" class="card-link">Lihat Data Pengajuan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card" style="width: 17rem; height: 12rem; border: 3px solid #CBCBCB;">
                <div class="card-body">
                    <?php 
                    $q = $conn->query("SELECT COUNT(*) AS jmltrpinjam FROM peminjaman WHERE status_pjm = 'Disetujui'");
                    $pinjam = $q->fetch_array();
                    ?>
                    <h5 class="card-title">Data Ruangan yang Telah Dipinjam</h5>
                    <p class="card-text">Ruangan Tersedia Saat Ini</p>
                    <h4><?= htmlspecialchars($pinjam['jmltrpinjam']); ?></h4>
                    <a href="../peminjam/datapinjamRuang.php" class="card-link">Lihat Data Ruangan</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
