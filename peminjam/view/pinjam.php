<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Jadwal pinjamRuang POLNES</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="icon" type="image/png" href="images/logopolnes.png">
<style>
    ul, li {
        list-style-type: none;
    }
</style>
</head>
<body>
<div class="container mt-5">
    <?php

    if (isset($_SESSION['pesan'])) {
        echo $_SESSION['pesan'];
        unset($_SESSION['pesan']);
    }
    ?>
    <h2>Data pinjamRuang</h2>
    <hr>

    <a href="../peminjam/index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Tambah Data
    </button>
    <div class="clearfix"></div>

    <table class="table table-sm mt-3">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Instansi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Ruangan</th>
                <th>Tujuan</th>
                <th>Surat</th>
                <th>Aksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
$conn = mysqli_connect('localhost', 'root', '', 'pjmruang');
$nama = $_SESSION['nama'];
$query = "SELECT * FROM peminjaman WHERE nama = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nama);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $no = 1;
    while ($pinjam = $result->fetch_assoc()) {
        $docPath = "../peminjam/prosesuploads/" . htmlspecialchars($pinjam['doc']);
        $lihatDokumen = file_exists($docPath)
            ? "<a href='" . htmlspecialchars($docPath) . "' target='_blank' class='btn btn-warning btn-sm' title='lihat' style='color: white;'>Lihat Dokumen</a>"
            : "<span class='text-danger'>Dokumen tidak ditemukan</span>";
        echo "<tr>
                <td>{$no}</td>
                <td>" . htmlspecialchars($pinjam['nama']) . "</td>
                <td>" . htmlspecialchars($pinjam['date1']) . "</td>
                <td>" . htmlspecialchars($pinjam['date2']) . "</td>
                <td>" . htmlspecialchars($pinjam['time1']) . "</td>
                <td>" . htmlspecialchars($pinjam['time2']) . "</td>
                <td>" . htmlspecialchars($pinjam['nama_ruang']) . "</td>
                <td>" . htmlspecialchars($pinjam['tujuan']) . "</td>
                <td>
                    <div>
                        " . $lihatDokumen . "
                    </div>
                </td>
                <td>
                    <div class='d-inline'>
                        <a href='?p=detail-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' class='btn btn-primary btn-sm'>Detail</a>
                        <a href='?p=edit-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' class='btn btn-success btn-sm'>Ubah</a>
                        <a href='?p=hapus-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                    </div>
                </td>
                <td>
                    <div>
                        <span class='badge bg-" . ($pinjam['status_pjm'] == 'Disetujui' ? 'success' : ($pinjam['status_pjm'] == 'Ditolak' ? 'danger' : 'warning')) . "'>" . htmlspecialchars($pinjam['status_pjm']) . "</span>
                    </div>
                </td>
            </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>";
}
?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pengajuan Jadwal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../peminjam/proses/proses_tambah_pinjam.php" method="post" enctype="multipart/form-data">
                    <ul>
                        <li>
                            <label for="nama">Nama Instansi</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($nama); ?>" readonly>
                        </li>
                        <li>
                            <label for="nohp">Nomor Telepon/WA</label>
                            <input type="text" name="nohp" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </li>
                        <li>
                            <label for="jurusan">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" placeholder="Masukan Jurusan" required>
                        </li>
                        <li>
                            <label for="date1">Tanggal Mulai</label>
                            <input type="date" name="date1" class="form-control" required>
                        </li>
                        <li>
                            <label for="date2">Tanggal Selesai</label>
                            <input type="date" name="date2" class="form-control" required>
                        </li>
                        <li>
                            <label for="time1">Waktu Mulai</label>
                            <input type="time" name="time1" class="form-control" required>
                        </li>
                        <li>
                            <label for="time2">Waktu Selesai</label>
                            <input type="time" name="time2" class="form-control" required>
                        </li>
                        <li>
                                <label for="nama_ruang">Ruangan</label>
                                <select name="nama_ruang" class="form-select" required>
                                    <option value="">Pilih Ruangan</option>
                                    <?php foreach ($ruangan as $r) : ?>
                                        <option value="<?= htmlspecialchars($r['nama_ruang']); ?>"><?= htmlspecialchars($r['nama_ruang']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                        <li>
                            <label for="tujuan">Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" placeholder="Masukkan Tujuan" required>
                        </li>
                        <li>
                            <label for="doc">Surat Pengajuan</label>
                            <p style="color:red;">Dimohon kirim surat dalam format PDF</p>
                            <input type="file" name="doc" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg" required>
                        </li>
                    </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </div>
                </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-rfUVe5w0H1spv6VO9e0o4XE4pBmTfE9Qddydpfspryys8bbBybb5fpB1bTvSX0bQ" crossorigin="anonymous"></script>
</body>
</html>
