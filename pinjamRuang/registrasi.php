<?php
require 'config/db.php';

$errors = array(); // Menyimpan pesan kesalahan
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $user_type = $_POST['user_type'];

    $select = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $errors[] = 'Akun Sudah Terdaftar!';
    } else {
        if($password != $password2){
            $errors[] = 'Kata Sandi Tidak Sama!';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $verifikasi = $user_type == 'Administrator' ? 0 : 1; // Set is_verified to 0 for admin

            $insert = "INSERT INTO users (username, email, pw, user_type, verifikasi) VALUES ('$username','$email','$hashed_password','$user_type','$verifikasi')";
            mysqli_query($conn, $insert);
            header('location:login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi pinjamRuang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/logopolnes.png">
    <style>
        label{
            display: block;
        }
        ul, li{
            list-style-type: none;
        }
        .error-msg{
            margin: 10px 0;
            display: block;
            background: crimson;
            color: #fff;
            border-radius: 5px;
            font-size: 20px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="card col-3 sm-4 mx-auto mt-5">
     <div class="card-header">
    <h1>Halaman Registrasi</h1>
     </div>
     <div class="card-body">
    <form action="" method="post">
    <?php
      if(!empty($errors)){
         foreach($errors as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
    ?>
        <ul>
            <li>
                <label for ="username">Nama/Nama Instansi :</label>
                <input type = "text" name ="username" id ="username" placeholder="Masukan Nama/Nama Instansi">
            </li>
            <br>
            <li>
                <label for ="email">Email :</label>
                <input type = "email" name ="email" id ="email" placeholder="Masukan Email">
            </li>
            <br>
            <li>
                <label for ="password">Kata Sandi :</label>
                <input type = "password" name ="password" id ="password" placeholder="Masukan Kata Sandi">
            </li>
            <br>
            <li>
                <label for ="password2">Konfirmasi Password :</label>
                <input type = "password" name ="password2" id ="password2"placeholder="Konfirmasi Kata Sandi">
            </li>
            <br>
            <li>
                  <label for ="user_type">Ingin Mendaftar Sebagai: </label>
                  <select name="user_type" id="user_type">
                    <option value="">--Daftar Sebagai--</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Peminjam">Peminjam</option>
                  </select>
              </li>
              <br>
            <li>
                <input type="submit" name="submit" class="btn btn-success d-grid gap-2 col-4 mx-auto" value="Daftar Sekarang">
                <br>
                <p class="text-center text-danger">*Harap Menunggu Verifikasi Akun Terlebih Dahulu</p>
                <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
            </li>
        </ul>
    </form>
    </div>
</div>
</body>
</html>
