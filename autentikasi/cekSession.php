<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

function cekRole($role_diperlukan) {
    if ($_SESSION['role'] !== $role_diperlukan) {
        echo "Akses ditolak untuk role: " . $_SESSION['role'];
        exit;
    }
}
?>
