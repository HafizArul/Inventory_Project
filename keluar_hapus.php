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

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM barang_keluar WHERE id_keluar='$id'");

header("Location: keluar.php");
exit;
