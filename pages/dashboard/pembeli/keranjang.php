<?php
session_start();
include '../../../koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'pembeli') {
    header("Location: ../../../autentikasi/login.php");
    exit;
}

$id_pembeli = $_SESSION['id_user'];

// Proses checkout jika tombol ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil isi keranjang
    $keranjang = mysqli_query($conn, "
        SELECT k.kode_barang, k.jumlah, b.id AS id_barang, b.harga 
        FROM keranjang k 
        JOIN barang b ON k.kode_barang = b.kode_barang 
        WHERE k.id_pembeli = $id_pembeli
    ");

    // Hitung total dan simpan item
    $total = 0;
    $items = [];
    while ($row = mysqli_fetch_assoc($keranjang)) {
        $subtotal = $row['harga'] * $row['jumlah'];
        $total += $subtotal;
        $items[] = $row;
    }

    if (count($items) === 0) {
        echo "Keranjang kosong.";
        exit;
    }

    // Simpan pesanan
    mysqli_query($conn, "
        INSERT INTO pesanan (id_pembeli, total_harga, status) 
        VALUES ($id_pembeli, $total, 'pending')
    ");
    $id_pesanan = mysqli_insert_id($conn);

    // Simpan detail pesanan
    foreach ($items as $item) {
        $id_barang = $item['id_barang'];
        $jumlah = $item['jumlah'];
        $harga = $item['harga'];

        mysqli_query($conn, "
            INSERT INTO detail_pesanan (id_pesanan, id_barang, jumlah, harga_satuan) 
            VALUES ($id_pesanan, $id_barang, $jumlah, $harga)
        ");
    }

    // Hapus keranjang
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_pembeli = $id_pembeli");

    echo "<p>Checkout berhasil! <a href='pembeli.php'>Kembali ke dashboard</a></p>";
    exit;
}
?>

<h2>Keranjang Anda</h2>
<a href="pembeli.php">Kembali ke Dashboard</a> | 
<a href="../../autentikasi/logout.php">Logout</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Subtotal</th>
    </tr>
    <?php
    $query = mysqli_query($conn, "
        SELECT k.*, b.nama_barang, b.harga 
        FROM keranjang k 
        JOIN barang b ON k.kode_barang = b.kode_barang 
        WHERE k.id_pembeli = $id_pembeli
    ");
    $total = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        $subtotal = $row['jumlah'] * $row['harga'];
        $total += $subtotal;
        echo "<tr>
            <td>{$row['nama_barang']}</td>
            <td>{$row['jumlah']}</td>
            <td>{$row['harga']}</td>
            <td>$subtotal</td>
        </tr>";
    }
    ?>
    <tr>
        <td colspan="3" align="right"><strong>Total</strong></td>
        <td><strong><?= $total ?></strong></td>
    </tr>
</table>

<br>
<form method="post">
    <button type="submit" onclick="return confirm('Yakin ingin checkout pesanan ini?')">Checkout Sekarang</button>
</form>
