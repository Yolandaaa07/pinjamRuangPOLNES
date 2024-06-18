<div class= "container mt-5">
<?php 
if (isset($_SESSION['pesan'])) {
    echo $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

?> 
    <h2>Data Ruangan POLNES</h2>
    <hr>

    <a href="index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>

    <table class="table table-sm mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Ruangan</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ruangan as $r) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $r['nama_ruang']; ?></td>
                    <td><?= $r['kondisi']; ?></td>
                    <td><?= $r['jumlah']; ?></td>
                    <td><?= $r['jenis']; ?></td>
                    <td><?= $r['keterangan']; ?></td>
                </tr>
                <?php endforeach;?>
        </tbody>
    </table>
</div>

