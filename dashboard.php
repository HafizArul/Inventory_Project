<?php
session_start();
require_once __DIR__ . '/config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_proyek = $_SESSION['id_proyek'] ?? 1;

/* CARD */
$total_proyek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM proyek"))['total'];
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM barang"))['total'];
$barang_masuk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(jumlah),0) total FROM barang_masuk"))['total'];
$barang_keluar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(jumlah),0) total FROM barang_keluar"))['total'];

/* PROGRESS */
$progress = mysqli_query($conn, "
    SELECT 
        tp.id_tahap,
        tp.nama_tahap,
        SUM(kp.jumlah_kebutuhan) AS total_kebutuhan,
        IFNULL(SUM(bk.jumlah), 0) AS total_terpakai,
        ROUND(
            IFNULL(SUM(bk.jumlah), 0) 
            / NULLIF(SUM(kp.jumlah_kebutuhan), 0) * 100
        ) AS persen
    FROM kebutuhan_proyek kp
    JOIN tahap_proyek tp ON kp.id_tahap = tp.id_tahap
    LEFT JOIN barang_keluar bk 
        ON bk.id_proyek = kp.id_proyek
        AND bk.id_barang = kp.id_barang
        AND bk.id_tahap = kp.id_tahap
    WHERE kp.id_proyek = $id_proyek
    GROUP BY tp.id_tahap, tp.nama_tahap
");

/* LOG */
$log = mysqli_query($conn, "
    SELECT b.nama_barang, bk.jumlah, bk.tanggal, tp.nama_tahap
    FROM barang_keluar bk
    JOIN barang b ON bk.id_barang = b.id_barang
    JOIN tahap_proyek tp ON bk.id_tahap = tp.id_tahap
    WHERE bk.id_proyek = $id_proyek
    ORDER BY bk.tanggal DESC
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard Proyek</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="sb-nav-fixed">

    <!-- NAVBAR -->
    <?php include 'navbar.php'; ?>


    <div id="layoutSidenav">

        <!-- SIDEBAR -->
        <div id="layoutSidenav_nav">
            <?php include 'sidebar.php'; ?>
        </div>

        <!-- CONTENT -->
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4">

                <h1 class="mt-4">Dashboard Proyek</h1>

                <!-- CARD -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Total Proyek</div>
                            <div class="card-footer"><?= $total_proyek ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Total Barang</div>
                            <div class="card-footer"><?= $total_barang ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Barang Masuk</div>
                            <div class="card-footer"><?= $barang_masuk ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Barang Keluar</div>
                            <div class="card-footer"><?= $barang_keluar ?></div>
                        </div>
                    </div>
                </div>

                <!-- PROGRESS -->
                <div class="card mb-4">
                    <div class="card-header">Progress Tahap Proyek</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tahap</th>
                                    <th>Kebutuhan</th>
                                    <th>Terpakai</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($p = mysqli_fetch_assoc($progress)) { ?>
                                    <tr>
                                        <td><?= $p['nama_tahap'] ?></td>
                                        <td><?= $p['total_kebutuhan'] ?></td>
                                        <td><?= $p['total_terpakai'] ?></td>
                                        <td>
                                            <div class="progress">
                                                <div
                                                    class="progress-bar bg-success"
                                                    role="progressbar"
                                                    style="width: <?= $p['persen'] > 100 ? '0%' : $p['persen'] . '%'  ?>">
                                                    <?= $p['persen'] ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- LOG -->
                <div class="card mb-4">
                    <div class="card-header">Riwayat Barang Keluar</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Tahap</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($l = mysqli_fetch_assoc($log)) { ?>
                                    <tr>
                                        <td><?= $l['nama_barang'] ?></td>
                                        <td><?= $l['nama_tahap'] ?></td>
                                        <td><?= $l['jumlah'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($l['tanggal'])) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="text-muted">© Inventory Proyek 2026</div>
                </div>
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>