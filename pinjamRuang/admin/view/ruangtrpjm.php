<div class="container mt-5">
   <?php 
if (isset($_SESSION['pesan'])) {
    echo $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}
?> 
    <h2>Data Ruangan yang Telah di Pinjam</h2>
    <hr>

    <a href="../admin/index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>

    <table class="table table-sm mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Instansi</th>
                <th>Ruangan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tujuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; // inisialisasi ulang nomor
            foreach ($rsetuju as $s): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($s['nama']) ?></td>
                <td><?= htmlspecialchars($s['nama_ruang']) ?></td>
                <td><?= htmlspecialchars($s['date1']) ?></td>
                <td><?= htmlspecialchars($s['date2']) ?></td>
                <td><?= htmlspecialchars($s['tujuan']) ?></td>
                <td>
                    <div class="d-inline">
                        <a href="?p=hapus-peminjam&id=<?= htmlspecialchars($s['id_pinjam']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apa yakin menghapus data ini?')">Hapus</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
