<?php
session_start();

// cek login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// koneksi ke database
$host = "localhost";
$user = "root"; // ganti sesuai user MySQL
$pass = "";     // ganti sesuai password MySQL
$db   = "proyek_inventory"; // ganti sesuai nama database
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// query data barang_masuk
$barang = mysqli_query($conn, "SELECT id_barang, nama_barang FROM barang");
$supplier = mysqli_query($conn, "SELECT id_supplier, nama_supplier FROM supplier");
$proyek = mysqli_query($conn, "SELECT id_proyek, nama_proyek FROM proyek");

$sql = "SELECT bm.id_masuk, b.nama_barang, s.nama_supplier, bm.jumlah, bm.tanggal 
        FROM barang_masuk bm
        JOIN barang b ON bm.id_barang = b.id_barang
        JOIN supplier s ON bm.id_supplier = s.id_supplier
        ORDER BY bm.tanggal DESC";
$result = mysqli_query($conn, $sql);

// Cek apakah form telah disubmit
if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $id_supplier = $_POST['id_supplier'];
    $id_proyek = $_POST['id_proyek'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];

    // Insert data ke database
    $insertSql = "INSERT INTO barang_masuk (id_barang, id_supplier, id_proyek, tanggal, jumlah) 
                  VALUES ('$id_barang', '$id_supplier', '$id_proyek', '$tanggal', '$jumlah')";

    if (mysqli_query($conn, $insertSql)) {
        // Redirect atau tampilkan pesan sukses
        header("Location: masuk.php");
        exit;
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Barang Masuk - INVENTORY SIMPK</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?> <!-- opsional, jika kamu pisahkan navbar -->

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include 'sidebar.php'; ?> <!-- opsional, sidebar -->
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Barang Masuk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard / Barang Masuk</li>
                    </ol>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus"></i> Tambah Barang Masuk
                    </button>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-boxes me-1"></i>
                            Data Barang Masuk
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID Masuk</th>
                                        <th>Nama Barang</th>
                                        <th>Supplier</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID Masuk</th>
                                        <th>Nama Barang</th>
                                        <th>Supplier</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Opsi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id_masuk']}</td>
                                                    <td>{$row['nama_barang']}</td>
                                                    <td>{$row['nama_supplier']}</td>
                                                    <td>{$row['jumlah']}</td>
                                                    <td>{$row['tanggal']}</td>
                                                    <td>
                                                        <button class='btn btn-sm btn-warning'><i class='bi bi-pencil-square'></i></button>
                                                        <button class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>
                                                    </td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Simpk Website 2026</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Form Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Barang Masuk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="id_barang" class="form-label">Input Nama Barang</label>
                        <select name="id_barang" class="form-select" required>
                            <option selected>Pilih Barang...</option>
                            <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                                <option value="<?= $b['id_barang'] ?>">
                                    <?= $b['nama_barang'] ?>
                                </option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="id_supplier" class="form-label">Input Nama Supplier</label>
                        <select name="id_supplier" class="form-select" required>
                            <option selected>Pilih Supplier</option>
                            <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                                <option value="<?= $s['id_supplier'] ?>">
                                    <?= $s['nama_supplier'] ?>
                                </option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="id_proyek" class="form-label">Input Nama Proyek</label>
                        <select name="id_proyek" class="form-select" required>
                            <option selected>Pilih Proyek</option>
                            <?php while ($p = mysqli_fetch_assoc($proyek)) { ?>
                                <option value="<?= $p['id_proyek'] ?>">
                                    <?= $p['nama_proyek'] ?>
                                </option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Input Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jumlah" class="form-label">Input Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 d-grid mx-auto">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>
</body>
</html>
