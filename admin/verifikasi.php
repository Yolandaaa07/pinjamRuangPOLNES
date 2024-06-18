<?php
require_once '../config/db.php';
require_once 'view/header.php';
session_start();

if (isset($_GET['verify_id'])) {
    $id = $_GET['verify_id'];
    $update = "UPDATE users SET verifikasi = 1 WHERE id_user = '$id'";
    mysqli_query($conn, $update);
    header('location:verifikasi.php');
    exit();
}

if (isset($_GET['reject_id'])) {
    $id = $_GET['reject_id'];
    $delete = "DELETE FROM users WHERE id_user = '$id'";
    mysqli_query($conn, $delete);
    header('location:verifikasi.php');
    exit();
}

$select = "SELECT * FROM users WHERE verifikasi = 0";
$result = mysqli_query($conn, $select);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/logopolnes.png">
</head>
<body>

<div class="container mt-5">
    <h2>Daftar Pengguna yang Menunggu Verifikasi</h2>
    <hr>
    <a href="../admin/index.php" class="btn btn-primary btn-sm float-left">&larr; Kembali</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama/Nama Instansi</th>
                <th>Email</th>
                <th>Mendaftar Sebagai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['user_type']; ?></td>
                <td>
                    <a href="verifikasi.php?verify_id=<?php echo $row['id_user']; ?>" class="btn btn-success">Verifikasi</a>
                    <a href="verifikasi.php?reject_id=<?php echo $row['id_user']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak pengguna ini?');">Tolak</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pFj5pC/lFzq4ZmnkANXoPfMSXePY64h/0PKV1Dqx0KpDVc3QwrnDfnLpCeyj7FO7" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-pFj5pC/lFzq4ZmnkANXoPfMSXePY64h/0PKV1Dqx0KpDVc3QwrnDfnLpCeyj7FO7" crossorigin="anonymous"></script>
</script>
</body>
</html>
