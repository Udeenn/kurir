<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "../../../uploads/$foto");
        mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', stok=$stok, harga=$harga, foto='$foto' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', stok=$stok, harga=$harga WHERE id=$id");
    }

    header("Location: barang.php");
    exit;
}
?>

<h2>Edit Barang</h2>
<form method="post" enctype="multipart/form-data">
    Nama: <input type="text" name="nama" value="<?= $data['nama_barang'] ?>"><br>
    Stok: <input type="number" name="stok" value="<?= $data['stok'] ?>"><br>
    Harga: <input type="number" name="harga" step="0.01" value="<?= $data['harga'] ?>"><br>
    Foto Baru: <input type="file" name="foto"><br>
    <img src="../../../uploads/<?= $data['foto'] ?>" width="100"><br>
    <button type="submit">Update</button>
</form>
