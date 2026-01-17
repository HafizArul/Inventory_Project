<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "proyek_inventory");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

/* ================= DATA TABEL ================= */
$dataKeluar = mysqli_query($conn, "
    SELECT bk.id_keluar, b.nama_barang, p.nama_proyek, bk.jumlah, bk.tanggal
    FROM barang_keluar bk
    JOIN barang b ON bk.id_barang = b.id_barang
    JOIN proyek p ON bk.id_proyek = p.id_proyek
    ORDER BY bk.tanggal DESC
");

/* ================= DROPDOWN ================= */
$barang = mysqli_query($conn, "SELECT id_barang, nama_barang FROM barang");
$proyek = mysqli_query($conn, "SELECT id_proyek, nama_proyek FROM proyek");
$tahap  = mysqli_query($conn, "SELECT id_tahap, nama_tahap FROM tahap_proyek");

// Cek apakah form telah disubmit
if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $id_proyek = $_POST['id_proyek'];
    $id_tahap  = $_POST['id_tahap'];
    $jumlah    = $_POST['jumlah'];
    $tanggal   = $_POST['tanggal'];

    // Insert data ke database
    $insertSql = "INSERT INTO barang_keluar (id_barang, id_proyek, id_tahap, jumlah, tanggal) 
                  VALUES ('$id_barang', '$id_proyek', '$id_tahap', '$jumlah', '$tanggal')";

    if (mysqli_query($conn, $insertSql)) {
        // Redirect atau tampilkan pesan sukses
        header("Location: keluar.php");
        exit;
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Barang Keluar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <?php include 'navbar.php'; ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include 'sidebar.php'; ?>
        </div>

        <div id="layoutSidenav_content">
            <main class="container-fluid px-4">

                <h1 class="mt-4">Barang Keluar</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard / Barang Masuk</li>
                </ol>
                <button class="btn btn-primary mb-3"
                    data-bs-toggle="modal"
                    data-bs-target="#modalKeluar">
                    <i class="fas fa-plus"></i> Tambah Barang Keluar
                </button>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-boxes me-1"></i>
                        Data Barang Keluar
                    </div>
                    <div class="card-body">

                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barang</th>
                                    <th>Proyek</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($dataKeluar)) { ?>
                                    <tr>
                                        <td><?= $row['id_keluar'] ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['nama_proyek'] ?></td>
                                        <td><?= $row['jumlah'] ?></td>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td>
                                            <button class='btn btn-sm btn-warning'><i class='bi bi-pencil-square'></i></button>
                                            <button class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- ================= MODAL ================= -->
    <div class="modal fade" id="modalKeluar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Input Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="post" action="">

                        <div class="mb-3">
                            <label class="form-label">Barang</label>
                            <select name="id_barang" class="form-select" required>
                                <option value="">Pilih Barang</option>
                                <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                                    <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Proyek</label>
                            <select name="id_proyek" class="form-select" required>
                                <option value="">Pilih Proyek</option>
                                <?php while ($p = mysqli_fetch_assoc($proyek)) { ?>
                                    <option value="<?= $p['id_proyek'] ?>"><?= $p['nama_proyek'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tahap Proyek</label>
                            <select name="id_tahap" class="form-select" required>
                                <option value="">Pilih Tahap</option>
                                <?php while ($t = mysqli_fetch_assoc($tahap)) { ?>
                                    <option value="<?= $t['id_tahap'] ?>"><?= $t['nama_tahap'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary w-100">
                            Simpan
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= SCRIPT ================= -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>

</body>

</html>