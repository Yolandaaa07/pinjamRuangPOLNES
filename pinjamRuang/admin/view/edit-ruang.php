<div class="container mt-5">
    <h2>Ubah Data Ruangan</h2>
    <br>

    <!--tombol Kembali-->
    <a href="dataruang.php" class="btn btn-success btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>

    <?php
    //ambil data ruangan sesuai id ruang yang akan diubah
    $ruang = $conn->query("SELECT * FROM ruangan WHERE id_ruang = '$_GET[id]'");
    $data = $ruang->fetch_assoc();
    ?>

    <form action="proses/proses_ubah_ruang.php" method="post" class="mt-3" autocomplete="off">
        <input type="hidden" name="id" value ="<?= $data['id_ruang'] ?>">
        <div class="form-group">
            <label>Nama Ruangan</label>
            <input type ="text" name="nama_ruang" placeholder="Contoh: <?= $data['nama_ruang'] ?>" class="form-control"  
                required value ="<?= $data['nama_ruang']?>">
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Jenis Ruangan</label>
                    <input type ="text" name="jenis" placeholder="Contoh: <?= $data['jenis'] ?>" class="form-control"  
                        required value ="<?= $data['jenis']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Jumlah Ruangan</label>
                    <input type ="text" name="jumlah" placeholder="Minimal 1" class="form-control"  
                        required value ="<?= $data['jumlah']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Kondisi Ruangan</label>
                    <input type ="text" name="kondisi" placeholder="Contoh: <?= $data['kondisi'] ?>" class="form-control"  
                        required value ="<?= $data['kondisi']?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" placeholder="(Opsional)"><?= $data['keterangan'] ?></textarea>
                </div>
            </div>
            
            <div class="col-md-4">
            <br>
            <button type="submit" name="simpan" class="btn btn-success btn-sm" style="margin-top: 32px; width: 100%;">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>