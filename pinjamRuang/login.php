<?php
require_once("config/helper.php");
require_once("config/db.php");
session_start();

$errors = [];
$email = "";
$password = "";
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $select = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $select);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['verifikasi'] == 0) {
            $errors[] = 'Akun Anda belum diverifikasi oleh admin.';
        } elseif (password_verify($password, $row['pw'])) {
            $_SESSION['nama'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];

            if ($row['user_type'] == 'Administrator') {
                $_SESSION['admin_name'] = $row['username'];
                header('location: admin/index.php');
                exit(); // Pastikan untuk keluar dari skrip setelah pengalihan header
            } elseif ($row['user_type'] == 'Peminjam') {
                $_SESSION['peminjam_name'] = $row['username'];
                header('location: peminjam/index.php');
                exit();
            }
        } else {
            $errors[] = 'Email atau Password Salah!';
        }
    } else {
        $errors[] = 'Email atau Password Salah!';
    }
}
?>


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login pinjamRuang POLNES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/logopolnes.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="images/logopolnes.png">
    <style>
        ul, li {
            list-style-type: none;
        }
        body {
            width: 100%;
            height: 100%;
            padding-top: 200px;
        }
       .error-msg {
            margin: 10px 0;
            display: block;
            background: crimson;
            color: #fff;
            border-radius: 5px;
            font-size: 20px;
            padding: 10px;
        }
        .card-header img {
            width: 20px; 
            height: 28px; 
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="card col-2 sm-4 mx-auto mt-5">
    <div class="card-header">
        <img src="images/logopolnes.png" alt="Logo"> Login pinjamRuang POLNES
    </div>
    <div class="card-body">
        <form action="" method="post">
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <ul>
                <li>
                    <label for="email">Email Instansi :</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email Terdaftar" autofocus required>
                </li>
                <li>
                    <label for="password">Kata Sandi :</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Kata Sandi" required>
                </li>
                <br>
                <li>
                    <input type="submit" name="submit" class="btn btn-success d-grid gap-2 col-4 mx-auto" value="Masuk">
                    <br>
                    <p>Belum punya akun? <a href="registrasi.php">Daftar sini</a>
                    Hubungi: 085753242650</p>
                </li>
            </ul>
        </form>
    </div>
</div>
</body>
</html>
