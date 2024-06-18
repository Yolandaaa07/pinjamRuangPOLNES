<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Jadwal pinjamRuang POLNES</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
<h2>Data Persetujuan pinjamRuang</h2>
<hr>

<a href="../admin/index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
<div class="clearfix"></div>

<table id="pinjamtb" class="table table-sm mt-3">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Instansi</th>
            <th>Nomor Telepon/WA</th>
            <th>Jurusan</th>
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
        $conn = new mysqli('localhost', 'root', '', 'pjmruang');
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $query = "SELECT * FROM peminjaman WHERE status_pjm = 'Menunggu'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $no = 1;
            while ($pinjam = $result->fetch_assoc()) {
                if ($pinjam['status_pjm'] === 'Ditolak') continue;
                
                $docPath = "../../pinjamruang/peminjam/prosesuploads/" . htmlspecialchars($pinjam['doc']);
                $lihatDokumen = file_exists("../peminjam/prosesuploads/" . $pinjam['doc'])
                    ? "<a href='" . htmlspecialchars($docPath) . "' target='_blank' class='btn btn-warning btn-sm' title='lihat' style='color: white;'>Lihat Dokumen</a>"
                    : "<span class='text-danger'>Dokumen tidak ditemukan</span>";

                echo "<tr id='row-{$pinjam['id_pinjam']}'>
                        <td>{$no}</td>
                        <td>" . htmlspecialchars($pinjam['nama']) . "</td>
                        <td>" . htmlspecialchars($pinjam['nohp']) . "</td>
                        <td>" . htmlspecialchars($pinjam['jurusan']) . "</td>
                        <td>" . htmlspecialchars($pinjam['date1']) . "</td>
                        <td>" . htmlspecialchars($pinjam['date2']) . "</td>
                        <td>" . htmlspecialchars($pinjam['time1']) . "</td>
                        <td>" . htmlspecialchars($pinjam['time2']) . "</td>
                        <td>" . htmlspecialchars($pinjam['nama_ruang']) . "</td>
                        <td>" . htmlspecialchars($pinjam['tujuan']) . "</td>
                        <td>{$lihatDokumen}</td>
                        <td>
                            <div class='d-inline'>
                                <a href='?p=hapus-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apa yakin menghapus data ini?\")'>Hapus</a>
                            </div>
                        </td>
                        <td>
                            <button class='btn btn-success setujui' data-id='{$pinjam['id_pinjam']}'>Setuju</button>
                            <button class='btn btn-danger tolak' data-id='{$pinjam['id_pinjam']}'>Tolak</button>
                        </td>
                        <td id='status-{$pinjam['id_pinjam']}'>" . htmlspecialchars($pinjam['status_pjm']) . "</td>
                    </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pFj5pC/lFzq4ZmnkANXoPfMSXePY64h/0PKV1Dqx0KpDVc3QwrnDfnLpCeyj7FO7" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('.setujui, .tolak').click(function() {
        var id = $(this).data('id');
        var action = $(this).hasClass('setujui') ? 'setuju' : 'tolak';

        if (action === 'tolak' && !confirm("Apakah anda yakin menolak pinjamRuang ini?")) {
            return false;
        }

        $.ajax({
            url: 'datapinjam.php',
            type: 'POST',
            data: {
                id_pinjam: id,
                [action]: true
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    if (action === 'tolak') {
                        $('#row-' + id).remove();
                    } else {
                        $('#status-' + id).text(data.status_pjm);
                    }
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            }
        });
    });
});
</script>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pFj5pC/lFzq4ZmnkANXoPfMSXePY64h/0PKV1Dqx0KpDVc3QwrnDfnLpCeyj7FO7" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pFj5pC/lFzq4ZmnkANXoPfMSXePY64h/0PKV1Dqx0KpDVc3QwrnDfnLpCeyj7FO7" crossorigin="anonymous"></script>
</script>
</body>
</html>