<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary d-flex justify-content-between p-3">
    <div>
        <a class="navbar-brand ps-3" href="dashboard.php">INVENTORY SIMPK</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <!-- USER INFO -->
    <div class="sidebar-user text-white">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-user-circle fa-2x"></i>
            <div class="d-flex gap-2">
                <div class="name"><?= $_SESSION['nama'] ?? 'User'; ?></div>
                <div class="role">(<?= $_SESSION['role'] ?? 'user'; ?>)</div>
            </div>
        </div>
    </div>
</nav>