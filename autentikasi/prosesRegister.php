<?php
include '../koneksi.php';

$nama = $_POST['nama'];
$pass = $_POST['password'];
$alamat = $_POST['alamat'];

$query = "INSERT INTO users (nama, password, alamat, role) VALUES ('$nama', '$pass', '$alamat', 'pembeli')";
if (mysqli_query($conn, $query)) {
    header("Location: login.php");
} else {
    echo "Registrasi gagal.";
}
?>
