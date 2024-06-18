<div class="container mt-5">
    <h2>Detail pinjamRuang</h2>
    <hr>

    <a href="dataruang.php" class="btn btn-success btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>
    <?php 
    $q = $conn->query("SELECT * FROM ruangan INNER JOIN users WHERE id_ruang = '$_GET[id]'");
    $data = $q->fetch_assoc();
    ?>

    <div class="card mt-3">
        <div class="card-header">
            <b><?= $data['nama_ruang'] ?></b>
        </div>
        <div class="card-body">
            <p>Jenis Ruang: <?= $data['jenis'] ?></p>
            <p>Jumlah: <?= $data['jumlah'] ?></p>
            <p>Kondisi: <?= $data['kondisi'] ?></p>
            <p>Keterangan: <?= $data['keterangan'] ?></p>
        </div>
    </div>