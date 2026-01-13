<?php
session_start();
require 'config/koneksi.php';

$pesan = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc($cekdatabase);

    if ($data) {
     if (password_verify($password, $data['password'])) {

    $_SESSION['login']   = true;
    $_SESSION['id_user'] = $data['id_user'];   // INI WAJIB ADA
    $_SESSION['username']= $data['username'];
    $_SESSION['nama']    = $data['nama'];      // kolom nama sudah ditambah
    $_SESSION['role']    = $data['role'];

    header("Location: dashboard.php");
    exit;


        } else {
            $pesan = "<div class='alert alert-danger'>Password salah!</div>";
        }
    } else {
        $pesan = "<div class='alert alert-danger'>Username tidak ditemukan!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Login</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light"> <!-- Ganti background body -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg mt-5" style="border-radius: 15px; border: 2px solid #ffffff;">
                <div class="card-header text-center" style="background-color: #e7b45c; color: #ffffff; font-weight: bold;">
                    <h3>Inventory SIMPK</h3>
                </div>
                <div class="card-body">

                    <?= $pesan ?>

                    <form method="POST">
                        <div class="form-floating mb-3">
                            <input class="form-control" name="username" required>
                            <label>Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" required>
                            <label>Password</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="login" class="btn" style="background-color: #28a745; color: #fff; font-weight: bold;">
                                Login
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
