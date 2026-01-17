<?php
$conn = new mysqli("localhost","root","","proyek_inventory");

$id = $_GET['id'];

// cek apakah barang dipakai
$cek = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM kebutuhan_proyek 
    WHERE id_barang='$id'
");
$data = mysqli_fetch_assoc($cek);

if ($data['total'] > 0) {
    echo "<script>
        alert('Barang tidak bisa dihapus karena masih digunakan di kebutuhan proyek');
        window.location='barang.php';
    </script>";
    exit;
}

// kalau aman → hapus
mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id'");

header("Location: barang.php");
