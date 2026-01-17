<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "proyek_inventory");
if ($conn->connect_error) {
    die("Koneksi gagal");
}

/* ================= DATA DROPDOWN ================= */
$barang   = mysqli_query($conn, "SELECT id_barang, nama_barang FROM barang");
$supplier = mysqli_query($conn, "SELECT id_supplier, nama_supplier FROM supplier");
$proyek   = mysqli_query($conn, "SELECT id_proyek, nama_proyek FROM proyek");

/* ================= DATA TABEL ================= */
$result = mysqli_query($conn, "
    SELECT bm.id_masuk, bm.id_barang, bm.id_supplier, bm.id_proyek,
           b.nama_barang, s.nama_supplier, p.nama_proyek,
           bm.jumlah, bm.tanggal
    FROM barang_masuk bm
    JOIN barang b ON bm.id_barang = b.id_barang
    JOIN supplier s ON bm.id_supplier = s.id_supplier
    JOIN proyek p ON bm.id_proyek = p.id_proyek
    ORDER BY bm.tanggal DESC
");

/* ================= TAMBAH ================= */
if (isset($_POST['submit'])) {
    mysqli_query($conn, "
        INSERT INTO barang_masuk (id_barang, id_supplier, id_proyek, tanggal, jumlah)
        VALUES (
            '$_POST[id_barang]',
            '$_POST[id_supplier]',
            '$_POST[id_proyek]',
            '$_POST[tanggal]',
            '$_POST[jumlah]'
        )
    ");
    header("Location: masuk.php");
    exit;
}

/* ================= EDIT ================= */
if (isset($_POST['update'])) {
    mysqli_query($conn, "
        UPDATE barang_masuk SET
            id_barang='$_POST[id_barang]',
            id_supplier='$_POST[id_supplier]',
            id_proyek='$_POST[id_proyek]',
            tanggal='$_POST[tanggal]',
            jumlah='$_POST[jumlah]'
        WHERE id_masuk='$_POST[id_masuk]'
    ");
    header("Location: masuk.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Barang Masuk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
    <?php include 'navbar.php'; ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav"><?php include 'sidebar.php'; ?></div>

        <div id="layoutSidenav_content">
            <main class="container-fluid px-4">

                <h1 class="mt-4">Barang Masuk</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard / Barang Masuk</li>
                </ol>

                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah Barang Masuk
                </button>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-boxes"></i>
                        Data Barang Masuk
                    </div>

                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barang</th>
                                    <th>Supplier</th>
                                    <th>Proyek</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= $row['id_masuk'] ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['nama_supplier'] ?></td>
                                        <td><?= $row['nama_proyek'] ?></td>
                                        <td><?= $row['jumlah'] ?></td>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit"
                                                data-id="<?= $row['id_masuk'] ?>"
                                                data-barang="<?= $row['id_barang'] ?>"
                                                data-supplier="<?= $row['id_supplier'] ?>"
                                                data-proyek="<?= $row['id_proyek'] ?>"
                                                data-jumlah="<?= $row['jumlah'] ?>"
                                                data-tanggal="<?= $row['tanggal'] ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="masuk_hapus.php?id=<?= $row['id_masuk'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
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

    <!-- ================= MODAL TAMBAH ================= -->
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Barang Masuk</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <select name="id_barang" class="form-select mb-2" required>
                            <option value="">Pilih Barang</option>
                            <?php mysqli_data_seek($barang, 0);
                            while ($b = mysqli_fetch_assoc($barang)) { ?>
                                <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                            <?php } ?>
                        </select>

                        <select name="id_supplier" class="form-select mb-2" required>
                            <option value="">Pilih Supplier</option>
                            <?php mysqli_data_seek($supplier, 0);
                            while ($s = mysqli_fetch_assoc($supplier)) { ?>
                                <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                            <?php } ?>
                        </select>

                        <select name="id_proyek" class="form-select mb-2" required>
                            <option value="">Pilih Proyek</option>
                            <?php mysqli_data_seek($proyek, 0);
                            while ($p = mysqli_fetch_assoc($proyek)) { ?>
                                <option value="<?= $p['id_proyek'] ?>"><?= $p['nama_proyek'] ?></option>
                            <?php } ?>
                        </select>

                        <input type="date" name="tanggal" class="form-control mb-2" required>
                        <input type="number" name="jumlah" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button name="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ================= MODAL EDIT ================= -->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="id_masuk" id="edit_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Barang Masuk</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <select name="id_barang" id="edit_barang" class="form-select mb-2" required>
                            <?php mysqli_data_seek($barang, 0);
                            while ($b = mysqli_fetch_assoc($barang)) { ?>
                                <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                            <?php } ?>
                        </select>

                        <select name="id_supplier" id="edit_supplier" class="form-select mb-2" required>
                            <?php mysqli_data_seek($supplier, 0);
                            while ($s = mysqli_fetch_assoc($supplier)) { ?>
                                <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                            <?php } ?>
                        </select>

                        <select name="id_proyek" id="edit_proyek" class="form-select mb-2" required>
                            <?php mysqli_data_seek($proyek, 0);
                            while ($p = mysqli_fetch_assoc($proyek)) { ?>
                                <option value="<?= $p['id_proyek'] ?>"><?= $p['nama_proyek'] ?></option>
                            <?php } ?>
                        </select>

                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control mb-2" required>
                        <input type="number" name="jumlah" id="edit_jumlah" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button name="update" class="btn btn-warning w-100">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/scripts.js"></script>

    <script>
        new simpleDatatables.DataTable("#datatablesSimple");

        document.getElementById('modalEdit').addEventListener('show.bs.modal', function(e) {
            const b = e.relatedTarget;
            edit_id.value = b.dataset.id;
            edit_barang.value = b.dataset.barang;
            edit_supplier.value = b.dataset.supplier;
            edit_proyek.value = b.dataset.proyek;
            edit_jumlah.value = b.dataset.jumlah;
            edit_tanggal.value = b.dataset.tanggal;
        });
    </script>

</body>

</html>