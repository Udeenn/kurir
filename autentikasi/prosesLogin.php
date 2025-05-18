<?php
session_start();
include '../koneksi.php';

$nama = $_POST['nama'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE nama = '$nama'";
$result = mysqli_query($conn, $query);
if ($user = mysqli_fetch_assoc($result)) {
    if ($password === $user['password']) {
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        switch ($user['role']) {
            case 'admin':
                header("Location: ../pages/dashboard/admin/admin.php");
                break;
            case 'pembeli':
                header("Location: ../pages/dashboard/pembeli/pembeli.php");
                break;
            case 'kurir':
                header("Location: ../pages/dashboard/kurir/kurir.php");
                break;
        }
    } else {
        echo "Password salah. <a href='login.php'>Coba lagi</a>";
    }
} else {
    echo "User tidak ditemukan. <a href='login.php'>Coba lagi</a>";
}
?>
