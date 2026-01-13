<?php
session_start();

// Hapus semua session
$_SESSION = [];
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: login.php");
exit;
?>
