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

// query data supplier
$sql = "SELECT id_supplier, nama_supplier, kontak, alamat 
        FROM supplier
        ORDER BY nama_supplier ASC";
$result = $conn->query($sql);

// Cek apakah form telah disubmit
if (isset($_POST['submit'])) {
    $namaSupplier = $_POST['namaSupplier'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];

    // Insert data ke database
    $insertSql = "INSERT INTO supplier (nama_supplier, kontak, alamat) VALUES ('$namaSupplier', '$kontak', '$alamat')";

    if (mysqli_query($conn, $insertSql)) {
        // Redirect atau tampilkan pesan sukses
        header("Location: supplier.php");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// ================== UPDATE SUPPLIER ==================
if (isset($_POST['update'])) {
    $id      = $_POST['id_supplier'];
    $nama    = $_POST['nama_supplier'];
    $kontak  = $_POST['kontak'];
    $alamat  = $_POST['alamat'];

    $update = mysqli_query($conn, "
        UPDATE supplier SET
            nama_supplier='$nama',
            kontak='$kontak',
            alamat='$alamat'
        WHERE id_supplier='$id'
    ");

    if ($update) {
        header("Location: supplier.php");
        exit;
    } else {
        echo "Gagal update data";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Supplier - INVENTORY SIMPK</title>
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
                    <h1 class="mt-4">Supplier</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard / Supplier</li>
                    </ol>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus"></i> Tambah Supplier
                    </button>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-truck me-1"></i>
                            Data Supplier
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Kontak</th>
                                        <th>Alamat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                    <td><?= $row['id_supplier'] ?></td>
                                                    <td><?= $row['nama_supplier']?></td>
                                                    <td><?= $row['kontak']?></td>
                                                    <td><?= $row['alamat']?></td>
                                                    <td>
                
                                                     <button class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit"
                                                        data-id="<?= $row['id_supplier']; ?>"
                                                        data-nama="<?= $row['nama_supplier']; ?>"
                                                        data-kontak="<?= $row['kontak']; ?>"
                                                        data-alamat="<?= $row['alamat']; ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <a href="supplier_hapus.php?id=<?= $row['id_supplier'] ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus supplier ini?')">
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Supplier</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="namaSupplier" class="form-label">Input Nama Supplier</label>
                    <input type="text" class="form-control" id="namaSupplier" name="namaSupplier" required>
                </div>
                <div class="mb-3">
                    <label for="kontak" class="form-label">Input Nomor Telepon</label>
                    <input type="tel" name="kontak" id="kontak" class="form-control" required>
                </div>
                <div class="mb-3">
                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Input Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
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

    <!-- ================= MODAL EDIT SUPPLIER ================= -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post">
                <input type="hidden" name="id_supplier" id="edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Edit Supplier
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" id="edit_nama"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="kontak" id="edit_kontak"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" id="edit_alamat"
                                  class="form-control" rows="3" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-success w-100">
                        <i class="bi bi-save"></i> Update
                    </button>
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
const modalEdit = document.getElementById('modalEdit');

modalEdit.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('edit_id').value     = button.getAttribute('data-id');
    document.getElementById('edit_nama').value   = button.getAttribute('data-nama');
    document.getElementById('edit_kontak').value = button.getAttribute('data-kontak');
    document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
});
</script>

</body>
</html>