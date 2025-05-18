<?php include '../../../autentikasi/cekSession.php'; cekRole('admin'); ?>
<h2>Dashboard Admin</h2>
<p>Selamat datang, <?= $_SESSION['nama'] ?> (<?= $_SESSION['role'] ?>)</p>
<a href="../../../autentikasi/logout.php">Logout</a><br>
<a href="barang.php">Daftar Barang</a>
<a href="user.php">Daftar User</a>
<a href="kelolaPesanan.php">Kelola Pesanan</a>
