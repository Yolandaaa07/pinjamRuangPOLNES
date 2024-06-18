<div class="container mt-5">
   <?php 
if (isset($_SESSION['pesan'])) {
    echo $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

?> 
    <h2>Data Peminjam</h2>
    <hr>

    <a href="index.php" class="btn btn-success btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>

    <table class="table table-sm mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Instansi</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peminjam as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['username'] ?></td>
                <td><?= $p['email'] ?></td>
                <td>
                    <div class="d-inline">
                        <a href="?p=hapus-peminjam&id=<?= $p['id_user'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apa yakin menghapus data ini?')">Hapus</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>