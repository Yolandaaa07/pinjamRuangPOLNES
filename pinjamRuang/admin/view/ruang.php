<div class="container mt-5">
   <?php 
if (isset($_SESSION['pesan'])) {
    echo $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}
?> 
    <h2>Data Ruangan POLNES</h2>
    <hr>

    <a href="index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Tambah Data
    </button>
    <div class="clearfix"></div>

    <table class="table table-sm mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Ruangan</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_ruang as $ruang) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($ruang['nama_ruang']); ?></td>
                    <td><?= htmlspecialchars($ruang['kondisi']); ?></td>
                    <td><?= htmlspecialchars($ruang['jumlah']); ?></td>
                    <td><?= htmlspecialchars($ruang['jenis']); ?></td>
                    <td>
                        <div class="d-inline">
                            <a href="?p=detail-ruang&id=<?= $ruang['id_ruang']; ?>" class="btn btn-primary btn-sm">Detail</a>
                            <a href="?p=edit-ruang&id=<?= $ruang['id_ruang']; ?>" class="btn btn-success btn-sm">Ubah</a>
                            <a href="?p=hapus-ruang&id=<?= $ruang['id_ruang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apa yakin menghapus data ini?')">Hapus</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Ruangan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="dataruang.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="nama_ruang">Nama Ruangan</label>
                <input type="text" name="nama_ruang" placeholder="Contoh: Lapangan D4" class="form-control" autofocus required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis">Jenis Ruangan</label>
                        <input type="text" name="jenis" placeholder="Contoh: Outdoor" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jumlah">Jumlah Ruangan</label>
                        <input type="number" name="jumlah" placeholder="Min. 1" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                     <div class="form-group">
                        <label for="kondisi">Kondisi Ruangan</label>
                        <input type="text" name="kondisi" placeholder="Contoh: Baik" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" placeholder="(Opsional)" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
