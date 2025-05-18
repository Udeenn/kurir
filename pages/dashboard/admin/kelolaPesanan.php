<?php
session_start();
include '../../../koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../autentikasi/login.php");
    exit;
}

// Proses penetapan kurir
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pesanan'], $_POST['id_kurir'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $id_kurir = $_POST['id_kurir'];

    $update = mysqli_query($conn, "
        UPDATE pesanan 
        SET id_kurir = $id_kurir, status = 'dikirim' 
        WHERE id = $id_pesanan
    ");

    if ($update) {
        echo "<script>alert('Kurir berhasil ditetapkan'); window.location.href='kelolaPesanan.php';</script>";
        exit;
    } else {
        echo "Gagal menetapkan kurir.";
    }
}

// Ambil data pesanan
$pesanan = mysqli_query($conn, "
    SELECT p.*, u.nama AS nama_pembeli, k.nama AS nama_kurir 
    FROM pesanan p
    JOIN users u ON p.id_pembeli = u.id
    LEFT JOIN users k ON p.id_kurir = k.id
    ORDER BY p.id DESC
");

// Ambil daftar kurir
$kurirList = mysqli_query($conn, "SELECT * FROM users WHERE role = 'kurir'");
?>

<h2>Kelola Pesanan</h2>
<a href="admin.php">Kembali ke Dashboard</a> | 
<a href="../../../autentikasi/logout.php">Logout</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Pembeli</th>
        <th>Total Harga</th>
        <th>Status</th>
        <th>Kurir</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($pesanan)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama_pembeli'] ?></td>
            <td><?= $row['total_harga'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['nama_kurir'] ?: '-' ?></td>
            <td>
                <?php if ($row['status'] === 'pending') { ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id_pesanan" value="<?= $row['id'] ?>">
                        <select name="id_kurir" required>
                            <option value="">--Pilih Kurir--</option>
                            <?php while ($kurir = mysqli_fetch_assoc($kurirList)) { ?>
                                <option value="<?= $kurir['id'] ?>"><?= $kurir['nama'] ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit">Tetapkan</button>
                    </form>
                <?php } else {
                    echo "Sudah ditetapkan";
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>
