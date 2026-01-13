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

// query data barang
$sql = "SELECT id_barang, nama_barang, stok, satuan, kategori 
        FROM barang
        ORDER BY nama_barang ASC";
$result = $conn->query($sql);

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    // Query untuk memasukkan data ke tabel barang
    $sql_insert = "INSERT INTO barang (nama_barang, stok, satuan, kategori, harga) 
                   VALUES ('$nama_barang', $stok, '$satuan', '$kategori', $harga)";

    if ($conn->query($sql_insert) === TRUE) {
        // Redirect atau tampilkan pesan sukses
        header("Location: barang.php");
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
    <title>Barang - INVENTORY SIMPK</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php require 'navbar.php'; ?> <!-- opsional -->

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php require 'sidebar.php'; ?> <!-- opsional -->
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Barang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard / Barang</li>
                    </ol>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </button>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-box me-1"></i>
                            Data Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th>Satuan</th>
                                        <th>Kategori</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th>Satuan</th>
                                        <th>Kategori</th>
                                        <th>Opsi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id_barang']}</td>
                                                    <td>{$row['nama_barang']}</td>
                                                    <td>{$row['stok']}</td>
                                                    <td>{$row['satuan']}</td>
                                                    <td>{$row['kategori']}</td>
                                                    <td>
                                                        <button class='btn btn-sm btn-warning'><i class='bi bi-pencil-square'></i></button>
                                                        <button class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>
                                                    </td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
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
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Data Barang</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="namaBarang" class="form-label">Input Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" name="nama_barang" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" required>
                </div>
                <div class="mb-3">
                    <div class="col-md-12">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select id="satuan" class="form-select" name="satuan" required>
                            <option selected>Pilih Satuan...</option>
                            <option value="Sak">Sak</option>
                            <option value="Batang">Batang</option>
                            <option value="M3">M3</option>
                            <option value="Kaleng">Kaleng</option>
                            <option value="Kg">Kg</option>
                            <option value="Unit">Unit</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-md-12">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select id="kategori" class="form-select" name="kategori" required>
                            <option selected>Pilih Kategori...</option>
                            <option value="Material">Material</option>
                            <option value="Alat">Alat</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
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