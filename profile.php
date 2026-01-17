<?php
session_start();
require_once __DIR__ . '/config/koneksi.php';

/* ================= CEK LOGIN ================= */
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['id_user'])) {
    die("Session user tidak valid. Silakan login ulang.");
}

$id_user = (int) $_SESSION['id_user'];

/* ================= UPDATE PROFIL ================= */
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    $update = mysqli_query($conn, "
        UPDATE users 
        SET nama = '$nama'
        WHERE id_user = $id_user
    ");

    if ($update) {
        header("Location: profile.php?success=1");
        exit;
    } else {
        die("Gagal update profile");
    }
}

/* ================= AMBIL DATA USER ================= */
$query = mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_user");

if (!$query || mysqli_num_rows($query) === 0) {
    die("Data user tidak ditemukan");
}

$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Profil User</title>

<link href="css/styles.css" rel="stylesheet">
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="sb-nav-fixed">

<!-- TOP NAV -->
<?php include 'navbar.php'; ?>

<div id="layoutSidenav">

<!-- SIDEBAR -->
<?php include 'sidebar.php'; ?>

<!-- CONTENT -->
<div id="layoutSidenav_content">
<main class="container-fluid px-4">

<h1 class="mt-4">Profil Saya</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        Profile berhasil diperbarui
    </div>
<?php endif; ?>

<div class="card col-md-6">
<div class="card-body">

<form method="post">
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text"
               name="nama"
               class="form-control"
               value="<?= htmlspecialchars($user['nama']) ?>"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text"
               class="form-control"
               value="<?= htmlspecialchars($user['username']) ?>"
               readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <input type="text"
               class="form-control"
               value="<?= htmlspecialchars($user['role']) ?>"
               readonly>
    </div>

    <button type="submit" name="update" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan Perubahan
    </button>
</form>

</div>
</div>

</main>

<footer class="py-4 bg-light mt-auto">
<div class="container-fluid px-4">
<div class="text-muted">Copyright &copy; Simpk Website 2026</div>
</div>
</footer>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
