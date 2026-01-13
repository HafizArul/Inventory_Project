<?php
session_start();
require_once __DIR__ . '/config/koneksi.php';

// cek login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// koneksi ke database
// $host = "localhost";
// $user = "root"; // ganti sesuai user MySQL
// $pass = "";     // ganti sesuai password MySQL
// $db   = "proyek_inventory"; // ganti sesuai nama database
// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

// query data proyek
$sql = "SELECT id_proyek, nama_proyek, lokasi, tanggal_mulai, tanggal_selesai 
        FROM proyek
        ORDER BY tanggal_mulai DESC";
$result = $conn->query($sql);

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama_proyek = $_POST['nama_proyek'];
    $jenisProyek = $_POST['jenisProyek'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    // Query untuk memasukkan data ke tabel proyek
    $sql_insert = "INSERT INTO proyek (nama_proyek, jenis_proyek, lokasi, status, tanggal_mulai, tanggal_selesai) 
                   VALUES ('$nama_proyek', '$jenisProyek', '$lokasi', '$status', '$tanggal_mulai', '$tanggal_selesai')";

    if (mysqli_query($conn, $sql_insert)) {
        // Redirect atau tampilkan pesan sukses
        header("Location: proyek.php");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Proyek - INVENTORY SIMPK</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?> <!-- opsional -->

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include 'sidebar.php'; ?> <!-- opsional -->
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Proyek</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard / Proyek</li>
                    </ol>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus"></i> Tambah Proyek
                    </button>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-building me-1"></i>
                            Data Proyek
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID Proyek</th>
                                        <th>Nama Proyek</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                         <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID Proyek</th>
                                        <th>Nama Proyek</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                         <th>Opsi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id_proyek']}</td>
                                                    <td>{$row['nama_proyek']}</td>
                                                    <td>{$row['lokasi']}</td>
                                                    <td>{$row['tanggal_mulai']}</td>
                                                    <td>{$row['tanggal_selesai']}</td>
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
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Data Proyek</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="namaProyek" class="form-label">Input Nama Proyek</label>
                    <input type="text" class="form-control" id="namaProyek" name="nama_proyek" required>
                </div>
                <div class="mb-3">
                    <label for="jenisProyek" class="form-label">Input Jenis Proyek</label>
                    <select id="jenisProyek" class="form-select" name="jenisProyek" required>
                        <option selected>Pilih Jenis Proyek...</option>
                        <option value="Perumahan">Perumahan</option>
                        <option value="Gedung">Gedung</option>
                        <option value="Jalan">Jalan</option>
                        <option value="Renovasi">Renovasi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="col-md-12">
                        <label for="lokasi" class="form-label">Input Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-md-12">
                        <label for="status" class="form-label">Input Status</label>
                        <select id="status" class="form-select" name="status" required>
                            <option selected>Pilih Status...</option>
                            <option value="Perencanaan">Perencanaan</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai" required>
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