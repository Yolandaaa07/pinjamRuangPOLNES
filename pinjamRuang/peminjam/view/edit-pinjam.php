<?php

// User tidak bisa langsung mengakses sebelum login
if (!isset($_SESSION['peminjam_name'])) {
    header('Location: ../login.php');
    exit();
}

// Cek koneksi
$conn = new mysqli('localhost', 'root', '', 'pjmruang');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_pinjam = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM peminjaman WHERE id_pinjam = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id_pinjam);
    $stmt->execute();
    $result = $stmt->get_result();
    $pinjam = $result->fetch_assoc();
    $stmt->close();
} else {
    $_SESSION['pesan'] = "<div class='alert alert-danger'>Tidak ada ID yang dipilih</div>";
    header('Location: ../datapinjam.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $nohp = htmlspecialchars($_POST['nohp']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $date1 = htmlspecialchars($_POST['date1']);
    $date2 = htmlspecialchars($_POST['date2']);
    $time1 = htmlspecialchars($_POST['time1']);
    $time2 = htmlspecialchars($_POST['time2']);
    $nama_ruang = htmlspecialchars($_POST['nama_ruang']);
    $tujuan = htmlspecialchars($_POST['tujuan']);
    $lihatDokumen = $_FILES['doc'];

    // Validasi dan upload file jika ada
    $uploadOk = 1;
    $target_dir = "../peminjam/prosesuploads/";
    $target_file = $target_dir . basename($lihatDokumen["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah PDF atau DOCX
    if ($fileType != "pdf" && $fileType != "docx") {
        $_SESSION['pesan'] = "<div class='alert alert-danger'>Maaf, hanya PDF dan DOCX yang diizinkan.</div>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && move_uploaded_file($lihatDokumen["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("UPDATE peminjaman SET nama = ?, nohp = ?, date1 = ?, date2 = ?, time1 = ?, time2 = ?, nama_ruang = ?, tujuan = ?, doc = ? WHERE id_pinjam = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssssssssi", $nama, $nohp, $jurusan, $date1, $date2, $time1, $time2, $nama_ruang, $tujuan, $target_file, $id_pinjam);
    } else {
        $stmt = $conn->prepare("UPDATE peminjaman SET nama = ?, nohp = ?, jurusan = ?, date1 = ?, date2 = ?, time1 = ?, time2 = ?, nama_ruang = ?, tujuan = ? WHERE id_pinjam = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sssssssssi", $nama, $nohp, $jurusan, $date1, $date2, $time1, $time2, $nama_ruang, $tujuan, $id_pinjam);
    }

    if ($stmt->execute()) {
        $_SESSION['pesan'] = "<div class='alert alert-success'>Data berhasil diperbarui</div>";
    } else {
        $_SESSION['pesan'] = "<div class='alert alert-danger'>Terjadi kesalahan saat memperbarui data</div>";
    }
    $stmt->close();
    header('Location: ../datapinjam.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Pengajuan Jadwal pinjamRuang POLNES</title>
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
    <h2>Edit Pengajuan Jadwal pinjamRuang POLNES</h2>
    <hr>

    <a href="../peminjam/datapinjam.php" class="btn btn-success btn-sm float-left">&larr; Kembali</a>
    <div class="clearfix"></div>
    
    <form action="proses/proses_ubah_pinjam.php" method="post" enctype="multipart/form-data" autocomplete="off">
        <ul>
            <li>
                <input type="hidden" name="id" value="<?= htmlspecialchars($pinjam['id_pinjam']) ?>">
                <input type="hidden" name="old_doc" value="<?= htmlspecialchars($pinjam['doc']) ?>">
            </li>
            <li>
                <label for="nama">Nama Instansi:</label><br>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($pinjam['nama']) ?>" placeholder="Masukan Nama Instansi" required>
            </li>
            <br>
            <li>
                <label for="nohp">Nomor Telepon/WA:</label><br>
                <input type="tel" id="nohp" name="nohp" pattern="[0-9]{10,13}" value="<?= htmlspecialchars($pinjam['nohp']) ?>" placeholder="No Yang Dapat Dihubungi" required>
            </li>
            <br>
            <li>
                <label for="jurusan">Jurusan:</label><br>
                <input type="text" id="jurusan" name="jurusan" value="<?= htmlspecialchars($pinjam['jurusan']) ?>" placeholder="Masukan Jurusan" required>
            </li>
            <br>
            <li>
                <label for="date1">Tanggal Peminjaman:</label><br>
                <input type="date" id="date1" name="date1" value="<?= htmlspecialchars($pinjam['date1']) ?>" placeholder="Tanggal Mulai Peminjaman" required>
            </li>
            <br>
            <li>
                <label for="date2">Tanggal Selesai Peminjaman:</label><br>
                <input type="date" id="date2" name="date2" value="<?= htmlspecialchars($pinjam['date2']) ?>" placeholder="Tanggal Selesai Peminjaman" required>
            </li>
            <br>
            <li>
                <label for="time1">Waktu Peminjaman:</label><br>
                <input type="time" id="time1" name="time1" value="<?= htmlspecialchars($pinjam['time1']) ?>" placeholder="Waktu Mulai Peminjaman" required>
            </li>
            <br>
            <li>
                <label for="time2">Waktu Selesai Peminjaman:</label><br>
                <input type="time" id="time2" name="time2" value="<?= htmlspecialchars($pinjam['time2']) ?>" placeholder="Waktu Selesai Peminjaman" required>
            </li>
            <br>
            <li>
                <label for="nama_ruang">Ruangan:</label><br>
                <select id="nama_ruang" name="nama_ruang" required>
                    <?php
                    // Array of room options
                    $ruanganOptions = [
                        "Aula Rektorat Lt.4" => "Aula Rektorat Lt.4",
                        "Lapangan Gedung D4" => "Lapangan Gedung D4",
                        "Lapangan Auditorium" => "Lapangan Auditorium",
                        "Gedung Auditorium" => "Gedung Auditorium"
                    ];

                    // Get the previously selected room
                    $selectedRoom = htmlspecialchars($pinjam['nama_ruang']);

                    // First, output the selected room
                    if ($selectedRoom) {
                        echo '<option value="' . $selectedRoom . '" selected>' . $selectedRoom . '</option>';
                    }

                    // Output the rest of the rooms, excluding the selected one
                    foreach ($ruanganOptions as $key => $value) {
                        if ($value !== $selectedRoom) {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>

            </li>
            <br>
            <li>
                <label for="tujuan">Tujuan Peminjaman:</label><br>
                <textarea id="tujuan" name="tujuan" placeholder="Tujuan Peminjaman" required><?= htmlspecialchars($pinjam['tujuan']) ?></textarea>
            </li>
            <br>
            <li>
                <label for="doc">Unggah Surat:</label>
                <input type="file" id="doc" name="doc">
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file.</small>
            </li>
            <br>
           <div class="modal-footer">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
           </div>
        </ul>
    </form>
</div>
</body>
</html>
