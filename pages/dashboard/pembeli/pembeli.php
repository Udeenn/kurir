<?php
session_start();
if ($_SESSION['role'] !== 'pembeli') {
    header("Location: ../../../autentikasi/login.php");
    exit;
}
include '../../../koneksi.php';
?>

<h2>Selamat datang, <?= $_SESSION['nama'] ?> (Pembeli)</h2>
<a href="../../../autentikasi/logout.php">Logout</a>

<h3>Daftar Barang</h3>
<table border="1">
    <tr><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
    <?php
    $query = mysqli_query($conn, "SELECT * FROM barang");
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
            <td>{$row['kode_barang']}</td>
            <td>{$row['nama_barang']}</td>
            <td>{$row['harga']}</td>
            <td>{$row['stok']}</td>
            <td>
                <form method='post' action='tambahKeranjang.php'>
                    <input type='hidden' name='kode_barang' value='{$row['kode_barang']}'>
                    <input type='number' name='jumlah' min='1' value='1'>
                    <button type='submit'>Tambah ke Keranjang</button>
                </form>
            </td>
        </tr>";
    }
    ?>
</table>

<a href="keranjang.php">Lihat Keranjang</a>
<a href="statusPesanan.php">Lihat Status Pesanan</a>
