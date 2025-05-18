<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM barang WHERE id=$id");

header("Location: barang.php");
exit;
?>
