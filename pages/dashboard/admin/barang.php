<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../autentikasi/login.php');
    exit;
}
include '../../../koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM barang");
?>

<h2>Daftar Barang</h2>
<a href="tambahBarang.php">Tambah Barang</a>
<table border="1">
    <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['kode_barang'] ?></td>
        <td><?= $row['nama_barang'] ?></td>
        <td><?= $row['stok'] ?></td>
        <td><?= $row['harga'] ?></td>
        <td><img src="../../../uploads/<?= $row['foto'] ?>" width="50"></td>
        <td>
            <a href="editBarang.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="hapusBarang.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
