<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "../../../uploads/$foto");

    mysqli_query($conn, "INSERT INTO barang (kode_barang, nama_barang, stok, harga, foto)
        VALUES ('$kode', '$nama', $stok, $harga, '$foto')");

    header("Location: barang.php");
    exit;
}
?>

<h2>Tambah Barang</h2>
<form method="post" enctype="multipart/form-data">
    Kode: <input type="text" name="kode"><br>
    Nama: <input type="text" name="nama"><br>
    Stok: <input type="number" name="stok"><br>
    Harga: <input type="number" step="0.01" name="harga"><br>
    Foto: <input type="file" name="foto"><br>
    <button type="submit">Simpan</button>
</form>
