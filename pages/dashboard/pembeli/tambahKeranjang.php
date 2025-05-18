<?php
session_start();
include '../../../koneksi.php';

$id_pembeli = $_SESSION['id_user'];
$kode_barang = $_POST['kode_barang'];
$jumlah = (int)$_POST['jumlah'];

mysqli_query($conn, "INSERT INTO keranjang (id_pembeli, kode_barang, jumlah) 
                     VALUES ($id_pembeli, '$kode_barang', $jumlah)");

header("Location: pembeli.php");
exit;
