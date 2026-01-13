<?php
session_start();
require_once __DIR__ . '/config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$pesan = "";

if (isset($_POST['ubah'])) {
    $lama = $_POST['password_lama'];
    $baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi'];

    $query = mysqli_query($conn, "SELECT password FROM users WHERE id_user = $id_user");
    $user = mysqli_fetch_assoc($query);

    if (!password_verify($lama, $user['password'])) {
        $pesan = "<div class='alert alert-danger'>Password lama salah</div>";
    } elseif ($baru !== $konfirmasi) {
        $pesan = "<div class='alert alert-danger'>Konfirmasi password tidak cocok</div>";
    } else {
        $hash = password_hash($baru, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$hash' WHERE id_user=$id_user");
        $pesan = "<div class='alert alert-success'>Password berhasil diubah</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Ganti Password</title>
<link href="css/styles.css" rel="stylesheet">
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="bg-primary">

<div id="layoutAuthentication">
<div id="layoutAuthentication_content">
<main>
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-5">

<div class="card shadow-lg border-0 rounded-lg mt-5">
<div class="card-header">
<h3 class="text-center my-4">Ganti Password</h3>
</div>

<div class="card-body">

<?= $pesan ?>

<form method="post">
    <div class="form-floating mb-3">
        <input type="password" name="password_lama" class="form-control" required>
        <label>Password Lama</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" name="password_baru" class="form-control" required>
        <label>Password Baru</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" name="konfirmasi" class="form-control" required>
        <label>Konfirmasi Password</label>
    </div>

    <div class="d-grid">
        <button type="submit" name="ubah" class="btn btn-primary">
            <i class="fas fa-key"></i> Simpan Password
        </button>
    </div>
</form>

</div>

<div class="card-footer text-center py-3">
<a href="dashboard.php">Kembali ke Dashboard</a>
</div>

</div>

</div>
</div>
</div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

