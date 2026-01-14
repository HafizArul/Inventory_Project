<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">


            <div class="nav">

                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                    ProjectBoard
                </a>

                <div class="sb-sidenav-menu-heading">Master Data</div>
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'proyek.php' ? 'active' : '' ?>" href="proyek.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                    Proyek
                </a>
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'barang.php' ? 'active' : '' ?>" href="barang.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Barang
                </a>
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'supplier.php' ? 'active' : '' ?>" href="supplier.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                    Supplier
                </a>

                <div class="sb-sidenav-menu-heading">Transaksi</div>
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'masuk.php' ? 'active' : '' ?>" href="masuk.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-down"></i></div>
                    Barang Masuk
                </a>
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'keluar.php' ? 'active' : '' ?>" href="keluar.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-up"></i></div>
                    Barang Keluar
                </a>

                <div class="sb-sidenav-menu-heading">Akun</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAuth">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                    Pengaturan
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
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