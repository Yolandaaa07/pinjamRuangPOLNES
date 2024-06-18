
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .content h3{
        font-size: 30px;
        color: #333;
        }
        .content h3 span{
        background: #0A6847;
        color: white;
        border-radius: 5px;
        padding: 0 15px;
        }
        .content h1 span{
        color: #0A6847;
        }
        content p{
            font-size: 25px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
   <div class="content">
            <br>
            <h3>Hi, <span><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span></h3>
            <h1>Selamat datang di <span>pinjamRuang POLNES</span></h1>
        </div>
        <div class="container col-8 mt-4">
    
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card" style="width: 18rem; border: 3px solid #CBCBCB;">
                    <div class="card-body">

                    <?php 
                    $q = $conn->query("SELECT COUNT(*) AS jmlruang FROM ruangan");
                    $ruang = $q->fetch_array();
                    
                    ?>
                        <h5 class="card-title">Data Ruangan POLNES</h5>
                        <p class="card-text">Ruangan Tersedia saat ini</p>
                        <h4><?= $ruang['jmlruang'] ?></h4>
                        <a href="dataruang.php" class="card-link">Lihat Data Ruangan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 18rem; border: 3px solid #CBCBCB;">
                    <div class="card-body">
                    <?php 
                    $q = $conn->query("SELECT COUNT(*) AS jmluser FROM users WHERE user_type = 'Peminjam'");
                    $user = $q->fetch_array();
                    
                    ?>
                        <h5 class="card-title">Data Peminjam</h5>
                        <p class="card-text">Jumlah Peminjam Keseluruhan</p>
                        <h4><?= $user['jmluser'] ?></h4>
                        <a href="datapeminjam.php" class="card-link">Lihat Data Peminjam</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" style="width: 23rem; border: 3px solid #CBCBCB;">
                    <div class="card-body">
                    <?php 
                    $q = $conn->query("SELECT COUNT(*) AS jmlapprv FROM peminjaman WHERE status_pjm = 'Menunggu'");
                    $pinjam = $q->fetch_array();
                    
                    ?>
                        <h5 class="card-title">Pengajuan pinjamRuang POLNES</h5>
                        <p class="card-text">Sudah Menyelesaikan Proses Administrasi</p>
                        <h4><?= $pinjam['jmlapprv'] ?></h4>
                        <a href="datapinjam.php" class="card-link">Lihat Data Pengajuan</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-md-4 mt-4">
                <div class="card" style="width: 18rem; border: 3px solid #CBCBCB;">
                    <div class="card-body">
                    <?php 
                    $q = $conn->query("SELECT COUNT(*) AS jmltrpnjm FROM peminjaman WHERE status_pjm = 'Disetujui' ");
                    $pinjam = $q->fetch_array();
                    
                    ?>
                        <h5 class="card-title">Data pinjamRuang POLNES</h5>
                        <p class="card-text">Data Ruangan yang dipinjam</p>
                        <h4><?= $pinjam['jmltrpnjm'] ?></h4>
                        <a href="datapinjamRuang.php" class="card-link">Lihat Data Ruangan</a>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div> 
</body>
</html>
