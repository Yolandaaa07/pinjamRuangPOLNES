<?php
// Buat koneksi
$conn = mysqli_connect('localhost', 'root', '', 'pjmruang');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Fungsi untuk mendapatkan data peminjaman yang belum diverifikasi
function getPeminjamanBelumVerifikasi($conn) {
    $sql = "SELECT * FROM peminjaman WHERE status_pjm = 'Belum'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}
$no=1;
// Mendapatkan data peminjaman yang belum diverifikasi
$peminjaman_belum_verifikasi = getPeminjamanBelumVerifikasi($conn);

// Fungsi untuk menyetujui peminjaman
function setujuiPeminjaman($conn, $id_peminjaman) {
    $sql = "UPDATE peminjaman SET status_pjm = 'Disetujui' WHERE id = $id_peminjaman";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menolak peminjaman
function tolakPeminjaman($conn, $id_peminjaman) {
    $sql = "UPDATE peminjaman SET status_pjm = 'Ditolak' WHERE id = $id_peminjaman";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['setujui'])) {
        $id_peminjaman = $_POST['id_pinjam'];
        if (setujuiPeminjaman($conn, $id_peminjaman)) {
            echo "Peminjaman berhasil disetujui.";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['tolak'])) {
        $id_peminjaman = $_POST['id_pinjam'];
        if (tolakPeminjaman($conn, $id_peminjaman)) {
            echo "Peminjaman berhasil ditolak.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Tampilkan peminjaman yang belum diverifikasi
if (!empty($peminjaman_belum_verifikasi)) {
    echo "<h2>Peminjaman Ruangan yang Belum Diverifikasi</h2>";
    echo "<table border='1'>
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
        </tr>";
        require_once 'pinjam.php';
    foreach ($peminjaman_belum_verifikasi as $pinjam) {
        echo "<tr>";
        echo "<td>". $no++; ."</td>";
            echo "<td>" . htmlspecialchars($pinjam['nama']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['nohp']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['jurusan']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['date1']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['date2']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['time1']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['time2']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['nama_ruang']) . "</td>";
            echo "<td>" . htmlspecialchars($pinjam['tujuan']) . "</td>";
            echo "<td>"
                    <div>
                        " . $lihatDokumen . "
                    </div>
                "</td>";
            echo "<td>"
                    <div class='d-inline'>
                        <a href='?p=detail-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' class='btn btn-primary btn-sm'>Detail</a>
                        <a href='?p=edit-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' class='btn btn-success btn-sm'>Ubah</a>
                        <a href='?p=hapus-pinjam&id=" . htmlspecialchars($pinjam['id_pinjam']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apa yakin menghapus data ini?\")'>Hapus</a>
                    </div>
                 "</td>";
            echo "<td>
                <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                    <input type='hidden' name='id_peminjaman' value='" . $pinjam['id'] . "'>
                    <input type='submit' name='setujui' value='Setujui'>
                    <input type='submit' name='tolak' value='Tolak'>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada peminjaman yang belum diverifikasi.";
}

$conn->close();
?>
