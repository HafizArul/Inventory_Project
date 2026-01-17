<?php
session_start();
require 'config/koneksi.php'; // koneksi database

$pesan = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = "user"; // default role

    // cek username
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "<div class='alert alert-danger'>Username sudah digunakan!</div>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$hash', '$role')");
        $pesan = "<div class='alert alert-success'>Registrasi berhasil! <a href='login.php'>Login</a></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="css/styles.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height:100vh;">
            <div class="col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Register Akun</h3>
                    </div>
                    <div class="card-body p-4">

                        <?= $pesan ?>

                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                                <label>Username</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                                <label>Password</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="register" class="btn btn-primary btn-lg">
                                    Register
                                </button>
                            </div>

                            <p class="text-center mt-3">
                                Sudah punya akun?
                                <a href="login.php">Login</a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>