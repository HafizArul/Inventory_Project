<?php
session_start();
require 'config/koneksi.php'; // koneksi database

$pesan = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = "user"; // default role

    // cek username sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "<div class='alert alert-danger'>Username sudah digunakan!</div>";
    } else {
        // hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // simpan ke DB
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$hash', '$role')");
        $pesan = "<div class='alert alert-success'>Registrasi berhasil! <a href='login.php'>Login</a></div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg mt-5">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Register</h3>
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
                            <button type="submit" name="register" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                        <p class="mt-2">Sudah punya akun? <a href="login.php">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
