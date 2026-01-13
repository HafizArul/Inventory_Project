<?php
session_start();

if (isset($_POST['id_proyek'])) {
    $_SESSION['id_proyek'] = (int) $_POST['id_proyek'];
}

header("Location: dashboard.php");
exit;
