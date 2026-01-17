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

if (!isset($_GET['id'])) {
    header("Location: supplier.php");
    exit;
}

$id = $_GET['id'];

// LANGSUNG HAPUS
$hapus = $conn->query("
    DELETE FROM supplier 
    WHERE id_supplier = '$id'
");

if ($hapus) {
    echo "<script>
        alert('Supplier berhasil dihapus');
        window.location='supplier.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus supplier');
        window.location='supplier.php';
    </script>";
}
