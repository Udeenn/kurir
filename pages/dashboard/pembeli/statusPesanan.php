<?php
session_start();
include '../../../koneksi.php';

$id_pembeli = $_SESSION['id_user'];

$query = mysqli_query($conn, "
    SELECT p.id, p.status, p.total_harga, p.created_at 
    FROM pesanan p 
    WHERE p.id_pembeli = $id_pembeli 
    ORDER BY p.created_at DESC
");

echo "<h2>Status Pesanan</h2><table border='1'>
<tr><th>ID</th><th>Status</th><th>Total</th><th>Waktu</th></tr>";

while ($row = mysqli_fetch_assoc($query)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['status']}</td>
        <td>{$row['total_harga']}</td>
        <td>{$row['created_at']}</td>
    </tr>";
}

echo "</table>";
?>
<a href="pembeli.php">Kembali ke Dashboard</a> |