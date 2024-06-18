<div class="container mt-5">
   <?php 
if (isset($_SESSION['pesan'])) {
    echo $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}
?> 
    <h2>Data Ruangan yang Telah di Pinjam</h2>
    <hr>

    <a href="../peminjam/index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>

    <table class="table table-sm mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama/Nama Instansi</th>
                <th>Ruangan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tujuan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; // inisialisasi ulang nomor
            foreach ($rsetuju as $r): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['nama']) ?></td>
                <td><?= htmlspecialchars($r['nama_ruang']) ?></td>
                <td><?= htmlspecialchars($r['date1']) ?></td>
                <td><?= htmlspecialchars($r['date2']) ?></td>
                <td><?= htmlspecialchars($r['tujuan']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
