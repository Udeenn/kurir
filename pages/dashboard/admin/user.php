<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<h2>Daftar User</h2>
<a href="tambahUser.php">Tambah User</a>
<table border="1">
    <tr>
        <th>Nama</th>
        <th>Password</th>
        <th>Alamat</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['password'] ?></td>
        <td><?= $row['alamat'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <a href="editUser.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="hapusUser.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
