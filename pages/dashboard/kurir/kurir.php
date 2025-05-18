<?php
session_start();
include '../../../koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'kurir') {
    header("Location: ../../../autentikasi/login.php");
    exit;
}

$id_kurir = $_SESSION['id_user'];

// Proses ubah status ke selesai
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pesanan'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $update = mysqli_query($conn, "
        UPDATE pesanan SET status = 'selesai' 
        WHERE id = $id_pesanan AND id_kurir = $id_kurir
    ");

    if ($update) {
        echo "<script>alert('Pesanan ditandai selesai'); window.location.href='kurir.php';</script>";
        exit;
    } else {
        echo "Gagal mengubah status.";
    }
}

// Ambil pesanan milik kurir ini
$query = "
    SELECT p.*, u.nama AS nama_pembeli 
    FROM pesanan p
    JOIN users u ON p.id_pembeli = u.id
    WHERE p.id_kurir = $id_kurir
    ORDER BY p.id DESC
";
$pesanan = mysqli_query($conn, $query);
?>

<h2>Dashboard Kurir</h2>
<a href="../../../autentikasi/logout.php">Logout</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID Pesanan</th>
        <th>Nama Pembeli</th>
        <th>Total Harga</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($pesanan)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama_pembeli'] ?></td>
            <td><?= $row['total_harga'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <?php if ($row['status'] === 'dikirim') { ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id_pesanan" value="<?= $row['id'] ?>">
                        <button type="submit">Tandai Selesai</button>
                    </form>
                <?php } else {
                    echo "-";
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>
