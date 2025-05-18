<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role'];

    mysqli_query($conn, "UPDATE users SET nama='$nama', password='$password', alamat='$alamat', role='$role' WHERE id=$id");

    header("Location: user.php");
    exit;
}
?>

<h2>Edit User</h2>
<form method="post" enctype="multipart/form-data">
    Nama: <input type="text" name="nama" value="<?= $data['nama'] ?>"><br>
    Password: <input type="text" name="password" value="<?= $data['password'] ?>"><br>
    Alamat: <input type="text" name="alamat" value="<?= $data['alamat'] ?>"><br>
    <select name="role" required>
        <option value=""><?= $data['role'] ?></option>
        <option value="admin">Admin</option>
        <option value="kurir">Kurir</option>
        <option value="pembeli">Pembeli</option>
    </select>
    <button type="submit">Simpan</button>
</form>
