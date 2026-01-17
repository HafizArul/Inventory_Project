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

// ================== UPDATE ==================
if (isset($_POST['update'])) {
    mysqli_query($conn, "
        UPDATE barang SET
            nama_barang = '$_POST[nama_barang]',
            stok        = '$_POST[stok]',
            satuan      = '$_POST[satuan]',
            harga       = '$_POST[harga]'
        WHERE id_barang = '$_POST[id_barang]'
    ");
    header("Location: barang.php");
    exit;
}

// ================== SELECT ==================
$result = $conn->query("
    SELECT id_barang, nama_barang, stok, satuan, kategori, harga
    FROM barang
    ORDER BY nama_barang ASC
");

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
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row['id_barang'] ?></td>
                                                <td><?= $row['nama_barang'] ?></td>
                                                <td><?= $row['stok'] ?></td>
                                                <td><?= $row['satuan'] ?></td>
                                                <td><?= $row['kategori'] ?></td>
                                                <td>

                                                    <button class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit"
                                                        data-id="<?= $row['id_barang'] ?>"
                                                        data-nama="<?= $row['nama_barang'] ?>"
                                                        data-stok="<?= $row['stok'] ?>"
                                                        data-satuan="<?= $row['satuan'] ?>"
                                                        data-harga="<?= $row['harga'] ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    

                                                    <a href="barang_hapus.php?id=<?= $row['id_barang'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus data?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php }
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

    <!-- ================= MODAL EDIT ================= -->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <input type="hidden" name="id_barang" id="edit_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Barang</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input class="form-control mb-2" name="nama_barang" id="edit_nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Barang</label>
                            <input class="form-control mb-2" name="stok" id="edit_stok" type="number" required>
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan Barang</label>
                            <select class="form-select mb-2" name="satuan" id="edit_satuan" required>
                                <option>Sak</option>
                                <option>Batang</option>
                                <option>Kg</option>
                                <option>Unit</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Barang</label>
                            <input class="form-control mb-2" name="harga" id="edit_harga" type="number" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning w-100" name="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>
    <script>
    document.getElementById('modalEdit').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('edit_id').value     = button.getAttribute('data-id');
    document.getElementById('edit_nama').value   = button.getAttribute('data-nama');
    document.getElementById('edit_stok').value   = button.getAttribute('data-stok');
    document.getElementById('edit_satuan').value = button.getAttribute('data-satuan');
    document.getElementById('edit_harga').value  = button.getAttribute('data-harga');
});
</script>

</body>

</html>