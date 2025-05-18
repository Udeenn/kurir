<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role'];

    mysqli_query($conn, "INSERT INTO users (nama, password, alamat, role) VALUES ('$nama', '$password', '$alamat', '$role')");

    header("Location: user.php");
    exit;
}
?>

<h2>Tambah User</h2>
<form method="post" enctype="multipart/form-data">
    Nama: <input type="text" name="nama"><br>
    Password: <input type="text" name="password"><br>
    Alamat: <input type="text" name="alamat"><br>
    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="kurir">Kurir</option>
        <option value="pembeli">Pembeli</option>
    </select>
    <button type="submit">Simpan</button>
</form>
