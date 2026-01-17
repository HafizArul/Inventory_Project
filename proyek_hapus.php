<?php
session_start();
require_once __DIR__ . '/config/koneksi.php';

/* ================= CEK LOGIN ================= */
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

/* ================= CEK PARAMETER ================= */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: proyek.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

/* ================= CEK DATA ADA ================= */
$cek = mysqli_query($conn, "SELECT id_proyek FROM proyek WHERE id_proyek='$id'");
if (mysqli_num_rows($cek) == 0) {
    header("Location: proyek.php");
    exit;
}

/* ================= HAPUS DATA ================= */
mysqli_query($conn, "DELETE FROM proyek WHERE id_proyek='$id'");

/* ================= REDIRECT ================= */
header("Location: proyek.php");
exit;
