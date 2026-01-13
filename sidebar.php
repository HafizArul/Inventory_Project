<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="layoutSidenav_nav">
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
<div class="sb-sidenav-menu">
<div class="nav">

<div class="sb-sidenav-menu-heading">User</div>
<div class="px-3 mb-3 text-white small">
    <div><i class="fas fa-user-circle"></i> <?= $_SESSION['nama'] ?? 'User'; ?></div>
    <div class="text-muted"><?= $_SESSION['role'] ?? 'user'; ?></div>
</div>

<div class="sb-sidenav-menu-heading">Core</div>
<a class="nav-link active" href="dashboard.php">
    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
    ProjectBoard
</a>

<div class="sb-sidenav-menu-heading">Data</div>
<a class="nav-link" href="proyek.php">Proyek</a>
<a class="nav-link" href="barang.php">Barang</a>
<a class="nav-link" href="masuk.php">Barang Masuk</a>
<a class="nav-link" href="keluar.php">Barang Keluar</a>
<a class="nav-link" href="supplier.php">Supplier</a>

<div class="sb-sidenav-menu-heading">Akun</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAuth">
    <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
    Pengaturan Akun
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>

<div class="collapse" id="collapseAuth" data-bs-parent="#sidenavAccordion">
<nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="profile.php">Profil</a>
    <a class="nav-link" href="password.php">Ganti Password</a>
    <a class="nav-link text-danger" href="logout.php">Logout</a>
</nav>
</div>

</div>
</div>
</nav>
</div>
